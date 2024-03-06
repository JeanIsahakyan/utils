<?php

namespace JI\Cache;


interface CacheInterface {
  public function get(string $key): mixed;
  public function set(string $key, mixed $value, ?int $ttl = null): bool;
  public function add(string $key, mixed $value, ?int $ttl = null): bool;
  public function delete(string $key): bool;
  public function increment(string $key, int $value): false|int;
  public function addOrIncrement(string $key, int $value, ?int $ttl = null);
}
