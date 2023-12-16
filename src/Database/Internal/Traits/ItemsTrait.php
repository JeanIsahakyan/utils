<?php

namespace JI\Database\Internal\Traits;
use JI\Database\Utils\AbstractItem;
use JI\Database\Utils\FullID;


/**
 * @author Zhan Isaakian <jeanisahakyan@gmail.com>
 */
trait ItemsTrait {

  public function insertItem(string $table, AbstractItem $insert): bool {
    return (bool)$this->insert($table, $insert->toArray());
  }

  public function insertItemWithId(string $table, AbstractItem $insert): ?int {
    return $this->insertWithId($table, $insert->toArray());
  }

  public function deleteItem(string $table, FullID $item_id, array $columns): bool {
    return (bool)$this->delete($table, $item_id->toColumns($columns));
  }

  public function updateItem(string $table, AbstractItem $update, FullID $item_id, array $columns): bool {
    return (bool)$this->update($table, $update->toArray(), $item_id->toColumns($columns));
  }
}
