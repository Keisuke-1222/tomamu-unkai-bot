<?php
require_once('phpQuery-onefile.php');

class Forecast {
  private $unkai_forecast;
  private $unkai_update;
  private $unkai_percentage;
  private $img_path;

  public function __construct() {
    $html = file_get_contents('https://www.snowtomamu.jp/summer/unkai/');
    $dom = phpQuery::newDocument($html);

    $this->unkai_forecast = $dom[".unkaiForecast h2"]->text();
    $this->unkai_update = $dom[".unkaiUpdate"]->text();
    $this->unkai_percentage = $dom[".prob dd"]->text();

    //"/summer/common/images/unkai/cloud.png"
    $this->img_path = $dom[".weather01 img"]->attr("src");
  }

  public function getForecast() {
    return implode(',', [
      $this->unkai_forecast,
      $this->unkai_update,
      $this->unkai_percentage
    ]);
  }

}
