<?php

use Symfony\Component\Yaml\Yaml;

class RequestTest extends PHPUnit_Framework_TestCase {
  public function testConstructor() {
    foreach (Yaml::parse(__DIR__ . '/fixtures/request.yml') as $xml) {
      $request = new Wechat_Request('', $xml);

      foreach (simplexml_load_string($xml) as $key => $value) {
        $this->assertEquals($request->{$key}, $value);
        $this->assertEquals($request->{strtolower($key)}, $value);
      }
    }
  }

  public function testCheckSignature() {
    $this->assertTrue(Wechat_Request::checkSignature('token', array(
      'timestamp' => 1397911023,
      'nonce' => 2056994866,
      'signature' => 'f97c166a920dc3196fadb9e668ed91ed8a593bfe',
    )));

    $this->assertFalse(Wechat_Request::checkSignature('error', array(
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

    $request = new Wechat_Request('token');
    $this->assertTrue($request->valid);

    $request = new Wechat_Request('error');
    $this->assertFalse($request->valid);
  }
}
