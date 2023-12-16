<?php
namespace JI\Database\Internal;

/**
 * @author Zhan Isaakian <jeanisahakyan@gmail.com>
 */
class WhereBuilder extends AbstractBuilder {

  public const FIELD_LIMIT = 'LIMIT';
  public const FIELD_ORDER = 'ORDER';

  public const MATCH_MODE_NATURAL = 'natural';
  public const MATCH_MODE_NATURAL_AND_QUERY = 'natural+query';
  public const MATCH_MODE_BOOLEAN = 'boolean';
  public const MATCH_MODE_QUERY = 'query';

  private const MATCH_MODES = [
    self::MATCH_MODE_NATURAL => 'IN NATURAL LANGUAGE MODE',
    self::MATCH_MODE_NATURAL_AND_QUERY => 'IN NATURAL LANGUAGE MODE WITH QUERY EXPANSION',
    self::MATCH_MODE_BOOLEAN => 'IN BOOLEAN MODE',
    self::MATCH_MODE_QUERY => 'WITH QUERY EXPANSION',
  ];

  private ?string $order = null;
  private ?string $limit = null;


  private static function isColumnParam(string $name) {
    return str_contains($name, '[') && str_ends_with($name, ']');
  }

  private function buildKeys($key, $value): string {
    $keys = [];
    foreach ($value as $k => $v) {
      $k = $key.$k;
      $this->bind[$k] = $v;
      $keys[] = ":{$k}";
    }
    return implode(', ', $keys);
  }

  private function prepareColumn(string $name, mixed $value) {
    $key = $this->getKey();
    if (!$this->isColumnParam($name)) {
      $name = "`{$name}`";
      if (is_array($value)) {
        $keys = $this->buildKeys($key, $value);
        return [$key, "{$name} IN ({$keys})"];
      }
      if ($value === null) {
        return [null, "{$name} IS NULL"];
      }
      return [$key, "{$name} = :{$key}"];
    }
    $eq = substr($name, strpos($name,  '['));
    $name = substr($name, 0, strpos($name,  '['));
    $name = "`{$name}`";
    return match ($eq) {
      '[>]' =>  [$key, "{$name} > :{$key}"],
      '[<]' =>  [$key, "{$name} < :{$key}"],
      '[>=]' => [$key, "{$name} >= :{$key}"],
      '[<=]' => [$key, "{$name} <= :{$key}"],
      '[!]' => $this->prepareNegativeColumn($key, $name, $value),
    };
  }

  private function prepareNegativeColumn(string $key, string $name, mixed $value): array {
    if (is_array($value)) {
      return [null, "{$name} NOT IN (".$this->buildKeys($key, $value).")"];
    }
    if ($value === null) {
      return [$key, "{$name} IS NOT NULL"];
    }
    return [$key, "{$name} != :{$key}"];
  }

  private function buildMatch(array $value): ?string {
    if (!$value['columns'] || !$value['keyword']) {
      return null;
    }
    $mode = '';
    if ($value['mode'] && array_key_exists($value['mode'], self::MATCH_MODES)) {
      $mode .= ' '.self::MATCH_MODES[$value['mode']];
    }
    $key = $this->getKey();
    $this->bind[$key] = (string)$value['keyword'];
    return ' MATCH (' . implode(', ', $value['columns']) . ') AGAINST (:' . $key . $mode . ')';
  }

  private function buildWhere(array $where): array {
    $and_query = [];
    foreach ($where as $name => $value) {
      if (str_starts_with($name, 'OR')) {
        $add_query = $this->buildWhere($value);
        $and_query[] = '('.implode(' OR ', $add_query).')';
        continue;
      }
      if (str_starts_with($name, 'AND')) {
        $add_query = $this->buildWhere($value);
        $and_query[] = '('.implode(' AND ', $add_query).')';
        continue;
      }
      if (str_starts_with($name, 'MATCH')) {
        $match = $this->buildMatch($value);
        if ($match) {
          $and_query[] = $match;
        }
        continue;
      }
      [$key, $q] = $this->prepareColumn($name, $value);
      $and_query[] = $q;
      if ($key) {
        $this->bind[$key] = $value;
      }
    }
    return $and_query;
  }

  private function buildOrder(array|string $value): void {
    if (!is_array($value)) {
      $value = [$value];
    }
    $q = [];
    foreach ($value as $name => $order) {
      if (!is_numeric($name)) {
        $order = $name;
      }
      if ($order === 'DESC' || $order === 'ASC') {
        $q[count($q) - 1] .= ' '.$order;
      } else {
        $q[] = "`{$order}`";
      }
    }
    $this->order = 'ORDER BY '.implode(', ', $q);
  }

  private function buildLimit(mixed $value): void {
    $limit = 0;
    $offset = 0;
    if (is_array($value)) {
      [$offset, $limit] = array_map('intval', $value);
    } elseif (is_numeric($value)) {
      $limit = (int)$value;
    }
    $q = 'LIMIT '.$limit;
    if ($offset) {
      $q .= ' OFFSET '.$offset;
    }
    $this->limit = $q;
  }

  protected function prepare(): void {
    $and_query = [];
    foreach ($this->raw as $name => $value) {
      if ($name === self::FIELD_ORDER) {
        $this->buildOrder($value);
        continue;
      }
      if ($name === self::FIELD_LIMIT) {
        $this->buildLimit($value);
        continue;
      }
      $and_query[] = implode(' AND ', $this->buildWhere([$name => $value]));
    }
    $this->query[] = 'WHERE';
    $this->query[] = implode(' AND ', $and_query);
    $this->query[] = $this->order;
    $this->query[] = $this->limit;
  }
}
