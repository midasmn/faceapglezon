<?php
require_once("lib/mysql-ini.php");
// require_once("lib/lib_upload.php");
// require_once("lib/mail.php");
// データベースに接続
if(!$db_conn = mysql_connect($host, $user, $pass))
{
  print("データベースにアクセスできません。");
  exit;
}
mysql_select_db($dbname);

////////////////////////////////////////////////////////////////////////////////
$textUpload = "og:imageタグ作成:";
$entry_st = "";
/////// アップロード
$cardtype=$_POST['cardtype'];
$url= $_POST['url'];

$base_url = "http://faceapglezon.info/ogimage/og_image.php?url=";

if($url)
{
  if($cardtype>100)
  {
    $get_url = $base_url.$url."&w=".$cardtype."&h=".$cardtype."&exm=crop";
    //リサイズ
    // system("/usr/bin/convert -resize  ${cardtype}x -density 72x72 -units PixelsPerInch ${get_url} ${OUT_FILE}");
    // system("/usr/bin/convert -gravity center -crop ${SIZE}x${SIZE}+0+0 ${OUT_FILE} ${OUT_FILE}")
    $ogtag = '<meta property=&quot;og:image&quot; content=&quot;'.$base_url.$url.'&amp;w='.$cardtype.'&amp;h='.$cardtype.'&amp;exm=crop&quot;/>';
  }else{
    $get_url = $base_url.$url;
    $ogtag = '<meta property=&quot;og:image&quot; content=&quot;'.$get_url.'&quot;/>';
  }
  $entry_st .= '<div class="row" style="margin-top:20px;" >';
  $entry_st .= '<div class="col-md-12" >';
  $ogtag = '<meta property=&quot;og:image&quot; content=&quot;'.$get_url.'&quot;/>';
  $entry_st .= '<input type="text" class="col-md-12" value="'.$ogtag.'">';
  $entry_st .= '<img src="'.$get_url.'" class="img-responsive img-thumbnail" alt="処理結果イメージ">';
  $entry_st .= '</div>';
  $entry_st .= '</div>';
}else{
  $entry_st = "URL未入力";
}

if (preg_match('/^text\/html/', $_SERVER['HTTP_ACCEPT'])) : ?>
<!-- HTMLのとき -->
<div  class="col-md-12" style="margin-top:30px;" >
  <h3><?php echo $textUpload; ?></h3>
</div>
<?php echo $entry_st; ?>

<!-- jsonのとき -->
<?php else: 
  header( 'Content-Type: application/json; charset=utf-8', true ); 
  echo json_encode( array("message" => "Upload is OK")  );
  endif; 
?>
