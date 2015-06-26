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

// $arycardtype = array(
//     'amazon' => 'アマゾンカード',
//     'bigsuica' => 'ビックカメラSuicaカード',
//     'smbcplus' => '三井住友デビュープラスカード',
//     'etc' => 'その他'
// );
$arycardtype = array(
    '' => 'Webページ全体',
    // '180' => '180x180',
    '320' => 'x320',
    '640' => 'x640',
    '970' => 'x970',
    '1200' => 'x1200'
);

$title = "og:imageタグ用のWebページサムネイル作成URL発行";	
$keywords = "OGPタグ Open Graph Protocol facebook google+ og:image";
$description = "OGP(Open Graph Protocol)タグ用のWebページサムネイル画像をURLだけで作成します。";
//
$og_title = $title;
$og_image = 'http://faceapglezon.info/ogimage/og_image.php?url='.(empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
$og_url = "http://faceapglezon.info/ogimage/index.php";
$og_site_name = $title;
$og_description = $description;

$h1_st = $title;
// $h1_st_s = "  現在21サイズ対応";
$culhtml = "http://faceapglezon.info/ogimage/";
$crlhtmltitle = "単機能1ページWebツール";
$site_name = "faceapglezon";
$footer_sitename = "faceapglezon";

// $sns_url = "http://".$_SERVER["HTTP_HOST"].htmlspecialchars($_SERVER["PHP_SELF"]);
$sns_url =  (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];

/////
?>
<?php require('../header.php');?>
<script>
function upload(form) 
{
  $form = $('#upload-form');
  fd = new FormData($form[0]);

  $('#submit-btn').hide(); //hide submit button
  $('#loading-img').show(); //hide submit button
  $("#rtn_div").html("");  

  $.ajax(
      'http://faceapglezon.info/ogimage/upload.php',
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
  <div class="container"  style="margin-top:10px;" >
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
          <h1><?=$h1_st?><br><small></small></h1>
        </div>
         <form  id="upload-form" method="post" name="form"  onSubmit="return upload(this);">
          <div style="width:60%;float:left;margin-right:10px;" class="input-group">
            <span class="input-group-btn">
              <span class="glyphicon glyphicon-card"></span>
            </span>
            <input name="url" id="url" type="text" class="form-control input-lg seoup" placeholder="http://" >
            

          </div>

          <div style="width:60%;float:left;margin-right:10px;" class="input-group">
            <span class="input-group-btn">
              <span class="glyphicon glyphicon-card"></span>
            </span>
            <!-- <input name="cardtype" id="cardtype" type="text" class="form-control input-lg seoup" placeholder="カード種類" > -->
            <select class="form-control input-group-lg btn-lg seoup placeholder" id="cardtype" name="cardtype">
                <?php
                if(!$cardtype)
                {
                  echo '<option class="input-group-lg btn-lg" value="" >▼仕上がりサイズ</option>';
                }
                foreach ($arycardtype as $key => $value)
                {
                  // $value = mb_convert_encoding($value , "UTF8", "SJIS");
                  if($key==$cardtype)
                  {
                    echo '<option  class="input-group-lg btn-lg" value="' . $key . '" selected>' . $value . '</option>';
                  }else{
                    echo '<option  class="input-group-lg btn-lg" value="' . $key . '">' . $value . '</option>';
                  }
                }
                ?>
            </select>

          </div>

          
          <div>
          <input type="submit" name="submit"  id="submit-btn" class="btn btn-primary btn-lg " value="サムネイルURL取得">
          <img src="img/load.gif" id="loading-img" style="display:none;" alt="Please Wait"/>
        </div>
        </form>


        <!-- アップロード -->
        <div id="note" class="col-md-12" style="margin-top:50px;">
          <h2><i class="glyphicon glyphicon-info-sign"></i> このツールでできること</h2>
            <ul>
              <li class="h4">指定したWebページのサムネイル画像を用URLを取得します。</li>
            </ul>
            <p class="help-block">※縦に長いページは仕上がりサイズ指定してください。</p>
            
          <h2><i class="glyphicon glyphicon-info-sign" style="margin-top:30px;"></i> ツール実行結果イメージ<br>
          <small>今のYahooトップサムネイル</small>
          </h2>
          <img src="http://faceapglezon.info/ogimage/og_image.php?url=http://www.yahoo.co.jp/&w=640&h=640&exm=crop" class="img-responsive img-thumbnail" alt="処理結果イメージ">
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
          <!-- 右肩広告 -->
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
          <!-- .右肩広告 -->
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
		<div class="row" style="margin-top:30px;text-align: center;" >
    	<div class="col-md-12">
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
    </div>
    <!-- 広告 -->

  </div><!-- .container -->
</div>
<?php require('../footer.php');?>

</body>
</html>






