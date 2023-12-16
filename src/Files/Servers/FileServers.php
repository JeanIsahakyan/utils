<?php
namespace JI\Files\Servers;

/**
 * @author Zhan Isaakian <jeanisahakyan@gmail.com>
 */
class FileServers {
  public const TYPE_LOCAL_SERVER = 0;
  public const TYPE_S3_SERVER = 1;

  /**
   * @var FileServerInterface[] $servers
   */
  private array $servers = [];
  protected static $instance;

  public static function getInstance(): self {
    if (!self::$instance) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  public function registerServer(array $config): self {
    $this->servers[$config['id']] = self::createServer($config);
    return $this;
  }

  public function serverExists(int $server_id): bool {
    return array_key_exists($server_id, $this->servers);
  }

  private function createServer(array $config): ?FileServerInterface {
    return match ($config['type']) {
      self::TYPE_S3_SERVER => S3FileServer::create($config),
      self::TYPE_LOCAL_SERVER => LocalFileServer::create($config),
      default => null,
    };
  }

  public function getServer(int $server_id): ?FileServerInterface {
    if (!$this->serverExists($server_id)) {
      return null;
    }
    return $this->servers[$server_id];
  }

  public function getRandomServer(): ?FileServerInterface {
    if (!$this->servers) {
      return null;
    }
    $server_id = array_rand($this->servers);
    return $this->servers[$server_id];
  }
}
