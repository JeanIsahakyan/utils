<?php

namespace JI\Database\Utils;

/**
 * @author Zhan Isaakian <jeanisahakyan@gmail.com>
 */
class FullID {
  private const HASH_GLUE = '_ID_ITEM_';
  public const SEPARATOR  = '_';

  /**
   * @var int[]|string[]
   */
  protected array $id = [];

  /**
   * @param int[]|string[] $id
   */
  public function __construct(...$id) {
    $this->id       = $id;
  }

  /**
   * @return int[]|string[]
   */
  public function getId(): array {
    return $this->id;
  }

  /**
   * @param int[]|string[] $id
   */
  public static function create(...$id): FullID {
    return new self(...$id);
  }

  /**
   * @param int[]|string[] $id
   * @return string
   */
  private function toString(array $id): string {
    return implode(self::SEPARATOR, $id);
  }

  private static function getHash(array $ids): string {
    return hash('sha256', implode(self::HASH_GLUE, $ids));
  }

  public function __toString(): string {
    return $this->string();
  }

  public function string(): string {
    return $this->toString($this->id);
  }


  public static function fromString(string $full_id): ?self {
    return self::create(...explode(self::SEPARATOR, $full_id));
  }

  public static function fromPublicString(string $full_id): ?self {
    $full_id = explode(self::SEPARATOR, $full_id);
    $hash = array_shift($full_id);
    if (self::getHash($full_id) !== $hash) {
      return null;
    }
    return self::create(...$full_id);
  }

  public function stringPublic(): string {
    return $this->toString([self::getHash($this->id), ...$this->id]);
  }

  /**
   * @param int[][]|string[][] $full_ids
   * @return self[]
   */
  public static function fromArray(array $full_ids): array {
    return array_map(fn(array $full_id) => self::create(...$full_id), $full_ids);
  }

  /**
   * @param string[] $full_ids
   * @return self[]
   */
  public static function fromStringArray(array $full_ids): array {
    return array_map(fn(string $full_id) => self::fromString($full_id), $full_ids);
  }

  /**
   * @param string[] $columns
   * @return string[][]|int[][]
   */
  public function toColumns(array $columns): array {
    return array_combine($columns, $this->id);
  }
}

