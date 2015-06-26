<?php
require_once("lib/mysql-ini.php");
require_once("lib/lib_upload.php");
// データベースに接続
if(!$db_conn = mysql_connect($host, $user, $pass))
{
	print("データベースにアクセスできません。");
	exit;
}
// $rtn = mysql_query("SET NAMES sjis" , $db_conn);
mysql_select_db($dbname);



// $html_base = "http://faceapglezon.info/tools/mpegmagick/index.php";
$html_base = $_SERVER["HTTP_REFERER"];


$exmname = $_GET['exm_dir'];
//処理フォルダ
// $TMP="../tmp/";
//
// $delpath = $TMP.$exmname;
//
remove_directory($exmname);
//フラグアップデート
f_update_flg($db_conn,$exmname);


header("Location: ". $html_base);
exit;

?>



