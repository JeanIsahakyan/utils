<?php
namespace JI\Files\Servers;
use JI\Files\File;

/**
 * @author Zhan Isaakian <jeanisahakyan@gmail.com>
 */
interface FileServerInterface {
  public function __construct(array $config);
  public function getServerId(): int;
  public function getPublicUrl(File $file, $expires = '+1 week'): ?string;
  public function createBucket(string $bucket): bool;
  public function deleteBucket(string $bucket): bool;
  public function saveFile(string $bucket, string $ext, string $local_path): ?string;
  public function deleteFile(File $file): bool;
  public function saveContent(string $bucket, string $ext, string $content_type, string $content): ?string;
}

