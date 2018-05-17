<?php
require_once('phpQuery-onefile.php');

class Unkai {
  private $forecast;
  private $update;
  private $percentage;
  private $comment;
  private $img_path;

  public function __construct() {
    $html = file_get_contents('https://www.snowtomamu.jp/summer/unkai/');
    $dom = phpQuery::newDocument($html);

    $this->forecast = $dom[".unkaiForecast h2"]->text();
    $this->update = $dom[".unkaiUpdate"]->text();
    $this->percentage = $dom[".prob dd"]->text();
    $this->comment = $dom[".unkaiComment p"]->text();

    //"/summer/common/images/unkai/cloud.png"
    $this->img_path = $dom[".weather01 img"]->attr("src");
  }

  public function getForecasts() {
    return implode(',', [
      $this->forecast,
      $this->update,
      $this->percentage,
      $this->comment
    ]);
  }

}
