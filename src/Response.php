<?php namespace Wechat;

class Response {
  /**
   * @var string
   */
  private $to;

  /**
   * @var string
   */
  private $from;

  /**
   * @var bool
   */
  private $_responded = false;

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
    if (!$this->_responded) {
      $class = 'Wechat\\Message\\' . ucfirst(strtolower($type));
      $message = new $class($this->from, $this->to, $data);
      echo $message;
      $this->_responded = true;
    }
  }

  /**
   * @return bool
   */
  public function responded() {
    return $this->_responded;
  }
}
