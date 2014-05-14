<?php namespace Wechat;

use SimpleXMLElement;
use Requests;

class Client {
  /**
   * @var string
   */
  public $url;

  /**
   * @var string
   */
  public $token;

  /**
   * @var string
   */
  public $from;

  /**
   * @var string
   */
  public $to;

  /**
   * @param string $url
   * @param string $token
   * @param string $from
   * @param string $to
   */
  public function __construct($url, $token='', $from='', $to='') {
    $this->url = $url;
    $this->token = $token;
    $this->from = $from;
    $this->to = $to;
  }

  /**
   * @param string $type
   * @param mixed $data
   * @return SimpleXMLElement
   */
  public function send($type, $data) {
    $array = [
      'MsgType' => $type,
      'FromUserName' => $this->from,
      'ToUserName' => $this->to,
    ];

    if ($type == 'text' && is_string($data)) {
      $array['content'] = $data;
    } else {
      foreach ($data as $key => $value) {
        $array[$key] = $value;
      }
    }

    if (!isset($array['MsgId'])) {
      $array['MsgId'] = mt_rand();
    }

    if (!isset($array['CreateTime'])) {
      $array['CreateTime'] = time();
    }

    return new Client\Response(Requests::post(
      $this->createUrl(), [], self::array2xml($array))->body);
  }

  /**
   * @return string
   */
  public function createUrl() {
    $prefix = strpos($this->url, '?') ? '&' : '?';
    $timestamp = time();
    $nonce = mt_rand();

    return $this->url . $prefix . http_build_query([
      'timestamp' => $timestamp,
      'nonce' => $nonce,
      'signature' => Request::createSignature(
          $this->token, $timestamp, $nonce),
    ]);
  }

  /**
   * @param array $array
   * @return string
   */
  public static function array2xml($array) {
    $xml = '<xml>';

    foreach ($array as $key => $value) {
      $xml .= '<' . ucfirst($key) . '>';
      $xml .= $value;
      $xml .= '</' . ucfirst($key) . '>';
    }

    return $xml . '</xml>';
  }
}
