<?php namespace Wechat\Client;

use SimpleXMLElement;

class Response {
  /**
   * @var SimpleXMLElement
   */
  private $data;

  /**
   * @var string
   */
  private $_raw;

  public function __construct($response) {
    $this->_raw = $response;
    @$this->data = simplexml_load_string($response);
  }

  /**
   * @return string
   */
  public function raw() {
    return $this->_raw;
  }

  /**
   * @param string $name
   * @return SimpleXMLElement
   */
  public function __get($name) {
    return $this->data->$name;
  }
}
