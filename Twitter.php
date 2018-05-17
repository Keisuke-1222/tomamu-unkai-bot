<?php
require_once('twitteroauth/autoload.php');
require_once('./vendor/autoload.php');


// 引数は「.env」ファイルが存在するディレクトリを指定する
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

echo getenv('NAME');
exit;

use Abraham\TwitterOAuth\TwitterOAuth;

class Twitter {
  private $consumer_key = "CONSUMER_KEY";
  private $consumer_secret = "CONSUMER_SECRET";
  private $access_token = "ACCESS_TOKEN";
  private $access_token_secret = "ACCESS_TOKEN_SECRET";
  private $connection;

  public function __construct() {
    $this->connection = new TwitterOAuth(
      $this->consumer_key,
      $this->consumer_secret,
      $this->access_token,
      $this->access_token_secret
    );
  }

  public function tweet($message) {
    try {
        //投稿設定
        $parameters = [
            'status' => $message,
        ];

        //投稿
        $result = $this->connection->post('statuses/update', $parameters);
        // レスポンス確認(異常時にはcatchにジャンプするため、ここへの到達は成功を意味する)
        var_dump($result);

    } catch (TwistException $e) {
        // エラーを表示
        echo "[{$e->getCode()}] {$e->getMessage()}";
    }
  }

  public function tweetWithImage($message, $img_path) {
    try {
        //画像をアップロード
        $media_id = $connection->upload("media/upload", ["media" => $img_path]);

        //投稿設定
        $parameters = [
            'status' => $message,
            'media_ids' => $media_id->media_id_string,
        ];

        //投稿
        $result = $connection->post('statuses/update', $parameters);
        // レスポンス確認(異常時にはcatchにジャンプするため、ここへの到達は成功を意味する)
        var_dump($result);

    } catch (TwistException $e) {
        // エラーを表示
        echo "[{$e->getCode()}] {$e->getMessage()}";
    }
  }
}
