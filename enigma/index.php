<?php
require_once("lib/mysql-ini.php");
// データベースに接続
if(!$db_conn = mysql_connect($host, $user, $pass))
{
  print("データベースにアクセスできません。");
  exit;
}
mysql_select_db($dbname);
mysql_query('set character set utf8');


// モバイル判定
function is_mobile(){
    $useragents = array(
        'iPhone', // iPhone
        'iPod', // iPod touch
        'Android.*Mobile', // 1.5+ Android *** Only mobile
        'Windows.*Phone', // *** Windows Phone
        'dream', // Pre 1.5 Android
        'CUPCAKE', // 1.5+ Android
        'blackberry9500', // Storm
        'blackberry9530', // Storm
        'blackberry9520', // Storm v2
        'blackberry9550', // Storm v2
        'blackberry9800', // Torch
        'webOS', // Palm Pre Experimental
        'incognito', // Other iPhone browser
        'webmate' // Other iPhone browser

    );
    $pattern = '/'.implode('|', $useragents).'/i';
    return preg_match($pattern, $_SERVER['HTTP_USER_AGENT']);
}
function f_insert_strrev($db_conn,$keyword,$user_agent)
{
  $sql = "INSERT INTO `strrev`( `keyword`,`user_agent`)VALUES('$keyword','$user_agent')";
  $result = mysql_query($sql, $db_conn);
  if(!$result)
  {
    $rtn =  "NG";
  }else{
    $rtn = "OK";
  }
  return $rtn;
}




$title = "YouTubeやDailymotion検索用に文字を反転させるツール";	
$keywords = "YouTube Dailymotion PandoraTV FC2動画 文字反転";
$description = "YouTubeやDailymotion検索用に文字を反転させるだけのツール";
//

$og_title = $title;
$og_image = "http://faceapglezon.info/tools/icon/img/tools_icon.png";
$og_url = "http://faceapglezon.info/tools/icon/index.php";
$og_site_name = $title;
$og_description = $description;

$h1_st = "YouTubeやDailymotion検索用に文字を反転";
$h1_st_s = "  現在21サイズ対応";
$culhtml = "http://faceapglezon.info/tools";
$crlhtmltitle = "単機能1ページWebツール";
$site_name = "faceapglezon";
$footer_sitename = "faceapglezon";

$sns_url = "http://".$_SERVER["HTTP_HOST"].htmlspecialchars($_SERVER["PHP_SELF"]);

// 文字反転
// $strrev = $_GET['strrev'];
$strrev = $_POST['strrev'];
$value_st = $_POST['value_st'];
if($strrev)
{
  // インサート
  $user_agent = $_SERVER['HTTP_USER_AGENT'];
  // $keyword = mb_convert_encoding($strrev, "UTF-8", "UTF-8");
  // echo $keyword;
  $rtn = f_insert_strrev($db_conn,$strrev,$user_agent);
  // 
  $tmp_st = "";
  $st_cnt = mb_strlen($strrev,"UTF-8");
  for ($i=0; $i < $st_cnt; $i++) 
  { 
    $tmp_st .= mb_substr($strrev,$st_cnt-$i-1,1,"UTF-8"); //後ろから1文字ずつ
  }
  $strrev = $tmp_st;
  if($value_st =="文字反転"){
    $value_st = "文字元に戻す";
  }else{
    $value_st = "文字反転";  
  }
}else{
  $value_st = "文字反転";  
}
/////
?>
<?php require('../header.php');?>
<body>
<div id="wrap" >
<?php require('../menu.php');?>
  <div class="container" style="margin-top:10px;" >
    <!-- パンくず -->
    <ol class="breadcrumb">
      <li><a href="/">ホーム</a></li>
      <!-- <li><a href="/tools/">単機能1ページWebツール</a></li> -->
      <li class="active"><?=$h1_st?></li>
    </ol>
  <!-- パンくず -->
    <!-- 広告 -->
    <div class="row" style="margin-top:10px;" >
      <div class="col-md-12" style="height:100px;text-align: center;">
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
          <h1><?=$h1_st?></h1>
        </div>

        <form  method="POST" action="index.php">
          <div style="width:60%;float:left;margin-right:10px;" class="input-group">
            <span class="input-group-btn">
              <span class="glyphicon glyphicon-calendar"></span>
            </span>
            <input name="strrev" type="text" class="form-control input-lg seoup" placeholder="反転したい文字入力" value="<?php echo $strrev;?>">
            <input mode="EXM" type="hidden">
          </div>
          <input type="hidden" name="value_st"  value="<?=$value_st ?>">
          <input type="submit" name="submit"  id="submit-btn" class="btn btn-primary btn-lg " value="<?=$value_st ?>">
          <img src="img/load.gif" id="loading-img" style="display:none;" alt="Please Wait"/>
        </form>

        <!-- アップロード -->
        
        <div id="rtn_div">
        <?php
        if($strrev)
        {
          $url_keyword = urlencode($strrev);
          $youtube_url = 'https://www.youtube.com/results?search_query='.$url_keyword;
          $dailymotion_url = 'http://www.dailymotion.com/jp/relevance/universal/search/'.$url_keyword;
          $soku_url = 'http://www.soku.com/search_video/q_'.$url_keyword;
          $pandora_url = 'http://jp.search.pandora.tv/?&query='.$url_keyword;
          $fc2_url ='http://video.fc2.com/movie_search.php?keyword='.$url_keyword;
        ?>
          <div class="row" style="margin-top:30px;" >

            <div class="col-md-12" >
              <a href="<?php echo $youtube_url; ?>" target="_blank" class="btn btn-danger btn-block btn-lg">
                <i id="social" class="fa fa-youtube-play fa-2x social-fb"></i> YouTub検索
              </a>
            </div> 

            <div class="col-md-12" style="margin-top:30px;">
              <a href="<?php echo $dailymotion_url; ?>" target="_blank" class="btn btn-primary btn-block btn-lg">
                <i id="social" class="fa fa-youtube-play fa-2x social-fb"></i> Dailymotion検索
              </a>
            </div> 

            <div class="col-md-12" style="margin-top:30px;">
              <a href="<?php echo $soku_url; ?>" target="_blank" class="btn btn-success btn-block btn-lg">
                <i id="social" class="fa fa-youtube-play fa-2x social-fb"></i> Youku検索
              </a>
            </div> 

            <div class="col-md-12" style="margin-top:30px;">
              <a href="<?php echo $pandora_url; ?>" target="_blank" class="btn btn-info btn-block btn-lg">
                <i id="social" class="fa fa-youtube-play fa-2x social-fb"></i> PandoraTV検索
              </a>
            </div> 

            <div class="col-md-12" style="margin-top:30px;">
              <a href="<?php echo $fc2_url; ?>" target="_blank" class="btn btn-warning btn-block btn-lg">
                <i id="social" class="fa fa-youtube-play fa-2x social-fb"></i> FC2動画検索
              </a>
            </div> 
          </div>
        </div>


          <?php
          }else{
          ?>
          <div id="note" class="col-md-12" style="margin-top:150px;">
            <h2><i class="glyphicon glyphicon-info-sign"></i> このツールでできること</h2>
            <h3>
            <p>入力した文字列を反転します。</p>
            <p>反転した文字列で下記サイト検索できるボタンを表示します。</p>
            </h3>
            <h4>
            YouTube(ユーチューブ)<br>
             Dailymotion(デイリーモーション)<br>
             Youku(ヨウク)<br>
             PandoraTV(パンドラTV)<br>
             FC2動画
            <p>※英数・日本語対応</p>
            </h4>
            <h2><i class="glyphicon glyphicon-info-sign" style="margin-top:30px;"></i> ツール実行結果イメージ</h2>
            <img src="img/tools_icon.png" class="img-responsive img-thumbnail" alt="処理結果イメージ">
          </div>
        </div>

          <?php
          }
          ?> 



  
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
      <!-- 広告 -->

  </div><!-- .container -->
</div><!-- .row -->
<?php require('../footer.php');?>

</body>
</html>






