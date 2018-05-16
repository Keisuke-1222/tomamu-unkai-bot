<?php
require_once('Forecast.php');
require_once('twitteroauth/autoload.php');
require_once('Operate.php');
require_once('Food.php');

use Abraham\TwitterOAuth\TwitterOAuth;

function isMorning() {
  $now = strtotime(date('G:i'));

  return $now < strtotime(date('12:00'));
}

$forecast =  new Forecast;
[$unkai_forecast, $unkai_update, $unkai_percentage] = explode(',', $forecast->getForecast());

$today = new DateTime();
$tomorrow = new DateTime("tomorrow");

$day = isMorning() ? $today : $tomorrow;
$operate = new Operate($day);
$time = $operate->getTime();

$date = $day->format("n月j日");

$now = isMorning() ? "morning" : "afternoon";
$food = new Food($now);
$lucky = $food->getLucky();
$coupe_or_koppe = $food->getCoupeOrKoppe();

$message =
<<<EOM
{$unkai_forecast}
{$unkai_update}
雲海発生確率：{$unkai_percentage}
{$date}のゴンドラ営業時間は{$time}です。

今日のラッキー{$coupe_or_koppe}：{$lucky}

EOM;

echo $message;
exit;

$consumer_key = "CONSUMER_KEY";
$consumer_secret = "CONSUMER_SECRET";
$access_token = "ACCESS_TOKEN";
$access_token_secret = "ACCESS_TOKEN_SECRET";

try {
    // クレデンシャル生成
    $connection = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);

    //画像をアップロード
    $media_id = $connection->upload("media/upload", ["media" => "./weather.jpg"]);

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
