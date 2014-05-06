<?php

class Wechat {
  /**
   * @var Wechat_Request
   */
  public $request;

  /**
   * @var Wechat_Response
   */
  public $response;

  /**
   * @param string $token
   */
  public function __construct($token='') {
    $this->request = new Wechat_Request($token);
    $this->response = new Wechat_Response(
      $this->request->toUserName, $this->request->fromUserName);
  }
}
