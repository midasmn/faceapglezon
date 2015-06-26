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



