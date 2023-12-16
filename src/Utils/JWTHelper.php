<?php

namespace JI\Utils;

use Firebase\JWT\JWT;

/**
 * @author Zhan Isaakian <jeanisahakyan@gmail.com>
 */
class JWTHelper {

  public static function decode(string $jwt, string $secret): ?object {
    try {
      return JWT::decode($jwt, $secret, ['HS256']);
    } catch (\Exception $e) {
      return null;
    }
  }

  public static function encode(array $payload, int $exp, string $secret): string {
    $payload = array_merge([
      'iat'  => Time::getTime(),
      'nbf'  => Time::getTime(),
    ], $payload);
    if ($exp) {
      $payload['exp'] = $exp;
    }
    return JWT::encode($payload, $secret);
  }
}

