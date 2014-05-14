<?php namespace Wechat;

class Wechat {
  /**
   * @var Wechat/Request
   */
  public $request;

  /**
   * @var Wechat/Response
   */
  public $response;

  /**
   * @param string $token
   */
  public function __construct($token='') {
    $this->request = new Request($token);
    $this->response = new Response(
      $this->request->toUserName, $this->request->fromUserName);
  }
}
