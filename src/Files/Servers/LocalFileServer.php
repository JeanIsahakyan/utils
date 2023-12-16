<?php
namespace JI\Files\Servers;

use JI\Files\File;

/**
 * @author Zhan Isaakian <jeanisahakyan@gmail.com>
 */
class LocalFileServer extends AbstractFileServer {

  public const FIELD_DIRECTORY = 'directory';
  public const FIELD_HOST = 'host';
  public const FIELD_ROOT_DIR = 'root_dir';

  private string $host = '';
  private string $root_dir = '';
  private string $directory = 'uploads';

  public function __construct(array $config) {
    parent::__construct($config);
    if (!$config[self::FIELD_HOST]) {
      throw new \Exception('host is required');
    }
    if (!$config[self::FIELD_ROOT_DIR]) {
      throw new \Exception('root_dir is required');
    }
    $this->host = $config[self::FIELD_HOST];
    $this->root_dir = $config[self::FIELD_ROOT_DIR];
    if ($config[self::FIELD_DIRECTORY]) {
      $this->directory = $config[self::FIELD_DIRECTORY];
    }
  }

  private function getInternalDir(string $bucket, string $file = ''): string {
    return $this->root_dir . '/' . $this->directory .'/'.$bucket.'/'.$file;
  }

  public function createBucket(string $bucket): bool {
    $dir = $this->getInternalDir($bucket);
    if (is_dir($dir)) {
      return true;
    }
    return mkdir($dir, 0777, true);
  }

  public function deleteBucket(string $bucket): bool {
    $dir = $this->getInternalDir($bucket);
    if (!is_dir($dir)) {
      return true;
    }
    return rmdir($dir);
  }

  public function getPublicUrl(File $file, $expires = '+1 week'): ?string {
    if (!$file->getHash() || !$file->getExt()) {
      return null;
    }
    return $this->host.'/'.$this->directory.'/'.$file->getBucket().'/'.$this->uuidFile($file->getHash(), $file->getExt());
  }

  public function saveFile(string $bucket, string $ext, string $local_path): ?string {
    if (!$this->createBucket($bucket)) {
      return null;
    }
    $uuid = $this->uuid();
    if (!$uuid) {
      return null;
    }
    $dir = $this->getInternalDir($bucket, $this->uuidFile($uuid, $ext));
    if (!copy($local_path, $dir)) {
      return null;
    }
    return $uuid;
  }

  public function saveContent(string $bucket, string $ext, string $content_type, string $content): ?string {
    if (!$this->createBucket($bucket)) {
      return null;
    }
    $uuid = $this->uuid();
    if (!$uuid) {
      return null;
    }
    $dir = $this->getInternalDir($bucket, $this->uuidFile($uuid, $ext));
    if (!file_put_contents($dir, $content)) {
      return null;
    }
    return $uuid;
  }

  public function deleteFile(File $file): bool {
    return @unlink($this->getInternalDir($file->getBucket(), $this->uuidFile($file->getHash(), $file->getExt())));
  }
}

