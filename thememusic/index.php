<?php
require_once("lib/lib_upload.php");
require_once("lib/mysql-ini.php");
// データベースに接続
if(!$db_conn = mysql_connect($host, $user, $pass))
{
  print("データベースにアクセスできません。");
  exit;
}
$rtn = mysql_query("SET NAMES sjis" , $db_conn);
mysql_select_db($dbname);

$arycardtype = array(
    'アマゾンカード' => 'アマゾンカード',
    'ビックカメラSuicaカード' => 'ビックカメラSuicaカード',
    '三井住友デビュープラスカード' => '三井住友デビュープラスカード',
    'その他' => 'その他'
);

$title = "SNS公式ページをさがします | SNSイエローページ"; 
$keywords = "公式twitter 公式facebookページ 公式Google+ページ";
$description = "ブランド、企業、Webサービスの公式SNSページをさがします。";
//
$og_title = $title;
$og_image = "http://faceapglezon.info/yellowpage/img/tools_icon.png";
$og_url = "http://faceapglezon.info/yellowpage/index.php";
$og_site_name = $title;
$og_description = $description;

$h1_st = "公式SNSページをさがします";
// $h1_st_s = "  現在21サイズ対応";
$culhtml = "http://faceapglezon.info/yellowpage";
$crlhtmltitle = "公式SNSページをさがします";
$site_name = "faceapglezon";
$footer_sitename = "faceapglezon";

$sns_url = "http://".$_SERVER["HTTP_HOST"].htmlspecialchars($_SERVER["PHP_SELF"]);

/////
?>
<?php require('../header.php');?>
<link href="css/thememusic.css" rel="stylesheet">
<script>
function upload(form) 
{
  $form = $('#upload-form');
  fd = new FormData($form[0]);

  $('#submit-btn').hide(); //hide submit button
  $('#loading-img').show(); //hide submit button
  $('#note').hide(); //hide submit button
  $("#rtn_div").html("");  

  $.ajax(
      'http://faceapglezon.info/yellowpage/scraping.php',
      {
      type: 'post',
      processData: false,
      contentType: false,
      data: fd,
      dataType: "html",
      success: function(data, textStatus){
          // 
          $('#submit-btn').show(); //hide submit button
          $('#loading-img').hide(); //hide submit button
          $('#note').hide(); //hide submit button
          $('#rtn_div').html(data);
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
          alert( "ERROR" );
          alert( textStatus );
          alert( errorThrown );
          $('#submit-btn').show(); //hide submit button
          $('#loading-img').hide(); //hide submit button
      }
  });
  return false;
}
</script>

<body>
<div id="wrap" >
<?php require('../menu.php');?>
  <div class="container" style="margin-top:10px;" >
    <ol class="breadcrumb"><!-- パンくず -->
      <li><a href="/">ホーム</a></li>
      <!-- <li><a href="/tools/">単機能1ページWebツール</a></li> -->
      <li class="active"><?=$h1_st?></li>
    </ol><!-- パンくず -->

    <div class="col-md-12">
      <div class="page-header">
        <h1><?=$h1_st?><br><small>twitter facebookページ Google+ etc…</small></h1>
      </div>
      <form  id="upload-form" method="post" name="form"  onSubmit="return upload(this);">
        <div style="width:80%;float:left;margin-right:10px;" class="input-group">
          <span class="input-group-btn">
            <span class="glyphicon glyphicon-calendar"></span>
          </span>
          <input name="URL" id="URL" type="text" class="form-control input-lg seoup" placeholder="Webサービス、公式サイトURL" >
        </div>
        <input type="submit" name="submit"  id="submit-btn" class="btn btn-primary btn-lg " value="SNS取得">
        <img src="img/load.gif" id="loading-img" style="display:none;" alt="Please Wait"/>
      </form>
      <!-- アップロード -->
      <div class="row" style="margin-top:30px;">
        <div id="rtn_div"></div><!-- 動画抜き出しPNGギャラリー -->
      </div>
    </div>

  </div><!-- .container -->
</div><!-- .wrap -->




<?php require('../footer.php');?>
<video autoplay loop poster="img.jpg">
    <source src="img/bg.mp4" type="video/mp4">
</video>
<!-- Shepherd -->
<!-- <script src="../js/shephead_icon.js"></script> -->
<script>
$(function(){
  $('#url').change(function() {
    $('#url').val($(this).val());
  });
})
</script>

<script>
$('#ex_date').datepicker({
  format: 'yyyy/mm/dd',
  language: 'ja',
  autoclose: true,
  clearBtn: true,
  startDate: Date()
});
</script>
<script type="text/javascript">
$("[data-toggle=tooltip]").tooltip()
$("[data-toggle=popover]").popover()
</script>

<script>
  //Geolocation APIに対応している
if(navigator.geolocation){
  //現在位置を取得できる場合の処理
  alert("あなたの端末では、現在位置を取得することができます。");
//Geolocation APIに対応していない
}else{
  //現在位置を取得できない場合の処理
  alert("あなたの端末では、現在位置を取得できません。");
}
</script>




</body>
</html>







