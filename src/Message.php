<?php namespace Wechat;

use LSS\Array2XML;

abstract class Message {
  /**
   * @var array
   */
  protected $data = array();

  /**
   * @param string $from
   * @param string $to
   * @param mixed $data
   */
  public function __construct($from='', $to='', $data) {
    $this->data = array(
      'FromUserName' => $from,
      'ToUserName' => $to,
      'CreateTime' => time(),
    );

    $this->setData($data);
  }

  /**
   * @return string
   */
  public function __toString() {
    $xml = Array2XML::createXML('xml', $this->data);
    return substr($xml->saveXML(), 39);
  }

  /**
   * @param mixed $data
   */
  abstract public function setData($data);
}
