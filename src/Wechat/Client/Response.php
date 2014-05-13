<?php namespace Wechat\Client;

class Response {
  /**
   * @var array
   */
  private $data;

  /**
   * @var string
   */
  private $_raw;

  public function __construct($response) {
    $this->_raw = $response;
    @$this->data = self::xml2array($response);
  }

  /**
   * @param $xml string
   * @return string
   */
  public static function xml2array($xml) {
    $array = [];

    foreach (simplexml_load_string($xml) as $key => $value) {
      $array[strtolower($key)] = (string)$value;
    }

    return $array;
  }

  /**
   * @return string
   */
  public function raw() {
    return $this->_raw;
  }

  /**
   * @param string $name
   */
  public function __get($name) {
    return $this->data[strtolower($name)];
  }
}
