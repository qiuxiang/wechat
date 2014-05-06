微信公众平台 SDK
==============
微信公众平台消息接口的简单封装，使用 composer 进行依赖管理。

简单使用
-------

```php
$wechat = new Wechat('token');

if ($wechat->request->valid) {
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

我做了一些处理，让请求信息成为了 request 的属性，并且访问时大小写无关，这意味着 `request->FromUserName` 与 `request->fromusername` 是一样的。

回复文本消息
----------

```php
$wechat->response->text('hello'); /* or */ $wechat->response('text', 'hello');
```

回复图文消息
----------
根据官方文档描述，title、content、picture、url 都是可选的。

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

注意，在多图文消息中，尽管可以指定 content，但在实际中并不会显示。
