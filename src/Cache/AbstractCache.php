<?php

namespace JI\Cache;


abstract class AbstractCache implements CacheInterface {

  public static function create(array $config): static {
    return new static($config);
  }

  public final function addOrIncrement(string $key, int $value, ?int $ttl = null): int {
    if ($this->add($key, $value, $ttl)) {
      return $value;
    }
    return $this->increment($key, $value);
  }
}
