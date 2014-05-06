<?php

class Wechat_Message_News extends Wechat_Message {
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

    foreach ($_news as $item) {
      $articles['item'][] = $this->createArticle($item);
    }

    $this->data['Articles'] = $articles;
  }

  /**
   * @param array $news
   * @return array
   */
  public function createArticle($news) {
    $article = array();

    if (isset($news['title'])) {
      $article['Title'] = $news['title'];
    }

    if (isset($news['content'])) {
      $article['Description'] = $news['content'];
    }

    if (isset($news['picture'])) {
      $article['PicUrl'] = $news['picture'];
    }

    if (isset($news['url'])) {
      $article['Url'] = $news['url'];
    }

    return $article;
  }
}
