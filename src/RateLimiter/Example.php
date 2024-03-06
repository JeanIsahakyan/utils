<?php
namespace JI\RateLimiter;

use JI\Cache\Cache;
use Memcached;

/**
 * @author Zhan Isaakian <jeanisahakyan@gmail.com>
 */
class Example extends AbstractRateLimiter {
  protected static $instance;

  /**
   * @return self
   */
  public static function getInstance() {
    if (!self::$instance) {
      $mc = new Memcached();
      $mc->addServer('host', 'port');
      $instance = Cache::getInstance($mc);
      self::$instance = self::create()->setCache($instance);
    }
    return self::$instance;
  }
}

