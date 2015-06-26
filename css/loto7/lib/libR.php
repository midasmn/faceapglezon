<?php
function f_utl_nocache_header()
{
	// set expires to past.
	// document is always fresh.
	// disable cache by HTTP/1.1 and HTTP/1.0
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
	header("Cache-Control: no-cache, must-revalidate");
	header("Pragma: no-cache");

	ob_start();	// fblib.phpに置きたいが、FileDl.phpでは
									// 実行させたくないので、ここで実行
}
// 自分自身のファイル名
$myself = basename($PHP_SELF);
//パワー数字
function f_get_powerNO($db_conn)
{
	$rtn_array = array();
	$sql = 'select no , sum from loto7_power order by no';
	$result = mysql_query($sql,$db_conn);
	if($result)
	{
		while($rec_tmp = mysql_fetch_row($result))
		{
			$rtn_array[$rec_tmp[0]] = $rec_tmp[1];
		}
	}
	return $rtn_array;
}
###################################################################################
# 最新結果取得
###################################################################################
function f_get_latest($db_conn)
{
	$rtn_array = array();
	$sql = 'select * from loto7_result order by cnt desc limit 1';
	$result = mysql_query($sql,$db_conn);
	if($result)
	{
		while($link = mysql_fetch_row($result))
		{
			list( $cnt,$cnt_data,$no1,$no2,$no3,$no4,$no5,$no6,$no7,$b,$b2,$amount1,$amount2,$amount3,$amount4,$amount5,$amount6,$carry) = $link;
			$rtn_array['cnt'] = $cnt;
			$rtn_array['cnt_date'] = $cnt_data;
			$rtn_array['1'] = $no1;
			$rtn_array['2'] = $no2;
			$rtn_array['3'] = $no3;
			$rtn_array['4'] = $no4;
			$rtn_array['5'] = $no5;
			$rtn_array['6'] = $no6;
			$rtn_array['7'] = $no7;
			$rtn_array['b'] = $b;
			$rtn_array['b2'] = $b2;
			$rtn_array['amount'] = $amount1;
			$rtn_array['carry'] = $carry;
		}
	}
	return $rtn_array;
}
function f_get_latest_only_no($db_conn)
{
	$rtn_array = array();
	$sql = 'select * from loto7_result order by cnt desc limit 1';
	$result = mysql_query($sql,$db_conn);
	if($result)
	{
		while($link = mysql_fetch_row($result))
		{
			list( $cnt,$cnt_data,$no1,$no2,$no3,$no4,$no5,$no6,$no7,$b,$b2,$amount1,$amount2,$amount3,$amount4,$amount5,$amount6,$carry) = $link;
			$rtn_array[0] = $no1;
			$rtn_array[1] = $no2;
			$rtn_array[2] = $no3;
			$rtn_array[3] = $no4;
			$rtn_array[4] = $no5;
			$rtn_array[5] = $no6;
			$rtn_array[6] = $no7;
			$rtn_array[7] = $b;
			$rtn_array[8] = $b2;
		}
	}
	return $rtn_array;
}
//予測記録
function f_log_writter($db_conn,$user_id,$nextNO,$winCNT_arr)
{
	$user_id = 0;
	$sql = "INSERT INTO loto7_user_log( id , user_id , cnt, no1 , no2, no3, no4, no5, no6, no7, per, created_at,amount)VALUES (NULL, '$user_id', '$nextNO', '$winCNT_arr[0]', '$winCNT_arr[1]', '$winCNT_arr[2]', '$winCNT_arr[3]', '$winCNT_arr[4]', '$winCNT_arr[5]', '$winCNT_arr[6]',0, CURRENT_TIMESTAMP,0)";
	$result = mysql_query($sql, $db_conn);
	if(!$result)
	{
		$rtn =  "NG";
	}else{
		$rtn = "OK";
	}
	return $rtn;
}

//////////////////////////////////////////////////////////////////
//前回数字支持
//////////////////////////////////////////////////////////////////
function  f_get_destiny_no($db_conn,$nextNO)
{
	$winCNT_arr = array(); //
	$base_arr = array(); //37個初期化
	for($i=1;$i<38;$i++){$base_arr[$i]=$i;}
	if(!$randamseed){$randamseed=date("Ymd");}//ランダムシードですティにー
 	f_get_late_one_no($db_conn,$winCNT_arr,$base_arr,$randamseed);	//前回からひとつ
	f_get_truss_no($db_conn,$winCNT_arr,$base_arr,$randamseed);	//下一桁ペア
	f_get_pair_no($db_conn,$winCNT_arr,$base_arr,$randamseed);	//連続ペア
	// f_get_power_no($db_conn,$winCNT_arr,$base_arr,$randamseed);	//パワー数字 10回まで凍結
	f_get_randamu_no($db_conn,$winCNT_arr,$base_arr,$randamseed);	//ランダムシードディスティニー
	f_get_randamu_no($db_conn,$winCNT_arr,$base_arr,$randamseed);	//ランダムシードディスティニー
	return $winCNT_arr;
}
//////////////////////////////////////////////////////////////////
//前回からひとつ
//////////////////////////////////////////////////////////////////
function f_get_late_one_no($db_conn,&$winCNT_arr,&$base_arr,$randamseed)
{
	$letest_arr = f_get_latest_only_no($db_conn);//最新数字
	srand((double)microtime()*$randamseed);
	$number=rand(0,8);
	$latest_no = $letest_arr[$number];
	array_push($winCNT_arr, $latest_no);	//当選番号配列に追加
	f_without_no($base_arr ,$latest_no);//当該番号前後削除
	foreach ($letest_arr as $key => $value)
	{
		unset($base_arr[$value]);//抽選配列削除
	}
}
////////////////////////////////////////////////////////////////
//連続ペア
////////////////////////////////////////////////////////////////
function f_get_pair_no($db_conn,&$winCNT_arr,&$base_arr,$randamseed)
{
	$WinningUPLOW_ar = array( 'UP' => 'UP'	,'LOW' => 'LOW'	);
	$exm_st=rand(0,count($WinningUPLOW_ar));//
	$exm = $WinningUPLOW_ar[$exm_st];//増減確定
	while(!in_array($get_count2,$base_arr)) ////抽選配列に2ペア目数字があったらOK
	{
		srand((double)microtime()*$randamseed);
		$number=rand(0,count($base_arr));//
		$get_count1 = $base_arr[$number];//ペア一つ目
		//
		if($get_count1==1){$exm = "UP";}elseif($get_count1==37){$exm = "LOW";}//１と４３増減強制変更
		//
		if($exm=="UP")
		{
			$rtn = array_search($get_count1 + 1, $base_arr);//配列候補検索
			if($rtn===false){//候補になければ候補削除
				f_without_no($base_arr ,$get_count1);
			}else{$get_count2 = $get_count1 + 1;}
		}else
		{
			$rtn = array_search($get_count1 - 1, $base_arr);//配列候補検索
			if($rtn===false){//候補になければ候補削除
				f_without_no($base_arr ,$get_count1);
			}else{$get_count2 = $get_count1 - 1;}
		}
	}
	f_without_no($base_arr ,$get_count1);//一個目削除当該番号前後削除
	f_without_no($base_arr ,$get_count2);//２個目削除当該番号前後削除
	array_push($winCNT_arr, $get_count1);	//当選番号配列に追加
	array_push($winCNT_arr, $get_count2);	//当選番号配列に追加
}
///////////////////////////////////////////////////////////
// 下一桁ペア
///////////////////////////////////////////////////////////
function f_get_truss_no($db_conn,&$winCNT_arr,&$base_arr,$randamseed)
{
	$pair_ar = array(); //
	srand((double)microtime()*$randamseed);
	$number=rand(0,count($base_arr));//
	// $get_num1 = $base_arr[$number];//ペア一つ目
	// $keta = 1;
	// $lastdigit = $get_num1 % pow(10, $keta);//1桁目数字取得
	//
	while(!$get_num2) ////抽選配列に2ペア目数字があったらOK
	{
		$number=rand(0,count($base_arr));//
		$get_num1 = $base_arr[$number];//ペア一つ目
		$keta = 1;
		$lastdigit = $get_num1 % pow(10, $keta);//1桁目数字取得
		if($get_num1==10)
		{
			if(in_array($get_num1+10,$base_arr)){$get_num2 = $get_num1+10;}
			if(!$get_num2){if(in_array($get_num1+20,$base_arr)){$get_num2 = $get_num1+20;}}
		}elseif($get_num1<10)
		{
			if($lastdigit<8)
			{
				if(in_array($get_num1+10,$base_arr)){$get_num2 = $get_num1+10;}
				if(!$get_num2){if(in_array($get_num1+20,$base_arr)){$get_num2 = $get_num1+20;}}
				if(!$get_num2){if(in_array($get_num1+30,$base_arr)){$get_num2 = $get_num1+30;}}
			}else{
				if(in_array($get_num1+10,$base_arr)){$get_num2 = $get_num1+10;}
				if(!$get_num2){if(in_array($get_num1+20,$base_arr)){$get_num2 = $get_num1+20;}}
			}
		}elseif($get_num1<20){
			if($lastdigit<8)
			{
				if(in_array($get_num1-10,$base_arr)){$get_num2 = $get_num1-10;}
				if(!$get_num2){if(in_array($get_num1+10,$base_arr)){$get_num2 = $get_num1+10;}}
				if(!$get_num2){if(in_array($get_num1+20,$base_arr)){$get_num2 = $get_num1+20;}}
			}else{
				if(in_array($get_num1-10,$base_arr)){$get_num2 = $get_num1-10;}
				if(!$get_num2){if(in_array($get_num1+10,$base_arr)){$get_num2 = $get_num1+10;}}
			}
		}elseif($get_num1==20)
		{
			if(in_array($get_num1-10,$base_arr)){$get_num2 = $get_num1-10;}
			if(!$get_num2){if(in_array($get_num1+10,$base_arr)){$get_num2 = $get_num1+10;}}
		}elseif($get_num1<30){
			if($lastdigit<8)
			{
				if(in_array($get_num1-20,$base_arr)){$get_num2 = $get_num1-20;}
				if(!$get_num2){if(in_array($get_num1-10,$base_arr)){$get_num2 = $get_num1-10;}}
				if(!$get_num2){if(in_array($get_num1+10,$base_arr)){$get_num2 = $get_num1+10;}}
			}else{
				if(in_array($get_num1-20,$base_arr)){$get_num2 = $get_num1-20;}
				if(!$get_num2){if(in_array($get_num1-10,$base_arr)){$get_num2 = $get_num1-10;}}
			}
		}elseif($get_num1==30)
		{
			if(in_array($get_num1-20,$base_arr)){$get_num2 = $get_num1-20;}
			if(!$get_num2){if(in_array($get_num1-10,$base_arr)){$get_num2 = $get_num1-10;}}
		}else{
			if($lastdigit<8)
			{
				if(in_array($get_num1-30,$base_arr)){$get_num2 = $get_num1-30;}
				if(!$get_num2){if(in_array($get_num1-20,$base_arr)){$get_num2 = $get_num1-20;}}
				if(!$get_num2){if(in_array($get_num1-10,$base_arr)){$get_num2 = $get_num1-10;}}
			}else{
				if(in_array($get_num1-30,$base_arr)){$get_num2 = $get_num1-30;}
				if(!$get_num2){if(in_array($get_num1-20,$base_arr)){$get_num2 = $get_num1-20;}}
				if(!$get_num2){if(in_array($get_num1-10,$base_arr)){$get_num2 = $get_num1-10;}}
			}
		}
	}
	if($get_num1&$get_num2)
	{
	array_push($winCNT_arr, $get_num1);	//当選番号配列に追加
	array_push($winCNT_arr, $get_num2);	//当選番号配列に追加
	f_without_no($base_arr ,$get_num1);//一個目削除当該番号前後削除
	f_without_no($base_arr ,$get_num2);//一個目削除当該番号前後削除
	}
}
//////////////////////////////////////////////////////////
//パワー数字取得処理
//////////////////////////////////////////////////////////
// function f_get_power_no($db_conn,$winCNT_arr,$base_arr,$randamseed)
// {
// 	while(!$rtn_rdm_no) ////パワー数字
// 	{
// 		$rtn_rdm_no = f_random_power($db_conn,$randamseed);//パワー数字取得
// 		if(in_array($rtn_rdm_no,$base_arr)){}else{$rtn_rdm_no="";}
// 	}
// 	array_push($winCNT_arr, $rtn_rdm_no);
// 	f_without_no($base_arr ,$rtn_rdm_no);//一個目削除当該番号前後削除
// }
////////////////////////////////////////////////////////
//ランダムシードデスティニー
////////////////////////////////////////////////////////
function f_get_randamu_no($db_conn,&$winCNT_arr,&$base_arr,$randamseed)
{
	srand((double)microtime()*$randamseed);
	$number=rand(0,36);
	$random_seed_destiny = $base_arr[$number];
	while(!in_array($random_seed_destiny,$base_arr)) ////抽選配列にパワー数字があったらOK
	{
		$number=rand(0,36);
		$random_seed_destiny = $base_arr[$number];
	}
	array_push($winCNT_arr, $random_seed_destiny);	//当選番号配列に追加
	sort($winCNT_arr);
	// return $winCNT_arr;
}
//////////////////////////////////////////////
//当該NOおよび隣接番号削除
//////////////////////////////////////////////
function f_without_no(&$array,$exm_no)
{
	$min_no =1;
	$max_no =37;
	$del_no = $exm_no; //当該削除NO
	if($exm_no==$min_no){$del_no_pre = $max_no;}else{$del_no_pre = $exm_no-1;} //隣接NO削除
	if($exm_no==$max_no){$del_no_nex = $min_no;}else{$del_no_nex = $exm_no+1;} //隣接NO削除
	unset($array[$del_no]);
	unset($array[$del_no_pre]);
	unset($array[$del_no_nex]);
}
// //////////////////////////////////////////////
// //パワー番号からランダムに一つ抜くだけ
// //////////////////////////////////////////////
function f_random_power($db_conn,$randamseed)
{
	$rtnary = array();
	$strSQL = "SELECT sum, no FROM loto7_power where sum > 0 order by sum DESC limit 30";
	$tbl_tmp = mysql_query($strSQL, $db_conn);
	if($tbl_tmp)
	{
		$index = 0;
		while($rec_tmp = mysql_fetch_row($tbl_tmp))
		{
			$rtnary[$index] = $rec_tmp[1];
			$index++;
		}
	}
	srand((double)microtime()*$randamseed);
	$number=rand(0,5);
	$rtn_no = $rtnary[$number];
	return $rtn_no;
}



////////////////////////////////////////////////
//大安チェック
////////////////////////////////////////////////
function f_checkTAIAN()
{
	//日めくりカレンダー
	$rdf_urlT = "http://www.himekuricalendar.com/";
	$contentT = file_get_contents($rdf_urlT);
	if ($contentT)
	{
		$bufT = mb_convert_encoding($contentT, 'SJIS', 'auto');
	}
	$seekposCNTT = mb_strpos($bufT,"<FONT COLOR='#008080'>大安</FONT>", 0);
	if(!$seekposCNTT)
	{
		$rtn_st = "NG";
	}else{
		$rtn_st = "OK";
	}
	return $rtn_st;
}

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
//メール送信関数
// $to：送信先メールアドレス
// $subject：件名（日本語OK）
// $body：本文（日本語OK）
// $fromname：送信元名（日本語OK）
// $fromaddress：送信元メールアドレス
       // 'host'=>'（SMTPサーバー名）',
       //  'port'=> 587 ,
       //  'from'=>'（Return-Pathにはいるメールアドレス）',
       //  'protocol'=>'SMTP_AUTH',
       //  'user'=>'（SMTP認証ユーザー名）',
       //  'pass' => '（SMTP認証パスワード）',
// function f_send_mail($to, $subject, $message,$from_name,$from_add)
// {
//     //SMTP送信
//     $mail = new Qdmail();
//     $mail -> smtp(true);
//     $param = array(
//         'host'=>'（SMTPサーバー名）',
//         'port'=> 587 ,
//         'from'=>'（Return-Pathにはいるメールアドレス）',
//         'protocol'=>'SMTP_AUTH',
//         'user'=>'（SMTP認証ユーザー名）',
//         'pass' => '（SMTP認証パスワード）',
//     );
//     $mail ->smtpServer($param);
//     $mail ->to($to);
//     $mail ->subject($subject);
//     $mail ->from($from_add,$from_name);
//     $mail ->text($message);
//     $return_flag = $mail ->send();
//     return $return_flag
// }
//$message = $message . 'http://mittelloge.com/Mouseion/'
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
	$from_name = "LOTO7-FaceApGleZon";;
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

///////////////////////////////////////////////
// LOTOメール登録
////////////////////////////////////////////////
function f_entry_loto7_mail($db_conn,$MAIL,$DM)
{
	// '0' => '日曜日'
	// , '1' => '月曜日'
	// , '2' => '火曜日'
	// , '3' => '水曜日'
	// , '4' => '木曜日'
	// , '5' => '金曜日'
	// , '6' => '土曜日'
	// , '9' => 'メール不要'

	//メールアドレスチェック
	if(!CheckEmailAddress($MAIL))
	{
		$rtn_Message ="メールアドレスをご確認ください。<BR>";
	}else{
		//重複アドレス削除
		$del_sql = "DELETE FROM `loto7_user` WHERE `mail` = '$MAIL' LIMIT 1";
		$query = mysql_query($del_sql, $db_conn);
		//エントリ
		$resultmemo = mysql_query("INSERT INTO `loto7_user` (`id` ,`mail` ,`week` ,`dm_flg`)VALUES ('' ,  '$MAIL',  '5',  '$DM')", $db_conn);
		if(!$resultmemo)
		{
			$rtn_Message ="登録できませんでした。<BR>";
		}else{
			//メール配信
			$subjectML = '[LOTO7]登録確認メール';
//			$message_top = $subjectML ."¥n";	//本文
			$url = "http://faceapglezon.info/loto7/";
			$from_add = 'contact@faceapglezon.info';	//管理者アドレス
$message_top = $MAIL.'さま';
$st_link = '

[LOTO7]メール配信登録を承りました。
まことにありがとうございます。';
$st_link .= "

----------------------------------------------
▼登録内容
----------------------------------------------
・メールアドレス：".$MAIL."
・関連情報：";
if($DM=="on"){$DM_ST = "受け取る";}else{$DM_ST = "受け取らない";}
$st_link .= $DM_ST."
----------------------------------------------

次回の抽選数字予測は「LOTO7」でどうぞ
";
$st_link = $st_link.$url;
$message_btm .= '

----------------------------------------------
▼メールアドレスの配信停止
----------------------------------------------
'.$rtn_dellurl = f_get_delurl($db_conn,$MAIL);

$message_btm .= "

LOTO7-FaceApGleZon.
";
//			$from_add = 'akashicrecords@mouseion.info';	//管理者アドレス
			$from_name = 'LOTO7-FaceApGleZon..ﾞ';
			$rtn = f_send_mail($MAIL, $subjectML, $message_top.$message .$st_link.$DM_ADstring. $message_btm,$from_add,$from_name);
			if ($rtn=="NG")
			{
				$rtn_Message ="メール送信に失敗しました。<BR>";
			}else{
				$rtn_Message ="OK";
			}
		}
	}
	return $rtn_Message;
}
/////////////////////////////////////////////
//メールアドレスチェック関数
/////////////////////////////////////////////
function CheckEmailAddress($sMailaddress) {
    if(preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', $sMailaddress)){
        list($username,$domain)=split('@',$sMailaddress);
        if(!checkdnsrr($domain,'MX')){
            return false;
        }
    return true;
    }
return false;
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
// http://faceapglezon.info/ctrl.php?&mode=dell&arid=".$id."&umid=".str_replace('@','loto7',$mail);

//////////////////////////////////////////
//汎用名前取得エンコード関数
//////////////////////////////////////////
function f_get_comon_name($db_conn, $tableName,$Namefiled,$Idfiled,$id)
{
	$rtn = mysql_query("SET NAMES sjis" , $db_conn);
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
//////////////////////////////////////////////////////
////　HTML分割　
/////////////////////////////////////////////////////
function f_cut_html_parse($buf,$start_pos,$start_st,$end_st)
{
	$start_st_len = mb_strlen($start_st,'UTF-8');//スタート検索文字列長
	$end_st_len = mb_strlen($end_st,'UTF-8');//エンド検索文字列長
	$seekStartPos = mb_strpos($buf,$start_st, $start_pos,'UTF-8');//スタート位置検索
	// $end_start_pos = $start_pos + $start_st_len+1;//エンドスタート
	$end_start_pos = $start_pos + $start_st_len;//エンドスタート
	$seekEndPos = mb_strpos($buf,$end_st, $end_start_pos,'UTF-8');//スタート位置検索
	//
	$rtn_st = mb_substr($buf,$seekStartPos+$start_st_len,$seekEndPos-$seekStartPos-$start_st_len,'UTF-8');
	return $rtn_st;
}
//////////////////////////////////////////////////////
////　HTML分割　スタート位置
/////////////////////////////////////////////////////
function f_cut_html_parse_pos($buf,$start_pos,$start_st,$end_st)
{
	$start_st_len = mb_strlen($start_st,'UTF-8');//スタート検索文字列長
	$end_st_len = mb_strlen($end_st,'UTF-8');//エンド検索文字列長
	$seekStartPos = mb_strpos($buf,$start_st, $start_pos,'UTF-8');//スタート位置検索
	// $end_start_pos = $start_pos + $start_st_len+1;//エンドスタート
	$end_start_pos = $start_pos + $start_st_len;//エンドスタート
	$seekEndPos = mb_strpos($buf,$end_st, $end_start_pos,'UTF-8');//スタート位置検索

	return $seekEndPos+$end_st_len;
}
///////////////////////////////////////////////////
// みずほ銀行抽選番号ページパース
///////////////////////////////////////////////////
function f_getloto7result($db_conn)
{
	$exm_cnt_arr = f_get_latest($db_conn);
	$exm_cnt = $exm_cnt_arr['cnt'];
	$exm_cnt = $exm_cnt+1;
	$exm_st = "処理無し";

	$seekposCNT = 0;
	$buf = "";
	$rdf_url = "";
	$st_gettag = "";
	// HTMLの指定
	// $rdf_url = "http://www.mizuhobank.co.jp/takarakuji/loto/loto6/index.html";
		$rdf_url = "http://www.mizuhobank.co.jp/takarakuji/loto/loto7/index.html";
	$buf = file_get_contents($rdf_url);
	$buf = mb_convert_encoding($buf, 'utf-8', 'auto');
	//第何回
	$rtn_count = f_cut_html_parse($buf,0,'<th colspan="7" class="center bgf7f7f7">第','回</th>');
	$rtn_next_pos = f_cut_html_parse_pos($buf,0,'<th colspan="7" class="center bgf7f7f7">第','回</th>');
//echo "<br>".$rtn_count ;
//echo "<br>";

	if($exm_cnt==$rtn_count)
	{

		$exm_st = "処理開始";
		//抽選日
		$rtn_date = f_cut_html_parse($buf,$rtn_next_pos,'<td colspan="7" class="center">','</td>');
		// "A" という文字列を "×" に置換する
		$rtn_date = str_replace("年", "/", $rtn_date);
		$rtn_date = str_replace("月", "/", $rtn_date);
		$rtn_date = str_replace("日", "", $rtn_date);
//echo "<br>".$rtn_date ;
//echo "<br>";
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td colspan="7" class="center">','</td>');
// 		//本数字1
		$rtn_hon1 = f_cut_html_parse($buf,$rtn_next_pos,'<td class="extension center"><strong>','</strong></td>');
//echo "<br>".$rtn_hon1;
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td class="extension center"><strong>','</strong></td>');
// 		//本数字2
		$rtn_hon2 = f_cut_html_parse($buf,$rtn_next_pos,'<td class="extension center"><strong>','</strong></td>');
//echo "<br>".$rtn_hon2;
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td class="extension center"><strong>','</strong></td>');
// 		//本数字3
		$rtn_hon3 = f_cut_html_parse($buf,$rtn_next_pos,'<td class="extension center"><strong>','</strong></td>');
//echo "<br>".$rtn_hon3;
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td class="extension center"><strong>','</strong></td>');
		//本数字4
		$rtn_hon4 = f_cut_html_parse($buf,$rtn_next_pos,'<td class="extension center"><strong>','</strong></td>');
//echo "<br>".$rtn_hon4;
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td class="extension center"><strong>','</strong></td>');
		//本数字5
		$rtn_hon5 = f_cut_html_parse($buf,$rtn_next_pos,'<td class="extension center"><strong>','</strong></td>');
//echo "<br>".$rtn_hon5;
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td class="extension center"><strong>','</strong></td>');
		//本数字6
		$rtn_hon6 = f_cut_html_parse($buf,$rtn_next_pos,'<td class="extension center"><strong>','</strong></td>');
//echo "<br>".$rtn_hon6;
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td class="extension center"><strong>','</strong></td>');
		// //本数字7
		$rtn_hon7 = f_cut_html_parse($buf,$rtn_next_pos,'<td class="extension center"><strong>','</strong></td>');
//echo "<br>".$rtn_hon7;
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td class="extension center"><strong>','</strong></td>');
		//B1
		$rtn_b1 = f_cut_html_parse($buf,$rtn_next_pos,'<td class="extension center green"><strong>(',')</strong></td>');
//echo "<br>".$rtn_b1;
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td class="extension center green"><strong>(',')</strong></td>');
		//B2
		$rtn_b2 = f_cut_html_parse($buf,$rtn_next_pos,'<td class="extension center green"><strong>(',')</strong></td>');
//echo "<br>".$rtn_b2;
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td class="extension center green"><strong>(',')</strong></td>');
// 		//一等d
// 		//
		$rtn_amount_dummy = f_cut_html_parse($buf,$rtn_next_pos,'<td colspan="3" class="right">','なし</td>');
		if($rtn_amount_dummy=="該当"){
			$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td colspan="3" class="right">','なし</td>');
		}else{
			$rtn_amount_dummy = f_cut_html_parse($buf,$rtn_next_pos,'<td colspan="3" class="right">','口</td>');
			$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td colspan="3" class="right">','口</td>');
		}
		$cary_flg = f_cut_html_parse($buf,$rtn_next_pos,'<td colspan="4" class="right"><strong>','なし</strong></td>');
		if($cary_flg=="該当"){
			$rtn_amount1 = 0;
			$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td colspan="4" class="right"><strong>','なし</strong></td>');
		}else{
			$rtn_amount1 = f_cut_html_parse($buf,$rtn_next_pos,'<td colspan="4" class="right"><strong>','円</strong></td>');
			$rtn_amount1 = str_replace(",", "", $rtn_amount1);
			$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td colspan="4" class="right"><strong>','円</strong></td>');
		}
// echo "<br>".$rtn_amount1;
		
	//
		$rtn_amount_dummy = f_cut_html_parse($buf,$rtn_next_pos,'<td colspan="3" class="right">','口</td>');
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td colspan="3" class="right">','口</td>');
		$rtn_amount2 = f_cut_html_parse($buf,$rtn_next_pos,'<td colspan="4" class="right"><strong>','円</strong></td>');
		$rtn_amount2 = str_replace(",", "", $rtn_amount2);
//echo "<br>".$rtn_amount2;
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td colspan="4" class="right"><strong>','円</strong></td>');
	//
		$rtn_amount_dummy = f_cut_html_parse($buf,$rtn_next_pos,'<td colspan="3" class="right">','口</td>');
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td colspan="3" class="right">','口</td>');
		$rtn_amount3 = f_cut_html_parse($buf,$rtn_next_pos,'<td colspan="4" class="right"><strong>','円</strong></td>');
		$rtn_amount3 = str_replace(",", "", $rtn_amount3);
//echo "<br>".$rtn_amount3;
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td colspan="4" class="right"><strong>','円</strong></td>');
	//
		$rtn_amount_dummy = f_cut_html_parse($buf,$rtn_next_pos,'<td colspan="3" class="right">','口</td>');
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td colspan="3" class="right">','口</td>');
		$rtn_amount4 = f_cut_html_parse($buf,$rtn_next_pos,'<td colspan="4" class="right"><strong>','円</strong></td>');
		$rtn_amount4 = str_replace(",", "", $rtn_amount4);
//echo "<br>".$rtn_amount4;
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td colspan="4" class="right"><strong>','円</strong></td>');
		//
		$rtn_amount_dummy = f_cut_html_parse($buf,$rtn_next_pos,'<td colspan="3" class="right">','口</td>');
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td colspan="3" class="right">','口</td>');
		$rtn_amount5 = f_cut_html_parse($buf,$rtn_next_pos,'<td colspan="4" class="right"><strong>','円</strong></td>');
		$rtn_amount5 = str_replace(",", "", $rtn_amount5);
//echo "<br>".$rtn_amount5;
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td colspan="4" class="right"><strong>','円</strong></td>');
		//
		$rtn_amount_dummy = f_cut_html_parse($buf,$rtn_next_pos,'<td colspan="3" class="right">','口</td>');
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td colspan="3" class="right">','口</td>');
		$rtn_amount6 = f_cut_html_parse($buf,$rtn_next_pos,'<td colspan="4" class="right"><strong>','円</strong></td>');
		$rtn_amount6 = str_replace(",", "", $rtn_amount6);
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td colspan="4" class="right"><strong>','円</strong></td>');
//echo "<br>".$rtn_amount6;
		//
		$rtn_next_pos = mb_strpos($buf, '<th>販売実績額</th>',$rtn_next_pos,'UTF-8');//スタート位置検索
		$rtn_dummy = f_cut_html_parse($buf,$rtn_next_pos,'<td colspan="7" class="right">','円</td>');
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td colspan="7" class="right">','円</td>');
//echo "<br>".$rtn_dummy;

		//キャリーおバー
		$rtn_next_pos = mb_strpos($buf, '<th>キャリーオーバー</th>',$rtn_next_pos,'UTF-8');//スタート位置検索
		$rtn_carry = f_cut_html_parse($buf,$rtn_next_pos,'<td colspan="7" class="right"><strong>','円</strong></td>');
		$rtn_carry = str_replace(",", "", $rtn_carry);
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td colspan="7" class="right">','円</td>');
//echo "<br>CO".$rtn_carry;



		$rtn = f_result_writter($db_conn,$rtn_count, $rtn_date, $rtn_hon1, $rtn_hon2, $rtn_hon3, $rtn_hon4, $rtn_hon5, $rtn_hon6, $rtn_hon7, $rtn_b1, $rtn_b2, $rtn_amount1,$rtn_amount2,$rtn_amount3,$rtn_amount4,$rtn_amount5,$rtn_amount6, $rtn_carry);

		if($rtn=="OK")
		{
			//メールフラグリセット
			f_update_user_mailflg($db_conn);
			//予測当選アップデート
			$exm_st = f_up_bingo($db_conn,$rtn_count,$rtn_hon1,$rtn_hon2,$rtn_hon3,$rtn_hon4,$rtn_hon5,$rtn_hon6,$rtn_hon7,$rtn_b1,$rtn_b2,$rtn_amount1,$rtn_amount2,$rtn_amount3,$rtn_amount4,$rtn_amount5,$rtn_amount6);
			//パワー数字集計
			f_get_defprice_writter($db_conn, $rtn_hon1);
			f_get_defprice_writter($db_conn, $rtn_hon2);
			f_get_defprice_writter($db_conn, $rtn_hon3);
			f_get_defprice_writter($db_conn, $rtn_hon4);
			f_get_defprice_writter($db_conn, $rtn_hon5);
			f_get_defprice_writter($db_conn, $rtn_hon6);
			f_get_defprice_writter($db_conn, $rtn_hon7);
		}else{

		}
		$buf = "";
		//当選番号案内メール
	}
	return $exm_st;
}

//////////////////////////////////////////////
//当選番号記録
//////////////////////////////////////////////
function f_result_writter($db_conn,$cnt, $cnt_date, $no1, $no2, $no3, $no4, $no5, $no6, $no7, $b, $b2, $amount1, $amount2, $amount3, $amount4, $amount5, $amount6, $carry)
{
	$del_sql = "DELETE FROM `loto7_result` WHERE `cnt` = '$cnt' LIMIT 1";
	$query = mysql_query($del_sql, $db_conn);
	//
	$sql = "INSERT INTO loto7_result(`cnt`, `cnt_date`, `no1`, `no2`, `no3`, `no4`, `no5`, `no6`, `no7`, `b`, `b2`, `amount1`,`amount2`,`amount3`,`amount4`,`amount5`,`amount6`, `carry`)VALUE('$cnt', '$cnt_date', '$no1', '$no2', '$no3', '$no4', '$no5', '$no6', '$no7', '$b', '$b2', '$amount1','$amount2','$amount3','$amount4','$amount5','$amount6', '$carry')";


	$result = mysql_query($sql, $db_conn);
	if(!$result)
	{
		$rtn = "NG";
	}else{
		$rtn = "OK";
	}
	return $rtn;
}
////////////////////////////////////////////////
//メール配信
////////////////////////////////////////////////
function f_send_mail_toto($db_conn,$cnt, $cnt_date, $no1, $no2, $no3, $no4, $no5, $no6, $no7, $b, $b2, $amount1, $carry)
{
	$subjectML =  "【LOTO7】第".$cnt."回抽選結果";
	//大安チェック
	$st_taian = f_checkTAIAN();
	if($st_taian=="OK")
	{
		$subjectML = "【LOTO7-本日大安】第".$cnt."回抽選結果";
	}
	if($carry>1)	//キャリーオーバー
	{
		$subjectML =  "【LOTO7-キャリーオーバー発生中】第".$cnt."回抽選結果";
		$price = 'キャリーオーバー:'.number_format($carry).'円';
	}else{
		$price = '1等賞金:'.number_format($amount1).'円';
    }

$from_add = 'contact@faceapglezon.info';	//管理者アドレス
$from_name = 'LOTO7-FaceApGleZon.';

//メール
$st_link = "

次回の抽選数字予測は「LOTO7」でどうぞ
http://faceapglezon.info/loto7/
";



$message_top = '■■■LOTO7  FaceApGleZon MAIL■■■
LOTO7当選数字取り出しサイトから最新の抽選結果や当選金を有効に使う情報などをお届けします。
----------------------------------------------
第'.$cnt.'回('.$cnt_date.')抽選結果
━━━━━━━━━━━━━
'.sprintf('%2s', $no1).' | '.sprintf('%2s', $no2).' | '.sprintf('%2s', $no3).' | '.sprintf('%2s', $no4).' | '.sprintf('%2s', $no5).' | '.sprintf('%2s', $no6).' | '.sprintf('%2s', $no7).'
━━━━━━━━━━━━━
ボーナス数字: '.sprintf('%2s', $b).' |'.sprintf('%2s', $b2);

$message_top .= '

'.$price;


$dm_header =  '
----------------------------------------------
┏━┓┏━┓┏━┓┏━┓┏━┓┏━┓┏━┓
┃オ┃┃ス┃┃ス┃┃メ┃┃！┃┃情┃┃報┃
┗━┛┗━┛┗━┛┗━┛┗━┛┗━┛┗━┛
----------------------------------------------
';

	// データベースに接続
//	$sql = "SELECT `id` ,  `mail` FROM `loto7_user` WHERE  `dm_flg` = 'on' and `send_flg` = 'off' order by id limit 100";
	$sql = "SELECT `id` ,  `mail` FROM `loto7_user` WHERE  `dm_flg` = 'on' and `send_flg` = 'off' order by id limit 100";
	$result = mysql_query($sql, $db_conn);
	if($result)
	{
		// 行数の取得
		$numrows = mysql_num_rows($result);
		if($numrows > 0)
		{
			while($link = mysql_fetch_row($result))
			{
				list($ID,$MAIL) = $link;
				//ボトム
$message_btm = '

----------------------------------------------
▼メールアドレスの配信停止
----------------------------------------------
'.$rtn_dellurl = f_get_delurl($db_conn,$MAIL);

$message_btm .= "

LOTO7-FaceApGleZon.
";
				// if(mbstrlen($DM_ADstring)>1){$DM_ADstring = $dm_header.$DM_ADstring;}
				//メール送信
				$rtn = f_send_mail($MAIL, $subjectML, $message_top .$st_link.$DM_ADstring. $message_btm,$from_add,$from_name);
				if ($rtn=="NG")
				{
					// f_mail_err_writer($db_conn,$MAIL);
	 				print "メール送信に失敗しました。<BR>¥n";
				}else{
					//メール送信フラグ
					f_update_user_sendflg($db_conn,$MAIL);
				}
			}
		}
		return "OK<BR>¥n";
	}else{
		 return "DB失敗。<BR>¥n";
	}
}
//////////////////////////////////
//　当選更新
/////////////////////////////////
function f_up_bingo($db_conn,$cnt,$no1,$no2,$no3,$no4,$no5,$no6,$no7,$b1,$b2,$amout1,$amout2,$amout3,$amout4,$amout5,$amout6)
{
	$atari_cnt = 0;
	$sql = "select id,cnt,no1,no2,no3,no4,no5,no6,no7 from loto7_user_log where cnt = '$cnt' and per = 0 order by id desc";
	$result = mysql_query($sql,$db_conn);
	if($result)
	{
		while($link = mysql_fetch_row($result))
		{
			list( $rtn_id,$rtn_cnt,$rtn_no1,$rtn_no2,$rtn_no3,$rtn_no4,$rtn_no5,$rtn_no6,$rtn_no7) = $link;
			$exm_array = array($no1,$no2,$no3,$no4,$no5,$no6,$no7,$rtn_no1,$rtn_no2,$rtn_no3,$rtn_no4,$rtn_no5,$rtn_no6,$rtn_no7);
			$bonus_array = array($rtn_no1,$rtn_no2,$rtn_no3,$rtn_no4,$rtn_no5,$rtn_no6,$rtn_no7);

			$ch_array = array_count_values($exm_array);
			foreach ($ch_array as $key => $value)
			{
  				if($value==2){//当選
  					$atari_cnt = $atari_cnt + 1;
  				}
			}

			switch ($atari_cnt)
			{
				case 3:
					//ボーナス一致$b1,$b2
					$rtn_ch = f_bonus_ch($bonus_array,$b1,$b2);
					if($rtn_ch=="on")
					{
						f_update_user_log($db_conn,$rtn_id,6,$amout6);//2等
					}
					break;
				case 4:
					f_update_user_log($db_conn,$rtn_id,5,$amout5);//5等
					break;
				case 5:
					f_update_user_log($db_conn,$rtn_id,4,$amout4);//4等
					break;
				case 6://6個一致
					//ボーナス一致$b1,$b2
					$rtn_ch = f_bonus_ch($bonus_array,$b1,$b2);
					if($rtn_ch=="on")
					{
						f_update_user_log($db_conn,$rtn_id,2,$amout2);//2等
					}else{
						f_update_user_log($db_conn,$rtn_id,3,$amout3);//3等
					}
					break;
				case 7: //7個全て一致
					f_update_user_log($db_conn,$rtn_id,1,$amout1);//1等
					break;
				default:
					# code...
					break;
			}
			$atari_cnt = 0;
		}
	}
	return $rtn_st;
}
////////////////
// メール送信フラグ
////////////////
function f_update_user_sendflg($db_conn,$mail)
{
	$sql = "UPDATE `loto7_user` SET `send_flg` = 'on' WHERE `mail` = '$mail'";
	$result = mysql_query($sql, $db_conn);
}
////////////////
// メール送信フラグリセット
////////////////
function f_update_user_mailflg($db_conn)
{
	$sql = "UPDATE `loto7_user` SET `send_flg` = 'off' WHERE `send_flg` = 'on'";
	$result = mysql_query($sql, $db_conn);
}
////////////////
// 予測成績アップデート
////////////////
function f_update_user_log($db_conn,$id,$per,$amount)
{
	$sql = "UPDATE `loto7_user_log` SET `per` = '$per', `amount` = $amount WHERE `loto7_user_log`.`id` = '$id' LIMIT 1";
	$result = mysql_query($sql, $db_conn);
}
//////////////
// 予測成績ゲット当選回数＆金額合計
//////////////
function f_get_user_log_result($db_conn)
{
	$rtn_array = array();
	$sql = 'SELECT count(`id`) , sum(`amount`) FROM `loto7_user_log` where `per` <> 0';
	$result = mysql_query($sql,$db_conn);
	if($result)
	{
		while($link = mysql_fetch_row($result))
		{
			list( $result_cnt,$result_amount) = $link;
			$rtn_array['result_cnt'] = $result_cnt;
			$rtn_array['result_amount'] = $result_amount;
		}
	}
	return $rtn_array;
}
//////////////
// 予測成績ゲット　当該等件数＆金額
//////////////
function f_get_user_log_result_pre($db_conn,$per)
{
	$rtn_array = array();
	$sql = "SELECT count(`id`) , sum(`amount`) FROM `loto7_user_log` where `per` = '$per'";
	$result = mysql_query($sql,$db_conn);
	if($result)
	{
		while($link = mysql_fetch_row($result))
		{
			list($result_cnt,$result_amount) = $link;
			$rtn_array['result_per_cnt'] = $result_cnt;
			$rtn_array['result_per_amount'] = $result_amount;
		}
	}
	return $rtn_array;
}
///
function f_get_cnt($db_conn)
{
	$rtn_array = array();
	$sql = "SELECT count(`id`) FROM `loto7_user_log` ";
	$result = mysql_query($sql,$db_conn);
	if($result)
	{
		while($link = mysql_fetch_row($result))
		{
			list( $result_cnt) = $link;
			$rtn_array['per_all'] = $result_cnt;
		}
	}
	return $rtn_array;
}
//////
// ボーナスチェック
///////////
function f_bonus_ch($arr,$b1,$b2)
{
	$rtn_flg = "off";
	$rtn = array_search($b1, $arr);
	if($rtn===false){}else{$rtn_flg="on";}
	$rtn = array_search($b2, $arr);
	if($rtn===false){}else{$rtn_flg="on";}
	return $rtn_flg;
}
////////////////////////////////////////
//パワーナンバライター
////////////////////////////////////////
function f_get_defprice_writter($db_conn, $NO)
{
	$arymakerid = array();
	$sql = "SELECT count(cnt) FROM  `loto7_result` WHERE  `no1` = '$NO' OR  `no2` ='$NO' OR  `no3` ='$NO' OR  `no4` ='$NO' OR  `no5` ='$NO' OR  `no6` ='$NO' OR  `no7` ='$NO'";
	$tbl_tmp = mysql_query($sql, $db_conn);
	if($tbl_tmp)
	{
		while($rec_tmp = mysql_fetch_row($tbl_tmp))
		{
			list($stimateno) = $rec_tmp;
		}
		$rtn_value = "OK";
		$result = mysql_query("UPDATE `loto7_power` SET `sum` = '$stimateno' WHERE `no` ='$NO'", $db_conn);
		if(!$result)
		{
			$rtn_value = "NG";
		}
		return $rtn_value;
	}
	return $rtn_value;
}