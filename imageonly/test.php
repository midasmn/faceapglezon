<?php
require_once("lib/mysql-ini.php");
require_once("lib/lib_upload.php");
require_once("lib/mail.php");
require ('lib/simple_html_dom.php');


$URL = 'http://www.nitori-net.jp/store/ja/ec';
$URL = 'http://www.amazon.co.jp/';
$html = file_get_html($URL);
$rtn = array();
$rtn_href = array();
$rtn_url= $URL;
$rtn = parse_url($rtn_url);
$rtn_host = $rtn['scheme'].'://'.$rtn['host'];

echo "<br>rtn_host=".$rtn_host;
    // タイトル取得

/////////////////////////////
// 画像全部取得
/////////////////////////////
$i=0;
foreach ($html->find('img') as $element)
{
  $rtn_tmp = $element->src;
   echo "<br>rtn_tmp=".$rtn_tmp;
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

$html->clear();
unset($rtn);

/////////////////////////////
// 画像パス
/////////////////////////////
$cnt = count($rtn_img_st['img']);
if($cnt>0) 
{
  // リモートサイズ取得>MAXで縮小
  $EXM_MAX = 300;
  for ($i=0;$i<=$cnt;$i++) 
  { 
    // サイズを取得
    list($img_width,$img_height) = @getimagesize($rtn_img_st['img'][$i]);
    // MAX
    $max = max($img_width,$img_height);

echo "<br>img_width=".$img_width;
echo "<br>img_height=".$img_height;

    if($max>1)
    {
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
    }else{
    	$rtn_img_html_st .= '<img src="'.$rtn_img_st['img'][$i].'">';
    }
  }
}
// var_dump($rtn_img_st);
  echo "<br><hr>".$rtn_img_html_st;
