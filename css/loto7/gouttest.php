<?php
    require 'goutte.phar';
    use Goutte\Client;

    header('Content-Type: text/html; charset=utf-8');

    $kNumberOfSamples = 10; // 何回サンプリングするか

    $titles = array(100);
    $totalOfTime = 0;
    for ($i = 0; $i < $kNumberOfSamples; ++$i)
    {
        // 計測を開始する
        $startTime = microtime(true);

        // ランキングにある全てのタイトルを取得する
        $client = new Client();
        $crawler = $client->request('GET', 'http://say-move.org/ranking.php');
        $rank = 0;
        $crawler->filter('h3.ranking_ttl')->each(function($element)
        {
            global $titles;
            global $rank;
            $titles[$rank] = $element->text();
            ++$rank;
        });

        // 解放する
        unset($client);
        unset($crawler);

        // 計測を終了する
        $totalOfTime += microtime(true) - $startTime;

        echo $totalOfTime . '<br/>';
    }

    print_r($titles);
    echo '<br/>平均実行時間: ' . $totalOfTime / $kNumberOfSamples;

    unset($titles);
?>