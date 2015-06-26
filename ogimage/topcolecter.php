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


require_once 'src/autoload.php';

use Knp\Snappy\Image;

if (isset($_GET['url']) && $_GET['url'] !== '') : $url = $_GET['url']; else : die('Incorrect data entered.'); endif;

$agent = $_SERVER['HTTP_USER_AGENT'];
$url = $_GET['url'];
//
$rtn = f_insert_og_image($db_conn, $url,$agent);

$WIDTH=1200;
$HEIGHT=1200;
$exm_st = "/usr/bin/wkhtmltoimage --crop-h ".$HEIGHT." --crop-w ".$WIDTH;
$snappy = new Image($exm_st);
// $snappy = new Image('/usr/bin/wkhtmltoimage');

header("Content-Type: image/jpeg");
echo $snappy->getOutput($url);

?>