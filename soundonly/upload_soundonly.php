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

//mpegmagick　インサート
function f_insert_upfile($db_conn,$filename,$exm_dir,$size,$time,$exm,$user_agent,$expiredate)
{
  // $sql = "INSERT INTO `mpegmagick`(`id`, `filename`, `exmname`, `flg`, `createdate`, `expiredate`)VALUES (NULL, '$filename', '$exm_dir', 'ON', now(),'$expiredate')";
  // $sql = "INSERT INTO `mpegmagick`( `filename`, `exmname`, `expiredate`)VALUES('$filename', '$exm_dir', '$expiredate')";
  $sql = "INSERT INTO `mpegmagick`( `filename`, `exmname`,`size`,`time`,`exm`,`user_agent`, `expiredate`)VALUES('$filename', '$exm_dir', '$size','$time','$exm','$user_agent','$expiredate')";
  $result = mysql_query($sql, $db_conn);
// var_dump($result);
  if(!$result)
  {
    // die('Invalid query: ' . mysql_error());
    $rtn =  "NG";
  }else{
    $rtn = "OK";
  }
  return $rtn;
}

////////////////////////////////////////////////////////////////////////////////
$textUpload = "";
/////// アップロード
// A list of permitted file extensions
$allowed = array('flv','mov','mp4','ogv','ogg','3gp','m4v','m4a','FLV','MOV','MP4','OGV','OGG','3GP','M4V','M4A','mpg','MPG','mpeg','3g2');
if(isset($_FILES['userfile']) && $_FILES['userfile']['error'] == 0)
{
  $extension = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
  if(!in_array(strtolower($extension), $allowed))
  { 
    $textUpload = "拡張子が違います。";
  }else
  {
    //拡張子OK
    $filename = urlencode($_FILES['userfile']['name']);
    //filesize
    $size = filesize($_FILES['userfile']['tmp_name']);
    $size = $size / 1024 / 1024; //K-MBに
    $size = round($size, 1); //小数点1位四捨五入
    //
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $exm_dir = time();
    $textUpload = $exm_dir;
    mkdir( 'uploads/'.$exm_dir );
    $WIDTH=336;
    if(move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/'.$exm_dir.'/'.$exm_dir.'.'.$extension))
    {
      flush();
      $rtn = f_sound_only($WIDTH,$exm_dir,'uploads/'.$exm_dir.'/'.$exm_dir.'.'.$extension);
      flush();
      // //DBに記録
      if($rtn=="OK"){
        $expiredate = date("Y-m-d", strtotime("2 day" ));  // 明日
        $rtn_time = f_get_mv_time('uploads/'.$exm_dir.'/'.$exm_dir.'.'.$extension);
        $rtn = f_insert_upfile($db_conn,$filename,$exm_dir,$size,$rtn_time,'sound',$user_agent,$expiredate);
      }
      flush();
      //
      $textUpload = "File is uploaded";

    }else{
      $textUplaod = "Upload fail";
    }
  }
}
// HTMLの時用
$HTML_BASE = "http://faceapglezon.info/soundonly/tmp/";
$TMP_PATH ="/usr/share/nginx/html/faceapglezon.info/soundonly/tmp/"; 
$TMP_HTML_BASE = "http://faceapglezon.info/soundonly/tmp/";
$HTML_BASE .= $exm_dir."/".$exm_dir;
$TMP_PATH .= $exm_dir."/";
$TMP_HTML_BASE .= $exm_dir."/";
//
// $rtn_png_st = '<a href=""></a>';
//抜き出しPNG
$rtn_png_st = "";

$sound_height = 155;

if (preg_match('/^text\/html/', $_SERVER['HTTP_ACCEPT'])) : ?>
<!-- HTMLのとき -->
<!--  -->
<style>
        .img-desc {
        position: relative;
        display: block;
        height:155px;
        width: 336px;
        }
        .img-desc cite {
        background: #111;
        -moz-opacity:.55;
        filter:alpha(opacity=55);
        opacity:.55;
        color: #fff;
        position: absolute;
        bottom: 0;
        left: 0;
        width: 336px;
        height: 155px;
        /*padding: 50px;*/
        /*margin: 0 auto; */
        font-size: large;
        text-align: center;  
        vertical-align: auto; 
        border-top: 1px solid #999;
        }
</style>
<!-- <div  class="col-md-6" style="margin-top:30px;" > -->
<div class="row" >
  <div  class="col-md-6" style="margin-top:30px;" >
    <div class="img-desc">
      <img src="http://faceapglezon.info/soundonly/img/soundonly.png" width="336" height="155">
      <cite>SOUND ONLY</cite>
    </div>
    <audio controls style="width:336px">
      <source src="<?=$HTML_BASE?>.mp3">
    </audio>
    <a href="mp3DL.php?exm_dir=<?php echo $exm_dir; ?>" class="btn btn-warning btn-block btn-lg">
      <span class="glyphicon glyphicon-save"></span> MP3ファイルをDLする
    </a>
  </div>
</div>
<!--  -->

<div class="row">
  <div class="col-md-12"  style="margin-top:30px;" >
    <a href="del.php?exm_dir=<?php echo $exm_dir; ?>" class="btn btn-danger btn-block btn-lg">
      <span class="glyphicon glyphicon-trash"></span> ファイルをすべて削除する
    </a>
  </div>  
</div>


<!-- jsonのとき -->
<?php else: 
  header( 'Content-Type: application/json; charset=utf-8', true ); 
  echo json_encode( array("message" => "Upload is OK")  );
  endif; 
?>
