<?php

namespace JI\Database\Internal\Traits;
use JI\Database\Utils\FullID;
use JI\Database\Utils\ItemsList;
use JI\Database\Utils\Limits;

/**
 * @author Zhan Isaakian <jeanisahakyan@gmail.com>
 */
trait ListsTrait {

  public function loadMany(string $table, $columns, array $where, Limits $limits, string $id_field = 'id', array $options = []): ItemsList {
    $items = ItemsList::create();
    $items->setTotalCount($this->count($table, '*', $where));
    if (!$items->getTotalCount() || !$limits->getCount()) {
      return $items;
    }
    $select = [
      'LIMIT' => $limits->getCount(),
      'ORDER' => $options['ORDER'] ?? [$id_field => 'DESC'],
    ];
    $cursor = $limits->getCursor();
    if ($cursor < 0) {
      $select[$id_field.'[<]'] = -$cursor;
    } else if ($cursor > 0) {
      $select[$id_field.'[>]'] = $cursor;
    }
    if ($columns !== '*') {
      if (!is_array($columns)) {
        $columns = [$columns];
      }
      if (!array_key_exists($id_field, $columns)) {
        $columns[] = $id_field;
      }
    }
    $rows            = array_reverse($this->select($table, $columns, $select + $options + $where));
    $items->setItems($rows);
    $previous_cursor = $rows[0][$id_field];
    $next_cursor     = $rows[count($rows) - 1][$id_field];
    if ($this->countAfter($table, $where, $next_cursor, $id_field)) {
      $items->setNextCursor($next_cursor);
    }
    if ($this->countBefore($table, $where, $previous_cursor, $id_field)) {
      $items->setPreviousCursor(-$previous_cursor);
    }
    return $items;
  }

  /**
   * always returns [$count, $rows, $offset]
   */
  public function loadManyOffset($table, $join, array $where = [], ?int $limit = 10, ?int $offset = 0): array {
    $join_count = $join;
    if (is_array($join)) {
      [$join_count] = $join;
    }
    $count = $this->count($table, $join_count, $where);
    if (!$limit) {
      return [$count, [], 0];
    }
    if (!$count) {
      return [$count, [], 0];
    }
    $where = array_merge($where, [
      'LIMIT'   => [
        $offset,
        $limit,
      ],
    ]);
    $rows = $this->select($table, $join, $where);
    $offset += count($rows);
    return [$count, $rows, $offset];
  }

  public function loadItems(string $table, array $item_ids, string|array $join, array $items_fields): array {
    $or_items = [];
    foreach ($item_ids as $item_id) {
      $or_params = [];
      foreach ($item_id->getId() as $index => $id) {
        $key = $items_fields[$index];
        if (!$key) {
          continue;
        }
        $or_params[$key] = $id;
      }
      $or_items['AND #' . (string)$item_id] = $or_params;
    }
    $items_where = [
      'OR' => $or_items,
    ];
    $rows = $this->select($table, $join, $items_where);
    $result = [];
    foreach ($item_ids as $item_id) {
      $result[(string)$item_id] = null;
    }
    foreach ($rows as $row) {
      $full_id = [];
      foreach ($items_fields as $field) {
        $full_id[] = $row[$field];
      }
      $result[(string)FullID::create(...$full_id)] = $row;
    }
    return $result;
  }


  public function loadItemsCounts(string $table, array $ids, string $id_field, string $count_field): array {
    $rows = $this->query('SELECT COUNT(' . $count_field . ') as cnt, ' . $id_field . ' FROM `'.$table.'` WHERE ' . $id_field . ' IN('.implode(',', $ids).') GROUP BY '. $id_field)
      ->fetchAll(\PDO::FETCH_ASSOC);
    $rows = $this->prepareRows($rows);
    $result = [];
    foreach ($rows as $row) {
      $result[$row[$id_field]] = [
        'count' => $row['cnt'],
      ];
    }
    foreach ($ids as $id) {
      if (!array_key_exists($id, $result)) {
        $result[$id] = [
          'count' => 0,
        ];
      }
    }
    return $result;
  }
}
