<?php namespace Wechat;

class Request {
  /**
   * @var bool
   */
  private $_valid;

  /**
   * @var array
   */
  private $data = [
    'fromusername' => '',
    'tousername' => '',
  ];

  /**
   * @param string $token
   * @param string $input post data
   */
  public function __construct($token='', $input='') {
    $this->_valid = self::checkSignature($token);

    if ($input = $input ?: file_get_contents('php://input')) {
      foreach (simplexml_load_string($input) as $key => $value) {
        $this->data[strtolower($key)] = (string)$value;
      }
    }
  }

  /**
   * @return array
   */
  public function toArray() {
    return $this->data;
  }

  /**
   * @return bool
   */
  public function valid() {
    return $this->_valid;
  }

  /**
   * @param string $name
   * @return string
   */
  public function __get($name) {
    return isset($this->data[strtolower($name)]) ?
      $this->data[strtolower($name)]: null;
  }

  /**
   * @param string $token
   * @param array $params
   * @return bool
   */
  public static function checkSignature($token, $params=[]) {
    if ($params = $params ?: $_GET) {
      return self::createSignature(
        $token, $params['timestamp'], $params['nonce']) == $params['signature'];
    } else {
      return false;
    }
  }

  /**
   * @param string $token
   * @param string $timestamp
   * @param string $nonce
   * @return string
   */
  public static function createSignature($token, $timestamp, $nonce) {
    $array = [$token, $timestamp, $nonce];
    sort($array, SORT_STRING);
    return sha1(implode($array));
  }
}
