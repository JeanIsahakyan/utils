<?php

namespace JI\Cache;
use Redis;

class RS extends AbstractCache {
  private Redis $rs;

  public function __construct(Redis $redis) {
    $this->rs = $redis;
  }

  public function get(string $key): mixed {
    try {
      return $this->rs->get($key);
    } catch (\RedisException $exception) {
      return false;
    }
  }

  public function set(string $key, mixed $value, ?int $ttl = null): bool {
    try {
      $result = $this->rs->set($key, $value);
      if ($result && $ttl) {
        $this->rs->expire($key, $ttl);
      }
      return $result;
    } catch (\RedisException $exception) {
      return false;
    }
  }

  public function add(string $key, mixed $value, ?int $ttl = null): bool {
    $result = $this->get($key);
    if ($result) {
      return false;
    }
    return $this->set($key, $value, $ttl);
  }

  public function delete(string $key): bool {
    try {
      return $this->rs->del($key);
    } catch (\RedisException $exception) {
      return false;
    }
  }

  public function increment(string $key, int $value): false|int {
    try {
      return $this->rs->incr($key, $value);
    } catch (\RedisException $exception) {
      return false;
    }
  }
}
