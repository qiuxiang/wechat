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
    $this->assertEquals('toUser', $response->toUserName);
    $this->assertEquals('fromUser', $response->fromUserName);
    $this->assertEquals('1348831860', $response->createTime);
    $this->assertEquals('text', $response->msgtype);
    $this->assertEquals('this is a test', $response->content);
  }

  public function testXml2array() {
    $this->assertEquals(
      ['a' => 'b', 'b' => 'c'],
      Wechat\Client\Response::xml2array('<xml><a>b</a><b>c</b></xml>'));
  }
}
