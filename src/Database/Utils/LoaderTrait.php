<?php
namespace JI\Database\Utils;

use ArrayObject;

/**
 * @author Zhan Isaakian <jeanisahakyan@gmail.com>
 */
trait LoaderTrait {
  private ArrayObject $needed;
  private ArrayObject $loaded;

  private static ?self $loader_instance = null;

  public function __construct() {
    $this->needed = new ArrayObject([]);
    $this->loaded = new ArrayObject([]);
  }

  /**
   * @param FullID[] $item_ids
   * @return mixed
   */
  abstract static function loadItems(array $item_ids);
  abstract static function skeleton(FullID $item_id, mixed $item);
  abstract static function fromArray(array $item);

  public static function loader(): self {
    if (!self::$loader_instance) {
      self::$loader_instance = new self();
    }
    return self::$loader_instance;
  }

  /**
   * @param FullID[] $item_ids
   * @param mixed[] $items
   */
  private function processLoaded(array $item_ids, array $items): void {
    foreach ($item_ids as $item_id) {
      $item = null;
      $item_id = (string)$item_id;
      if (!array_key_exists($item_id, $items) || $items[$item_id] === false) {
        $item = false;
      } else if ($items[$item_id]) {
        $item = $items[$item_id];
      }
      $this->needed->offsetUnset($item_id);
      $this->loaded->offsetSet($item_id, $item);
    }
  }

  public final function needOne(FullID $item_id): self {
    if (!$item_id->getId()) {
      return $this;
    }
    $string_id = (string)$item_id;
    if ($this->needed->offsetExists($string_id)) {
      return $this;
    }
    if ($this->needed->offsetExists($string_id)) {
      return $this;
    }
    $this->needed->offsetSet($string_id, $item_id);
    return $this;
  }

  public final function needMany(array $item_ids): self {
    foreach ($item_ids as $item_id) {
      $this->needOne($item_id);
    }
    return $this;
  }

  public final function load(): self {
    if ($this->needed->count() === 0) {
      return $this;
    }
    /**
     * @var FullID[] $items_ids
     */
    $items_ids = array_values($this->needed->getArrayCopy());
    $this->processLoaded($items_ids, self::loadItems($items_ids));
    return $this;
  }

  public function getOne(FullID $item_id) {
    $item = $this->loaded->offsetGet((string)$item_id);
    if ($item === null || $item === false) {
      if (method_exists($this, 'skeleton')) {
        $item = self::skeleton($item_id, $item);
      } else {
        $item = [];
      }
    }
    return self::fromArray($item);
  }

  public function clearOne(FullID $item_id): self {
    $this->needed->offsetUnset((string)$item_id);
    $this->loaded->offsetUnset((string)$item_id);
    return $this;
  }

  /**
   * @param FullID[] $item_ids
   */
  public function clearMany(array $item_ids): self {
    foreach ($item_ids as $item_id) {
      $this->clearOne($item_id);
    }
    return $this;
  }

  public final function clearAll(): self {
    $this->loaded->exchangeArray([]);
    $this->needed->exchangeArray([]);
    return $this;
  }

  public function fetchOne(FullID $item_id) {
    return $this->needOne($item_id)
      ->load()
      ->getOne($item_id);
  }
}
