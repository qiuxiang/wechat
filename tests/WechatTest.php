<?php

class WechatTest extends Wechat\TestCase {
  /**
   * @var string
   */
  public $fromUserName = 'user';

  /**
   * @var string
   */
  public $toUserName = 'server';

  /**
   * @var string
   */
  public $token = 'token';

  /**
   * @var string
   */
  public $serverUrl = 'http://localhost:8001';

  public function testBase() {
    $result = $this->send('text', ['content' => 'hello']);

    $this->assertEquals('user', $result->ToUserName);
    $this->assertEquals('server', $result->FromUserName);
    $this->assertEquals('world', $result->Content);
    $this->assertEquals('text', $result->MsgType);
    $this->assertEquals(time(), (int)$result->CreateTime);
  }

  public function testSubscribe() {
    $result = $this->send('event', ['event' => 'subscribe']);
    $this->assertEquals('welcome', $result->Content);
  }

  public function testResponse() {
    $result = $this->send('text', ['content' => 'text']);
    $this->assertEquals('text', $result->MsgType);
    $this->assertEquals('content', $result->Content);

    $result = $this->send('text', ['content' => 'single news']);
    $this->assertEquals('news', $result->MsgType);
    $this->assertEquals('1', $result->ArticleCount);
    $this->assertEquals('title', $result->Articles->item[0]->Title);
    $this->assertEquals('content', $result->Articles->item[0]->Description);
    $this->assertEquals('picture', $result->Articles->item[0]->PicUrl);
    $this->assertEquals('url', $result->Articles->item[0]->Url);

    $result = $this->send('text', ['content' => 'multiple news']);
    $this->assertEquals('news', $result->MsgType);
    $this->assertEquals('2', $result->ArticleCount);
    $this->assertEquals('title1', $result->Articles->item[0]->Title);
    $this->assertEquals('picture1', $result->Articles->item[0]->PicUrl);
    $this->assertEquals('title2', $result->Articles->item[1]->Title);
    $this->assertEquals('picture2', $result->Articles->item[1]->PicUrl);
  }
}