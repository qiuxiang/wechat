<?php

class ResponseTest extends PHPUnit_Framework_TestCase {
  public function testResponseText() {
    $xml = $this->output(function () {
      $response = new Wechat\Response('from', 'to');
      $response->text('hello');
    });

    $this->assertEquals('from', $xml->FromUserName);
    $this->assertEquals('to', $xml->ToUserName);
    $this->assertEquals('text', $xml->MsgType);
    $this->assertEquals('hello', $xml->Content);
  }

  public function testSingleNews() {
    $xml = $this->output(function () {
      $response = new Wechat\Response();
      $response->news([
        'title' => 'title',
        'content' => 'content',
        'picture' => 'picture',
        'url' => 'url',
      ]);
    });

    $this->assertEquals('news', $xml->MsgType);
    $this->assertEquals('1', $xml->ArticleCount);
    $this->assertEquals('title', $xml->Articles->item->Title);
    $this->assertEquals('content', $xml->Articles->item->Description);
    $this->assertEquals('picture', $xml->Articles->item->PicUrl);
    $this->assertEquals('url', $xml->Articles->item->Url);
  }

  public function testMultiNews() {
    $xml = $this->output(function () {
      $response = new Wechat\Response();
      $response->news([
        [
          'title' => 'title1',
          'content' => 'content1',
          'picture' => 'picture1',
          'url' => 'url1',
        ],
        [
          'title' => 'title2',
          'content' => 'content2',
        ],
      ]);
    });

    $this->assertEquals('2', $xml->ArticleCount);
    $this->assertEquals('title1', $xml->Articles->item[0]->Title);
    $this->assertEquals('content1', $xml->Articles->item[0]->Description);
    $this->assertEquals('picture1', $xml->Articles->item[0]->PicUrl);
    $this->assertEquals('url1', $xml->Articles->item[0]->Url);
    $this->assertEquals('title2', $xml->Articles->item[1]->Title);
    $this->assertEquals('content2', $xml->Articles->item[1]->Description);
    $this->assertEmpty($xml->Articles->item[1]->PicUrl);
    $this->assertEmpty($xml->Articles->item[1]->Url);
  }

  /**
   * @param callback $function
   * @return SimpleXMLElement
   */
  public function output($function) {
    ob_start();
    $function();
    $output = ob_get_contents();
    ob_clean();
    return simplexml_load_string($output);
  }
}
