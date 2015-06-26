<?php
$footer_sitename = "faceapglezon";
$copy = "© ".date('Y').' '.$footer_sitename;
$fb_url = "https://www.facebook.com/pages/FaceApGleZon/180485931995158";
$tw_url = "https://twitter.com/FaceApGleZon";
// $gp_url = "https://plus.google.com/u/0/b/107664182547620758913/107664182547620758913/about/p/pub";
$gp_url = "https://plus.google.com/+FaceapglezonInfo";

$tb_url= "tumblr";
$git_url= "github";
$pin_url= "pinterest";
$in_url= "linkedin";
?>
<!-- ページトップへ -->
<a href="" class="btn btn-default pull-right" id="page-top">
<i class="fa fa-angle-up fa-fw"></i>
</a>
<!-- フッター -->
<footer class="bs-footer" role="contentinfo">
	<div class="container">
		<!-- ソーシャルボタン -->
		<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
		<div class="bs-social">
			<ul class="bs-social-buttons">
				<li class="facebook-button">
					<a href="<?=$fb_url?>" target="_blank"><i id="social" class="fa fa-facebook-square fa-3x social-fb"></i></a>
				</li>
				<li class="follow-btn">
					<a href="<?=$tw_url?>" target="_blank"><i id="social" class="fa fa-twitter-square fa-3x social-tw"></i></a>
				</li>
				<li class="tweet-btn">
					<a href="<?=$gp_url?>" target="_blank"><i id="social" class="fa fa-google-plus-square fa-3x social-gp"></i></a>
				</li>
			</ul>
		</div>
		<!-- ソーシャルボタン -->
		<!-- リンク -->
		<p class="ft_link"><?=$copy?>
			<a href="form.php" >お問い合わせ</a>	
<!-- 			<a href="/terms/" >利用規約</a> | 
			<a href="/privacy/">プライバシー</a> -->
		</p>
		<!-- リンク -->
	</div>
</footer>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="js/modernizr-2.6.2-respond-1.1.0.min.js"></script>
<script src="js/rrssb.min.js"></script>
<!-- datepicker -->
<script type="text/javascript" src="js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="js/bootstrap-datepicker.ja.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<!-- <script src="../js/bootstrap.min.js"></script> -->
<!-- アップロード -->
<script>
$(function(){
	$('#upload-form-file').change(function() {
		$('#upfile').val($(this).val());
	});
})
</script>
<!-- .アップロード -->
<!-- footer.js -->
<script src="js/footer.js"></script>
<!-- google -->
<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-39613103-1']);
_gaq.push(['_trackPageview']);
(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>
<!-- Shepherd -->
<script src="js/shepherd.js"></script>


<!-- Facebook -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&appId=528563560616645&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<!-- Twitter -->
<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
<!-- Google+ -->
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
<!-- はてなブックマーク -->
<script type="text/javascript" src="http://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script>
<!-- //サムネイル -->
<!-- <script type="text/javascript" src="js/jquery-jLinkPreview-1.0.0-min.js"></script>
<script type="text/javascript">
$(function() {
   $().jLinkPreview({
         'preload': true,
         'width': 256,
         'height': 192,
         'fade': 300,
         'background-color': '#333',
         'elementsHavingId': '',
         'elementsHavingClass': 'example',
         'attribute': 'title'
   });
});
</script> -->






