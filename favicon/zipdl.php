<?php
require_once("lib/lib_upload.php");

$exm_dir = $_GET['exm_dir'];
// Zipクラスロード
$zip = new ZipArchive();
// Zipファイル名
$zipFileName = 'favicon_set.zip';
// Zipファイル一時保存ディレクトリ
$zipTmpDir = '/usr/share/nginx/html/faceapglezon.info/favicon/zip/';

// Zipファイルオープン
$result = $zip->open($zipTmpDir.$zipFileName, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);
if ($result !== true) {
    // 失敗した時の処理
}


$TMP_PATH ="/usr/share/nginx/html/faceapglezon.info/favicon/tmp/".$exm_dir."/";
$image_data_array = get_files_zip($TMP_PATH);

$HTTP_PATH ="http://faceapglezon.info/favicon/tmp/".$exm_dir."/";
// var_dump($image_data_array);
// 処理制限時間を外す
set_time_limit(0);

foreach ($image_data_array as $filename)
{
    // $filename = basename($filepath);
	$filepath = $TMP_PATH.$filename;
    // 取得ファイルをZipに追加していく
    $zip->addFromString($filename,file_get_contents($filepath));
}



$zip->close();

// ストリームに出力
header('Content-Type: application/zip; name="' . $zipFileName . '"');
header('Content-Disposition: attachment; filename="' . $zipFileName . '"');
header('Content-Length: '.filesize($zipTmpDir.$zipFileName));
echo file_get_contents($zipTmpDir.$zipFileName);

// 一時ファイルを削除しておく
unlink($zipTmpDir.$zipFileName);
exit();
