<?php
require_once("lib/mysql-ini.php");
require_once("lib/lib.php");

function f_getloto7result_test($db_conn)
{
	$exm_cnt_arr = f_get_latest($db_conn);
	$exm_cnt = 63;
	$exm_cnt = $exm_cnt+1;
	$exm_st = "処理無し";
	//
	$seekposCNT = 0;
	$buf = "";
	$rdf_url = "";
	$st_gettag = "";
	// HTMLの指定
	$rdf_url = "http://www.mizuhobank.co.jp/takarakuji/loto/loto7/index.html";
	$buf = file_get_contents($rdf_url);
	$buf = mb_convert_encoding($buf,'utf-8','auto');
	//第何回
	$rtn_count = f_cut_html_parse($buf,0,'<th colspan="7" class="center bgf7f7f7">第','回</th>');
	$rtn_next_pos = f_cut_html_parse_pos($buf,0,'<th colspan="6" class="center bgf7f7f7">第','回</th>');

	if($exm_cnt==$rtn_count)
	{
		$exm_st = "処理開始";
		//抽選日
		$rtn_date = f_cut_html_parse($buf,$rtn_next_pos,'<td colspan="7" class="center">','</td>');
		// "A" という文字列を "×" に置換する
		$rtn_date = str_replace("年", "/", $rtn_date);
		$rtn_date = str_replace("月", "/", $rtn_date);
		$rtn_date = str_replace("日", "", $rtn_date);
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td colspan="7" class="center">','</td>');
// 		//本数字1
		$rtn_hon1 = f_cut_html_parse($buf,$rtn_next_pos,'<td class="center">','</td>');
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td class="center">','</td>');
// 		//本数字2
		$rtn_hon2 = f_cut_html_parse($buf,$rtn_next_pos,'<td class="center">','</td>');
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td class="center">','</td>');
// 		//本数字3
		$rtn_hon3 = f_cut_html_parse($buf,$rtn_next_pos,'<td class="center">','</td>');
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td class="center">','</td>');
		//本数字4
		$rtn_hon4 = f_cut_html_parse($buf,$rtn_next_pos,'<td class="center">','</td>');
echo "<br>".$rtn_hon4;
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td class="center">','</td>');
		//本数字5
		$rtn_hon5 = f_cut_html_parse($buf,$rtn_next_pos,'<td class="center">','</td>');
echo "<br>".$rtn_hon5;
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td class="center">','</td>');
		//本数字6
		$rtn_hon6 = f_cut_html_parse($buf,$rtn_next_pos,'<td class="center">','</td>');
echo "<br>".$rtn_hon6;
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td class="center">','</td>');
		// //本数字7
		$rtn_hon7 = f_cut_html_parse($buf,$rtn_next_pos,'<td class="center">','</td>');
echo "<br>".$rtn_hon7;
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td class="center">','</td>');
		//B1
		$rtn_b1 = f_cut_html_parse($buf,$rtn_next_pos,'<td class="center green">(',')</td>');
echo "<br>".$rtn_b1;
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td class="center green">(',')</td>');
		//B2
		$rtn_b2 = f_cut_html_parse($buf,$rtn_next_pos,'<td class="center green">(',')</td>');
echo "<br>".$rtn_b2;
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td class="center green">(',')</td>');

		//
		$rtn_amount_dummy = f_cut_html_parse($buf,$rtn_next_pos,'<td colspan="3" class="right">','口</td>');
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td colspan="3" class="right">','口</td>');
		$rtn_amount1 = f_cut_html_parse($buf,$rtn_next_pos,'<td colspan="4" class="right">','円</td>');
		$rtn_amount1 = str_replace(",", "", $rtn_amount1);
	echo "<br>".$rtn_amount1;
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td colspan="4" class="right">','円</td>');
		//
		$rtn_amount_dummy = f_cut_html_parse($buf,$rtn_next_pos,'<td colspan="3" class="right">','口</td>');
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td colspan="3" class="right">','口</td>');
		$rtn_amount2 = f_cut_html_parse($buf,$rtn_next_pos,'<td colspan="4" class="right">','円</td>');
		$rtn_amount2 = str_replace(",", "", $rtn_amount2);
	// echo "<br>".$rtn_amount2;
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td colspan="4" class="right">','円</td>');
	//
		$rtn_amount_dummy = f_cut_html_parse($buf,$rtn_next_pos,'<td colspan="3" class="right">','口</td>');
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td colspan="3" class="right">','口</td>');
		$rtn_amount3 = f_cut_html_parse($buf,$rtn_next_pos,'<td colspan="4" class="right">','円</td>');
		$rtn_amount3 = str_replace(",", "", $rtn_amount3);
	// echo "<br>".$rtn_amount3;
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td colspan="4" class="right">','円</td>');
	//
		$rtn_amount_dummy = f_cut_html_parse($buf,$rtn_next_pos,'<td colspan="3" class="right">','口</td>');
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td colspan="3" class="right">','口</td>');
		$rtn_amount4 = f_cut_html_parse($buf,$rtn_next_pos,'<td colspan="4" class="right">','円</td>');
		$rtn_amount4 = str_replace(",", "", $rtn_amount4);
// echo "<br>".$rtn_amount4;
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td colspan="4" class="right">','円</td>');
		//
		$rtn_amount_dummy = f_cut_html_parse($buf,$rtn_next_pos,'<td colspan="3" class="right">','口</td>');
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td colspan="3" class="right">','口</td>');
		$rtn_amount5 = f_cut_html_parse($buf,$rtn_next_pos,'<td colspan="4" class="right">','円</td>');
		$rtn_amount5 = str_replace(",", "", $rtn_amount5);
// echo "<br>".$rtn_amount5;
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td colspan="4" class="right">','円</td>');
		//
		$rtn_amount_dummy = f_cut_html_parse($buf,$rtn_next_pos,'<td colspan="3" class="right">','口</td>');
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td colspan="3" class="right">','口</td>');
		$rtn_amount6 = f_cut_html_parse($buf,$rtn_next_pos,'<td colspan="4" class="right">','円</td>');
		$rtn_amount6 = str_replace(",", "", $rtn_amount6);
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td colspan="4" class="right">','円</td>');
// echo "<br>".$rtn_amount6;
		//
		$rtn_next_pos = mb_strpos($buf, '<th>販売実績額</th>',$rtn_next_pos,'UTF-8');//スタート位置検索
		$rtn_dummy = f_cut_html_parse($buf,$rtn_next_pos,'<td colspan="7" class="right">','円</td>');
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td colspan="7" class="right">','円</td>');
// echo "<br>".$rtn_dummy;

		//キャリーおバー
		$rtn_next_pos = mb_strpos($buf, '<th>キャリーオーバー</th>',$rtn_next_pos,'UTF-8');//スタート位置検索
		$rtn_carry = f_cut_html_parse($buf,$rtn_next_pos,'<td colspan="7" class="right">','円</td>');
		$rtn_carry = str_replace(",", "", $rtn_carry);
		$rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos,'<td colspan="7" class="right">','円</td>');

		$rtn = f_result_writter($db_conn,$rtn_count, $rtn_date, $rtn_hon1, $rtn_hon2, $rtn_hon3, $rtn_hon4, $rtn_hon5, $rtn_hon6, $rtn_hon7, $rtn_b1, $rtn_b2, $rtn_amount1,$rtn_amount2,$rtn_amount3,$rtn_amount4,$rtn_amount5,$rtn_amount6, $rtn_carry);



		$buf = "";
		//当選番号案内メール
	}
	$exm_st = "OK";
	return $exm_st;
}
//
///////////////////////////////////////////
// データベースに接続
if(!$db_conn = mysql_connect($host, $user, $pass)){
print("データベースにアクセスできません。");
exit;
}
$rtn = mysql_query("SET NAMES sjis" , $db_conn);
mysql_select_db($dbname);

$rtn = f_getloto7result_test($db_conn);
echo $rtn;

?>