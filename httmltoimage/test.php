<?php




// $sock = stream_socket_client('tcp://183.207.237.11:86', $errno, $errstr, 10, STREAM_CLIENT_CONNECT);  
  
// if(!$sock) exit();  
  
// $request = array();  
// $request[] = 'GET http://www.xiami.com HTTP/1.1';  
// $request[] = 'Host: www.xiami.com/';  
// $request[] = 'User-Agent: TestClient';  
  
// if(!fwrite($sock, implode("\r\n", $request)."\r\n\r\n")){  
//     exit();  
// }  
  
// $response = '';  
// while(!feof($sock)){  
//     $response .= fgets($sock, 4096);  
// }  
  
// echo $response;  
  
// fclose($sock);  


$get_url = "http://www.xiami.com";
$get_url = "http://www.xiami.com/search?key=ももクロ&pos=1";
$get_url = "http://www.xiami.com/album/1825691529?spm=a1z1s.3521865.23310001.2.NDLpEW";
$get_url = "http://www.xiami.com/song/play?ids=/song/playlist/id/1774042966/object_name/default/object_id/0#open";




$tcp = "tcp://183.207.237.11:86";



// プロクシ経由
$context = stream_context_create(
  array(
    "http" => array(
      "proxy" => $tcp,
      "request_fulluri" => TRUE,
    )
  ));

echo file_get_contents($get_url, FALSE, $context);

// echo (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];






?>