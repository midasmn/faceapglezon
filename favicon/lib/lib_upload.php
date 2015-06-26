<?php
// モバイル判定
function is_mobile(){
    $useragents = array(
        'iPhone', // iPhone
        'iPod', // iPod touch
        'Android.*Mobile', // 1.5+ Android *** Only mobile
        'Windows.*Phone', // *** Windows Phone
        'dream', // Pre 1.5 Android
        'CUPCAKE', // 1.5+ Android
        'blackberry9500', // Storm
        'blackberry9530', // Storm
        'blackberry9520', // Storm v2
        'blackberry9550', // Storm v2
        'blackberry9800', // Torch
        'webOS', // Palm Pre Experimental
        'incognito', // Other iPhone browser
        'webmate' // Other iPhone browser

    );
    $pattern = '/'.implode('|', $useragents).'/i';
    return preg_match($pattern, $_SERVER['HTTP_USER_AGENT']);
}
//アップロードファイルサイズの上限を取得する
function getMaxUploadSize(){
    /*アップロードファイルサイズの上限は以下の3項目のうちの最小値。
    通常は memory_limit > post_max_size > upload_max_filesize
    */
    $limit_max = (ini_get_bytes('post_max_size') < ini_get_bytes('upload_max_filesize') )?
                'post_max_size' : 'upload_max_filesize';
    $limit_max = (ini_get_bytes($limit_max) < ini_get_bytes('memory_limit'))?
                $limit_max : 'memory_limit';
    return ini_get($limit_max);
}
//設定オプションを整数表現に変換して返す。
function ini_get_bytes($varname) {
    $val = ini_get($varname);
    $val = trim($val);
    $last = strtolower($val[strlen($val)-1]);
    switch($last) {
        // 'G' は PHP 5.1.0 以降で使用可能です
        case 'g':
            $val *= 1024;
        case 'm':
            $val *= 1024;
        case 'k':
            $val *= 1024;
    }

    return $val;
}

//短編取得
function f_check_size($filepath)
{
  $image_data = imagecreatefromstring(file_get_contents($filepath));
  $width  = imagesx($image_data);
  $height = imagesy($image_data);
  if($width==$height)
  {
    return "square";
  }elseif($width>$height)
  {
    return "rectangle";
  }
  elseif($width<$height)
  {
    return "Vrectangle";
  }
}

//通常アイコン
function f_resize_icon($filepath,$OUT_PATH,$DPI,$SIZE,$OUT_FILENAME)
{
  $OUT_FILE = $OUT_PATH.'/'.$OUT_FILENAME;
  $CH_SIZE = f_check_size($filepath);
  if($CH_SIZE=="square")
  {
    system("/usr/bin/convert -resize  ${SIZE}x${SIZE} -density 72x72 -units PixelsPerInch ${filepath} ${OUT_FILE}");
    system("/usr/bin/convert -gravity center -crop ${SIZE}x${SIZE}+0+0 ${OUT_FILE} ${OUT_FILE}");
  }elseif($CH_SIZE=="rectangle")
  {
    system("/usr/bin/convert -resize  x${SIZE} -density 72x72 -units PixelsPerInch ${filepath} ${OUT_FILE}");
    system("/usr/bin/convert -gravity center -crop ${SIZE}x${SIZE}+0+0 ${OUT_FILE} ${OUT_FILE}");
  }elseif($CH_SIZE=="Vrectangle")
  {
    system("/usr/bin/convert -resize  ${SIZE}x -density 72x72 -units PixelsPerInch ${filepath} ${OUT_FILE}");
    system("/usr/bin/convert -gravity center -crop ${SIZE}x${SIZE}+0+0 ${OUT_FILE} ${OUT_FILE}");
  }
}
//マルチfavicon
function f_resize_icon_icon($filepath,$OUT_PATH,$OUT_FILENAME)
{
  $IN_FILE = $OUT_PATH.'/'.'apple-touch-icon-57x57.png';
  system("/usr/bin/convert -resize  48x48 -density 72x72 -units PixelsPerInch ${IN_FILE} ${OUT_PATH}/48.png");
  system("/usr/bin/convert ${OUT_PATH}/48.png -define icon:auto-resize ${OUT_PATH}/48.ico");
  system("/usr/bin/convert ${OUT_PATH}/favicon-32x32.png -define icon:auto-resize ${OUT_PATH}/32.ico");
  system("/usr/bin/convert ${OUT_PATH}/favicon-16x16.png -define icon:auto-resize ${OUT_PATH}/16.ico");

  $OUT_FILE = $OUT_PATH.'/'.$OUT_FILENAME;
  system("/usr/bin/convert ${OUT_PATH}/48.ico ${OUT_PATH}/32.ico ${OUT_PATH}/16.ico -define icon:auto-resize ${OUT_FILE}");
  //
  unlink($OUT_PATH."/48.png");
  unlink($OUT_PATH."/48.ico");
  unlink($OUT_PATH."/32.ico");
  unlink($OUT_PATH."/16.ico");
}
// 角丸
function f_resize_icon_mask($filepath,$OUT_PATH,$DPI,$SIZE,$OUT_FILENAME)
{
  $OUT_FILE = $OUT_PATH.'/'.$OUT_FILENAME;
  $MASK_FILE = "/usr/share/nginx/html/faceapglezon.info/favicon/img/180-mask-white-r85.png";

  $CH_SIZE = f_check_size($filepath);
  if($CH_SIZE=="square")
  {
    system("/usr/bin/convert -resize  ${SIZE}x${SIZE} -density 72x72 -units PixelsPerInch ${filepath} ${OUT_FILE}");
    system("/usr/bin/convert ${OUT_FILE} -matte ${MASK_FILE} -compose copy-opacity -composite -unsharp 0x1 -resize ${SIZE}x${SIZE}  ${OUT_FILE}");
  }elseif($CH_SIZE=="rectangle")
  {
    system("/usr/bin/convert -resize  x${SIZE} -density 72x72 -units PixelsPerInch ${filepath} ${OUT_FILE}");
  system("/usr/bin/convert ${OUT_FILE} -matte ${MASK_FILE} -compose copy-opacity -composite -unsharp 0x1 -resize ${SIZE}x${SIZE}  ${OUT_FILE}");
  }elseif($CH_SIZE=="Vrectangle")
  {
    system("/usr/bin/convert -resize  ${SIZE}x -density 72x72 -units PixelsPerInch ${filepath} ${OUT_FILE}");
    system("/usr/bin/convert ${OUT_FILE} -matte ${MASK_FILE} -compose copy-opacity -composite -unsharp 0x1 -resize ${SIZE}x${SIZE}  ${OUT_FILE}");
  }
}

/////////////////////
// convertメイン
//////////////////////
function f_make_icon($WIDTH,$exm_dir,$filepath)
{
	//処理フォルダ
	$TMP="/usr/share/nginx/html/faceapglezon.info/favicon/tmp";
	mkdir($TMP.'/'.$exm_dir, 0777);
	$OUT_PATH=$TMP.'/'.$exm_dir;
  //
/////////////
$exm_body =<<<EOF
<link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon-180x180.png">
<link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
<link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96">
<link rel="icon" type="image/png" href="/favicon-160x160.png" sizes="160x160">
<link rel="icon" type="image/png" href="/favicon-192x192.png" sizes="192x192">
<meta name="msapplication-TileColor" content="#eaeff5">
<meta name="msapplication-TileImage" content="/mstile-144x144.png">
EOF;

$fp = fopen($OUT_PATH.'/'.'icon.txt', 'a');
if ($fp){
    if (flock($fp, LOCK_EX)){
        if (fwrite($fp,  $exm_body) === FALSE){
            print('ファイル書き込みに失敗しました');
        }else{
            // print($data.'をファイルに書き込みました');
        }

        flock($fp, LOCK_UN);
    }else{
        print('ファイルロックに失敗しました');
    }
}
fclose($fp);
/////////////
$exm_body2 =<<<EOF
<?xml version="1.0" encoding="utf-8"?>
<browserconfig>
  <msapplication>
    <tile>
      <square70x70logo src="/mstile-70x70.png"/>
      <square150x150logo src="/mstile-150x150.png"/>
      <square310x310logo src="/mstile-310x310.png"/>
      <TileColor>#da532c</TileColor>
    </tile>
  </msapplication>
</browserconfig>
EOF;

$fp = fopen($OUT_PATH.'/'.'browserconfig.xml', 'a');
if ($fp){
    if (flock($fp, LOCK_EX)){
        if (fwrite($fp,  $exm_body2) === FALSE){
            print('ファイル書き込みに失敗しました');
        }else{
            // print($data.'をファイルに書き込みました');
        }

        flock($fp, LOCK_UN);
    }else{
        print('ファイルロックに失敗しました');
    }
}
fclose($fp);

  //処理時間をはずす
  set_time_limit(0);
  f_resize_icon($filepath,$OUT_PATH,'72x72','57','apple-touch-icon-57x57.png');
  f_resize_icon($filepath,$OUT_PATH,'72x72','60','apple-touch-icon-60x60.png');
  f_resize_icon($filepath,$OUT_PATH,'72x72','72','apple-touch-icon-72x72.png');
  f_resize_icon($filepath,$OUT_PATH,'72x72','76','apple-touch-icon-76x76.png');
  f_resize_icon($filepath,$OUT_PATH,'72x72','114','apple-touch-icon-114x114.png');
  f_resize_icon($filepath,$OUT_PATH,'72x72','120','apple-touch-icon-120x120.png');
  f_resize_icon($filepath,$OUT_PATH,'72x72','144','apple-touch-icon-144x144.png');
  f_resize_icon($filepath,$OUT_PATH,'72x72','152','apple-touch-icon-152x152.png');
  f_resize_icon($filepath,$OUT_PATH,'72x72','180','apple-touch-icon-180x180.png');

  f_resize_icon_mask($filepath,$OUT_PATH,'72x72','180','apple-touch-icon-precomposed.png');

  f_resize_icon($filepath,$OUT_PATH,'72x72','180','apple-touch-icon.png');
  //
  f_resize_icon($filepath,$OUT_PATH,'72x72','16','favicon-16x16.png');
  f_resize_icon($filepath,$OUT_PATH,'72x72','32','favicon-32x32.png');
  f_resize_icon($filepath,$OUT_PATH,'72x72','96','favicon-96x96.png');
  f_resize_icon($filepath,$OUT_PATH,'72x72','160','favicon-160x160.png');
  f_resize_icon($filepath,$OUT_PATH,'72x72','192','favicon-192x192.png');
  //
  f_resize_icon($filepath,$OUT_PATH,'72x72','70','mstile-70x70.png');
  f_resize_icon($filepath,$OUT_PATH,'72x72','144','mstile-144x144.png');
  f_resize_icon($filepath,$OUT_PATH,'72x72','150','mstile-150x150.png');
  f_resize_icon($filepath,$OUT_PATH,'72x72','310','mstile-310x310.png');
  //
  // f_resize_icon_WH($filepath,$OUT_PATH,'72x72','310','150','mstile-310x150.png');
  //favicon
  f_resize_icon_icon($filepath,$OUT_PATH,'favicon.ico');
  //
}

//ファイル削除DBフラグ更新
function f_update_flg($db_conn,$exmname)
{
	$sql = "UPDATE `icon` SET `FLG` = 'DEL' WHERE `exmname` = '$exmname'";
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
//ディレクトリ削除
function remove_directory($exm_dir)
{
  $TMP_PATH ="/usr/share/nginx/html/faceapglezon.info/favicon/tmp/";
  $dir = $TMP_PATH.$exm_dir;
  if ($handle = opendir("$dir")) {
   while (false !== ($item = readdir($handle))) {
     if ($item != "." && $item != "..") {
       if (is_dir("$dir/$item")) {
         remove_directory("$dir/$item");
       } else {
         unlink("$dir/$item");
         // echo " removing $dir/$item<br>\n";
       }
     }
   }
   closedir($handle);
   rmdir($dir);
   // echo "removing $dir<br>\n";
  }
}

//
function get_file_extension($file_name) {
  return substr(strrchr($file_name,'.'),1);
}
function get_files($images_dir,$exts = array('png','ico'))
{
  $files = array();
  $rt =  is_dir($images_dir);
  if($handle = @opendir($images_dir))
  {
    while(false !== ($file = readdir($handle)))
    {
      $extension = strtolower(get_file_extension($file));
      if($extension && in_array($extension,$exts))
      {
        $files[] = $file;
      }
    }
    closedir($handle);
  }
  return $files;
}
function get_files_zip($images_dir,$exts = array('png','txt','xml','ico'))
{
  $files = array();
  $rt =  is_dir($images_dir);
  if($handle = @opendir($images_dir))
  {
    while(false !== ($file = readdir($handle)))
    {
      $extension = strtolower(get_file_extension($file));
      if($extension && in_array($extension,$exts))
      {
        $files[] = $file;
      }
    }
    closedir($handle);
  }
  return $files;
}
//////////////////////
###################################################################################
#汎用名前取得エンコード関数 //////////////////////////////////////////
###################################################################################
function f_get_comon_item($db_conn, $tableName,$Namefiled,$Idfiled,$id)
{
  // $rtn = mysql_query("SET NAMES sjis" , $db_conn);
  $aryname = array();
  $strSQL = "SELECT $Idfiled,$Namefiled FROM $tableName"
            . "  WHERE $Idfiled ='". $id . "'";
  $tbl_tmp = mysql_query($strSQL, $db_conn);
  if($tbl_tmp)
   {
          while($rec_tmp = mysql_fetch_row($tbl_tmp))
          {
      $aryname[$rec_tmp[0]] = $rec_tmp[1];
          }
    }

  foreach ($aryname as $key => $value)
  {
    $name = $value;
  }
     return $name;
}
//////////サイズ実績
function f_get_max_size($db_conn,$exm)
{
  // $rtn = mysql_query("SET NAMES sjis" , $db_conn);
  $aryname = array();
  $strSQL = "SELECT `id`,max(`size`) FROM `mpegmagick` WHERE `exm` = '$exm' limit 1";
  $tbl_tmp = mysql_query($strSQL, $db_conn);
  if($tbl_tmp)
   {
          while($rec_tmp = mysql_fetch_row($tbl_tmp))
          {
      $aryname[$rec_tmp[0]] = $rec_tmp[1];
          }
    }

  foreach ($aryname as $key => $value)
  {
    $name = $value;
  }
     return $name;
}
/// 時間実績実績
function f_get_max_time($db_conn,$exm)
{
  // $rtn = mysql_query("SET NAMES sjis" , $db_conn);
  $aryname = array();
  $strSQL = "SELECT `id`,max(`time`) FROM `mpegmagick` WHERE `exm` = '$exm' limit 1";
  $tbl_tmp = mysql_query($strSQL, $db_conn);
  if($tbl_tmp)
   {
          while($rec_tmp = mysql_fetch_row($tbl_tmp))
          {
      $aryname[$rec_tmp[0]] = $rec_tmp[1];
          }
    }

  foreach ($aryname as $key => $value)
  {
    $name = $value;
  }
     return $name;
}
