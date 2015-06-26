<?php

$url = "geoexm.php";
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


<script>
    navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
    function successCallback(position) {    /* 成功時の処理 */
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;
        if(latitude){   /* 変数latitudeに値が入ってた時 */
            location.href = "<?php echo $url; ?>?lati=" + latitude + "&long=" + longitude + "&map=https://maps.google.com/maps?q=" + latitude + "," + longitude;
        }
    }
    function errorCallback(error) { /* 失敗時の処理 */
        location.href = "<?php echo $url; ?>?alart=on";
    }
    </script>

    </head>
<body>
    </body>
    </html>