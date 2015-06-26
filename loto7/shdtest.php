<?php
    require 'simple_html_dom.php';

    header('Content-Type: text/html; charset=utf-8');

    $kNumberOfSamples = 10; // 何回サンプリングするか

    $titles = array();
    $totalOfTime = 0;
    for ($i = 0; $i < $kNumberOfSamples; ++$i)
    {
        // 計測を開始する
        $startTime = microtime(true);

        // ランキングにある全てのタイトルを取得する
        $html = file_get_html('http://say-move.org/ranking.php');
        $rank = 0;
        foreach ($html->find('h3.ranking_ttl') as $element)
        {
            $titles[$rank] = $element->text();
            ++$rank;
        }

        // 解放する
        $html->clear();

        // 計測を終了する
        $totalOfTime += microtime(true) - $startTime;

        echo $totalOfTime . '<br/>';
    }

    print_r($titles);
    echo '<br/>平均実行時間: ' . $totalOfTime / $kNumberOfSamples;

    unset($titles);
?>