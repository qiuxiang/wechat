<?php

class ClientTest extends PHPUnit_Framework_TestCase {
  public function testConstructor() {
    $client = new Wechat\Client('http://localhost:8001', 'token');
    $this->assertEquals('http://localhost:8001', $client->url);
    $this->assertEquals('token', $client->token);
  }

  public function testArray2xml() {
    $this->assertEquals(
      '<xml><Ab>bc</Ab><C>d</C></xml>',
      Wechat\Client::array2xml(['ab' => 'bc', 'c' => 'd']));
  }

  public function testCreateUrl() {
    $client = new Wechat\Client('http://example.com', 'token');
    $url = parse_url($client->createUrl());
    parse_str($url['query'], $url['query']);
    $this->assertEquals(Wechat\Request::createSignature(
      $client->token, $url['query']['timestamp'], $url['query']['nonce']),
      $url['query']['signature']);
  }
}
