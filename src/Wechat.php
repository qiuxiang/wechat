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
   * @var string
   */
  public $token;

  /**
   * @param string $token
   */
  public function __construct($token='') {
    $this->token = $token;
    $this->request = new Request($token);
    $this->response = new Response(
      $this->request->toUserName, $this->request->fromUserName);
  }
}
