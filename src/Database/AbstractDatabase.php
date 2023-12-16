<?php

namespace JI\Database;
use JI\Database\Internal\QueryBuilder;
use JI\Database\Internal\Traits\ItemsTrait;
use JI\Database\Internal\Traits\ListsTrait;
use JI\Database\Internal\WhereBuilder;
use PDO;
use PDOException;
use PDOStatement;

/**
 * Inspired by https://medoo.in/
 *
 * @author Zhan Isaakian <jeanisahakyan@gmail.com>
 */
abstract class AbstractDatabase {
  private PDO $pdo;
  use ItemsTrait;
  use ListsTrait;

  public function __construct(array $config, array $options = []) {
    $dsn = "{$config['database_type']}:dbname={$config['database_name']};host={$config['server']}";
    $this->pdo = new PDO($dsn, $config['username'], $config['password'], $options);
    $queries = [
      "SET SQL_MODE=ANSI_QUOTES;",
      "SET NAMES {$config['charset']} COLLATE {$config['collation']};",
    ];
    foreach ($queries as $query) {
      $this->pdo->exec($query);
    }
  }

  public final function id(): int {
    return (int)$this->pdo->lastInsertId();
  }

  public function selectPairs($table, $columns = null, $where = null): array {
    $rows = $this->select($table, $columns, $where);
    $result = [];
    foreach ($rows as $item) {
      [$key, $value] = array_keys($item);
      $result[$item[$key]] = $item[$value];
    }
    return $result;
  }

  public function insertWithId($table, array $data): ?int {
    if (!$this->insert($table, $data)) {
      return null;
    }
    $incr_id = $this->id();
    if (!$incr_id) {
      return null;
    }
    return $incr_id;
  }

  public function count(string $table, string $column, array $where): int {
    $where = WhereBuilder::create($where);
    $statement = $this->query("SELECT COUNT({$column}) as cnt FROM {$table} {$where->getQuery()}", $where->getParams());
    if (!$statement) {
      return 0;
    }
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
      return 0;
    }
    return (int)$row['cnt'];
  }

  public function countAfter(string $table, array $where, int $id, ?string $id_field = 'id'): int {
    if (!$id) {
      return 0;
    }
    return (int)$this->count($table, $id_field, array_merge($where, [
      $id_field.'[>]' => (int)$id,
    ]));
  }

  public function countBefore(string $table, array $where, int $id, ?string $id_field = 'id'): int {
    if (!$id) {
      return 0;
    }
    return (int)$this->count($table, $id_field, array_merge($where, [
      $id_field.'[<]' => (int)$id,
    ]));
  }

  public function prepareRows(array $rows): array {
    return array_map(function($row) {
      return array_map(function ($field) {
        if (is_numeric($field)) {
          return (int)$field;
        }
        if (is_float($field)) {
          return (float)$field;
        }
        if (is_null($field)) {
          return null;
        }
        return (string)$field;
      }, $row);
    }, $rows);
  }

  private function execute(string $query, array $params): ?PDOStatement {
    $statement = $this->pdo->prepare($query);
    if (!$statement) {
      throw new PDOException('Cant prepare db request');
    }
    foreach ($params as $param => $value_type) {
      [$value, $type] = $value_type;
      $statement->bindValue($param, $value, $type);
    }
    if (!$statement->execute()) {
      throw new PDOException($statement->errorInfo()[1], $statement->errorCode());
    }
    return $statement;
  }

  private function executeQuery(QueryBuilder $query): ?PDOStatement {
    return $this->query($query->getQuery(), $query->getParams());
  }

  public final function query(string $query, array $params = []): ?PDOStatement {
    $statement = $this->execute($query, $params);
    if (!$statement) {
      return null;
    }
    return $statement;
  }

  public final function insert(string $table, array $values): ?PDOStatement {
    $query = QueryBuilder::create($table)
      ->values($values)
      ->insert();
    return $this->executeQuery($query);
  }

  public final function update(string $table, array $values, array $where): ?PDOStatement {
    $query = QueryBuilder::create($table)
      ->values($values)
      ->where($where)
      ->update();
    return $this->executeQuery($query);
  }

  public final function delete(string $table, array $where): ?PDOStatement {
    $query = QueryBuilder::create($table)
      ->where($where)
      ->delete();
    return $this->executeQuery($query);
  }

  public final function select($table, array|string $columns = [], array $where = []): ?array {
    $query = QueryBuilder::create($table)
      ->columns($columns)
      ->where($where)
      ->select();
    $statement = $this->executeQuery($query);
    if (!$statement) {
      return null;
    }
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
    if (!$rows) {
      return $rows;
    }
    return $this->prepareRows($rows);
  }

  public final function get(string $table, string|array $columns, array $where): ?array {
    $rows = $this->select($table, $columns, [
      ...$where,
      'LIMIT' => 1,
    ]);
    if (!$rows) {
      return null;
    }
    return $rows[0];
  }
}
