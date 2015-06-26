<?php
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--  -->
	<meta name="keywords" content="<?=$keywords?>">
	<meta name="description" content="<?=$description?>">
	<title><?=$title?></title>
	<!-- OGP -->
	<meta property="og:type" content="website" />
	<meta property="og:title" content="<?=$og_title?>" />
	<meta property="og:image" content="http://faceapglezon.info/ogimage/icalendar.php?url=<?php echo (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];?>" />
	<!-- <meta property="og:image" content="<?=$og_image2?>" /> -->
	<meta property="og:url" content="<?=$og_url?>" />
	<meta property="og:site_name" content="<?=$og_site_name?>" />
	<meta property="og:description" content="<?=$og_description?>" />
	<meta property="og:locale" content="ja_JP" />

	<meta property="fb:app_id" content="<?=$fb_app_id?>" /> 
	<meta property="article:publisher" content="<?=$article_publisher?>" />

	<meta name="twitter:card" content="summary">
	<meta name="twitter:site" content="<?=$twitter_site?>">
	<meta property="twitter:account_id" content="<?=$twitter_account_id?>" />

	<title itemprop="name"><?=$itemprop_name?></title>
	<meta itemprop="description" content="<?=$itemprop_description?>" />
	<link itemprop="author" href="<?=$itemprop_author?>" />
	<!-- OGP --> 
    <!-- Bootstrap -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
	<!-- footer -->
	<link href="/css/footer.css" rel="stylesheet">
	<!-- SNSボタン -->
	<link href="/css/normalize.min.css" rel="stylesheet">
	<!-- datepicker -->
    <link rel="stylesheet" type="text/css" href="../css/bootstrap-datepicker.css" />	
	<link href="/css/rrssb.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<!-- ファビコン・アイコン -->
	<link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon-180x180.png">
	<link rel="icon" type="image/png" href="/favicon-192x192.png" sizes="192x192">
	<link rel="icon" type="image/png" href="/favicon-160x160.png" sizes="160x160">
	<link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96">
	<link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
	<link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
	<meta name="msapplication-TileColor" content="#eaeff5">
	<meta name="msapplication-TileImage" content="/mstile-144x144.png">
	<!-- ファビコン・アイコン -->
  </head>
 





