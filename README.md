微信公众平台 SDK
==============
微信公众平台消息接口的简洁封装，使用 composer 进行依赖管理。

简单使用
-------

```php
$wechat = new Wechat('token');

if ($wechat->request->valid()) {
  $wechat->response->text('hello');
}
```

获取请求信息
----------
获取文本、图片等消息

```php
echo $wechat->request->fromUserName; // 获取发送者 OpenID
echo $wechat->request->msgtype;      // 获取消息类型
echo $wechat->request->content;      // 获取文本消息内容
```

值得一提的是，`request` 属性是大小写无关的，这意味着 `request->FromUserName` 与 `request->fromusername` 是一样的。

回复文本消息
----------

```php
$wechat->response->text('hello');
```

回复图文消息
----------
根据官方文档描述，`title`、`content`、`picture`、`url` 都是可选的。

### 单图文消息

```php
$wechat->response->news(array(
  'title'   => '标题',
  'content' => '描述',
  'picture' => 'http://example.com/picture.png',
  'url'     => 'http://example.com',
));
```

### 多图文消息

```php
$wechat->response->news(array(
  array(
    'title'   => '标题1',
    'picture' => 'http://example.com/picture.png',
    'url'     => 'http://example.com',
  ),
  array(
    'title'   => '标题2',
  ),
));
```

注意，在多图文消息中，尽管可以指定 `content`，但在实际中并不会显示。

单元测试
-------
这里还提供了一个方便测试微信后台功能的 `TestCase`

```php
class WechatTest extends Wechat\TestCase {
  // 定义微信后台信息
  public $serverUrl = 'http://example.com';
  public $token = 'token';
  public $fromUserName = 'user'; // 用户 OpenID
  public $toUserName = 'server'; // 开发者微信号

  // 测试文本消息
  public function testText() {
    // 发送文本消息
    $result = $this->send('text', 'hello');

    // 对返回结果进行断言
    $this->assertEquals($this->toUserName, $result->ToUserName);
    $this->assertEquals($this->fromUserName, $result->FromUserName);
    $this->assertEquals('world', $result->Content);
    $this->assertEquals('text', $result->MsgType);
  }

  // 测试订阅事件
  public function testSubscribe() {
    // 发送订阅事件
    $result = $this->send('event', array('event' => 'subscribe'));
    // 断言应该返回 'welcome'
    $this->assertEquals('welcome', $result->Content);
  }
}
```
