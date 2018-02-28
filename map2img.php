<?php

session_start();

$size = intval($_SESSION['worldSize']);
$pixSize = intval($_SESSION['pixelSize']);
$imgName = $_GET['name'];

// Create an image
$canvas = imagecreatetruecolor($size*$pixSize, $size*$pixSize);

// Allocate colors
$colorArray = array();

for ($i = 0; $i < count($_SESSION[$imgName]['colorArray']); $i++) {
    $colorArray[$i] = imagecolorallocate(
        $canvas,
        $_SESSION[$imgName]['colorArray'][$i][0],
        $_SESSION[$imgName]['colorArray'][$i][1],
        $_SESSION[$imgName]['colorArray'][$i][2]);
}

// Draw points
for($j = 0; $j < $size; $j++) {
    for($k = 0; $k < $size; $k++) {
        imagefilledrectangle($canvas,
                             $j*$pixSize, $k*$pixSize,
                             ($j+1)*$pixSize, ($k+1)*$pixSize,
                             $colorArray[$_SESSION[$imgName]['pixelArray'][($k*$size)+$j]]);
    }
}

// Output and free from memory
header('Content-Type: image/png');

imagepng($canvas);
imagedestroy($canvas);

?>