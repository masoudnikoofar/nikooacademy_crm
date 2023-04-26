<?php
header ("Content-type: image/jpeg");
$im  = imagecreate (100, 50);
$background_color = imagecolorallocate ($im, 255, 255, 255);
$text_color = imagecolorallocate ($im, 233, 14, 91);
imagestring ($im, 20, 30, 15,  $_GET[capcha], $text_color);
imagejpeg($im);
?>
