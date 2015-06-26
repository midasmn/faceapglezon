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

$title = "ワールド動画：スマート特派員";	
$keywords = "YOUTUBE 動画 世界 人気 ランキング スマート特派員 Smart Correspondent";
$description = "世界各国で人気のYOUTUBE動画をスマート特派員が紹介します。";
//

$og_title = $title;
$og_image = "http://faceapglezon.info/tools/icon/img/tools_icon.png";
$og_url = "http://faceapglezon.info/tools/icon/index.php";
$og_site_name = $title;
$og_description = $description;

$h1_st = "ワールド動画";
$h1_st_s = "  ";
$culhtml = "http://faceapglezon.info/tools";
$crlhtmltitle = "スマート特派員";
$site_name = "Smart Correspondent";
$footer_sitename = "Smart Correspondent";

$sns_url = "http://".$_SERVER["HTTP_HOST"].htmlspecialchars($_SERVER["PHP_SELF"]);
//アクティブメニュー
$active_st[8] = 'class="active"';
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
      			<!-- 世界地図 -->
				    <div id="worldmap" class="col-md-12 text-center" style="width: 100%; height: 500px;"></div>
				    <!-- .世界地図 -->
      		</div>
      	</div>

    </div><!-- /.container -->

</div>
<!-- .wrap -->
<?php require('footer.php');?>
<!-- 世界地図 -->
<script type="text/javascript" src="js/jquery.vmap.min.js"></script>
<script type="text/javascript" src="js/jquery.vmap.world.js"></script>
<script type="text/javascript" src="js/jquery.vmap.sampledata.js"></script>
<script>
$(function() {
	$('#worldmap').vectorMap({
	map: 'world_en', //表示エリア world_en, usa_en, europe_en,germany_en
	backgroundColor: null, //背景色
	color: '#ffffff', //地域の色
	hoverOpacity: 0.7, //マウスオーバー時の透過度
	selectedColor: '#666666', //選択された時の色
	enableZoom: true, //ズームさせるか
	showTooltip: true, //吹き出しをだすか
	values: sample_data, //色を付けたいエリア
	scaleColors: ['#C8EEFF', '#006491'], //上記で指定した場所の色
	normalizeFunction: 'polynomial' //色の分布
	});
});
</script>
<!-- .世界地図 -->
</body>
</html>






