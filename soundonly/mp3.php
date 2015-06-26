<?php
$exm_dir = $_GET['exm_dir'];
$dl_file='/usr/share/nginx/html/faceapglezon.info/soundonly/tmp/'.$exm_dir.'/'.$exm_dir.'.mp3';
$j_file   = $exm_dir.'.mp3';

echo "<br>path=".$dl_file;
echo "<br>j_file=".$j_file;
// $j_file   = mb_convert_encoding($j_file, "SJIS", "EUC");
header("Content-Type: audio/mpeg3");
// ダイアログボックスに表示するファイル名
header("Content-Disposition: attachment; filename=$j_file");
header('Content-Length: ' . filesize($dl_file));
// 対象ファイルを出力する。
readfile($dl_file);