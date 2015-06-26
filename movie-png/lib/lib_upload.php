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
//// 幅取得
function f_get_width($filepath)
{
	$command = '/usr/bin/ffmpeg -i "'.$filepath.'"';
	exec("{$command}  2>&1", $output);
// print_r($output);
 	// ffmpegの出力結果を取得
	for ($h = 0; $h < count($output); $h++) 
	{
		//$outに出力された値は配列に格納されるので、forで配列を一つづつ確認する。
     	if(preg_match('/([0-9]{3,4})x([0-9]{2,4})/', $output[$h]))
     	{
     		//preg_match関数で176x144のような結果が$out[$h]にあるかどうかを確認。
     		//正規表現を使っているので'//'で囲む。
     		//([0-9]{3,4})の{}の数字は文字数3または4を示す。
        	if(!preg_match('/([0-9]{5,})x([0-9]{5,})/', $output[$h]))
        	{
        		//{5,}は今のところ解像度で5桁はないだろうから!で5桁以上を除外。
           		preg_match('/([0-9]{3,4})x([0-9]{2,4})/', $output[$h],$PregMatch,PREG_OFFSET_CAPTURE);
           		//3番目の要素($PregMatch)に検索結果が入る。
           		//4番目の要素は{}で指定した文字数を分割して出力する場合に記載する。
        	}
     	}
	}
	$Width = $PregMatch[1][0];
	$Height = $PregMatch[2][0];
	return $Width;
}
////時間取得
function f_get_mv_time($filepath)
{
//	$command = "/usr/local/bin/ffmpeg -i \"$filepath\"";
	$command = '/usr/bin/ffmpeg -i "'.$filepath.'"';
	exec("{$command}  2>&1", $output);
 	// ffmpegの出力結果を取得
	foreach($output as $line)
	{
    	// 正規表現で時間を表示している文字列を取得
    	preg_match("/Duration: [0-9]{2}:[0-9]{2}:[0-9]{2}/s",  $line, $matches);
    	// 時間を取得している場合は解析
    	if(count($matches) > 0)
    	{
        	$tmp1 = str_replace(" ", "", $matches[0]);
        	$tmp2 = split(":", $tmp1);
        	// 動画の時間を計算
        	$time = intval($tmp2[1]) * 3600 + intval($tmp2[2]) * 60 + intval($tmp2[3]);
        	//echo "{$time} seconds.\n";
        	//break;
        	$time = gmdate('H:i:s',$time);
        	return $time;
    	}
	}
}
////アスペクト比取得
function f_get_aspect_ratio($filepath)
{
	$command = '/usr/bin/ffmpeg -i "'.$filepath.'"';
	exec("{$command}  2>&1", $output);
// print_r($output);
 	// ffmpegの出力結果を取得
	for ($h = 0; $h < count($output); $h++) 
	{
		//$outに出力された値は配列に格納されるので、forで配列を一つづつ確認する。
     	if(preg_match('/([0-9]{3,4})x([0-9]{2,4})/', $output[$h]))
     	{
     		//preg_match関数で176x144のような結果が$out[$h]にあるかどうかを確認。
     		//正規表現を使っているので'//'で囲む。
     		//([0-9]{3,4})の{}の数字は文字数3または4を示す。
        	if(!preg_match('/([0-9]{5,})x([0-9]{5,})/', $output[$h]))
        	{
        		//{5,}は今のところ解像度で5桁はないだろうから!で5桁以上を除外。
           		preg_match('/([0-9]{3,4})x([0-9]{2,4})/', $output[$h],$PregMatch,PREG_OFFSET_CAPTURE);
           		//3番目の要素($PregMatch)に検索結果が入る。
           		//4番目の要素は{}で指定した文字数を分割して出力する場合に記載する。
        	}
     	}
	}
	$Width = $PregMatch[1][0];
	$Height = $PregMatch[2][0];
	return round($Width/$Height,2);
}
//
function f_get_ratio($width,$ratio)
{
	 $rtn_height = round($width/$ratio,-1);
	 $rtn_st = $width."x".$rtn_height;
	 return $rtn_st;
}

/////////////////////
// ffmpeg convertメイン

/////////////////////
// ffmpeg convertメイン
//////////////////////
function f_make_png($WIDTH,$exm_dir,$filepath)
{
  //ファイル名
  $path_parts = pathinfo($filepath);
  // $filename = $path_parts['filename'];
  $filename = $exm_dir;
  //処理フォルダ
  $TMP="/usr/share/nginx/html/faceapglezon.info/movie-png/tmp";
  mkdir($TMP.'/'.$exm_dir, 0777);
  $OUT_PATH=$TMP.'/'.$exm_dir;
  //幅取得
  $get_width = f_get_width($filepath);
  //元幅が$WIDTH(320)より小さい場合小さい方
  if($get_width<$WIDTH){$WIDTH=$get_width;}
  //ファイル情報取得
  $ratio = f_get_aspect_ratio($filepath);
  //仕上がりサイズ
  $OUT_SIZE = f_get_ratio($WIDTH,$ratio);
  //
  //$R_RATE=1; //1秒の抜き出すコマ数
 // $KEY_PNG_NO="0010";
  // $R_RATE=1;
  $R_RATE=3;
  $KEY_PNG_NO="00100";
  //png抜き出し
  system("/usr/bin/ffmpeg -i ${filepath}  -r ${R_RATE} -s ${OUT_SIZE} ${OUT_PATH}/%04d.png");
  flush();
  //pngからgifアニメ
  // system("/usr/bin/convert ${OUT_PATH}/*.png ${OUT_PATH}/${filename}.gif");
  flush();
  //存在確認
  // if(file_exists( $OUT_PATH."/".$filename.".gif")) 
  // {
  //   $rtn = "OK";
  // } else {
  //   $rtn = "NG";
  // }
  // flush();
  // return $rtn;
  return "OK";
}



//ファイル削除DBフラグ更新
function f_update_flg($db_conn,$exmname)
{
	$sql = "UPDATE `mpegmagick` SET `FLG` = 'DEL' WHERE `exmname` = '$exmname'";
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
  $TMP_PATH ="/usr/share/nginx/html/faceapglezon.info/movie-png/tmp/";
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
function get_files($images_dir,$exts = array('png'))
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
function get_files_zip($images_dir,$exts = array('png','gif','mp3'))
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
//////////
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

