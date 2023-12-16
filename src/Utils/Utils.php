<?php
namespace JI\Utils;

/**
 * @author Zhan Isaakian <jeanisahakyan@gmail.com>
 */
class Utils {

  public static function isDevServer(): bool {
    return str_contains(self::getDomain(), 'localhost');
  }

  /**
   * @return string
   */
  public static function getHttpScheme() {
    $proto = Arrays::getValueOrNull($_SERVER, 'HTTP_X_FORWARDED_PROTO');
    if ($proto) {
      return $proto;
    }
    $https = Arrays::getValueOrNull($_SERVER, 'HTTPS');
    if ($https === 'on') {
      return 'https';
    }
    $request_scheme = Arrays::getValueOrNull($_SERVER, 'REQUEST_SCHEME');
    if ($request_scheme) {
      return (string)$request_scheme;
    }
    return 'http';
  }

  /**
   * @return string
   */
  public static function getDomain() {
    return (string)Arrays::getValueOrNull($_SERVER, 'HTTP_HOST');
  }

  /**
   * @return string
   */
  public static function ipAddress() {
    $ip_address = (string)Arrays::getValueOrNull($_SERVER, 'HTTP_CF_CONNECTING_IP');
    if ($ip_address) {
      return $ip_address;
    }
    return (string)Arrays::getValueOrNull($_SERVER, 'REMOTE_ADDR');
  }

  public static function getHost(): string {
    return self::getHttpScheme() .'://'.self::getDomain();
  }

  /**
   * @return string
   */
  public static function getUserAgent() {
    return (string)Arrays::getValueOrNull($_SERVER, 'HTTP_USER_AGENT');
  }
}
