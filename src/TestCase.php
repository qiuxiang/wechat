<?php namespace Wechat;

use PHPUnit_Framework_TestCase;
use SimpleXMLElement;
use Requests;
use Requests_Exception;

class TestCase extends PHPUnit_Framework_TestCase {
  /**
   * @var string
   */
  protected $fromUserName = '';

  /**
   * @var string
   */
  protected $toUserName = '';

  /**
   * @var string
   */
  protected $token = '';

  /**
   * @var string
   */
  protected $serverUrl = '';

  /**
   * @var Client
   */
  protected $client;

  public function __construct() {
    $this->client = new Client(
      $this->serverUrl,
      $this->token,
      $this->fromUserName,
      $this->toUserName);
  }

  /**
   * @param string $type
   * @param mixed $data
   * @return SimpleXMLElement
   */
  public function send($type, $data) {
    return $this->client->send($type, $data);
  }

  public function setUp() {
    try {
      Requests::get($this->serverUrl);
    } catch (Requests_Exception $e) {
      $this->markTestSkipped($this->serverUrl . ' unable to connect');
    }
  }
}
