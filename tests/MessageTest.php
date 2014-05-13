<?php

class MessageTest extends PHPUnit_Framework_TestCase {
  public function testText() {
    $message = new Wechat\Message\Text('from', 'to', 'content');
    $xml = simplexml_load_string($message->__toString());

    $this->assertEquals('from', $xml->FromUserName);
    $this->assertEquals('to', $xml->ToUserName);
    $this->assertEquals('text', $xml->MsgType);
    $this->assertEquals('content', $xml->Content);
  }

  public function testSingleNews() {
    $message = new Wechat\Message\News('from', 'to', array(
      'title' => 'title',
      'content' => 'content',
      'picture' => 'picture',
      'url' => 'url',
    ));

    $xml = simplexml_load_string($message->__toString());

    $this->assertEquals('news', $xml->MsgType);
    $this->assertEquals('1', $xml->ArticleCount);
    $this->assertEquals('title', $xml->Articles->item->Title);
    $this->assertEquals('content', $xml->Articles->item->Description);
    $this->assertEquals('picture', $xml->Articles->item->PicUrl);
    $this->assertEquals('url', $xml->Articles->item->Url);
  }

  public function testMultiNews() {
    $message = new Wechat\Message\News('from', 'to', array(
      array(
        'title' => 'title1',
        'content' => 'content1',
        'picture' => 'picture1',
        'url' => 'url1',
      ),
      array(
        'title' => 'title2',
        'content' => 'content2',
      ),
    ));

    $xml = simplexml_load_string($message->__toString());

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
}
