<?php

namespace JI\Database\Internal;

/**
 * @author Zhan Isaakian <jeanisahakyan@gmail.com>
 */
class QueryBuilder {

  private const TYPE_INSERT = 1;
  private const TYPE_SELECT = 2;
  private const TYPE_UPDATE = 3;
  private const TYPE_DELETE = 4;

  private ?int $query_type = null;
  private string $table;
  private ?WhereBuilder $where = null;
  private ?ValuesBuilder $values = null;
  private ?string $columns = null;

  public function __construct(string $table) {
    $this->table = $table;
  }

  public static function create(string $table) {
    return new self($table, null, null);
  }

  public function where(array $where): self {
    $this->where = WhereBuilder::create($where);
    return $this;
  }

  public function values(array $values): self {
    $this->values = ValuesBuilder::create($values);
    return $this;
  }

  public function columns(array|string $columns): self {
    if (!is_array($columns)) {
      $columns = [$columns];
    }
    $this->columns = implode(', ', $columns);
    return $this;
  }


  public function getParams(): array {
    $result = [];
    if ($this->where) {
      $result += $this->where->getParams();
    }
    if ($this->values) {
      $result += $this->values->getParams();
    }
    return $result;
  }

  public function getQuery(): string {
    return match ($this->query_type) {
      self::TYPE_INSERT => "INSERT INTO {$this->table} {$this->values->getQuery()}",
      self::TYPE_UPDATE => "UPDATE {$this->table} {$this->values->getQuery()} {$this->where->getQuery()}",
      self::TYPE_DELETE =>  "DELETE FROM {$this->table} {$this->where->getQuery()}",
      self::TYPE_SELECT =>  "SELECT {$this->columns} FROM `{$this->table}` {$this->where->getQuery()}",
    };
  }

  public function delete(): self {
    $this->query_type = self::TYPE_DELETE;
    if (!$this->where) {
      throw new \PDOException('Where is required for delete');
    }
    return $this;
  }

  public function update(): self {
    $this->query_type = self::TYPE_UPDATE;
    if (!$this->values) {
      throw new \PDOException('Values is required for update');
    }
    if (!$this->where) {
      throw new \PDOException('Where is required for update');
    }
    return $this;
  }

  public function insert(): self {
    $this->query_type = self::TYPE_INSERT;
    if (!$this->values) {
      throw new \PDOException('Values is required for insert');
    }
    return $this;
  }

  public function select(): self {
    $this->query_type = self::TYPE_SELECT;
    if (!$this->where) {
      throw new \PDOException('Where is required for select');
    }
    if (!$this->columns) {
      throw new \PDOException('Columns is required for select');
    }
    return $this;
  }
}
