<?php
require_once("lib/lib_upload.php");
require_once("lib/mysql-ini.php");
// データベースに接続
if(!$db_conn = mysql_connect($host, $user, $pass))
{
  print("データベースにアクセスできません。");
  exit;
}
// $rtn = mysql_query("SET NAMES sjis" , $db_conn);
mysql_select_db($dbname);

//サーバ設定UPLOAD最大値
$max_up_size = getMaxUploadSize();
//UPLOAD実績最大値
// $exm = 'gif';
$exm = 'sound';
// $exm = 'png';
$max_time = f_get_max_time($db_conn,$exm);
$max_size = f_get_max_size($db_conn,$exm);
$exm_max_size = '時間:'.$max_time.'/サイズ:'.$max_size;

$title = "動画から音声データ抜き出し→MP3"; 
$keywords = "動画 音声抜き出し Webサービス ffmpeg imagemagick";
$description = "動画から音声データ抜き出し→MP3";

$og_title = $title;
$og_image = "http://faceapglezon.info/soundonly/img/tools_sound.png";
$og_url = "http://faceapglezon.info/soundonly/sound.php";
$og_site_name = $title;
$og_description = $description;
//
$sns_url = "http://".$_SERVER["HTTP_HOST"].htmlspecialchars($_SERVER["PHP_SELF"]);

//
$h1_st = "動画から音声データ抜き出し->MP3";
$h1_st_s = "  最大サイズ=".$max_up_size."まで";
/////
$site_name = "faceapglezon";
$footer_sitename = "faceapglezon";
$culhtml = "http://faceapglezon.info/soundonly";
$crlhtmltitle = "単機能1ページWebツール";
?>
<?php require('../header.php');?>
<script>
	function upload(form) {
            $form = $('#upload-form');
            fd = new FormData($form[0]);

            $('#submit-btn').hide(); //hide submit button
            $('#loading-img').show(); //hide submit button
            $("#rtn_div").html("");  

            $.ajax(
                'http://faceapglezon.info/soundonly/upload_soundonly.php',
                {
                type: 'post',
                processData: false,
                contentType: false,
                data: fd,
                dataType: "html",
                timeout:300000,
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
  <div class="container" style="margin-top:10px;">
    <!-- パンくず -->
    <ol class="breadcrumb">
      <li><a href="/">ホーム</a></li>
      <!-- <li><a href="/tools/">単機能1ページWebツール</a></li> -->
      <li class="active"><?=$h1_st?></li>
    </ol>
  <!-- パンくず -->
    <!-- 広告 -->
    <div class="row" style="margin-top:10px;" >
      <div class="col-md-12" style="height: 100px;text-align: center;">
      <!-- ＜スポンサーリンク＞ -->
        <?php if (is_mobile()) :?>
        <!-- スマートフォン向けコンテンツ -->
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- レスポンシブ -->
        <ins class="adsbygoogle"
        style="display:block"
        data-ad-client="ca-pub-6625574146245875"
        data-ad-slot="6145590005"
        data-ad-format="auto"></ins>
        <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
        <?php else: ?>
        <!-- PC向けコンテンツ -->
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- ビッグバナー大 -->
        <ins class="adsbygoogle"
             style="display:inline-block;width:970px;height:90px"
             data-ad-client="ca-pub-6625574146245875"
             data-ad-slot="8563765200"></ins>
        <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
        <?php endif; ?>
        
      </div>
      <!-- 広告 -->
      <div class="col-md-8">
        <div class="page-header">
          <h1><?=$h1_st?><br><small>動画ファイルから音声ファイル(MP3)のみを抜き出します</small></h1>
        </div>
        <p>処理実績=<?php echo $exm_max_size;?>MB</p>
				<form  id="upload-form" method="post" name="form" enctype="multipart/form-data" onSubmit="return upload(this);">
				  <br>
					<input type="file" id="upload-form-file" name="userfile" accept="image/*;capture=camera" style="display: none;">
          <div style="width:60%;float:left;margin-right:10px;" class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default btn-lg" type="button" onclick="$('#upload-form-file').click();">
                <i class="glyphicon glyphicon-folder-open "></i>
              </button>
            </span>
            <input id="upfile" type="text" class="form-control input-lg sh_sound" placeholder="動画セレクト..." disabled>
          </div>
          <input type="submit" name="submit"  id="submit-btn" class="btn btn-primary btn-lg" value="アップロード">
          <img src="img/load.gif" id="loading-img" style="display:none;" alt="Please Wait"/>
				</form>


        <!-- アップロード -->
        <div id="note" class="col-md-12" style="margin-top:150px;">
          <h2><i class="glyphicon glyphicon-info-sign"></i> このツールでできること</h2>
          <h3><p>動画ファイル(mp4、flv、mov、mpeg)から音声ファイル(MP3)のみを抜き出します。</p></h3>
          <p class="help-block">※通信環境等によって処理ファイルサイズが変わります。</p>

          <h2><i class="glyphicon glyphicon-info-sign" style="margin-top:30px;"></i> ツール実行結果イメージ</h2>
          <img src="img/tools_sound.png" class="img-responsive img-thumbnail" alt="処理結果イメージ">
        </div>
        <!-- 動画抜き出しPNGギャラリー -->
        <div id="rtn_div"></div>
      </div>

      <!-- サイドバー -->
      <div class="col-md-4" style="margin-top:50px;text-align: center;" >
        <!--↓TAB 不要な時は削除してください-->
        <div class="well">
          ＜スポンサーリンク＞
          <?php if (is_mobile()) :?>
          <!-- スマートフォン向けコンテンツ -->
          <?php else: ?>
          <!-- PC向けコンテンツ -->
          <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
          <!-- ラージ スカイスクレイパー -->
          <ins class="adsbygoogle"
               style="display:inline-block;width:300px;height:600px"
               data-ad-client="ca-pub-6625574146245875"
               data-ad-slot="3993964800"></ins>
          <script>
          (adsbygoogle = window.adsbygoogle || []).push({});
          </script>
          <?php endif; ?>
        </div>
        <div class="well">

          ＜スポンサーリンク＞
          <a href="http://px.a8.net/svt/ejp?a8mat=2BY9UT+941Y6Q+D8Y+C5VW1" target="_blank">
            <img border="0" width="250" height="250" alt="" src="http://www28.a8.net/svt/bgt?aid=141007205551&wid=005&eno=01&mid=s00000001717002043000&mc=1"></a>
            <img border="0" width="1" height="1" src="http://www10.a8.net/0.gif?a8mat=2BY9UT+941Y6Q+D8Y+C5VW1" alt="">
        </div>
        <div class="well">
          <!-- 右肩広告 -->
          ＜スポンサーリンク＞
          <a href="http://px.a8.net/svt/ejp?a8mat=2C0KWL+CL2Z82+CO4+699KH" target="_blank">
            <img border="0" width="250" height="250" alt="" src="http://www22.a8.net/svt/bgt?aid=141114837761&wid=005&eno=01&mid=s00000001642001051000&mc=1"></a>
            <img border="0" width="1" height="1" src="http://www18.a8.net/0.gif?a8mat=2C0KWL+CL2Z82+CO4+699KH" alt="">
          <!-- .右肩広告 -->
        </div>
        <div class="well">
          <!-- 右肩広告 -->
          ＜関連サイト＞
          <a href="http://it-education.xyz/" target="_blank">
            <img border="0" width="250" height="93" alt="IT教習所-ITで稼ぐために必要な学習の高速道路の走り方を学ぶ" src="/images/IT250x93.jpg">
          </a>

        </div>
        <div class="well">
          <!-- 右肩広告 -->
          ＜関連サイト＞
          <a href="http://icalendar.xyz/calendar/28/2015/01" target="_blank">
            <img border="0" width="250" height="66" alt="画像カレンダーでその日の出来事が一瞬でわかる" src="/images/b.jpg">
          </a>
          <!-- .右肩広告 -->
        </div>
      </div>
      <!-- サイドバー -->

    </div><!-- .row -->
		<!-- 広告 -->
		<div class="col-md-12" style="margin-top:50px;text-align: center;" >
        <!-- ＜スポンサーリンク＞ -->
        <?php if (is_mobile()) :?>
        <!-- スマートフォン向けコンテンツ -->
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- レスポンシブ -->
        <ins class="adsbygoogle"
        style="display:block"
        data-ad-client="ca-pub-6625574146245875"
        data-ad-slot="6145590005"
        data-ad-format="auto"></ins>
        <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
        <?php else: ?>
        <!-- PC向けコンテンツ -->
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- ビッグバナー大 -->
        <ins class="adsbygoogle"
             style="display:inline-block;width:970px;height:90px"
             data-ad-client="ca-pub-6625574146245875"
             data-ad-slot="8563765200"></ins>
        <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
        <?php endif; ?>
        
      </div>
      <!-- 広告 -->

  </div><!-- .container -->
</div><!-- .row -->
<?php require('../footer.php');?>

<!-- アップロード -->
<script>
$(function(){
  $('#upload-form-file').change(function() {
    $('#upfile').val($(this).val());
  });
})
</script>
<!-- .アップロード -->
</body>
</html>





