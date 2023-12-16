<?php
namespace JI\Database\Utils;

use ReflectionClass;

/**
 * @author Zhan Isaakian <jeanisahakyan@gmail.com>
 */
abstract class AbstractItem {
  private ReflectionClass $_reflection;

  public function __construct() {
    $this->_reflection    = new ReflectionClass($this);
  }

  public static function create(): static {
    return new static();
  }

  final public static function fromArrayArray(array $rows): array {
    return array_map(fn($row): static => static::fromArray($row), $rows);
  }

  /**
   * @param static[] $rows
   * @return array
   */
  final public static function arrayObjectToArray(array $rows): array {
    return array_map(fn($row): array => $row->toArray(), $rows);
  }

  final public static function fromArray(array $row): static {
    $item = static::create();
    foreach ($item->_reflection->getProperties() as $property) {
      $name = $property->getName();
      $value = $row[$name];
      if ($value === null) {
        continue;
      }
      $type = $property->getType();
      if ($type->getName() === 'array') {
        $value = json_decode($value, true);
      }
      $property->setValue($item, $value);
    }
    return $item;
  }

  final public function toArray(): array {
    $row = [];
    foreach ($this->_reflection->getProperties() as $property) {
      $name = $property->getName();
      if (str_starts_with($name, '_')) {
        continue;
      }
      $value = $property->getValue($this);
      if ($value === null) {
        continue;
      }
      $type = $property->getType();
      if ($type->getName() === 'array') {
        $value = json_encode($value);
      }
      $row[$name] = $value;
    }
    return $row;
  }
}
