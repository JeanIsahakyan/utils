<?php

namespace JI\Cache;
use Memcached;

class MC extends AbstractCache {
  private Memcached $mc;

  public function __construct(Memcached $mc) {
    $this->mc = $mc;
  }

  public function get(string $key): mixed {
    return $this->mc->get($key);
  }

  public function set(string $key, mixed $value, ?int $ttl = null): bool {
   return $this->mc->set($key, $value, $ttl);
  }

  public function add(string $key, mixed $value, ?int $ttl = null): bool {
    return $this->mc->add($key, $value, $ttl);
  }

  public function delete(string $key): bool {
    return $this->mc->delete($key);
  }

  public function increment(string $key, int $value): false|int {
    return $this->mc->increment($key, $value);
  }
}
