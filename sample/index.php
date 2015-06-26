<?php
$title = "Bootstrap3完璧サンプル";	
$keywords = "Bootstrap3,OGタグ,favicon,apple-touch-icon";
$description = "Bootstrap3の完璧サンプル";

$og_title = $title;
$og_image = "http://it-education.xyz/wp-content/uploads/2014/11/logo512.jpg";
$og_image2 = "http://it-education.xyz/wp-content/uploads/2014/11/logo512.jpg";
$og_url = "http://faceapglezon.info/sample/";
$og_site_name = $title;
$og_description = $description;
//
$itemprop_name = $title;
$itemprop_description = $description;
$itemprop_author = "http://it-education.xyz/about";
//
$fb_app_id = 1459017077694190;
$article_publisher = "https://www.facebook.com/iteducationxyz";
//
$twitter_site = "@icalendar_xyz";
$twitter_account_id =  2761857000;
//

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
	<meta property="og:image" content="<?=$og_image?>" />
	<meta property="og:image" content="<?=$og_image2?>" />
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
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

	<!-- ファビコン・アイコン -->
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
	<link rel="apple-touch-icon" href="/apple-touch-icon.png" />
	<link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png" />
	<link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png" />
	<link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png" />
	<link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png" />
	<!-- ファビコン・アイコン -->

  </head>
 
  <body>
    <h1>Hello, world!</h1>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>





