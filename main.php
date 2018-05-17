<?php
require_once('Unkai.php');
require_once('Twitter.php');
require_once('Operate.php');
require_once('Food.php');
require_once('Functions.php');

$unkai =  new Unkai;
[$forecast, $update, $percentage, $comment] = explode(',', $unkai->getForecasts());

$today = new DateTime();
$tomorrow = new DateTime("tomorrow");

$day = isMorning() ? $today : $tomorrow;
$operate = new Operate($day);
$operating_time = $operate->getTime();
$date = $day->format("n月j日");

$now = isMorning() ? "morning" : "afternoon";
$food = new Food($now);
$recommended = $food->getRecommended();
$coupe_or_koppe = $food->getCoupeOrKoppe();

//unkaiCommentの中に”中止”が含まれていた場合は別メッセージ
if (isStop($comment)) {
  $message = <<<EOM
{$forecast}
{$update}
{$comment}

今日のおすすめ{$coupe_or_koppe}：{$recommended}

EOM;
} else {
  $message = <<<EOM
{$forecast}
{$update}
雲海発生確率：{$percentage}
{$date}のゴンドラ営業時間は{$operating_time}です。

今日のおすすめ{$coupe_or_koppe}：{$recommended}

EOM;

}

$twitter = new Twitter();
$twitter->tweet($message);
