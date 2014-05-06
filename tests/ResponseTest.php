<?php

class ResponseTest extends PHPUnit_Framework_TestCase {
  public function testConstructor() {
    $response = new Wechat_Response('from', 'to');

    $this->assertEquals('from', $response->from);
    $this->assertEquals('to', $response->to);
  }
}
