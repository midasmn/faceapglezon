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

$title = "世界の今がわかる：スマート特派員";	
$keywords = "特派員 動画 地域 ";
$description = "世界の今がわかる：スマート特派員";
//

$og_title = $title;
$og_image = "http://faceapglezon.info/tools/icon/img/tools_icon.png";
$og_url = "http://faceapglezon.info/tools/icon/index.php";
$og_site_name = $title;
$og_description = $description;

$h1_st = $title;
$h1_st_s = "  ";
$culhtml = "http://faceapglezon.info/tools";
$crlhtmltitle = "スマート特派員";
$site_name = "Smart Correspondent";
$footer_sitename = "Smart Correspondent";

$sns_url = "http://".$_SERVER["HTTP_HOST"].htmlspecialchars($_SERVER["PHP_SELF"]);

//アクティブメニュー
$active_st[1] = 'class="active"';
?>
<?php require('header.php');?>
<body>
<?php require('menu.php');?>

<!-- ページのコンテンツすべてをwrapする（フッター以外） -->
<div id="wrap">

    <div class="container">
        <div class="page-header">
            <h1>スマート特派員へようこそ</h1>
        </div>

        <p class="lead">This example shows the navmenu element. If the viewport is <b>less than 992px</b> the menu will be placed the off canvas and will be shown with a slide in effect.</p>
        <p>Also take a look at the examples for a navmenu with <a href="../navmenu-push">push effect</a> and <a href="../navmenu-reveal">reveal effect</a>.</p>
    
    </div><!-- /.container -->

</div>
<!-- .wrap -->
<?php require('footer.php');?>
</body>
</html>






