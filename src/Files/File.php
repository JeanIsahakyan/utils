<?php
namespace JI\Files;

use JI\Database\Utils\AbstractItem;
use JI\Utils\Mask;

class File extends AbstractItem {
  private ?int $file_id      = null;
  private ?int $server_id    = null;
  private ?int $flags       = null;
  private ?string $bucket      = null;
  private ?string $hash      = null;
  private ?string $ext       = null;

  public const FIELD_FILE_ID       = 'file_id';
  public const FIELD_FLAGS         = 'flags';
  public const FIELD_SERVER_ID     = 'server_id';
  public const FIELD_EXT           = 'ext';
  public const FIELD_HASH          = 'hash';

  public const FLAG_DELETED = Mask::FLAG_0;
  public const FLAG_BANNED  = Mask::FLAG_1;

  /**
   * @return int|null
   */
  public function getFileId(): ?int {
    return $this->file_id;
  }

  /**
   * @param int|null $file_id
   * @return File
   */
  public function setFileId(?int $file_id): File {
    $this->file_id = $file_id;
    return $this;
  }

  /**
   * @return int|null
   */
  public function getServerId(): ?int {
    return $this->server_id;
  }

  /**
   * @param int|null $server_id
   * @return File
   */
  public function setServerId(?int $server_id): File {
    $this->server_id = $server_id;
    return $this;
  }

  public function getFlags(): int {
    return $this->flags ?? 0;
  }


  public function setFlags(?int $flags): File {
    $this->flags = $flags;
    return $this;
  }

  /**
   * @return string|null
   */
  public function getBucket(): ?string {
    return $this->bucket;
  }

  /**
   * @param string|null $bucket
   * @return File
   */
  public function setBucket(?string $bucket): File {
    $this->bucket = $bucket;
    return $this;
  }

  /**
   * @return string|null
   */
  public function getHash(): ?string {
    return $this->hash;
  }

  /**
   * @param string|null $hash
   * @return File
   */
  public function setHash(?string $hash): File {
    $this->hash = $hash;
    return $this;
  }

  /**
   * @return string|null
   */
  public function getExt(): ?string {
    return $this->ext;
  }

  /**
   * @param string|null $ext
   * @return File
   */
  public function setExt(?string $ext): File {
    $this->ext = $ext;
    return $this;
  }

  private function checkFlag(int $flag): bool {
    return $this->getFlags() & $flag;
  }

  public function isDeletedOrBanned(): bool {
    return $this->isDeleted() || $this->isBanned();
  }

  public function isDeleted(): bool {
    return $this->checkFlag(self::FLAG_DELETED);
  }

  public function isBanned(): bool {
    return $this->checkFlag(self::FLAG_BANNED);
  }

  public function getPublicUrl(): ?string {
    if ($this->isDeletedOrBanned() || !$this->getServerId()) {
      return null;
    }
    $server = FileServers::getInstance()->getServer($this->getServerId());
    if (!$server) {
      return null;
    }
    return $server->getPublicUrl($this);
  }

}


