<?php
namespace JI\Utils;

/**
 * @author Zhan Isaakian <jeanisahakyan@gmail.com>
 */
class Strings {
  public const USERNAME_REGEX = '/[^a-zA-Z0-9_\\-.]/';

  public static function validateEmail(string $email): ?string {
    $email = strtolower($email);
    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return null;
    }
    return $email;
  }

  public static function validateUsername(string $username): ?string {
    $username = trim($username);
    if (!$username) {
      return null;
    }
    $username = preg_replace(self::USERNAME_REGEX, '', $username);
    if (!$username) {
      return null;
    }
    if (!preg_match('/^(?=.{4,32}$)(?![_.-])(?!.*[_.]{2})[a-z0-9._-]+(?<![_.])$/i', $username)) {
      return null;
    }
    return strtolower($username);
  }
}
