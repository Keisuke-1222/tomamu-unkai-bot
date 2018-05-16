<?php

class Food {
  private $lucky;
  private $coupe_or_koppe;

  private $tomakoppes = [
    "ダブルサーモン＆オニオン",
    "ソーセージ＆ポテト",
    "生ハム＆トマト",
    "アスパラ＆ツナ",
    "コーン＆エッグ",
    "ハスカップ＆カマンベール",
    "メンチカツ＆キャベツ",
    "イチゴ＆ホイップ"
  ];

  private $coupes = [
    "メロンショート",
    "イチゴショート",
    "ミルフィーユ",
    "ティラミス",
    "フルーツタルト",
    "メロンシュー",
    "メロンゼリー",
    "ブランマンジェ"
  ];

  public function __construct($now) {
    $foods = $now === "morning" ? $this->tomakoppes : $this->coupes;
    $key = array_rand($foods);
    $this->lucky = $foods[$key];

    $this->coupe_or_koppe = $now === "morning" ? "クープ" : "とまコッペ";
  }

  public function getLucky() {
    return $this->lucky;
  }

  public function getCoupeOrKoppe() {
    return $this->coupe_or_koppe;
  }
}
