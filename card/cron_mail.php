<?php
require_once("lib/mysql-ini.php");
require_once("lib/lib_upload.php");
require_once("lib/mail.php");
// データベースに接続
if(!$db_conn = mysql_connect($host, $user, $pass))
{
  print("データベースにアクセスできません。");
  exit;
}
mysql_select_db($dbname);
mysql_set_charset('utf8'); // ←変更

$today = date('Y-m-d');
list($yy, $mm, $exm_day) = explode('-', $today);// 文字列の分解


$sql = "SELECT `mail`,`card` ,`to`,`token` FROM `user` WHERE `flg`= 'undone' and `status` = 'ON' and  `to` >= '$today' and  `exm_day` = '$exm_day'";
$result = mysql_query($sql, $db_conn);
// echo $sql;
if($result)
{
	while($link = mysql_fetch_row($result))
	{
		list($mail,$cardtype,$ex_date,$token) = $link;
		// 
		//メール配信文作成
		$next_ex_date = date('Y/m/d', strtotime(date($ex_date) . '+1 year'));
		// 
		$subjectML = '[FaceApGleZon]実質無料クレジットカードリマインダーメール';
		$url = "http://faceapglezon.info/card/";
		$from_add = 'contact@faceapglezon.info';  //管理者アドレス
		$from_name = 'FaceApGleZon..';
		//クリアURL
		$exm_url = $url."exm.php?token=".$token;
		//削除用URL
		$del_url = $url."del.php?token=".$token;
		// 
		$message = $mail."さま". "

";
      $message .= "有効期限".$ex_date."までに会費無料条件クリアをお忘れなく。"."

";
      $message .= "----------------------------------------------". "
";
      $message .= "▼登録内容". "
";
      $message .= "----------------------------------------------". "
";
      $message .= "・カード種類：".$cardtype."". "
";
      $message .= "・有効期限：".$ex_date."". "
";
      $message .= "・メールアドレス：".$mail."". "
";
      $message .= "----------------------------------------------". "
";
      $message .= "※毎月".$exm_day."日にお知らせメール（".$mail."宛）を配信します。". "
";
      $message .= "※下記URLでアクセスして無料条件クリアボタンを押すと本年度(".$ex_date."まで)のメール配信は停止します。". "
";
      $message .= "※".$ex_date."以降は次年度分(".$next_ex_date."期限)メール配信再開します。". "

";
      $message .= "----------------------------------------------". "
";
      $message .= "▼無料条件クリアURL". "
";
      $message .= "----------------------------------------------". "
";
      $message .= $exm_url."". "
";
      $message .= "※無料条件をクリアした時には上記URLをクリックしてください。". "






";

      // 
      $message .= "----------------------------------------------". "
";
      $message .= "▼登録情報の削除URL". "
";
      $message .= "----------------------------------------------". "
";
      $message .= $del_url."". "

";
      $message .= "FaceApGleZon". "
";


      //メール配信
      $rtn = f_send_mail($mail, $subjectML, $message,$from_add,$from_name);
	}
}
//
// 期限が1日過ぎた場合の期間延長＆flgリセット処理
//期間1年延長

$sqlup = "SELECT `token`,`to` FROM `user` WHERE `flg`= 'undone' and `status` = 'ON' and  `to` < '$today'";
$resultup = mysql_query($sqlup, $db_conn);
if($resultup)
{
	while($link = mysql_fetch_row($resultup))
	{
		list($token,$to) = $link;
		$next_ex_date = date('Y/m/d', strtotime(date($to) . '+1 year'));
		// echo $next_ex_date;
		f_upflg($db_conn,$token,$next_ex_date);
	}
}

//////
function f_upflg($db_conn,$token,$to)
{
	$up_sql = "UPDATE `user` SET `flg` = 'undone',`to` = '$to' WHERE `token` = '$token' and `status` = 'ON' limit 1";
	$result = mysql_query($up_sql, $db_conn);
}

echo "<br>OK";
?>


      


