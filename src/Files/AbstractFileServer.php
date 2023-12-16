<?php
namespace JI\Files;

use Exception;

abstract class AbstractFileServer implements FileServerInterface {
  private int $server_id;

  final public static function create(array $config): ?static {
    if (!$config['id']) {
      return null;
    }
    $server = new static($config);
    $server->server_id = (int)$config['id'];
    return $server;
  }

  final public function getServerId(): int {
    return $this->server_id;
  }

  final protected function uuid(): string {
    try {
      $hash = bin2hex(random_bytes(16));
    } catch (Exception $exception) {
      $hash = substr(hash('sha256', $string), 10, 32);
    }
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split($hash, 4));
  }

  final protected function uuidFile(string $uuid, $ext): ?string {
    return "{$uuid}.{$ext}";
  }
  abstract public function getPublicUrl(File $file, $expires = '+1 week'): ?string;

  abstract public function saveFile(string $bucket, string $ext, string $local_path): ?string;

  abstract public function saveContent(string $bucket, string $ext, string $content_type, string $content): ?string;

  abstract public function deleteFile(File $file): bool;

  abstract public function createBucket(string $bucket): bool;

  public function __construct(array $config) {

  }

  abstract public function deleteBucket(string $bucket): bool;
}

