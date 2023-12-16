<?php
namespace JI\Utils;

/**
 * @author Zhan Isaakian <jeanisahakyan@gmail.com>
 */
class Arrays {
  /**
   * @param mixed[] $array
   *
   * @return int[]
   */
  public static function forceInt(array $array) {
    return array_unique(array_map(fn($value) => (int)$value, $array));
  }

  /**
   * @param mixed[] $array
   *
   * @return string[]
   */
  public static function forceString(array $array) {
    return array_unique(array_map(fn ($value) => (string)$value, $array));
  }

  /**
   * @param $var
   * @param $key
   * @param $value
   */
  private static function nestedArrayPush(&$var, $key, $value) {
    if (!empty($var) && is_array($var)) {
      foreach ($var as $inner_key => &$inner_var) {
        if (!empty($inner_var) && is_array($inner_var) && $inner_key != $key) {
          self::nestedArrayPush($inner_var, $key, $value);
        } elseif($inner_key == $key && $value) {
          $inner_var = $value;
        }
      }
    } else {
      $var[$key] = $value;
    }
  }

  /**
   * @param $vars
   * @param $value
   * @param array $variable
   *
   * @return array
   */
  public static function nestedArray($vars, $value, &$variable = []) {
    foreach ($vars as $i => $key) {
      if ($i == count($vars) - 1) {
        self::nestedArrayPush($variable, $key, $value);
      } else {
        self::nestedArrayPush($variable, $key, []);
      }
    }
    return $variable;
  }

  /**
   * @param string $json
   *
   * @return mixed
   */
  public static function json2Assoc($json) {
    return json_decode($json, true);
  }

  /**
   * @param array $data
   * @param int|string $index
   * @return mixed|null
   */
  public static function getValueOrNull(array $data, $index) {
    if (!array_key_exists($index, $data)) {
      return null;
    }
    if (is_numeric($data[$index])) {
      return (int)$data[$index];
    }
    return trim((string)$data[$index]);
  }
}
