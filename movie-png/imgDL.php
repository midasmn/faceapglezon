<?php
$exm_dir = $_GET['exm_dir'];
$no = $_GET['no'];
$dl_file='/usr/share/nginx/html/faceapglezon.info/movie-png/tmp/'.$exm_dir.'/'.sprintf("%04d", $no).'.png';
$j_file   = $exm_dir.'_'.$no.'.png';
// $j_file   = mb_convert_encoding($j_file, "SJIS", "EUC");
header("Content-Type: image/png");
// ダイアログボックスに表示するファイル名
header("Content-Disposition: attachment; filename=$j_file");
// 対象ファイルを出力する。
readfile($dl_file);