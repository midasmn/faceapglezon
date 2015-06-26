<?php
$footer_sitename = "faceapglezon";
$copy = "© ".date('Y').' '.$footer_sitename;
$fb_url = "https://www.facebook.com/pages/FaceApGleZon/180485931995158";
$tw_url = "https://twitter.com/FaceApGleZon";
// $gp_url = "https://plus.google.com/u/0/b/107664182547620758913/107664182547620758913/about/p/pub";
$gp_url = "https://plus.google.com/+FaceapglezonInfo";

?>
<!-- ページトップへ -->
<!-- <div class="row">
	<div class="col-md-9"></div>
	<div class="col-md-2"> -->
		<!-- <h2> -->
			<a href="" class="btn btn-default pull-right" id="page-top">
			<span class="glyphicon glyphicon-arrow-up"></span> ページ上へ</a>
		<!-- </h2> -->
<!-- 	</div>
</div> -->
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
			<a href="tools/form.php" >お問い合わせ</a>	
<!-- 			<a href="/terms/" >利用規約</a> | 
			<a href="/privacy/">プライバシー</a> -->
		</p>
		<!-- リンク -->
	<!-- 		<a href="/terms/" >利用規約</a> | 
			<a href="/privacy/">プライバシー</a> -->
		</p>
		<!-- リンク -->
	</div>
</footer>

<!-- ソーシャルボタン -->
<!-- {Permalink}を記事URL、{Title}を記事タイトル、{BlogURL}をブログトップURL -->
<p class="social-button">
<a href="http://b.hatena.ne.jp/entry/<?php echo $og_url;?>" title="この記事をはてなブックマークに追加" target="_blank">
<img src="/images/sns/Hatebu.png"></a> 
<a href="http://twitter.com/intent/tweet?url=<?php echo $og_url;?>&text=<?php echo $title;?>" target="_blank">
<img src="/images/sns/Twitter.png"></a> 
<a href="http://www.facebook.com/sharer.php?src=bm&u=<?php echo $og_url;?>&amp;t=<?php echo $title;?>" target="_blank">
<img src="/images/sns/Facebook.png"></a> 
<a href="https://plus.google.com/share?url=<?php echo $og_url;?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
<img src="/images/sns/Google+.png"></a> 
<a href="http://line.me/R/msg/text/?<?php echo $title;?>%0D%0A<?php echo $og_url;?>>">
<img src="/images/sns/Line.png"></a> 
<a href="http://getpocket.com/edit?url=<?php echo $og_url;?>&<?php echo $title;?>=<?php echo $title;?>" target="_blank">
<img src="/images/sns/Pocket.png"></a> 
</p>
<!-- ソーシャルボタン -->


<script src="/js/modernizr-2.6.2-respond-1.1.0.min.js"></script>
<script src="/js/rrssb.min.js"></script>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/js/bootstrap.min.js"></script>
<!-- datepicker -->
<script type="text/javascript" src="/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="/js/bootstrap-datepicker.ja.min.js"></script>
<!-- footer.js -->
<script src="/js/footer.js"></script>


<!--  google -->
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
