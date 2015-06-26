<?php
require_once("lib/lib.php");
require_once("lib/mysql-ini.php");
// データベースに接続
if(!$db_conn = mysql_connect($host, $user, $pass))
{
  print("データベースにアクセスできません。");
  exit;
}
mysql_select_db($dbname);

$title = "地域(日本)動画：スマート特派員";	
$keywords = "YOUTUBE 動画 日本 人気 ランキング スマート特派員 Smart Correspondent";
$description = "地域(日本)で人気のYOUTUBE動画をスマート特派員が紹介します。";
//

$og_title = $title;
$og_image = "http://faceapglezon.info/tools/icon/img/tools_icon.png";
$og_url = "http://faceapglezon.info/tools/icon/index.php";
$og_site_name = $title;
$og_description = $description;

$h1_st = "地域(日本)動画";
$h1_st_s = "  ";
$culhtml = "http://faceapglezon.info/tools";
$crlhtmltitle = "スマート特派員";
$site_name = "Smart Correspondent";
$footer_sitename = "Smart Correspondent";

$sns_url = "http://".$_SERVER["HTTP_HOST"].htmlspecialchars($_SERVER["PHP_SELF"]);
//アクティブメニュー
$active_st[7] = 'class="active"';
?>
<?php require('header.php');?>
<body>
<?php require('menu.php');?>

<!-- ページのコンテンツすべてをwrapする（フッター以外） -->
<div id="wrap">
	<!-- パンくず -->
    <ol class="breadcrumb">
      <li><a href="<?php echo $base_url;?>"><i class="fa fa-university"></i></a></li>
      <li class="active"><?=$h1_st?></li>
    </ol>
  <!-- パンくず -->
    <div class="container">
        <div class="page-header">
            <h1><?=$h1_st?></h1>
        </div>

        <div class="row" >
      		<div class="col-md-12" >
          <!-- <div class="col-md-12 text-center" style="width:50%; height:300px;"></div> --> -->

          </div>
        </div>
      



    </div><!-- /.container -->
</div>
<!-- .wrap -->



<?php require('footer.php');?>

</body>
</html>






