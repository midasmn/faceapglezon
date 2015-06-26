<?php
require_once("lib/mysql-ini.php");
require_once("lib/libR.php");
include("lib/simple_html_dom.php");

if(!$db_conn = @mysql_connect($host, $user, $pass))
{
	print("データベス接続失敗");
//	exit;
}
mysql_select_db($dbname);

$rtn_st = f_getloto7result($db_conn);

//ロトメール関数呼び出し
$latest_arr = f_get_latest($db_conn);
//
$st_rtb = f_send_mail_toto($db_conn,$latest_arr['cnt'],$latest_arr['cnt_date'], $latest_arr[1], $latest_arr[2], $latest_arr[3], $latest_arr[4], $latest_arr[5], $latest_arr[6], $latest_arr[7], $latest_arr[b], $latest_arr[b2], $latest_arr['amount'], $latest_arr['carry']);
?>