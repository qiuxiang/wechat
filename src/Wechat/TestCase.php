<?php namespace Wechat;

use PHPUnit_Framework_TestCase;
use SimpleXMLElement;
use Requests;
use Requests_Exception;

class TestCase extends PHPUnit_Framework_TestCase {
  /**
   * @var string
   */
  public $fromUserName = '';

  /**
   * @var string
   */
  public $toUserName = '';

  /**
   * @var string
   */
  public $token = '';

  /**
   * @var string
   */
  public $serverUrl = '';

  /**
   * @param string $type
   * @param mixed $data
   * @return SimpleXMLElement
   */
  public function send($type, $data) {
    $array = array(
      'MsgType' => $type,
      'FromUserName' => $this->fromUserName,
      'ToUserName' => $this->toUserName,
    );

    foreach ($data as $key => $value) {
      $array[$key] = $value;
    }

    if (!isset($array['MsgId'])) {
      $array['MsgId'] = mt_rand();
    }

    if (!isset($array['CreateTime'])) {
      $array['CreateTime'] = time();
    }

    return simplexml_load_string(Requests::post(
      $this->createUrl(), array(), $this->array2xml($array))->body);
  }

  /**
   * @return string
   */
  public function createUrl() {
    $prefix = strpos($this->serverUrl, '?') ? '&' : '?';
    $timestamp = time();
    $nonce = mt_rand();

    return $this->serverUrl . $prefix . http_build_query(array(
      'timestamp' => $timestamp,
      'nonce' => $nonce,
      'signature' => Request::createSignature(
         $this->token, $timestamp, $nonce),
    ));
  }

  /**
   * @param array $array
   * @return string
   */
  public function array2xml($array) {
    $xml = '<xml>';

    foreach ($array as $key => $value) {
      $xml .= '<' . ucfirst($key) . '>';
      $xml .= $value;
      $xml .= '</' . ucfirst($key) . '>';
    }

    return $xml . '</xml>';
  }

  public function setUp() {
    try {
      Requests::get($this->serverUrl);
    } catch (Requests_Exception $e) {
      $this->markTestSkipped($this->serverUrl . ' unable to connect');
    }
  }
}
