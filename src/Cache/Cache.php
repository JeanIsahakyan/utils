<?php

namespace JI\Cache;
use Memcached;
use Redis;

class Cache {
  public static function getInstance(Redis|Memcached $cache): ?CacheInterface {
    if ($cache instanceof Memcached) {
      return new MC($cache);
    }
    if ($cache instanceof Redis) {
      return new RS($cache);
    }
    return null;
  }
}
