<?php
$title = "FaceApGleZon | ペライチのWebツール"; 
$keywords = "ペライチ、Bootstrap、Webツール、Webサービス、アップル、apple、グーグル、google、フェイスブック、facebook、アマゾン、amazon";
$description = "FaceApGleZonには、アップル(apple)、グーグル(google)、フェイスブック(facebook)、アマゾン(amazon)に無いものしかない！  ";

$og_title = $title;
$og_image = "/mstile-310x310.png";
// $og_image2 = "//it-education.xyz/wp-content/uploads/2014/11/logo512.jpg";
$og_url = "http://faceapglezon.info/sample/";
$og_site_name = $title;
$og_description = $description;
//
//


$itemprop_name = $title;
$itemprop_description = $description;
$itemprop_author = "http://faceapglezon.info/";
// //
$fb_app_id = 528563560616645;
$article_publisher = "https://www.facebook.com/pages/FaceApGleZon/180485931995158";
// //
$twitter_site = "@FaceApGleZon";
// $twitter_account_id =  ;

//
$h1_st = $title;
$h1_st_s = "トップページ";

$sns_url = "http://".$_SERVER["HTTP_HOST"].htmlspecialchars($_SERVER["PHP_SELF"]);
/////
?>
<?php require('header.php');?>
<body>
  <div id="wrap">
  <?php require('menu.php');?>
  <div class="container">
    <div class=" text-center">
        <h1><?=$h1_st?><br><small><?=$h1_st_s?></small></h1>
    </div>

    <div class="row text-center">
      <h2><small>このサイトはペライチの単機能Webツールを公開しています。</small></h2>
    



      </div>


    <div class="row" style="margin-top:30px;">
    
      <div class="col-md-12 col-xs-12">
      <h2>
        <a href="/favicon/" class="btn btn-success btn-block btn-lg">
          <span class="glyphicon glyphicon-picture"></span> Webサイトに必要なfaviconを一括生成  
        </a>
      </h2>
      </div>  
      <div class="col-md-12 col-xs-12">
        <h2>
        <a href="/yellowpage/" class="btn btn-info btn-block btn-lg">
          <span class="glyphicon glyphicon-share"></span> 公式SNS(twitter/facebook/Google+)ページをさがします
        </a>
      </h2>
      </div>  
      <div class="col-md-12 col-xs-12">
      <h2>
        <a href="/ogimage/" class="btn btn-info btn-block btn-lg">
          <span class="glyphicon glyphicon-share"></span> og:imageタグ用のWebページサムネイル作成URL発行  
        </a>
      </h2>
      </div>  
      <div class="col-md-12 col-xs-12">
        <h2>
        <a href="/imageonly/" class="btn btn-info btn-block btn-lg">
          <!-- <span class="badge pull-left">NEW</span> -->
          <i class="fa fa-file-text"></i> タグのない世界 <span class="badge">NEW</span>
        </a>
      </h2>
      </div>  

      <div class="col-md-12 col-xs-12">
        <h2>
        <a href="/movie-png/" class="btn btn-warning btn-block btn-lg">
          <span class="glyphicon glyphicon-film"></span> 動画から画像ファイル抜き出し->PNG
        </a>
      </h2>
      </div>  
      <div class="col-md-12 col-xs-12">
      <h2>
        <a href="/soundonly/" class="btn btn-warning btn-block btn-lg">
          <span class="glyphicon glyphicon-film"></span> 動画から音声データ抜き出し->MP3  
        </a>
      </h2>
      </div>  
      <div class="col-md-12 col-xs-12">
        <h2>
        <a href="/movie-gif/" class="btn btn-warning btn-block btn-lg">
          <span class="glyphicon glyphicon-film"></span> 動画からGIFアニメーション作成->GIF
        </a>
      </h2>
      </div>  
      
      <div class="col-md-12 col-xs-12">
        <h2>
        <a href="/enigma/" class="btn btn-danger btn-block btn-lg">
          <span class="glyphicon glyphicon-play-circle"></span> エニグマ-YouTubeやDailymotion検索用に文字を反転
        </a>
      </h2>
      </div>  

      <div class="col-md-12 col-xs-12">
      <h2>
        <a href="/card/" class="btn btn-primary btn-block btn-lg">
          <span class="glyphicon glyphicon-credit-card"></span> 実質無料クレジットカードメール通知リマインダー  
        </a>
      </h2>
      </div>  
      

    </div>

        
  </div><!-- .container -->
  </div><!-- .wrap -->
<?php require('footer.php');?>
