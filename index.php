<?php

include 'vendor/autoload.php';

$wechat = new Wechat('token');
if ($wechat->request->valid) {
  $wechat->response->news(array(array(
    'title' => 'hello',
    'picture' => 'http://xsh.gxun.edu.cn/ams/img/logo.png',
    'url' => 'http://xsh.gxun.edu.cn/ams/',
  ), array(
    'title' => 'world',
    'picture' => 'http://xsh.gxun.edu.cn/ams/img/logo.png',
    'url' => 'http://xsh.gxun.edu.cn/ams/',
  )));
} else {
  $wechat->response->text('false');
}
