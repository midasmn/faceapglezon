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

if($URL)
{
  if (preg_match('/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $URL)) 
  {
    // $textUpload =   '正しいURLです。';
    $html = file_get_html($URL);
    $rtn = array();
    $rtn_href = array();
    $rtn_url= $URL;
    // $rtn['title']  = $html->find('h1',0)->plaintext;
    // $rtn['description']  = $html->find('description',0)->innertext;
    foreach ($html->find('title') as $element)
    {
      // $rtn['title'] = $element->plaintext; 
      $rtn_title = $element->plaintext; 
    }
    foreach($html->find('h1') as $element)
    {
      // $rtn['h1']  = $element->plaintext;
      $rtn_h1 = $element->plaintext;
    }
    /////////////////////////////
    // SNSページ取得
    /////////////////////////////
    $i=0;
    foreach ($html->find('a') as $element)
    {
      
      $rtn_href['href'] [$i]= $element->href;
      $i++;
    }
    $href_cnt = count($rtn_href['href'] );
    for ($s=0; $s <= $href_cnt; $s++) 
    { 
      if(strpos($rtn_href['href'][$s], '//www.facebook.com') !==false )
      {
        if(strpos($rtn_href['href'][$s], '//www.facebook.com/share') !==false )
        {}else{
          $rtn_facebook = $rtn_href['href'][$s]; 
        }
      }
      if(strpos($rtn_href['href'][$s], '//twitter.com') !==false )
      {
        if(strpos($rtn_href['href'][$s], '//twitter.com/share') !==false )
        {}else{
          $rtn_twitter = $rtn_href['href'][$s];  
        }
      }
      if(strpos($rtn_href['href'][$s], '//plus.google.com') !==false )
      {
        if(strpos($rtn_href['href'][$s], '//plus.google.com/share') !==false )
        {}else{
          $rtn_google = $rtn_href['href'][$s];
        }
      }
      if(strpos($rtn_href['href'][$s], '.tumblr.com/') !==false )
      {
        $rtn_tumblr = $rtn_href['href'][$s];
      }
      if(strpos($rtn_href['href'][$s], '//pinterest.com/') !==false )
      {
        $rtn_pinterest = $rtn_href['href'][$s];
      }
      if(strpos($rtn_href['href'][$s], 'www.linkedin.com/company/') !==false )
      {
        $rtn_linkedin = $rtn_href['href'][$s];
      }
      if(strpos($rtn_href['href'][$s], 'www.youtube.com/user/') !==false )
      {
        $rtn_youtube = $rtn_href['href'][$s];
      }
    }
    $html->clear();
    unset($rtn);
    //
    ////////////////////////////////
    // OPG取得
    ///////////////////////////////// 
    // $output = file_get_contents($URL);
    $output = explode("\n", file_get_contents($URL));
    // $output = mb_convert_encoding($output, 'utf-8', 'auto');
    foreach($output as $line)
    {   
      if(!$og_image){
        if(strpos($line,"og:image")>0)
        {
          $og_image = trim($line);
          $og_image = str_replace('<meta', '', $og_image);
          $og_image = str_replace('property="og:image"', '', $og_image);
          $og_image = str_replace('content="', '', $og_image);
          $og_image = str_replace('" />', '', $og_image);
          $og_image = str_replace('"/>', '', $og_image);
          $og_image = str_replace('">', '', $og_image);
        }
      }
    }
    // 
    // DB登録
    $rtn = f_insert_sns($db_conn,$rtn_title,$URL,$og_image,$rtn_facebook,$rtn_twitter,$rtn_google,$rtn_linkedin,$rtn_youtube,$rtn_tumblr,$rtn_pinterest);
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
      if($rtn_url)
      {
        echo '<div style="width:100%;float:left;margin-right:10px;margin-top:10px;" class="input-group">';
        echo '<a class="h2" href="'.$rtn_url.'">'.$rtn_url.'</a>';
        echo '</div>';
      }
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
      if($og_image)
      {
        echo '<div style="width:100%;float:left;margin-right:10px;margin-top:10px;" class="input-group">';
        echo '<a href="'.$rtn_url.'"><img class="img-responsive img-thumbnail" src="'.$og_image.'"></a>';
        echo '</div>';
      }
      ?>
      

      <ul class="bs-social-buttons">
        <?php 
        if($rtn_twitter){
          echo '<li class="tweet-btn">';
          echo '<a data-toggle="tooltip" href="'.$rtn_twitter.'" target="_blank"><i id="socialY" class="fa fa-twitter-square fa-3x social-tw"></i></a>';
          echo '</li>';
        }
        if($rtn_facebook){
          echo '<li class="facebook-button">';
          echo '<a href="'.$rtn_facebook.'" target="_blank"><i id="socialY" class="fa fa-facebook-square fa-3x social-fb"></i></a>';
          echo '</li>';
        }
        if($rtn_google){
          echo '<li class="tweet-btn">';
          echo '<a href="'.$rtn_google.'" target="_blank"><i id="socialY" class="fa fa-google-plus-square fa-3x social-gp"></i></a>';
          echo '</li>';
        }
        if($rtn_tumblr){
          echo '<li class="tweet-btn">';
          echo '<a href="'.$rtn_tumblr.'" target="_blank"><i id="socialY" class="fa fa fa-tumblr-square fa-3x social-tb"></i></a>';
          echo '</li>';
        }
        if($rtn_pinterest){
          echo '<li class="tweet-btn">';
          echo '<a href="'.$rtn_pinterest.'" target="_blank"><i id="socialY" class="fa fa fa-pinterest-square fa-3x social-pin"></i></a>';
          echo '</li>';
        }
        if($rtn_linkedin){
          echo '<li class="tweet-btn">';
          echo '<a href="'.$rtn_linkedin.'" target="_blank"><i id="socialY" class="fa fa fa-linkedin-square fa-3x social-in"></i></a>';
          echo '</li>';
        }
        if($rtn_youtube){
          echo '<li class="tweet-btn">';
          echo '<a href="'.$rtn_youtube.'" target="_blank"><i id="socialY" class="fa fa fa-youtube-square fa-3x social-yt"></i></a>';
          echo '</li>';
        }
        ?>
      </ul>
  </div>
</div>

<!-- jsonのとき -->
<?php else: 
  header( 'Content-Type: application/json; charset=utf-8', true ); 
  echo json_encode( array("message" => "Upload is OK")  );
  endif; 
?>
