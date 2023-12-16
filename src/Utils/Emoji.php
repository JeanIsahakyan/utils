<?php
namespace JI\Utils;

/**
 * @author Zhan Isaakian <jeanisahakyan@gmail.com>
 */
class Emoji {
  public static function stripEmoji(string $str): string {
    return trim(preg_replace('/[^\p{L}\p{N}\p{P}\p{Z}]/iu', '', $str));
  }

  public static function isEmojiOnly(string $str): bool {
    return self::noEmojiCount($str) === 0;
  }

  public static function noEmojiCount(string $str): int {
    return mb_strlen(self::stripEmoji($str));
  }

  public static function convertISOCodeToFlagEmoji(string $iso_country_code): string {
    $chars = [''];
    foreach (str_split(strtolower($iso_country_code)) as $letter) {
      $chars[] = chr(ord($letter) + 0x45);
    }
    return implode("\xF0\x9F\x87", $chars);
  }
}
