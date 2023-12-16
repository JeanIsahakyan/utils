<?php
namespace JI\Utils;

/**
 * @author Zhan Isaakian <jeanisahakyan@gmail.com>
 */
class Curl {

  private static function parseHeaders(string $content): array {
    $headers = [];
    $content = explode("\r\n", trim($content));
    foreach ($content as $header)  {
      [$key, $value] = explode(': ', $header);
      if ($value === null) {
        $headers['http_code'] = $key;
        continue;
      }
      $headers[$key] = $value;
    }
    return $headers;
  }

  public static function fetchHeaders(string $url): array {
    $link = curl_init();
    curl_setopt_array($link, [
      CURLOPT_HEADER => 1,
    ]);
    $result = self::execRequest($link, $url, true);
    $header_size = curl_getinfo($link, CURLINFO_HEADER_SIZE);
    curl_close($link);
    $headers = substr($result, 0, $header_size);
    return self::parseHeaders($headers);
  }

  public static function fetchGet(string $url, array $params = []) {
    return self::execRequest(curl_init(), $url.'?'.self::buildParams($params));
  }

    public static function fetchPost(string $url, array $params = []) {
      $link = curl_init();
      curl_setopt_array($link, [
        CURLOPT_POST       => 1,
        CURLOPT_POSTFIELDS => self::buildParams($params)
      ]);
      return self::execRequest($link, $url);
    }

    public static function fetchPostJson(string $url, array $params = [], array $headers = []) {
      $link = curl_init();
      if (is_array($params)) {
        $params = json_encode($params);
      }
      curl_setopt_array($link, [
        CURLOPT_POST       => 1,
        CURLOPT_POSTFIELDS => $params,
        CURLOPT_HTTPHEADER => array_merge([
          'Content-Type: application/json',
          'Accept: application/json',
          ], $headers),
      ]);
      return self::execRequest($link, $url);
    }

    private static function execRequest($link, string $url, bool $no_close = false) {
      curl_setopt_array($link, [
        CURLOPT_URL       => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_ENCODING => '',
      ]);
      $res = curl_exec($link);
      if (!$no_close) {
        curl_close($link);
      }
      return $res;
    }

    private static function buildParams(array $params) {
      return urldecode(http_build_query($params));
    }
}
