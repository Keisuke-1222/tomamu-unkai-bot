<?php

class Operate {

  private $time;

  public function __construct($day) {
    $first_day = new DateTime('2018-05-12');
    $second_day = new DateTime('2018-05-31');
    $third_day = new DateTime('2018-08-31');
    $fourth_day = new DateTime('2018-09-24');
    $fifth_day = new DateTime('2018-10-15');

    if ($first_day <= $day && $day <= $second_day) {
      $this->time = "5:00～7:00";
    } elseif ($second_day < $day && $day <= $third_day) {
      $this->time = "5:00～8:00";
    } elseif ($third_day < $day && $day <= $fourth_day) {
      $this->time = "4:30～8:00";
    } elseif ($fourth_day < $day && $day <= $fifth_day) {
      $this->time = "5:00～7:00";
    } else {
      $this->time = NULL;
    }
  }

  public function getTime() {
    if (! $this->time) {
      echo "ゴンドラ営業期間外です。";
      exit;
    }

    return $this->time;
  }

}
