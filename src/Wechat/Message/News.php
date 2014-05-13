<?php namespace Wechat\Message;

use Wechat\Message;

class News extends Message {
  /**
   * @param array $news
   */
  public function setData($news) {
    if (!isset($news[0])) {
      $_news[] = $news;
    } else {
      $_news = $news;
    }

    $this->data['MsgType'] = 'news';
    $this->data['ArticleCount'] = count($_news);
    $this->data['Articles'] = array_reduce($_news, function ($articles, $item) {
      $articles['item'][] = $this->createArticle($item);
      return $articles;
    });
  }

  /**
   * @param array $news
   * @return array
   */
  public function createArticle($news) {
    $article = [];

    foreach ([
      'title'   => 'Title',
      'content' => 'Description',
      'picture' => 'PicUrl',
      'url'     => 'Url',
    ] as $k => $v) {

      if (isset($news[$k])) {
        $article[$v] = $news[$k];
      }
    }

    return $article;
  }
}
