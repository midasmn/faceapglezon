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

$token = $_GET['token'];

$sql = "SELECT COUNT(`token`) as cnt,`card`,`to`,`mail` FROM `user` WHERE `token` = '$token' and `status` = 'ON' limit 1";
$result = mysql_query($sql, $db_conn);
// echo $sql;
if($result)
{
	while($link = mysql_fetch_row($result))
	{
		list($cnt,$cardtype,$to,$mail) = $link;
	}
}
//
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
</head>
<body>
<?php
if($cnt<1)
{
	echo "削除対象の登録はありませんでした。";
}else{
	//削除フラグ
	$del_sql = "UPDATE `user` SET `status` = 'DELL' WHERE `token` = '$token' and `status` = 'ON' limit 1";
	$result = mysql_query($del_sql, $db_conn);
	// $rtn_st = "OK";
	echo "下記登録を削除しました。ありがとうございました。<br><br>";
	echo "----------------------------------------------<br>";
	echo  "▼削除内容<br>";
	echo "----------------------------------------------<br>";
	echo "カード種類：".$cardtype."<br>";
	echo "有効期限：".$to."<br>";
	echo "メールアドレス：".$mail."<br>";
}
?>
<br><hr>
＜スポンサーリンク＞
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
 	    <!-- レスポンシブ -->
  <ins class="adsbygoogle"
   style="display:block"
   data-ad-client="ca-pub-6625574146245875"
   data-ad-slot="6145590005"
   data-ad-format="auto">
  </ins>
<script>
   (adsbygoogle = window.adsbygoogle || []).push({});
</script>
<br><hr>
<a href="http://faceapglezon.info/card/index.php" >実質無料クレジットカードメール通知リマインダー登録ページへ</a>
<br><hr>
</body>
</html>

      


