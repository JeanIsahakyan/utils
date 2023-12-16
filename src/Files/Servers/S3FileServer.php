<?php
namespace JI\Files\Servers;

use Aws\S3\S3Client;
use JI\Files\File;

/**
 * @author Zhan Isaakian <jeanisahakyan@gmail.com>
 */
class S3FileServer extends AbstractFileServer {
  private S3Client $s3;

  public function __construct(array $config) {
    parent::__construct($config);
    $this->s3 = new S3Client([
      'version'                 => 'latest',
      'region'                  => $config['region'],
      'endpoint'                => $config['endpoint'],
      'use_path_style_endpoint' => $config['use_path_style_endpoint'],
      'credentials' => [
        'key'         =>  $config['key'],
        'secret'      => $config['secret'],
      ],
    ]);
  }

  public function createBucket(string $bucket): bool {
    if ($this->s3->doesBucketExist($bucket)) {
      return true;
    }
    try {
      $this->s3->createBucket([
        'Bucket' => $bucket,
      ]);
      return true;
    } catch (\Exception $exception) {
      return false;
    }
  }

  public function deleteBucket(string $bucket): bool {
    if (!$this->s3->doesBucketExist($bucket)) {
      return true;
    }
    try {
      $this->s3->deleteBucket([
        'Bucket' => $bucket,
      ]);
      return true;
    } catch (\Exception $exception) {
      return false;
    }
  }

  public function getPublicUrl(File $file, $expires = '+1 week'): ?string {
    if (!$file->getHash() || !$file->getExt()) {
      return null;
    }
    $command = $this->s3->getCommand('GetObject', [
      'Bucket' => $file->getBucket(),
      'Key'    => $this->uuidFile($file->getHash(), $file->getExt()),
    ]);
    $request = $this->s3->createPresignedRequest($command, $expires);
    if (!$request) {
      return null;
    }
    $url = (string)$request->getUri();
    if (!$url) {
      return null;
    }
    return $url;
  }

  public function saveFile(string $bucket, string $ext, string $local_path): ?string {
    if (!$this->createBucket($bucket)) {
      return null;
    }
    $uuid = $this->uuid();
    if (!$uuid) {
      return null;
    }
    try {
      $this->s3->putObject([
        'Bucket'     => $bucket,
        'Key'        => $this->uuidFile($uuid, $ext),
        'SourceFile' => $local_path,
      ]);
    } catch (\Exception $exception) {
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
    try {
      $this->s3->putObject([
        'Bucket'      => $bucket,
        'Key'         => $this->uuidFile($uuid, $ext),
        'Body'        => $content,
        'ContentType' => $content_type,
      ]);
    } catch (\Exception $exception) {
      return null;
    }
    return $uuid;
  }

  public function deleteFile(File $file): bool {
    try {
      $this->s3->deleteObject([
        'Bucket'      => $file->getBucket(),
        'Key'         => $this->uuidFile($file->getHash(), $file->getExt()),
      ]);
      return true;
    } catch (\Exception $exception) {
      return false;
    }
  }
}

