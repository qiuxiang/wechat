<?php

class RequestTest extends PHPUnit_Framework_TestCase {
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
    $request = new Wechat\Request('token', $xml);

    foreach (simplexml_load_string($xml) as $key => $value) {
      $this->assertEquals($request->{$key}, $value);
      $this->assertEquals($request->{strtolower($key)}, $value);
    }
  }

  public function testCreateSignature() {
    $this->assertEquals(
      'f97c166a920dc3196fadb9e668ed91ed8a593bfe',
      Wechat\Request::CreateSignature('token', 1397911023, 2056994866));

    $this->assertNotEquals(
      'a97c166a920dc3196fadb9e668ed91ed8a593bfe',
      Wechat\Request::CreateSignature('token', 1397911023, 2056994866));
  }

  public function testCheckSignature() {
    $_GET = array(
      'timestamp' => 1397911023,
      'nonce' => 2056994866,
      'signature' => 'f97c166a920dc3196fadb9e668ed91ed8a593bfe',
    );

    $this->assertTrue(Wechat\Request::checkSignature('token'));
    $this->assertFalse(Wechat\Request::checkSignature('error'));

    $this->assertTrue(Wechat\Request::checkSignature('token', array(
      'timestamp' => 1397911023,
      'nonce' => 2056994866,
      'signature' => 'f97c166a920dc3196fadb9e668ed91ed8a593bfe',
    )));

    $this->assertFalse(Wechat\Request::checkSignature('error', array(
      'timestamp' => 1397911023,
      'nonce' => 2056994866,
      'signature' => 'f97c166a920dc3196fadb9e668ed91ed8a593bfe',
    )));
  }

  public function testValid() {
    $_GET = array(
      'timestamp' => 1397911023,
      'nonce' => 2056994866,
      'signature' => 'f97c166a920dc3196fadb9e668ed91ed8a593bfe',
    );

    $request = new Wechat\Request('token');
    $this->assertTrue($request->valid());

    $request = new Wechat\Request('error');
    $this->assertFalse($request->valid());
  }
}
