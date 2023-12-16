<?php
namespace JI\Database\Utils;

/**
 * @author Zhan Isaakian <jeanisahakyan@gmail.com>
 */
class Limits {
  private $count  = null;
  private $cursor = null;

  public function getCount(): ?int {
    return $this->count;
  }

  public function setCount(?int $count): Limits {
    $this->count = $count;
    return $this;
  }

  public function getCursor(): ?int {
    return $this->cursor;
  }

  public function setCursor(?int $cursor): Limits {
    $this->cursor = $cursor;
    return $this;
  }

  public static function create(): self {
    return new self();
  }
}
