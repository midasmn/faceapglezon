<?php
// $site_name = "ファビコン・アイコンリサイズ";
?>
<!-- ナビゲーションバー -->
<nav class="navbar navbar-default" role="navigation" style="margin-bottom: 0;">
	<div class="container" id="listroot">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-bootsnipp-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<!-- サイト名 -->
			<div class="animbrand">
				<a class="navbar-brand" href="#">
        			<!-- <img alt="Brand" src="..."> -->
        			<?=$site_name?>
      			</a>
			</div>
		</div>
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse navbar-bootsnipp-collapse">
			<!-- 左メニュー -->
			<ul class="nav navbar-nav">
				<!-- リスト -->
				<li class="dropdown ">
					<a href="" class="dropdown-toggle" data-toggle="dropdown">
						<span class="glyphicon glyphicon-th-list"></span> ドロップダウンメニュ <b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
						<li class="">
							<a href="#">
								<span class="glyphicon glyphicon-plus"></span> 登録
							</a>
						</li>
						<li class="divider"></li>
						<li class="dropdown-header">更新のﾍｯﾀﾞｰ</li>
						<li class="">
							<a href="#">
								<span class="glyphicon   glyphicon-pencil"></span> 更新
							</a>
						</li>
					</ul>
				</li>
				<!-- リスト -->
			</ul>
			<!-- 左メニュー -->

			<!-- 右メニュー -->
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown ">
					<a href="" class="dropdown-toggle" data-toggle="dropdown">
						<span class="glyphicon glyphicon-th-list"></span> 管理 <b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
						<li class="">
							<a href="#︎">
								<span class="glyphicon glyphicon-pencil"></span> マスター追加
							</a>
						</li>
						<li class="divider"></li>
						<li class="dropdown-header"> 削除の説明</li>
						<li class="">
							<a href="/rc/dellist.php">
								<span class="glyphicon glyphicon-pencil"></span> 削除
							</a>
						</li>
					</ul>
				</li>
			</ul>
			<!-- 右メニュー -->
		</div><!-- /.navbar-collapse -->
	</div>
</nav>