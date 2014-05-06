<?php

class Wechat_Message_Text extends Wechat_Message {
  /**
   * @param string $text
   */
  public function setData($text) {
    $this->data['MsgType'] = 'text';
    $this->data['Content'] = $text;
  }
}
