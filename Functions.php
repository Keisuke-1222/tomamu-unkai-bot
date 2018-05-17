<?php

function isMorning() {
  $now = strtotime(date('G:i'));

  return $now < strtotime(date('12:00'));
}

function isStop($comment) {
  return strpos($comment, "中止") !== false;
}
