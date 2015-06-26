<?php
$footer_sitename = $site_name;
// $copy = " ".date('Y').' '.$footer_sitename;
$fb_url = "https://www.facebook.com/pages/FaceApGleZon/180485931995158";
$tw_url = "https://twitter.com/FaceApGleZon";
$gp_url = "https://plus.google.com/u/0/b/107664182547620758913/107664182547620758913/about/p/pub";

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

<div class="footer">
	<div class="container">
		<div class="whiteband clearfix">
			<ul class="pull-left">
				<li><a href="<?php echo $base_url;?>" target="_self">ホーム</a> /</li>
				<li><a href="/tour" target="_self">使い方</a> /</li>
				<li><a href="#/">ブログ</a> /</li>
				<li><a href="#">ヘルプ</a> /</li>
				<li><a href="/contact" target="_self">お問い合わせ</a> /</li>

				<li><a href="/api" target="_self">開発</a> /</li>
				<li><a href="/doc/terms" target="_self">利用規約</a> /</li>
				<li><a href="/doc/privacy" target="_self">プライバシー</a></li>
			</ul>

			<div class="pull-right hidden-xs">
				<a class="social-icon" href="#" target="_blank" rel="fb_share" data-original-title="Like us on Facebook">
					<i id="social" class="fa fa-facebook-square fa-2x social-fb"></i>
				</a>
				<a class="social-icon" href="#" target="_blank" rel="fb_share" data-original-title="Follow us on Twitter">
					<i id="social" class="fa fa-twitter-square fa-2x social-tw"></i>
				</a>
				<a class="social-icon" href="#" target="_blank" rel="fb_share" data-original-title="Follow us on Twitter">
					<i id="social" class="fa fa-google-plus-square fa-2x social-gp"></i>
				</a>
<!-- fa fa-google-plus-square fa-3x social-gp -->
			</div>
		</div>

		<div>
			&copy;<?php echo date('Y');?> <a href="<?php echo $base_url;?>" target="_blank" style="font-family:'EB Garamond',serif;"><?php echo $footer_sitename;?></a>
			<i class="glyphicon glyphicon-globe"></i> <a data-title="Language" href="javascript:;" id="language-switch">日本語</a>
			<span id="languages-list" style="display:none;">
				<a href="/en">English</a><br />
				<a href="#">日本語</a><br />
			</span>
		</div>
	</div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<!-- asny-bootstrap -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>
<!-- def.js -->
<script src="js/def.js"></script>  