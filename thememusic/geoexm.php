<?php


$lati = $_GET['lati'];
$long = $_GET['long'];
$map = $_GET['map'];
?>
<!-- <style>
.ggmap {
position: relative;
padding-bottom: 56.25%;
padding-top: 30px;
height: 0;
overflow: hidden;
}
.ggmap iframe,
.ggmap object,
.ggmap embed {
position: absolute;
top: 0;
left: 0;
width: 100%;
height: 100%;
}
</style> -->
<br><?=$lati?>
<br><?=$long?>
<div class="ggmap"><iframe src="<?=$map?>"></iframe></div>
