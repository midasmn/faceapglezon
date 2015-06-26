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
      		<div class="col-md-12 jmap" >

               <!-- 日本地図 -->
                <style type="text/css" media="screen">
                #japanmap{
                  width: 800px;
                  height: 500px;
                  padding: 10px;
                  margin: 20px auto;
                  /*box-shadow: 1px 2px 5px rgba(0, 0, 0, 0.3);*/
                  background: #fff;
                }
                @media only screen and (max-width:799px){
                  #japanmap{
                    width: 100%;
                    box-sizing: border-box;
                  }
                  #japanmap canvas{
                    width: 100%;
                  }
                }
                </style>
                <div id="japanmap"></div>
               <!-- <div id="japanmap"></div> -->
               <!-- <div id="japanmap" class="col-md-12 text-center" style="width:50%; height:300px;"></div> -->
                <!-- .日本地図 -->


          </div>
        </div>
      



    </div><!-- /.container -->
</div><!-- .wrap -->
<?php require('footer.php');?>
<!-- 日本地図 -->
<script type="text/javascript" src="js/jquery.japan-map.min.js"></script>
<script>
$(function(){
  //地域を設定
  //{"code":[地域のコード], "name": [地域の名前], "color":[地域につける色], "hoverColor":[地域をマウスでホバーしたときの色], "prefectures":[地域に含まれる都道府県のコード]}
  var areas = [
    {"code": 1 , "name":"北海道地方", "color":"#ca93ea", "hoverColor":"#e0b1fb", "prefectures":[1]},
    {"code": 2 , "name":"東北地方",   "color":"#a7a5ea", "hoverColor":"#d6d4fd", "prefectures":[2,3,4,5,6,7]},
    {"code": 3 , "name":"関東地方",   "color":"#84b0f6", "hoverColor":"#c1d8fd", "prefectures":[8,9,10,11,12,13,14]},
    {"code": 4 , "name":"北陸・甲信越地方",   "color":"#52d49c", "hoverColor":"#93ecc5", "prefectures":[15,16,17,18,19,20]},
    {"code": 4 , "name":"東海地方",   "color":"#77e18e", "hoverColor":"#aff9bf", "prefectures":[21,22,23,24]},
    {"code": 6 , "name":"近畿地方",   "color":"#f2db7b", "hoverColor":"#f6e8ac", "prefectures":[25,26,27,28,29,30]},
    {"code": 7 , "name":"中国地方",   "color":"#f9ca6c", "hoverColor":"#ffe5b0", "prefectures":[31,32,33,34,35]},
    {"code": 8 , "name":"四国地方",   "color":"#fbad8b", "hoverColor":"#ffd7c5", "prefectures":[36,37,38,39]},
    {"code": 9 , "name":"九州地方",   "color":"#f7a6a6", "hoverColor":"#ffcece", "prefectures":[40,41,42,43,44,45,46]},
    {"code":10 , "name":"沖縄地方",   "color":"#ea89c4", "hoverColor":"#fdcae9", "prefectures":[47]}
  ];

  var areaLinks = {
    "北海道地方" : "area.php?area=北海道地方",
    "東北地方" : "area.php?area=東北地方",
    "関東地方" : "area.php?area=関東地方",
    "北陸・甲信越地方" : "area.php?area=北陸・甲信越地方",
    "東海地方" : "area.php?area=東海地方",
    "近畿地方" : "area.php?area=近畿地方",
    "中国地方" : "area.php?area=中国地方",
    "四国地方" : "area.php?area=四国地方",
    "九州地方" : "area.php?area=九州地方",
    "沖縄地方" : "area.php?area=沖縄地方",
  };
 
  $("#japanmap").japanMap(
    {
      areas  : areas, //上で設定したエリアの情報
      selection : "prefecture", //選ぶことができる範囲(県→prefecture、エリア→area)
      borderLineWidth: 0.25, //線の幅
      drawsBoxLine : false, //canvasを線で囲む場合はtrue
      movesIslands : true, //南西諸島を左上に移動させるときはtrue、移動させないときはfalse
      showsAreaName : false, //エリア名を表示しない場合はfalse
      width: 800, //canvasのwidth。別途heightも指定可。
      height: 500, //canvasのwidth。別途heightも指定可。
      backgroundColor: "#ffffff", //canvasの背景色
      font : "MS Mincho", //地図に表示する文字のフォント
      fontSize : 12, //地図に表示する文字のサイズ
      fontColor : "areaColor", //地図に表示する文字の色。"areaColor"でエリアの色に合わせる
      fontShadowColor : "black", //地図に表示する文字の影の色
      onSelect:function(data){
        location.href = areaLinks[data.area.name];
      },
    }
  );
});
</script>
<!-- .日本地図 -->
</body>
</html>






