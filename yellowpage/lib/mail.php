<?php
////////////////////////////////////////////////
//SJIS→JIS変換
/* original by TOMO http://www.spencernetwork.org/ */
function f_sjis2jis($sjis){                //SJIS→JIS変換
    $jis = '';
    $ascii = true;
    $b = unpack("C*", $sjis);
    for ($i = 1; $i <= count($b); $i++) {
      if($b[$i] >= 0x80){
        if ($ascii) {
          $ascii = false;
          $jis .= chr(0x1B).'$B';
        }
        $b[$i] <<= 1;
        if ($b[$i+1] < 0x9F) {
          $b[$i]   -= ($b[$i] < 0x13F) ? 0xE1 : 0x61;
          $b[$i+1] -= ($b[$i+1] > 0x7E) ? 0x20 : 0x1F;
        } else {
          $b[$i] -= ($b[$i] < 0x13F) ? 0xE0 : 0x60;
          $b[$i+1] -= 0x7E;
        }
        $b[$i] = $b[$i] & 0xff;
        $jis .= pack("CC", $b[$i], $b[$i+1]);
        $i++;
      } else {
        if (!$ascii) {
          $ascii = true;
          $jis .= chr(0x1B).'(B';
        }
        $jis .= pack("C", $b[$i]);
      }
    }
    if (!$ascii) $jis .= chr(0x1B).'(B';

    return $jis;
}
//////////////////////////////////////////////
//半角→全角
function f_HANtoZEN_SJIS($str_HAN){//半角→全角
    $table_han2zen_sjis = array(0x8142,0x8175,0x8176,0x8141,0x8145,0x8392,
    0x8340,0x8342,0x8344,0x8346,0x8348,0x8383,0x8385,0x8387,0x8362,0x815B,
    0x8341,0x8343,0x8345,0x8347,0x8349,0x834A,0x834C,0x834E,0x8350,0x8352,
    0x8354,0x8356,0x8358,0x835A,0x835C,0x835E,0x8360,0x8363,0x8365,0x8367,
    0x8369,0x836A,0x836B,0x836C,0x836D,0x836E,0x8371,0x8374,0x8377,0x837A,
    0x837D,0x837E,0x8380,0x8381,0x8382,0x8384,0x8386,0x8388,0x8389,0x838A,
    0x838B,0x838C,0x838D,0x838F,0x8393,0x814A,0x814B);
    $str_ZEN = '';
    $b = unpack("C*", $str_HAN);
    for($i = 1; $i <= count($b); $i++){
        if(0xA1 <= $b[$i] && $b[$i] <= 0xDF){
            $b[$i] -= 0xA1;
            $c1 = ($table_han2zen_sjis[$b[$i]] & 0xff00) >> 8;
            $c2 = $table_han2zen_sjis[$b[$i]] & 0x00ff;
            $str_ZEN .= pack("CC", $c1, $c2);
        }elseif($b[$i] >= 0x80){
            $str_ZEN .= pack("CC", $b[$i], $b[$i+1]);
            $i++;
        }else{
            $str_ZEN .= pack("C", $b[$i]);
        }
    }
    return $str_ZEN;
}

function f_mime_enc($usr_str,$mime=0){            //MIMEエンコード
  if(get_magic_quotes_gpc()) $usr_str = stripslashes($usr_str);//¥は取る
  $usr_str = f_HANtoZEN_SJIS($usr_str);
  $enc = f_sjis2jis($usr_str);            //JISに変換
  if($mime) $encode = "=?iso-2022-jp?B?" . base64_encode($enc) . "?=";    //Bヘッダ＋エンコード
  else $encode = $enc;
  return $encode;
}
///////////////////////////////////////////////////////
//phpメール送信
///////////////////////////////////////////////////////
function f_send_mail($to, $subject, $message,$from_add,$from_name)
{
	// 言語と文字エンコーディングを正しくセット
	mb_language("Japanese");
	mb_internal_encoding("UTF-8");
	// 宛先情報をエンコード
	// $to_name = "宛先太郎";
	// $to_addr = "taro@example.com";
	// $to_name_enc = mb_encode_mimeheader($to_name,"ISO-2022-JP");
//	$to = "$to_name_enc<$to_addr>";
	// 送信元情報をエンコード
	// $from_name = "FaceApGleZon";;
	$from_addr = $from_add;
	$from_name_enc = mb_encode_mimeheader($from_name, "ISO-2022-JP");
	$from = "$from_name_enc<$from_addr>";
	// メールヘッダを作成
	$header  = "From: $from\n";
	$header .= "Reply-To: $from";
	// 件名や本文をセット(ここは自動的にエンコードされる)
//	$subject = "メールのテスト";
	$body = $message;
	// 日本語メールの送信
	$result = mb_send_mail($to, $subject, $body, $header);
	if ($result) {
	$rtn = "OK";
	} else {
	$rtn =  "NG";
	}
	return $rtn;
}
?>