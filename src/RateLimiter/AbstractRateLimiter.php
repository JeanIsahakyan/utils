<?php

namespace JI\RateLimiter;

use JI\Cache\CacheInterface;

abstract class AbstractRateLimiter {
  public const PREFIX = 'JI';

  private CacheInterface $cache;

  protected static final function create() {
    return new static();
  }

  protected final function setCache(CacheInterface $cache): static {
    $this->cache = $cache;
    return $this;
  }

  private function parse(string $limits): array {
    $limits = explode(',', $limits);
    $result = [];
    foreach ($limits as $limit) {
      $result[] = explode(':', $limit);
    }
    return $result;
  }

  /**
   * @param int[] $limit
   */
  private function getKey(string $name, array $limit): string {
    return static::PREFIX . "_{$name}_".implode('_', $limit);
  }

  public final function checkOrIncr(string $name, string $limits, int $increment = 1): bool {
    foreach ($this->parse($limits) as $limit) {
      [$count, $ttl] = $limit;
      $key = $this->getKey($name, $limit);
      if ($this->cache->add($key, $increment, $ttl)) {
        continue;
      }
      $value = (int)$this->cache->get($key);
      if ($value >= $count) {
        return true;
      }
      $value = $this->cache->increment($key, $increment);
      if ($value > $count) {
        return true;
      }
    }
    return false;
  }

  public final function check(string $name, string $limits): bool {
    foreach ($this->parse($limits) as $limit) {
      [$count,] = $limit;
      if ($count === 0) {
        continue;
      }
      $value = (int)$this->cache->get($this->getKey($name, $limit));
      if (!$value) {
        continue;
      }
      if ($value < $count) {
        continue;
      }
      return true;
    }
    return false;
  }

  public final function clear(string $name, string $limits): void {
    foreach ($this->parse($limits) as $limit) {
      $this->cache->delete($this->getKey($name, $limit));
    }
  }
}


