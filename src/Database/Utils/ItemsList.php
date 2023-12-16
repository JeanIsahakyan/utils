<?php
namespace JI\Database\Utils;

/**
 * @author Zhan Isaakian <jeanisahakyan@gmail.com>
 */
class ItemsList {
  private int $total_count = 0;
  private mixed $next_cursor = null;
  private mixed $previous_cursor = null;
  private array $items = [];

  public function getTotalCount(): int {
    return $this->total_count;
  }

  public function setTotalCount(int $total_count): ItemsList {
    $this->total_count = $total_count;
    return $this;
  }

  public function getNextCursor() {
    return $this->next_cursor;
  }

  public function setNextCursor(int $next_cursor) {
    $this->next_cursor = $next_cursor;
    return $this;
  }


  public function getPreviousCursor() {
    return $this->previous_cursor;
  }

  public function setPreviousCursor(int $previous_cursor) {
    $this->previous_cursor = $previous_cursor;
    return $this;
  }


  public function getItems() {
    return $this->items;
  }

  public function setItems($items): ItemsList {
    $this->items = $items;
    return $this;
  }

  public function getLastItem() {
   return $this->getItems()[count($this->getItems()) - 1];
  }

  public function getFirstItem() {
   return $this->getItems()[0];
  }

  public static function create(): self {
    return new self();
  }
}
