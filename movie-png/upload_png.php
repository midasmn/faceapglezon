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
      //処理時間をはずす
      // set_time_limit(0);
      $rtn = f_make_png($WIDTH,$exm_dir,'uploads/'.$exm_dir.'/'.$exm_dir.'.'.$extension);
      flush();
      // //DBに記録
      if($rtn=="OK")
      {
        $expiredate = date("Y-m-d", strtotime("2 day" ));  // 明日
        $rtn_time = f_get_mv_time('uploads/'.$exm_dir.'/'.$exm_dir.'.'.$extension);
        // $rtn_time = "12:00";
        $rtn = f_insert_upfile($db_conn,$filename,$exm_dir,$size,$rtn_time,'png',$user_agent,$expiredate);
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
$HTML_BASE = "http://faceapglezon.info/movie-png/tmp/";
$TMP_PATH ="/usr/share/nginx/html/faceapglezon.info/movie-png/tmp/"; 
$TMP_HTML_BASE = "http://faceapglezon.info/movie-png/tmp/";
$HTML_BASE .= $exm_dir."/".$exm_dir;
$TMP_PATH .= $exm_dir."/";
$TMP_HTML_BASE .= $exm_dir."/";
//
// $rtn_png_st = '<a href=""></a>';
//抜き出しPNG
$rtn_png_st = "";
$image_files = get_files($TMP_PATH);
$cnt = count($image_files);
if($cnt>0) 
{
  for ($i=1; $i <= $cnt; $i++) 
  { 
  //   //ファイル名
    $png_name = sprintf("%04d", $i);
    $rtn_png_st .=  '<a href="imgDL.php?exm_dir='.$exm_dir.'&no='.$i.'">';
    $rtn_png_st .=  '<img src="'.$TMP_HTML_BASE.$png_name.'.png" />';
    $rtn_png_st .=  '</a>';
  }
}
list($width, $height) = getimagesize($TMP_HTML_BASE.'0002.png');
$sound_height = $height - 35;

if (preg_match('/^text\/html/', $_SERVER['HTTP_ACCEPT'])) : ?>
<!-- HTMLのとき -->
<!-- <div  class="col-md-6" style="margin-top:30px;" >
  <img src="<?=$HTML_BASE?>.gif" width="<?php echo $width;?>" height="<?php echo $height; ?>" >
  <a href="gifDL.php?exm_dir=<?php echo $exm_dir; ?>" class="btn btn-success btn-block btn-lg">
    <span class="glyphicon glyphicon-save"></span> GIFアニメファイルをDLする
  </a>
</div> -->
<!--  -->
<!--  -->
<div class="col-md-12"  style="margin-top:50px;" >
  <p>↓画像をクリックするとPNGファイルをダウンロードできます。</p>
  <?php echo $rtn_png_st; ?>
  <p>↑画像をクリックするとPNGファイルをダウンロードできます。</p>
</div>
<!--  -->
<div class="row" style="margin-top:20px;" >
  <div class="col-md-12" >
    <a href="zipdl.php?exm_dir=<?php echo $exm_dir; ?>" class="btn btn-success btn-block btn-lg">
      <span class="glyphicon glyphicon-save"></span> ファイルをすべてダウンロードする
    </a>
  </div>  
</div>

<div class="row" style="margin-top:30px;" >
  <div class="col-md-12" >
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
