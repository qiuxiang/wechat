<?php namespace Wechat\Message;

use Wechat\Message;

class Text extends Message {
  /**
   * @param string $text
   */
  public function setData($text) {
    $this->data['MsgType'] = 'text';
    $this->data['Content'] = $text;
  }
}
