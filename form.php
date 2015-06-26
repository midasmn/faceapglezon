<?php
$title = "FaceApGleZon | １枚ペラのWebツール群"; 
$keywords = "Bootstrap、Webツール、Webサービス、アップル、apple、グーグル、google、フェイスブック、facebook、アマゾン、amazon";
$description = "FaceApGleZonには、アップル(apple)、グーグル(google)、フェイスブック(facebook)、アマゾン(amazon)に無いものしかない！  ";

$og_title = $title;
$og_image = "//it-education.xyz/wp-content/uploads/2014/11/logo512.jpg";
$og_image2 = "//it-education.xyz/wp-content/uploads/2014/11/logo512.jpg";
$og_url = "http://faceapglezon.info/sample/";
$og_site_name = $title;
$og_description = $description;
//
$itemprop_name = $title;
$itemprop_description = $description;
$itemprop_author = "http://it-education.xyz/about";
//
$fb_app_id = 1459017077694190;
$article_publisher = "https://www.facebook.com/iteducationxyz";
//
$twitter_site = "@icalendar_xyz";
$twitter_account_id =  2761857000;
//
$h1_st = "faceapglezon";
$h1_st_s = "トップページ";
/////
?>
<?php require('/tools/header.php');?>
<body>
  <div id="wrap">
  <?php require('/tools/menu.php');?>
  <div class="container">
    <div class=" text-center">
        <h1><?=$h1_st?><br><small><?=$h1_st_s?></small></h1>
    </div>

    <div class="row text-center">
      <h2><small>このサイトは1枚ペラの単機能Webツールを公開しています。</small></h2>
    </div>

    <div class="row" style="margin-top:30px;">

      <!-- １行目 -->
      <div class="col-md-1">
      </div> 
      <div class="col-md-4">
        <a href="/logo7/" class="btn btn-danger btn-block btn-lg">
          <span class="glyphicon glyphicon-trash"></span> LOTO7予想ツール
        </a>
      </div>  
      <div class="col-md-2">
      </div>  
      <div class="col-md-4">
        <a href="/tools/mpegmagick" class="btn btn-danger btn-block btn-lg">
          <span class="glyphicon glyphicon-trash"></span> 動画ファイル変換
        </a>
      </div>  
      <div class="col-md-1">
      </div> 
      <!-- １行目 -->


    </div>



  </div><!-- .container -->
  </div><!-- .wrap -->
<?php require('/tools/footer.php');?>
