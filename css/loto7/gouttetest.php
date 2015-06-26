<?php
    require 'goutte.phar';
    use Goutte\Client;

 //    $scURL = 'http://d.hatena.ne.jp/keyword/%BA%B0%CC%EE%A4%A2%A4%B5%C8%FE';

 //    //USERAGENT
	// $config = array('useragent' => 'MyRobot/1.1')
	// $client = new Client($config);
	// $crawler = $client->request('GET', $scURL);

	// // $crawler = $client->request('GET', 'http://d.hatena.ne.jp/keyword/%BA%B0%CC%EE%A4%A2%A4%B5%C8%FE');
	// list(list($title, $url)) = $crawler->filter('div.keyword-container a.title')->extract(array('_text', 'href'));
	// $furigana = $crawler->filter('div.keyword-container span.furigana')->text();

	// var_dump($title, $url, $furigana);
?>