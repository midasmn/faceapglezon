<?php
$title = "Webアイコンフォント「Font Awesome」サンプル";	
$keywords = "FontAwesome Bootstrap CDN Webフォント アイコン";
$description = "Bootstrapで簡単につかえるWebアイコンフォント「Font Awesome」サンプル";
//

$og_title = $title;
$og_url = "http://faceapglezon.info/fa/index.php";
$og_site_name = $title;
$og_description = $description;

$h1_st = $title;
$h1_st_s = "  SNSブランドアイコン";
$culhtml = "http://faceapglezon.info/fa";
$crlhtmltitle = "ペライチ単機能Webツール";
$site_name = "faceapglezon";
$footer_sitename = "faceapglezon";

$sns_url = "http://".$_SERVER["HTTP_HOST"].htmlspecialchars($_SERVER["PHP_SELF"]);

/////
?>
<?php require('../header.php');?>

<body>
<?php require('../menu.php');?>
<div class="row" style="margin-top:10px;" >
  <div class="container">
    <!-- パンくず -->
    <ol class="breadcrumb">
      <li><a href="/">ホーム</a></li>
      <!-- <li><a href="/tools/">単機能1ページWebツール</a></li> -->
      <li class="active"><?=$h1_st?></li>
    </ol>
  <!-- パンくず -->
    <!-- 広告 -->
    <div class="row" style="margin-top:10px;" >
      <div class="col-md-12" style="height: 100px;">
        ＜スポンサーリンク＞
      <!-- <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12"> -->
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
      </div>
      <!-- 広告 -->
      <div class="col-md-8">
        <div class="page-header">
          <h1><?=$h1_st?><br><small>ソーシャル系ブランドWebフォントサンプル</small></h1>
        </div>
       
        <style>
        .fa-facebook-square {
        color: #d1d4d3;
        }
        .fa-twitter-square {
        color: #d1d4d3;
        }
        .fa-google-plus-square {
        color: #d1d4d3;
        }
        .fa-tumblr-square{
        color: #d1d4d3;
        }
        .fa-github  {
        color: #d1d4d3;
        }
        .fa-pinterest-square {
        color: #d1d4d3;
        }
        .fa-linkedin-square{
        color: #d1d4d3;
        }
        /**/
        .fa-facebook-square:hover {
        color: #3B5998;
        }
        .fa-twitter-square:hover {
        color: #4099FF;
        }
        .fa-google-plus-square:hover {
        color: #d34836;
        }
        .fa-tumblr-square:hover {
        color: #35465c;
        }
        .fa-github:hover {
        color: #666;
        }
        .fa-pinterest-square:hover {
        color: #cc2127;
        }
        .fa-linkedin-square:hover {
        color: #0976b4;
        }
        </style>
        <i class="fa fa-facebook-square fa-lg fa-fw "></i>
        <i class="fa fa-twitter-square fa-2x fa-fw fa-spin"></i>
        <i  class="fa fa-google-plus-square fa-3x fa-fw"></i>
        <i class="fa fa-github fa-5x fa-fw fa-spin"></i>
        <i  class="fa fa-tumblr-square fa-4x fa-fw"></i>
        <i  class="fa fa-pinterest-square fa-3x fa-fw"></i>
        <i  class="fa fa-linkedin-square fa-2x fa-fw"></i>
    



        <!-- SNS -->
        <div class="sbver" style="margin-top:30px;">
          <ul style="mmargin:0; padding:0; clear: both;">
            <li class="likeButton" style="list-style-type:none; float: left; margin-right:10px;">
              <!-- <div class="fb-like" data-href="<?php echo $sns_url; ?>" data-send="false" data-layout="box_count" data-width="72" data-show-faces="false"></div> -->
              <div class="fb-like" data-href="<?php echo $sns_url; ?>" data-layout="box_count" data-action="recommend" data-show-faces="false" data-share="false"></div>
            </li> 
            <li class="tweetButton" style="list-style-type:none; float: left; margin-right:10px;">
              <a href="https://twitter.com/share" class="twitter-share-button" data-count="vertical" data-url="<?php echo $sns_url; ?>" data-text="<?php echo $h1_st; ?>" data-via="" data-lang="ja">ツイート</a>
            </li>
            <li class="gplusButton" style="list-style-type:none; float: left; margin-right:10px;">
              <g:plusone size="tall" href="<?php echo $sns_url; ?>"></g:plusone>
            </li>
            <li class="hatebuButton" style="list-style-type:none; float: left; margin-right:10px;">
              <a href="http://b.hatena.ne.jp/entry/<?php echo $sns_url; ?>" class="hatena-bookmark-button" data-hatena-bookmark-title="<?php echo $h1_st; ?>" data-hatena-bookmark-layout="vertical-balloon" title="このエントリーをはてなブックマークに追加">
                <img src="http://b.st-hatena.com/images/entry-button/button-only.gif" alt="このエントリーをはてなブックマークに追加" width="20" height="20" style="border: none;" />
              </a>
            </li>
          </ul>
        </div>
        <!-- SNS -->
      </div>

      <!-- サイドバー -->
      <div class="col-md-4" style="margin-top:50px;text-align: center;" >
        <!--↓TAB 不要な時は削除してください-->
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
      </div>
      <!-- サイドバー -->

    </div><!-- .row -->
		<!-- 広告 -->
		<div class="row" style="margin-top:30px;" >
    	<div class="col-md-12">
        ＜スポンサーリンク＞
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
   	 	    <!-- レスポンシブ -->
          <ins class="adsbygoogle"
           style="display:block"
           data-ad-client="ca-pub-6625574146245875"
           data-ad-slot="6145590005"
           data-ad-format="auto">
          </ins>
        <script>
    	   (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    	</div>
    </div>
    <!-- 広告 -->

  </div><!-- .container -->
</div><!-- .row -->
<?php require('../footer.php');?>
<!-- Shepherd -->

</body>
</html>






