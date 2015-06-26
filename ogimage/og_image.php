<?php
require_once("lib/mysql-ini.php");
// データベースに接続
if(!$db_conn = mysql_connect($host, $user, $pass))
{
  print("データベースにアクセスできません。");
  exit;
}
$rtn = mysql_query("SET NAMES sjis" , $db_conn);
mysql_select_db($dbname);

function f_insert_og_image($db_conn, $url,$agent)
{
  mysql_set_charset('utf8'); // ←変更
  $sql = "INSERT INTO `sit` (`url`, `agent`) VALUES ('$url','$agent')";
  $result = mysql_query($sql, $db_conn);
  if(!$result)
  {
    $rtn =  "NG";
  }else{
    $rtn = "OK";
  }
  return $rtn;
}

// (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
//使用方法 
//スタンダード
// http://faceapglezon.info/httmltoimage/og_image.php?url=ページURL指定
//
//サイズを指定
//http://faceapglezon.info/httmltoimage/og_image.php?url=「ページURL指定」&w=「幅」&h=「高さ」&=exm=res
//
//トリミング
//http://faceapglezon.info/httmltoimage/og_image.php?url=「ページURL指定」&w=「幅」&h=「高さ」&=exm=crop

require_once 'src/autoload.php';

use Knp\Snappy\Image;

if (isset($_GET['url']) && $_GET['url'] !== '') : $url = $_GET['url']; else : die('Incorrect data entered.'); endif;

$agent = $_SERVER['HTTP_USER_AGENT'];
$url = $_GET['url'];
//
$rtn = f_insert_og_image($db_conn, $url,$agent);

$EXM=$_GET['exm'];
// $WIDTH=$_GET['w'];
$WIDTH=1200;
$HEIGHT=$_GET['h'];
if($WIDTH>0&&$HEIGHT>0)
{
	if($EXM=="res")
	{
		//サイズ指定
		$exm_st = "/usr/bin/wkhtmltoimage --width ".$WIDTH." --height ".$HEIGHT;	
		// $exm_st = "/usr/bin/wkhtmltoimage --crop-h 600 --width 180 --height 100";

		$snappy = new Image($exm_st);
	}elseif($EXM=="crop"){
		//トリミング
		// $exm_st = "/usr/bin/wkhtmltoimage --crop-h ".$HEIGHT." --crop-w ".$WIDTH;
		$exm_st = "/usr/bin/wkhtmltoimage --crop-h ".$HEIGHT." --crop-w ".$WIDTH;
		$snappy = new Image($exm_st);
	}else{
		//スタンダード
		$snappy = new Image('/usr/bin/wkhtmltoimage');
	}
}else{
	//スタンダード
	$snappy = new Image('/usr/bin/wkhtmltoimage');
}


header("Content-Type: image/jpeg");
echo $snappy->getOutput($url);

?>