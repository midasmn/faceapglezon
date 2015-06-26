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
//
function f_insert_user($db_conn, $mail,$token,$card,$to,$exm_day)
{
  mysql_set_charset('utf8'); // ←変更
  $sql = "INSERT INTO `user` (`mail`, `token`,`card`, `to`, `exm_day`) VALUES ('$mail','$token','$card' ,'$to', '$exm_day')";
  $result = mysql_query($sql, $db_conn);
  if(!$result)
  {
    $rtn =  "NG";
  }else{
    $rtn = "OK";
  }
  return $rtn;
}
//////////////////////
###################################################################################
#汎用名前取得エンコード関数 //////////////////////////////////////////
###################################################################################
function f_get_comon_item($db_conn, $tableName,$Namefiled,$Idfiled,$id)
{
  // $mysql_set_charset('utf8'); // ←変更
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

/////////////////////////////////////////////
//メールアドレスチェック関数
/////////////////////////////////////////////
function CheckEmailAddress($sMailaddress) {
    if(preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', $sMailaddress)){
        list($username,$domain)=split('@',$sMailaddress);
        if(!checkdnsrr($domain,'MX')){
            return "NG";
        }
    return "OK";
    }
return "NG";
}
//////////////////////
// メール削除URL作成
//////////////////////
function f_get_delurl($db_conn,$mail)
{
  $id = f_get_comon_name($db_conn, 'loto7_user','id','mail',$mail);
  $rtn_st = "http://faceapglezon.info/loto7/ctrl.php?&mode=dell&arid=".$id."&umid=".str_replace('@','loto7',$mail);
  return $rtn_st;
}
//////////////////////
//リモートでもローカルでもファイルサイズ取得
//////////////////////
function remote_filesizeR($url) {
    static $regex = '/^Content-Length: *+\K\d++$/im';
    if (!$fp = @fopen($url, 'rb')) {
        return false;
    }
    if (
        isset($http_response_header) &&
        preg_match($regex, implode("\n", $http_response_header), $matches)
    ) {
        return (int)$matches[0];
    }
    return strlen(stream_get_contents($fp));
}
// ファイルサイズ大きいとここまるやつ
function remote_filesize($url) 
{
    if (false === $response = @file_get_contents($url)) {
        return false;
    }
    return strlen($response);
}
function f_get_resize_length($imagepath,$thumb_width,$thumb_height)
{  
  // サイズを取得
  list($img_width, $img_height) = @getimagesize("$imagepath");
  if($img_width >= $img_height)
  {
    // 幅広のときは幅に合わせて縮小
    if($img_width >= $thumb_width)
    {
      $width = $thumb_width;
      $height = floor($img_height * $thumb_width / $img_width);
      // $height = round($img_height * $thumb_width / $img_width);
    }
  }
  elseif($img_width < $img_height)
  {
    // 縦長のときは長さにあわせて縮小
    if($img_height > $thumb_height)
    {
      $height = $thumb_height;
      $width = floor($img_width * $thumb_height / $img_height);
      // $width = round($img_width * $thumb_height / $img_height);
    }
  }   
  $arySize = array($width, $height);    
  return $arySize;
}
// ファイルなしでのリサイズ＝たてよこ入れる
function f_get_resize_length_without_file($img_width,$img_height,$thumb_width,$thumb_height)
{  
  if($img_width >= $img_height)
  {
    // 幅広のときは幅に合わせて縮小
    if($img_width >= $thumb_width)
    {
      $width = $thumb_width;
      $height = floor($img_height * $thumb_width / $img_width);
      // $height = round($img_height * $thumb_width / $img_width);
    }
  }
  elseif($img_width < $img_height)
  {
    // 縦長のときは長さにあわせて縮小
    if($img_height > $thumb_height)
    {
      $height = $thumb_height;
      $width = floor($img_width * $thumb_height / $img_height);
      // $width = round($img_width * $thumb_height / $img_height);
    }
  }   
  $arySize = array($width, $height);    
  return $arySize;
}


