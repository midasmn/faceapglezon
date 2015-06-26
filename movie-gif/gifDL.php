<?php
$exm_dir = $_GET['exm_dir'];
$dl_file='/usr/share/nginx/html/faceapglezon.info/movie-gif/tmp/'.$exm_dir.'/'.$exm_dir.'.gif';
$j_file   = $exm_dir.'.gif';
// $j_file   = mb_convert_encoding($j_file, "SJIS", "EUC");
header("Content-Type: image/gif");
// ダイアログボックスに表示するファイル名
header("Content-Disposition: attachment; filename=$j_file");
// 対象ファイルを出力する。
readfile($dl_file);