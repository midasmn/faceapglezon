<?php
require_once("lib/mysql-ini.php");
require_once("lib/libR.php");

///////////////////////////////////////////
// データベースに接続
if(!$db_conn = mysql_connect($host, $user, $pass)){
print("データベースにアクセスできません。");
exit;
}
$rtn = mysql_query("SET NAMES sjis" , $db_conn);
mysql_select_db($dbname);

// http://faceapglezon.info/ctrl.php?&mode=dell&arid=".$id."&umid=".str_replace('@','loto7',$mail);
// http://faceapglezon.info/loto7/ctrl.php?&mode=dell&arid=1&umid=midasmnloto7gmail.com
$id = $_GET['arid'];
$mail = $_GET['umid'];
$mail = str_replace('loto7','@',$mail);
// echo "id=".$id;
// echo "<br>mail=".$mail;
// exit;

//重複アドレス削除
$del_sql = "DELETE FROM `loto7_user` WHERE `mail` = '$mail' and `id` = '$id' LIMIT 1";
$query = mysql_query($del_sql, $db_conn);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
</head>
<body>
<?php
if(!$query)
{
	// $rtn_st = "NG";
	echo "登録はありませんでした。";
}else{
	// $rtn_st = "OK";
	echo $mail."削除しました。<br>ありがとうございました。";
}
?>
</body>
</html>


