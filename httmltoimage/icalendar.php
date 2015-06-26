<?php
//使用方法 
//スタンダード
//wkhtmltoimage http://blog.96color.com blog.96color.com.png
//
//サイズを指定して取得する
//wkhtmltoimage --width 1200 --height 800 http://blog.96color.com blog.96color.com.png
//
//スクリーンショットのトリミングをして撮影する場合
//wkhtmltoimage --crop-h 300 --crop-w 400 http://blog.96color.com blog.96color.com.png
//
//画質を指定する
//wkhtmltoimage --quality http://blog.96color.com blog.96color.com.png

require_once 'src/autoload.php';

use Knp\Snappy\Image;

if (isset($_GET['url']) && $_GET['url'] !== '') : $url = $_GET['url']; else : die('Incorrect data entered.'); endif;

//スタンダード
$snappy = new Image('/usr/bin/wkhtmltoimage');

//サイズを指定して取得する
// $snappy = new Image('/usr/bin/wkhtmltoimage --width 1200 --height 1200 ');

//スクリーンショットのトリミングをして撮影する場合
//$snappy = new Image('/usr/bin/wkhtmltoimage');
//$snappy = new Image('/usr/local/bin/wkhtmltopdf');
// wkhtmltoimage --crop-h 300 --crop-w 400 http://blog.96color.com blog.96color.com.png

header("Content-Type: image/jpeg");
echo $snappy->getOutput($url);

?>