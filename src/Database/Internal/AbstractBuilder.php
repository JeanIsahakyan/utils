<?php

namespace JI\Database\Internal;
use PDO;

/**
 * @author Zhan Isaakian <jeanisahakyan@gmail.com>
 */
abstract class AbstractBuilder {
  protected array $raw;
  protected array $query = [];
  protected array $bind = [];

  private const PDO_TYPES = [
    'NULL' => PDO::PARAM_NULL,
    'integer' => PDO::PARAM_INT,
    'double' => PDO::PARAM_STR,
    'boolean' => PDO::PARAM_BOOL,
    'string' => PDO::PARAM_STR,
    'object' => PDO::PARAM_STR,
    'resource' => PDO::PARAM_LOB
  ];

  public function __construct(array $raw = []) {
    $this->raw = $raw;
    $this->prepare();
  }

  public final static function create(array $raw = []): static {
    return new static($raw);
  }

  abstract protected function prepare();

  protected function getKey(): string {
    return sha1(random_bytes(16));
  }

  public final function getParams(): array {
    $result = [];
    foreach ($this->bind as $key => $value) {
      $type = gettype($value);
      if ($type === 'boolean') {
        $value = (int)$value;
      } elseif ($type === 'NULL') {
        $value = null;
      }
      $result[$key] = [$value, self::PDO_TYPES[$type]];
    }
    return $result;
  }

  public final function getQuery(): string {
    return implode(' ', $this->query);
  }
}
