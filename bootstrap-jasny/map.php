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

$title = "世界地図";	
$keywords = "世界地図";
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

/////
?>
<?php require('header.php');?>
<body>
<?php require('menu.php');?>

<!-- ページのコンテンツすべてをwrapする（フッター以外） -->
<div id="wrap">
	<!-- パンくず -->
    <ol class="breadcrumb">
      <li><a href="/"><i class="fa fa-university"></i></a></li>
      <!-- <li><a href="/tools/">単機能1ページWebツール</a></li> -->
      <li class="active"><?=$h1_st?></li>
    </ol>
  <!-- パンくず -->
    <div class="container">
        <div class="page-header">
            <h1>世界地図</h1>
        </div>

        <div class="row" style="margin-top:10px;" >
      		<div class="col-md-12" >
      			<!-- 世界地図 -->
				<!-- <div id="worldmap"  style="width: 600px; height: 400px;"></div> -->
				<!-- <div id="worldmap" class="col-md-12" style="width:900px; height:600px;"></div> -->
				<div id="worldmap" class="col-md-12 text-center" style="900px; height:500px;"></div>
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






