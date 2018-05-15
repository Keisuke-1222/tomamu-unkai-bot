<?php
require_once('phpQuery-onefile.php');
require_once('twitteroauth/autoload.php');

use Abraham\TwitterOAuth\TwitterOAuth;

$today = new DateTime();
$tomorrow = new DateTime("tomorrow");

$date_today = $today->format("n月j日");
$date_tomorrow = $tomorrow->format("n月j日");

$first_day = new DateTime('2018-05-12');
$second_day = new DateTime('2018-05-31');
$third_day = new DateTime('2018-08-31');
$fourth_day = new DateTime('2018-09-24');
$fifth_day = new DateTime('2018-10-15');

if ($first_day <= $today && $today <= $second_day) {
  $operating_time = "5:00～7:00";
} elseif ($second_day < $today && $today <= $third_day) {
  $operating_time = "5:00～8:00";
} elseif ($third_day < $today && $today <= $fourth_day) {
  $operating_time = "4:30～8:00";
} elseif ($fourth_day < $today && $today <= $fifth_day) {
  $operating_time = "5:00～7:00";
} else {
  $operating_time = NULL;
}

if (! $operating_time) {
  echo $date_today."はゴンドラ営業期間外です。";
  exit;
}

$consumer_key = "CONSUMER_KEY";
$consumer_secret = "CONSUMER_SECRET";
$access_token = "ACCESS_TOKEN";
$access_token_secret = "ACCESS_TOKEN_SECRET";

$tomaKoppes = ["ダブルサーモン＆オニオン",
               "ソーセージ＆ポテト",
               "生ハム＆トマト",
               "アスパラ＆ツナ",
               "コーン＆エッグ",
               "ハスカップ＆カマンベール",
               "メンチカツ＆キャベツ",
               "イチゴ＆ホイップ"
             ];

$key = array_rand($tomaKoppes);
$today_koppe = $tomaKoppes[$key];

$html = file_get_contents('https://www.snowtomamu.jp/summer/unkai/');
$dom = phpQuery::newDocument($html);

$unkaiForecast = $dom[".unkaiForecast h2"]->text();
$unkaiUpdate = $dom[".unkaiUpdate"]->text();
$unkaiPercentage = $dom[".prob dd"]->text();

//"/summer/common/images/unkai/cloud.png"
$img_path = $dom[".weather01 img"]->attr("src");

$message =
<<<EOM
{$unkaiForecast}
{$unkaiUpdate}
雲海発生確率：{$unkaiPercentage}
{$date_tomorrow}のゴンドラ営業時間は{$operating_time}です。

今日のラッキーとまコッペ：{$today_koppe}

EOM;

echo $message;
exit;

try {
    // クレデンシャル生成
    $to = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);

    //画像をアップロード
    $media_id = $to->upload("media/upload", array("media" => "./weather.jpg"));

    //投稿設定
    $parameters = array(
        'status' => $message,
        'media_ids' => $media_id->media_id_string,
    );

    //投稿
    $result = $to->post('statuses/update', $parameters);
    // レスポンス確認(異常時にはcatchにジャンプするため、ここへの到達は成功を意味する)
    var_dump($result);

} catch (TwistException $e) {
    // エラーを表示
    echo "[{$e->getCode()}] {$e->getMessage()}";
}
