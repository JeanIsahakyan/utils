<?php
namespace JI\Database;
/**
 * @author Zhan Isaakian <jeanisahakyan@gmail.com>
 */
class Example extends AbstractDatabase {
  protected static $instance;

  /**
   * @return self
   */
  public static function getInstance() {
    if (!self::$instance) {
      $config = [
        'database_type'     => 'mysql',
        'charset'           => 'utf8mb4',
        'collation'         => 'utf8mb4_unicode_ci',
        'server'            => 'host',
        'database_name'     => 'db_name',
        'username'          => 'username',
        'password'          => 'password',
      ];
      self::$instance = new self($config);
    }
    return self::$instance;
  }


}
