<?php

//Qdmailをロード
//require_once('qdmail.php');
// include_once "/lib/qdmail.php";
//Qdsmtpをロード
//（ドキュメントには、記述不要とかいてあるが、書かないとうまくいかないことがあった）
// require_once('qdsmtp.php');
// include_once "/lib/qdsmtp.php";

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
/////////////////////////////////////////
//
function  f_get_destiny_no($db_conn,$nextNO)
{
//////////////////////////////////////////////////////////////////
//前回数字支持
//////////////////////////////////////////////////////////////////
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
	f_without_no(&$base_arr ,$latest_no);//当該番号前後削除
	foreach ($letest_arr as $key => $value)
	{
		unset($base_arr[$value]);//抽選配列削除
	}
}
//////////////////////////////////////////////////////////////////
//連続ペア
//////////////////////////////////////////////////////////////////
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
				f_without_no(&$base_arr ,$get_count1);
			}else{$get_count2 = $get_count1 + 1;}
		}else
		{
			$rtn = array_search($get_count1 - 1, $base_arr);//配列候補検索
			if($rtn===false){//候補になければ候補削除
				f_without_no(&$base_arr ,$get_count1);
			}else{$get_count2 = $get_count1 - 1;}
		}
	}
	f_without_no(&$base_arr ,$get_count1);//一個目削除当該番号前後削除
	f_without_no(&$base_arr ,$get_count2);//２個目削除当該番号前後削除
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
	if($get_num1&&$get_num2)
	{
	array_push($winCNT_arr, $get_num1);	//当選番号配列に追加
	array_push($winCNT_arr, $get_num2);	//当選番号配列に追加
	f_without_no(&$base_arr ,$get_num1);//一個目削除当該番号前後削除
	f_without_no(&$base_arr ,$get_num2);//一個目削除当該番号前後削除
	}
}
//////////////////////////////////////////////////////////
//パワー数字取得処理
//////////////////////////////////////////////////////////
function f_get_power_no($db_conn,&$winCNT_arr,&$base_arr,$randamseed)
{
	while(!$rtn_rdm_no) ////パワー数字
	{
		$rtn_rdm_no = f_random_power($db_conn,$randamseed);//パワー数字取得
		if(in_array($rtn_rdm_no,$base_arr)){}else{$rtn_rdm_no="";}
	}
	array_push($winCNT_arr, $rtn_rdm_no);
	f_without_no($base_arr ,$rtn_rdm_no);//一個目削除当該番号前後削除
}
//////////////////////////////////////////////////////////
//ランダムシードデスティニー
//////////////////////////////////////////////////////////
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
	return $winCNT_arr;
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
//////////////////////////////////////////////
//パワー番号からランダムに一つ抜くだけ
//////////////////////////////////////////////
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
