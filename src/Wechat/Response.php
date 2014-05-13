<?php

class Wechat_Response {
  /**
   * @var string
   */
  private $to;

  /**
   * @var string
   */
  private $from;

  /**
   * @param string $from
   * @param string $to
   */
  public function __construct($from='', $to='') {
    $this->from = $from;
    $this->to = $to;
  }

  /**
   * @param string $text
   */
  public function text($text) {
    $this->__invoke('text', $text);
  }

  /**
   * @param array $news
   */
  public function news($news) {
    $this->__invoke('news', $news);
  }

  /**
   * @param string $type
   * @param array $data
   */
  public function __invoke($type, $data) {
    $class = 'Wechat_Message_' . ucfirst(strtolower($type));
    $message = new $class($this->from, $this->to, $data);
    echo $message;
  }
}
