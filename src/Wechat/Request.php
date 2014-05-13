<?php

class Wechat_Request {
  /**
   * @var bool
   */
  private $isValid;

  /**
   * @var array
   */
  private $data = array(
    'fromusername' => '',
    'tousername' => '',
  );

  /**
   * @param string $token
   * @param string $input post data
   */
  public function __construct($token='', $input='') {
    $this->isValid = self::checkSignature($token);

    if ($input = $input ?: file_get_contents('php://input')) {
      foreach (simplexml_load_string($input) as $key => $value) {
        $this->data[strtolower($key)] = $value->__toString();
      }
    }

    if ($this->isValid && isset($_GET['echostr'])) {
      echo $_GET['echostr'];
    }
  }

  /**
   * @return bool
   */
  public function valid() {
    return $this->isValid;
  }

  /**
   * @param string $name
   */
  public function __get($name) {
    return $this->data[strtolower($name)];
  }

  /**
   * @param string $token
   * @param array $params
   * @return bool
   */
  public static function checkSignature($token, $params=array()) {
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
    $array = array($token, $timestamp, $nonce);
    sort($array, SORT_STRING);
    return sha1(implode($array));
  }
}