<?php

use Symfony\Component\Yaml\Yaml;

class RequestTest extends PHPUnit_Framework_TestCase {
  public function testConstructor() {
    foreach (Yaml::parse(__DIR__ . '/fixtures/request.yml') as $xml) {
      $request = new Wechat\Request('token', $xml);

      foreach (simplexml_load_string($xml) as $key => $value) {
        $this->assertEquals($request->{$key}, $value);
        $this->assertEquals($request->{strtolower($key)}, $value);
      }
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
    $_GET = [
      'timestamp' => 1397911023,
      'nonce' => 2056994866,
      'signature' => 'f97c166a920dc3196fadb9e668ed91ed8a593bfe',
    ];

    $this->assertTrue(Wechat\Request::checkSignature('token'));
    $this->assertFalse(Wechat\Request::checkSignature('error'));

    $this->assertTrue(Wechat\Request::checkSignature('token', [
      'timestamp' => 1397911023,
      'nonce' => 2056994866,
      'signature' => 'f97c166a920dc3196fadb9e668ed91ed8a593bfe',
    ]));

    $this->assertFalse(Wechat\Request::checkSignature('error', [
      'timestamp' => 1397911023,
      'nonce' => 2056994866,
      'signature' => 'f97c166a920dc3196fadb9e668ed91ed8a593bfe',
    ]));
  }

  public function testValid() {
    $_GET = [
      'timestamp' => 1397911023,
      'nonce' => 2056994866,
      'signature' => 'f97c166a920dc3196fadb9e668ed91ed8a593bfe',
    ];

    $request = new Wechat\Request('token');
    $this->assertTrue($request->valid());

    $request = new Wechat\Request('error');
    $this->assertFalse($request->valid());
  }
}
