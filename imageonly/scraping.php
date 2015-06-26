<?php
require_once("lib/mysql-ini.php");
require_once("lib/lib_upload.php");
require_once("lib/mail.php");
require ('lib/simple_html_dom.php');

// データベースに接続
if(!$db_conn = mysql_connect($host, $user, $pass))
{
  print("データベースにアクセスできません。");
  exit;
}
mysql_select_db($dbname);

//インサート
function f_insert_sns($db_conn,$rtn_title,$URL,$og_image,$rtn_facebook,$rtn_twitter,$rtn_google,$rtn_linkedin,$rtn_youtube,$rtn_tumblr,$rtn_pinterest)
{
  mysql_set_charset('utf8'); // ←変更
  $sql = "INSERT INTO `sns` (`title`, `url`, `img`, `FB`, `TW`, `GP`, `IN`, `YT`, `TB`, `PN`) VALUES ('$rtn_title','$URL','$og_image','$rtn_facebook','$rtn_twitter','$rtn_google','$rtn_linkedin','$rtn_youtube','$rtn_tumblr','$rtn_pinterest')";
  $result = mysql_query($sql, $db_conn);
  if(!$result)
  {
    $rtn = "NG";
  }else{
    $rtn = "OK";
  }
  return $rtn;
}
////////////////////////////////////////////////////////////////////////////////
$textUpload = "";
$entry_st = "";
/////// アップロード
$URL= $_POST['URL'];
$rtn_img_st = "";
if($URL)
{
  if (preg_match('/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $URL)) 
  {
    // $textUpload =   '正しいURLです。';
    $html = file_get_html($URL);
    $rtn = array();
    $rtn_href = array();
    $rtn_url= $URL;
    $rtn = parse_url($rtn_url);
    $rtn_host = $rtn['scheme'].'://'.$rtn['host'];
    // タイトル取得
     foreach ($html->find('title') as $element)
    {
      // $rtn['title'] = $element->plaintext; 
      $rtn_title = $element->plaintext; 
    }
    // H1タグ取得
    foreach($html->find('h1') as $element)
    {
      // $rtn['h1']  = $element->plaintext;
      $rtn_h1 = $element->plaintext;
    }
    /////////////////////////////
    // 画像全部取得
    /////////////////////////////
    $i=0;
    foreach ($html->find('img') as $element)
    {
      $rtn_tmp = $element->src;
      if(substr($rtn_tmp, 0,4)=="http"||substr($rtn_tmp, 0,5)=="https")//http(s)がない場合
      {
        $rtn_img['img'][$i]=$rtn_tmp;//そのまま
      }else{
        // //の場合
        if(substr($rtn_tmp, 0,2)=="//")
        {
          $rtn_img['img'][$i]="http:".$rtn_tmp;
        }else{
          $rtn_img['img'][$i]=$rtn_host.$rtn_tmp;
        }
      }
      // 
      $rtn_tmp = "";
      $i++;
    }
    $rtn_img_st = $rtn_img;


    /////////////////////////////
    // 全文タグ抜き
    /////////////////////////////
    $html_st = $html->plaintext;

    $html->clear();
    unset($rtn);
    /////////////////////////////
    // 画像パス
    /////////////////////////////
    $cnt = count($rtn_img_st['img']);
    if($cnt>0) 
    {
      // リモートサイズ取得>MAXで縮小
      $EXM_MAX = 200;
      for ($i=0;$i<=$cnt;$i++) 
      { 
        // サイズを取得
        list($img_width,$img_height) = @getimagesize($rtn_img_st['img'][$i]);
        // MAX
        $max = max($img_width,$img_height);
        if($max<10) //10以下は捨てる
        {
        }else{
          // リサイズ
          if($max<$EXM_MAX)
          {
          }else{
           //300にリサイズ
            $rtn_arr = f_get_resize_length_without_file($img_width,$img_height,$EXM_MAX,$EXM_MAX);
            list($img_width, $img_height) = $rtn_arr;
          }
          // リモートサイズ取得>MAXで縮小
          $rtn_img_html_st .= '<img src="'.$rtn_img_st['img'][$i].'" width="'.$img_width.'" height="'.$img_height.'">';
        }
      }
      /////////////////////////////
      // .画像パス
      /////////////////////////////

      /////////////////////////////
      // 形態素解析&画像化
      /////////////////////////////
      // $html_st
//       $phrase = $html_st;
//       $json = json_decode(file_get_contents('http://yapi.ta2o.net/apis/mecapi.cgi?sentence='.urlencode($phrase).'&format=json'));
//       var_dump($json);
    }
    //
    // DB登録
    // $rtn = f_insert_sns($db_conn,$rtn_title,$URL,$og_image,$rtn_facebook,$rtn_twitter,$rtn_google,$rtn_linkedin,$rtn_youtube,$rtn_tumblr,$rtn_pinterest);
  } else {
    $textUpload =  '正しくないURLです。';
  } 
}else{
  $textUpload =  'URLを入力してください。';
}

if (preg_match('/^text\/html/', $_SERVER['HTTP_ACCEPT'])) : ?>
<!-- HTMLのとき -->
<div  class="col-md-12" style="margin-top:30px;" >
  <h3><?php echo $textUpload; ?></h3>
<!--   <h3><?php var_dump($textUpload) ; ?></h3> -->
</div>

<div class="row" style="margin-top:30px;" >
  <div class="col-md-12" >
      <?php
      if($rtn_title)
      {
        echo '<div style="width:100%;float:left;margin-right:10px;margin-top:10px;" class="input-group">';
        echo '<span class="h3 text-muted">'.$rtn_title.'</span>';
        echo '</div>';
      }
      if($rtn_h1)
      {
        echo '<div style="width:100%;float:left;margin-right:10px;margin-top:10px;" class="input-group">';
        echo '<span class="h3 text-muted">'.$rtn_h1.'</span>';
        echo '</div>';
      }
      if($rtn_url)
      {
        echo '<div style="width:100%;float:left;margin-right:10px;margin-top:10px;" class="input-group">';
        echo '<a class="h5" href="'.$rtn_url.'">'.$rtn_url.'</a>';
        echo '</div>';
      }
      if($rtn_img_st)
      {
        echo '<div style="width:100%;float:left;margin-right:10px;margin-top:10px;" class="input-group">';
        echo $rtn_img_html_st;
        echo '</div>';
      }
      if($html_st)
      {
        echo '<div style="width:100%;float:left;margin-right:10px;margin-top:10px;" class="input-group">';
        echo $html_st;
        echo '</div>';
      }

      
      ?>
  </div>
</div>

<!-- jsonのとき -->
<?php else: 
  header( 'Content-Type: application/json; charset=utf-8', true ); 
  echo json_encode( array("message" => "Upload is OK")  );
  endif; 
?>
