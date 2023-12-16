<?php
namespace JI\Utils;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * @author Zhan Isaakian <jeanisahakyan@gmail.com>
 */
class Mail extends PHPMailer {

  protected static $instance;

  private $config = [];

  /**
   * @return self
   */
  public static function getInstance() {
    if (!self::$instance) {
      self::$instance = new self(true);
    }
    return self::$instance;
  }

  public function setConfig(array $config): self {
    $this->config = $config;
    return $this;
  }

  public const FIELD_CHARSET = 'charset';
  public const FIELD_PORT = 'port';
  public const FIELD_HOST = 'host';
  public const FIELD_USERNAME = 'username';
  public const FIELD_PASSWORD = 'password';
  public const FIELD_FROM = 'from';
  public const FIELD_NAME = 'name';

  public function sendMessage(string $to_email, string $subject, string $message, string $language) {
    $this->isSMTP();
    $this->Encoding   = 'base64';
    $this->SMTPAuth   = true;
    $this->SMTPSecure = 'tls';
    $this->CharSet    = $this->config[self::FIELD_CHARSET];
    $this->Port       = $this->config[self::FIELD_PORT];
    $this->Host       = $this->config[self::FIELD_HOST];
    $this->Username   = $this->config[self::FIELD_USERNAME];
    $this->Password   = $this->config[self::FIELD_PASSWORD];
    $this->SMTPOptions = [
      'ssl' => [
        'verify_peer'       => false,
        'verify_peer_name'  => false,
        'allow_self_signed' => true
      ]
    ];
    $this->setFrom($this->config[self::FIELD_FROM], '=?'.$this->CharSet.'?B?'.base64_encode($this->config[self::FIELD_NAME]).'?=');
    $this->language = $language;
    $this->addAddress($to_email);
    $this->isHTML(true);
    $this->Subject = $subject;
    $this->Body    = $message;
    $this->AltBody = strip_tags($message);
    return $this->send();
  }

}
