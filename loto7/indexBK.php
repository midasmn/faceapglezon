<?php
require_once("lib/mysql-ini.php");
require_once("lib/lib.php");
//
$title = "LOTO7 - FaceApGleZon";
$footer_title = "FaceApGleZon.";
$keywords = "LOTO7,ロト7,宝くじ,当選番号,メール配信,予測,予想";
$description = "LOTO7の当選番号予想＆抽選結果メール配信サイト。ゲイル理論と独自のランダムシードデスティニーシステムで当選番号を予測します。";
//
$footer = '<div data-role="footer">';
$footer .= '<h4>'.date(Y).'　'.$footer_title.'</h4>';
$footer .= '</div>';
///////////////////////////////////////////
// データベースに接続
if(!$db_conn = mysql_connect($host, $user, $pass)){
print("データベースにアクセスできません。");
exit;
}
$rtn = mysql_query("SET NAMES sjis" , $db_conn);
mysql_select_db($dbname);

//予測ゲット
$rtn_pfo = f_get_user_log_result($db_conn);
$result_cnt = $rtn_pfo['result_cnt'];//当選件数
$result_amount = $rtn_pfo['result_amount'];//当選金額
$relult_all = f_get_cnt($db_conn);
$relult_all_all = $relult_all['per_all'];
//
$per_array1 = f_get_user_log_result_pre($db_conn,1);
$result_per_cnt1 = $per_array1['result_per_cnt'];
$result_per_amount1 = $per_array1['result_per_amount'];
//
$per_array2 = f_get_user_log_result_pre($db_conn,2);
$result_per_cnt2 = $per_array2['result_per_cnt'];
$result_per_amount2 = $per_array2['result_per_amount'];
//
$per_array3 = f_get_user_log_result_pre($db_conn,3);
$result_per_cnt3 = $per_array3['result_per_cnt'];
$result_per_amount3 = $per_array3['result_per_amount'];
//
$per_array4 = f_get_user_log_result_pre($db_conn,4);
$result_per_cnt4 = $per_array4['result_per_cnt'];
$result_per_amount4 = $per_array4['result_per_amount'];
//
$per_array5 = f_get_user_log_result_pre($db_conn,5);
$result_per_cnt5 = $per_array5['result_per_cnt'];
$result_per_amount5 = $per_array5['result_per_amount'];
//
$per_array6 = f_get_user_log_result_pre($db_conn,6);
$result_per_cnt6 = $per_array6['result_per_cnt'];
$result_per_amount6 = $per_array6['result_per_amount'];

$mode = $_POST['mode'];
$mode2 = $_POST['mode2'];
if($mode2=="mailentry")
{
  $MAIL = $_POST['MAIL'];
  $DM = $_POST['DM'];
  $rtn_st = f_entry_loto7_mail($db_conn,$MAIL,$DM); //メール登録
}
/////////////////////////////////////////////////////
$latest_arr = f_get_latest($db_conn);
$latestNO = $latest_arr['cnt'];
$nextNO = $latestNO+1;
$cnt_amount = $latest_arr['amount'];
$cnt_carry = $latest_arr['carry'];
$cnt_date = $latest_arr['cnt_date'];
$today = getdate();
if(!$cnt_date){$cnt_date=$today['year']."/".$today['mon'].'/'.$today['mday'];}
///////////////////////////////////////////////
$powerNo_arr = f_get_powerNO($db_conn);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.0/jquery.mobile-1.3.0.min.css" />
<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
<script>
$(document).bind('mobileinit', function(){
$.mobile.ajaxEnabled = false;
});
</script>
<script src="http://code.jquery.com/mobile/1.3.0/jquery.mobile-1.3.0.min.js"></script>
<title><?=$title?></title>
<!-- <link href='http://fonts.googleapis.com/css?family=Anton' rel='stylesheet' type='text/css'> -->
<meta name="keywords" content="<?=$keywords?>" />
<meta name="description" content="<?=$description?>" />
<meta name="apple-touch-fullscreen" content="YES" />
<meta name="format-detection" content="telephone=no" />
<!-- OG -->
<meta property="og:title" content="LOTO7-第<?=$nextNO?>回当選番号" />
<meta property="og:type" content="website" />
<meta property="og:description" content="LOTO7の当選番号予想＆抽選結果メール配信サイト。" />
<meta property="og:url" content="http://faceapglezon.info/loto7/" />
<meta property="og:image" content="http://faceapglezon.info/loto7/apple-touch-icon-144×144.png" />
<meta property="og:site_name" content="LOTO7-当選番号予測＆メール配信" />
<meta property="fb:app_id" content="FaceApGleZon" />
<!-- OG -->
<link href="http://faceapglezon.info/loto7/apple-touch-icon-144×144.png" rel="apple-touch-icon-144×144" />
<link href="http://faceapglezon.info/loto7/apple-touch-icon-114×114.png" rel="apple-touch-icon-114×114" />
<link href="http://faceapglezon.info/loto7/apple-touch-icon-72×72.png" rel="apple-touch-icon-72×72" />
<link href="http://faceapglezon.info/loto7/apple-touch-icon.png" rel="apple-touch-icon" />
<link rel="shortcut icon" href="favicon.ico" >

<link rel="stylesheet" href="http://faceapglezon.info/loto7/css/base.css" />
</head>
<body onLoad="document.fm.MAIL.focus()">
<!--トップページ-->
<div data-role="page" id="home">
    <div data-role="header">
        <h1>LOTO7当選番号メール配信</h1>
<!--     <a href="#home" data-icon="home">ホーム</a>
    <a href="/" data-icon="home" data-iconpos="notext" class="ui-btn-right">ホーム</a>
 -->    <a href="#entry" data-icon="plus" class="ui-btn-right">メール登録</a>
    </div>

    <div data-role="content">
      <?php
      if($mode=="read")
      {
        echo '<p>LOTO7次回(第'.$nextNO.'回)当選番号予測</p>';
        //予測開始
        $winCNT_arr = f_get_destiny_no($db_conn,$nextNO);
// echo var_dump($winCNT_arr);
// exit;
        //予測記録
        $rtn_log_writer_st = f_log_writter($db_conn,$user_id,$nextNO,$winCNT_arr);
        //画像のみ
//echo $rtn_log_writer_st;
        foreach ($winCNT_arr as $key => $value)
        {
          if($key==0||$key==1||$key==2||$key==3||$key==4||$key==5)
          {
            if (strlen($value) == 1)
            {
              $numberURL = f_get_number($value);
              echo '<img src="'.$numberURL.'" width=33 height=33 >-';
            }else{
              $numberURL = f_get_number(substr($value,0,1));
              echo '<img src="'.$numberURL.'" width=33 height=33 >';
              $numberURL2 = f_get_number(substr($value,1,1));
              echo '<img src="'.$numberURL2.'" width=33 height=33>-';
            }
          }elseif($key==6)
          {
            if (strlen($value) == 1)
            {
              $numberURL = f_get_number($value);
              echo '<img src="'.$numberURL.'" width=33 height=33 >';
            }else{
              $numberURL = f_get_number(substr($value,0,1));
              echo '<img src="'.$numberURL.'" width=33 height=33 >';
              $numberURL2 = f_get_number(substr($value,1,1));
              echo '<img src="'.$numberURL2.'" width=33 height=33>';
            }
          }
        }
        //文字
        ?>
    <div class="number-box">
      <div data-role="collapsible" data-collapsed="true" data-inline="true">
        <h3>読みにくい場合...</h3>
        <div class="clear"></div>
        <div id="no_area">
          <ul>
            <li><div id="star-five_red"></div></li>
            <li><div id="star-five_blue"></div></li>
            <li><div id="star-five_orange"></div></li>
            <li><div id="star-five_red"></div></li>
            <li><div id="star-five_blue"></div></li>
            <li><div id="star-five_orange"></div></li>
            <li><div id="star-five_red"></div></li>
          </ul>
        </div>
        <div id="no">
          <ul>
            <li><span><?=$winCNT_arr[0]?></span></li>
            <li><span><?=$winCNT_arr[1]?></span></li>
            <li><span><?=$winCNT_arr[2]?></span></li>
            <li><span><?=$winCNT_arr[3]?></span></li>
            <li><span><?=$winCNT_arr[4]?></span></li>
            <li><span><?=$winCNT_arr[5]?></span></li>
            <li><span><?=$winCNT_arr[6]?></span></li>
          </ul>
        </div>
        <div class="clear"></div>
      </div>
    </div>
    <div class="clear"></div>
    <hr>
    <form action="" method="post">
      <input type="hidden" size="120"name="mode" value="read">
      <input type="submit" value="再度次回当選番号予測" data-theme="e">
      </form><br>
      <?php
      }else{//予想モードじゃない場合
      ?>
        <p>LOTO7第<?=$latestNO?>回(<?=$cnt_date?>)当選番号</p>
    <div id="no_area">
      <ul>
        <li><div id="star-five_red"></div></li>
        <li><div id="star-five_blue"></div></li>
        <li><div id="star-five_orange"></div></li>
        <li><div id="star-five_red"></div></li>
        <li><div id="star-five_blue"></div></li>
        <li><div id="star-five_orange"></div></li>
        <li><div id="star-five_red"></div></li>
      </ul>
    </div>
    <div id="no">
      <ul>
        <li><span><?=$latest_arr[1]?></span></li>
        <li><span><?=$latest_arr[2]?></span></li>
        <li><span><?=$latest_arr[3]?></span></li>
        <li><span><?=$latest_arr[4]?></span></li>
        <li><span><?=$latest_arr[5]?></span></li>
        <li><span><?=$latest_arr[6]?></span></li>
        <li><span><?=$latest_arr[7]?></span></li>
      </ul>
    </div>
    <div class="clear"></div>
    <div id="bonus-no">
      <ul>
        <li><span id="bonus"><?=$latest_arr[b]?></span></li>
        <li><span id="bonus"><?=$latest_arr[b2]?></span></li>
      </ul>
    </div>
    <div class="clear"></div>
    <?php
    if($cnt_carry>1)
    {
      echo '<hr><p>キャリーオーバー：'.number_format($cnt_carry).'円</p>';

    }else{
      echo '<hr><p>1等賞金：'.number_format($cnt_amount).'円</p>';
    }
    echo '<hr>';
    echo '<form action="" method="post">';
    echo '<input type="hidden" size="120"name="mode" value="read">';
    echo '<input type="submit" value="次回当選番号予測" data-theme="e">';
    echo '</form><br>';
    }//予測モード以下
    ?>

    <ul data-role="listview">
      <li data-role="list-divider"></li>
      <li data-icon="star"><a href="#performance">予測成績</a></li>
      <li data-icon="grid"><a href="#power">パワー数字(出現回が多い数字)</a></li>
      <li data-icon="info"><a href="#about">LOTO7について</a></li>
      <li><a href="http://www.mizuhobank.co.jp/takarakuji/loto/loto7/index.html">みずほ銀行宝くじコーナ</a></li>
    </ul>
  </div>
    <?=$footer?>
</div>

<!-- アバウト-->
<div data-role="page" id="about" data-add-back-btn="true" data-back-btn-text="戻る">
    <div data-role="header">
        <h1>LOTO7について</h1>
        <!-- <a href="#home" data-icon="home">ホーム</a> -->
        <a href="#home" data-icon="home" data-iconpos="notext" class="ui-btn-right">ホーム</a>
    </div>

  <div data-role="content">
    <hr>
    <P>LOTO7は誰でも当たり券を簡単（無料）に手に入れることができるだけでなく、7個の当たり番号をマークするだけで最高8億円もらえる素晴らしいクジです。</P>
    <P>当サイトでは、LOTOクジで有名なゲイル理論と独自のランダムシードデスティニーシステムで当選番号を予測します。</P>

    ・予測のルール
    <P>1.前回当選数字9個（本数字7個＋ボーナス数字2個）の中から、後追い数字となりえるものをにひとつ抽選します。</p>
    <P>2.上記数字を除いた、末尾下一桁が同じ数字のペアを抽選します。</p>
    <P>3.上記数字を除いた、隣り合った連続数字ペアを抽選します。</p>
    <P>4.上記数字を除いた、当選回数の多いパワー数字からひとつ抽選します。</p>
    <P>5.上記数字を除いた、抽選時間を種に運命数をランダムにひとつ抽選します。</p>
    <P>※すべての抽選は日付等を種にランダムに選んでいます。</p>
    <p></p>
    LOTO7とは　※出典=wikipedia
    <li>01から37までの37個の数字の中から異なる7個を選択するものである。抽せんは、12月31日 - 1月3日を除く毎週金曜日18:45 (JST)</li>
    <li>数字の組み合わせは10,295,472通りあるため、数字選択式のくじの中で最も難易度が高い。</li>
    <li>1等
    申込数字が本数字7個全て一致するもの。見込み当せん金は約4億円になる。</li>
    <li>2等
    申込数字が本数字6個一致し、さらにボーナス数字2個のうち1個一致するもの。見込み当せん金は約1000万円になる。</li>
    <li>3等
    申込数字が本数字6個一致するもの。見込み当せん金は約100万円になる。</li>
    <li>4等
    申込数字が本数字5個一致するもの。見込み当せん金は約12500円になる。</li>
    <li>5等
    申込数字が本数字4個一致するもの。見込み当せん金は約2000円になる。</li>
    <li>6等
    申込数字が本数字3個一致し、さらにボーナス数字2個のうち2個もしくは1個一致するもの。見込み当せん金は約1000円になる。</li>
  </div>
     <!-- フッター -->
    <?=$footer?>
</div>

<!-- パワー数字 -->
<div data-role="page" id="power" data-add-back-btn="true" data-back-btn-text="戻る">
    <div data-role="header">
        <h1>パワー数字</h1>
        <a href="#home" data-icon="home" data-iconpos="notext" class="ui-btn-right">ホーム</a>
    </div>

    <div data-role="content">
      <p>パワー数字(出現回数が多い数字)</p>
      <table border=0 cellpadding=0 cellspacing=10>
        <tr id="trtitle">
          <td id="tdtitle">NO</td><td id="tdtitle">回</td><td id="tdtitle">NO</td><td id="tdtitle">回</td>
          <td id="tdtitle">NO</td><td id="tdtitle">回</td><td id="tdtitle">NO</td><td id="tdtitle">回</td>
          <td id="tdtitle">NO</td><td id="tdtitle">回</td>
        </tr>
        <tr>
        <?php
        $col=5;
        $i=1;
        foreach ($powerNo_arr as $key => $value)
        {
          if($i % $col ==0){  //割り切れる
            echo '<td id="tdno">'.number_format($key).'</td><td id="tdcnt">'.number_format($value).'</td></tr><tr>';
          }else{
            echo '<td id="tdno">'.number_format($key).'</td><td id="tdcnt">'.number_format($value).'</td>';
          }
          $i++;
        }
        ?>
        </tr>
    </table>
  </div>
    <!-- フッター -->
    <?=$footer?>
</div>

<!-- 登録-->
<div data-role="page" id="entry" data-add-back-btn="true" data-back-btn-text="戻る">
    <div data-role="header">
        <h1>メール登録</h1>
        <a href="#home" data-icon="home" data-iconpos="notext" class="ui-btn-right">ホーム</a>
    </div>

    <div data-role="content">
      <P>毎週金曜日18:45分の抽選番号確定後に結果をメール配信します。</P>
      <?php
      if($mode2=="mailentry")
      {
        if($rtn_st=="OK")
        {
                //メール配信成功
          echo '<p>メール登録ありがとうございます。</p>';
          echo '<p>毎週金曜日18:45分の抽選番号確定後に結果をメール配信します。</p>';
        }else{
           echo $rtn_st;
        }
      }else
      {
      ?>
      <form action="#entry" method="post" name="fm">
        <div data-role="fieldcontain">
          <script type="text/javascript">
<!--
// ロード時に自動でカーソルを合わせる
$(document).ready( function() {
$("#MAIL").focus()
});
//-->
</script>
          <label for="MAIL" >メールアドレス:</label>
          <input type="email" name="MAIL" id="MAIL" value="<?=$MAIL?>" data-theme="c">
        </div>



        <div data-role="fieldcontain">
            <label for="DM">LOTO7に関するお得な情報:</label>
            <select name="DM" id="DM" data-role="slider">
                <option value="on">受取る</option>
                <option value="off">不要</option>
            </select>
        </div>

          <input type="hidden" size="120"name="mode2" value="mailentry">
          <input type="submit" value="メール登録" data-theme="b">

      </form>
      <?php
      }
      ?>
   </div>
   <!-- フッター -->
    <?=$footer?>
</div>


<!-- 成績-->
<div data-role="page" id="performance" data-add-back-btn="true" data-back-btn-text="戻る">
    <div data-role="header">
        <h1>LOTO7予測成績</h1>
        <!-- <a href="#home" data-icon="home">ホーム</a> -->
        <a href="#home" data-icon="home" data-iconpos="notext" class="ui-btn-right">ホーム</a>
    </div>

  <div data-role="content">
    <p>LOTO7予測成績</p>
    総予測件数：<?=number_format($relult_all_all)?>件
    <hr>
    当選：<?=number_format($result_cnt)?>件(当選金額：<?=number_format($result_amount)?>円)
    <hr>
    1等：<?=number_format($result_per_cnt1)?>件(当選金額：<?=number_format($result_per_amount1)?>円)<br>
    2等：<?=number_format($result_per_cnt2)?>件(当選金額：<?=number_format($result_per_amount2)?>円)<br>
    3等：<?=number_format($result_per_cnt3)?>件(当選金額：<?=number_format($result_per_amount3)?>円)<br>
    4等：<?=number_format($result_per_cnt4)?>件(当選金額：<?=number_format($result_per_amount4)?>円)<br>
    5等：<?=number_format($result_per_cnt5)?>件(当選金額：<?=number_format($result_per_amount5)?>円)<br>
    6等：<?=number_format($result_per_cnt6)?>件(当選金額：<?=number_format($result_per_amount6)?>円)
    <hr>

  </div>
     <!-- フッター -->
    <?=$footer?>
</div>

<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-39613103-1']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
</body>
</html>