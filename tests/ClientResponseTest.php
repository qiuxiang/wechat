<?php

class ClientResponseTest extends PHPUnit_Framework_TestCase {
  public function testConstructor() {
    $xml = '
      <xml>
        <ToUserName><![CDATA[toUser]]></ToUserName>
        <FromUserName><![CDATA[fromUser]]></FromUserName>
        <CreateTime>1348831860</CreateTime>
        <MsgType><![CDATA[text]]></MsgType>
        <Content><![CDATA[this is a test]]></Content>
        <MsgId>1234567890123456</MsgId>
      </xml>';
    $response = new Wechat\Client\Response($xml);

    $this->assertEquals($xml, $response->raw());
    $this->assertEquals('toUser', $response->ToUserName);
    $this->assertEquals('fromUser', $response->FromUserName);
    $this->assertEquals('1348831860', $response->CreateTime);
    $this->assertEquals('text', $response->MsgType);
    $this->assertEquals('this is a test', $response->Content);
  }
}
