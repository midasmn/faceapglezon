<?php
require_once("lib/mysql-ini.php");
require_once("lib/lib_upload.php");
// データベースに接続
if(!$db_conn = mysql_connect($host, $user, $pass))
{
  print("データベースにアクセスできません。");
  exit;
}
mysql_select_db($dbname);

//mpegmagick　インサート
function f_insert_upfile($db_conn,$filename,$exm_dir,$size,$user_agent,$expiredate)
{
  $sql = "INSERT INTO `icon`( `filename`, `exmname`,`size`,`user_agent`, `expiredate`)VALUES('$filename', '$exm_dir', '$size','$user_agent','$expiredate')";
  $result = mysql_query($sql, $db_conn);
  if(!$result)
  {
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
$allowed = array('jpg','jpeg','png','PNG');
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
      $rtn = f_make_icon($WIDTH,$exm_dir,'uploads/'.$exm_dir.'/'.$exm_dir.'.'.$extension);
      flush();
      // //DBに記録
      $expiredate = date("Y-m-d", strtotime("2 day" ));  // 明日
      $rtn = f_insert_upfile($db_conn,$filename,$exm_dir,$size,$user_agent,$expiredate);
      flush();
      //
      $textUpload = "File is uploaded";

    }else{
      $textUplaod = "Upload fail";
    }
  }
}

// HTMLの時用
$ICON_PATH = "/usr/share/nginx/html/faceapglezon.info/tools/icon/tmp/".$exm_dir."/";
$HTML_ICON_PATH = "/tools/icon/tmp/".$exm_dir."/";
//抜き出しPNG
$rtn_png_st = "";
$image_files = get_files($ICON_PATH);
$cnt = count($image_files);
sort($image_files) ;
if($cnt>0) 
{
  $rtn_png_st .=  '<div  class="col-md-12" >';
  $rtn_png_st .=  '<table class="table table-striped table-bordered">';
  $rtn_png_st .=  '<thead>';
  $rtn_png_st .=  '<tr class="success">';
  $rtn_png_st .=  '<th class="text-center">画像</th>';
  $rtn_png_st .=  '<th class="text-center">ファイル名</th>';
  $rtn_png_st .=  '</tr>';
  $rtn_png_st .=  '</thead>';
  $rtn_png_st .=  '<tbody>';

  foreach ($image_files as $key => $value)
  {
    $rtn_png_st .=  '<tr class="text-center">';
    $rtn_png_st .=  '<td>';
    // $rtn_png_st .=  '<img class="img-thumbnail" src="'.$HTML_ICON_PATH.$value.'" />';
    $rtn_png_st .=  '<img  src="'.$HTML_ICON_PATH.$value.'" />';
    $rtn_png_st .=  '</td>';
    $rtn_png_st .=  '<td style="vertical-align:middle;">';
    $rtn_png_st .=  '<h4>'.$value.'</h4>';
    $rtn_png_st .=  '</td>';
    $rtn_png_st .=  '</tr>';
  }

  $rtn_png_st .=  '</tbody>';
  $rtn_png_st .=  '</table>';
  $rtn_png_st .=  '</div>';
}

//htmlテキストを読み込む
$rtn_html = "";
$html_PATH ="http://faceapglezon.info/tools/icon/tmp/".$exm_dir."/icon.txt";
$lines = file($html_PATH);
foreach ($lines as $line_num => $line) 
{
  // $rtn_html .= htmlspecialchars($line);
  $rtn_html .= $line;
}


if (preg_match('/^text\/html/', $_SERVER['HTTP_ACCEPT'])) : ?>
<!-- HTMLのとき -->
<div  class="col-md-12" style="margin-top:30px;" >
  <h3>アイコン一覧：</h3>
</div>

<?php echo $rtn_png_st; ?>

<div class="row" style="margin-top:20px;" >
  <div class="col-md-12" >
    <h3>アイコン用HTMLテキスト：</h3>
      <textarea name="introduction" id="introduction" cols="45" rows="8" placeholder="" class="form-control"><?php echo $rtn_html; ?></textarea>
      <!-- 注意書きは以下 -->
      <p class="help-block">※ダウンロードZIPファイルには上記アイコン用のHTMLコードを記載したテキストファイル「icon.txt」およびWindows8で機能するIE11用「browserconfig.xml」が含まれます。</p>
      <p class="help-block">favicon.icoファイルはマルチ(16/32/48)アイコンです。</p>
  </div>  
</div>

<div class="row" style="margin-top:20px;" >
  <div class="col-md-12" >
    <a href="zipdl.php?exm_dir=<?php echo $exm_dir; ?>" class="btn btn-success btn-block btn-lg">
      <span class="glyphicon glyphicon-save"></span> アイコンをすべてダウンロードする
    </a>
  </div>  
</div>


<div class="row" style="margin-top:30px;" >
  <div class="col-md-12" >
    <a href="del.php?exm_dir=<?php echo $exm_dir; ?>" class="btn btn-danger btn-block btn-lg">
      <span class="glyphicon glyphicon-trash"></span> 画像ファイルをすべて削除する
    </a>
    <p class="help-block">上記削除ボタンを押さなくても、24時間後の午前3時に自動的に削除します。</p>
  </div>  
</div>
<!-- jsonのとき -->
<?php else: 
  header( 'Content-Type: application/json; charset=utf-8', true ); 
  echo json_encode( array("message" => "Upload is OK")  );
  endif; 
?>
