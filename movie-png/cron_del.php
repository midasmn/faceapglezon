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

// function f_update_flg($db_conn,$exmname)
// {
// 	$sql = "UPDATE `mpegmagick` SET `FLG` = 'DEL' WHERE `exmname` = '$exmname'";
// 	$result = mysql_query($sql, $db_conn);
// // var_dump($result);
// 	if(!$result)
// 	{
// 		// die('Invalid query: ' . mysql_error());
// 		$rtn =  "NG";
// 	}else{
// 		$rtn = "OK";
// 	}
// 	return $rtn;
// }
// //
// function remove_directory($dir) {
//   if ($handle = opendir("$dir")) {
//    while (false !== ($item = readdir($handle))) {
//      if ($item != "." && $item != "..") {
//        if (is_dir("$dir/$item")) {
//          remove_directory("$dir/$item");
//        } else {
//          unlink("$dir/$item");
//          // echo " removing $dir/$item<br>\n";
//        }
//      }
//    }
//    closedir($handle);
//    rmdir($dir);
//    // echo "removing $dir<br>\n";
//   }
// }


//処理フォルダ
// $TMP="../tmp/";
//
$deldate = date("Y-m-d");
// $deldate = date("2014-12-22");

$sql = "SELECT `exmname` FROM  `mpegmagick` WHERE `FLG` = 'ON' AND `expiredate` <= '$deldate'";
$result = mysql_query($sql, $db_conn);
while($link = mysql_fetch_row($result))
{
	list($exmname) = $link;
	//ディレクトリ削除
	// $delpath = $TMP.$exmname;
	remove_directory($exmname);
	//フラグアップデート
	f_update_flg($db_conn,$exmname);
}

?>



