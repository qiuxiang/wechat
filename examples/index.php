<?php

include __DIR__ . '/../vendor/autoload.php';

$wechat = new Wechat('token');

if ($wechat->request->valid()) {
  switch ($wechat->request->msgtype) {
    case 'text':
      switch ($wechat->request->content) {
        case 'hello':
          $wechat->response->text('world');
          break;

        case 'text':
          $wechat->response->text('content');
          break;

        case 'single news':
          $wechat->response->news(array(
            'title' => 'title',
            'content' => 'content',
            'picture' => 'picture',
            'url' => 'url',
          ));
          break;

        case 'multiple news':
          $wechat->response->news(array(
            array(
              'title' => 'title1',
              'picture' => 'picture1',
            ),
            array(
              'title' => 'title2',
              'picture' => 'picture2',
            ),
          ));
          break;

        default:
          $wechat->response->text('No matches');
      }
      break;

    case 'event':
      switch ($wechat->request->event) {
        case 'subscribe':
          $wechat->response->text('welcome');
          break;

        default:
          $wechat->response->text('unknow event');
      }
      break;
  }
} else {
  $wechat->response->text('Forbidden');
}
