<?php
require_once("lib/mysql-ini.php");
require_once("lib/lib_upload.php");
require_once("lib/mail.php");
// データベースに接続
if(!$db_conn = mysql_connect($host, $user, $pass))
{
  print("データベースにアクセスできません。");
  exit;
}
mysql_select_db($dbname);

////////////////////////////////////////////////////////////////////////////////
$textUpload = "";
$entry_st = "";
/////// アップロード
$cardtype= $_POST['cardtype'];
$ex_date= $_POST['ex_date'];
$mail= $_POST['mail'];

if($cardtype&&$ex_date&&$mail)
{
  //メールアドレスチェック
  $rnt = CheckEmailAddress($mail);
  if($rnt=="OK")
  {
    list($yy, $mm, $dd) = explode('/', $ex_date);// 文字列の分解
    $exm_day = $dd;
    $next_ex_date = date('Y/m/d', strtotime(date($ex_date) . '+1 year'));
    //
    $token = md5( $mail.'faceapglezon'.$cardtype.$ex_date);
    $rtn = f_insert_user($db_conn, $mail,$token,$cardtype,$ex_date,$exm_day,$token);
    if($rtn=="OK")
    {
      //メール配信文作成
      $subjectML = '[FaceApGleZon]実質無料クレジットカード通知リマインダー登録メール';
      $url = "http://faceapglezon.info/card/";
      $from_add = 'contact@faceapglezon.info';  //管理者アドレス
      $from_name = 'FaceApGleZon..';
      //クリアURL
      $exm_url = $url."exm.php?token=".$token;
      //削除用URL
      $del_url = $url."del.php?token=".$token;
      // 
      $message = $mail."さま". "

";
      $message .= "[FaceApGleZon]実質無料クレジットカード通知リマインダー登録を承りました。". "

";
      $message .= "まことにありがとうございます。". "

";
      $message .= "----------------------------------------------". "
";
      $message .= "▼登録内容". "
";
      $message .= "----------------------------------------------". "
";
      $message .= "・カード種類：".$cardtype."". "
";
      $message .= "・有効期限：".$ex_date."". "
";
      $message .= "・メールアドレス：".$mail."". "
";
      $message .= "----------------------------------------------". "
";
      $message .= "※毎月".$exm_day."日にお知らせメール（".$mail."宛）を配信します。". "
";
      $message .= "※下記URLでアクセスして無料条件クリアボタンを押すと本年度(".$ex_date."まで)のメール配信は停止します。". "
";
      $message .= "※".$ex_date."以降は次年度分(".$next_ex_date."期限)メール配信再開します。". "

";
      $message .= "----------------------------------------------". "
";
      $message .= "▼無料条件クリアURL". "
";
      $message .= "----------------------------------------------". "
";
      $message .= $exm_url."". "
";
      $message .= "※無料条件をクリアした時には上記URLをクリックしてください。". "






";

      // 
      $message .= "----------------------------------------------". "
";
      $message .= "▼登録情報の削除URL". "
";
      $message .= "----------------------------------------------". "
";
      $message .= $del_url."". "

";
      $message .= "FaceApGleZon". "
";


      //メール配信
      $rtn = f_send_mail($mail, $subjectML, $message,$from_add,$from_name);
      if ($rtn=="NG")
      {
        $textUpload ="メール送信に失敗しました。";
      }else{  
        // $textUpload ="OK";
      }
      //
      $textUpload .= '登録内容:';
      //
      $entry_st .= '<div class="row" style="margin-top:20px;" >';
      $entry_st .= '<div class="col-md-12" >';
      $entry_st .= '<h3 class="h4">カード種類：'.$cardtype.'</h3>';
      $entry_st .= '<h3 class="h4">有効期限：'.$ex_date.'</h3>';
      $entry_st .= '<h3 class="h4">メールアドレス：'.$mail.'</h3>';

      $entry_st .= '<p class="help-block">※毎月<b>'.$exm_day.'日</b>にお知らせメール（<b>'.$mail.'</b>宛）を配信します。</p>';
      $entry_st .= '<p class="help-block">※メール記載のURLでアクセスして無料条件クリアボタンを押すと<b>'.$ex_date.'</b>までメール配信は停止します。</p>';
      $entry_st .= '<p class="help-block">※<b>'.$ex_date.'</b>以降は次年度分(<b>'.$next_ex_date.'</b>期限)メール配信再開します。</p>';
      $entry_st .= '</div>';
      $entry_st .= '</div>';
    }else{
      $textUpload .= 'DB登録失敗しました。';
    }
  }else{
    $textUpload .= 'メールアドレスをご確認ください。';
  }
}else{
  $textUpload .= '未入力項目があります。';
}




if (preg_match('/^text\/html/', $_SERVER['HTTP_ACCEPT'])) : ?>
<!-- HTMLのとき -->
<div  class="col-md-12" style="margin-top:30px;" >
  <h3><?php echo $textUpload; ?></h3>
</div>

<?php echo $entry_st; ?>



<!-- jsonのとき -->
<?php else: 
  header( 'Content-Type: application/json; charset=utf-8', true ); 
  echo json_encode( array("message" => "Upload is OK")  );
  endif; 
?>
