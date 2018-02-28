<?php

// Parameters
$size = 200;
$numPoints = 7;
$targetZone = 0.5;
$walkDist = 50;

// Rand Function
$seed = time();

function myRand($maxPlusOne) {
    global $seed;
    static $r = 0;
    
    $maxPlusOne = intval($maxPlusOne);
    
    $randNum = abs(crc32($seed . $r));
    if ($maxPlusOne > 0) $randNum = $randNum % $maxPlusOne;
    else $randNum = 0;
    
    $r++;
    
    return $randNum;
}

// Create points
$points = array();
$lines = array();

$points[] = array(intval(myRand($size*$targetZone)+($size*$targetZone*0.5)),
    intval(myRand($size*$targetZone)+($size*$targetZone*0.5)),
    1);

for ($i = 1; $i < $numPoints; $i++) {
    $nPoint = count($points);
    $curPoint = myRand($nPoint);
    $newX = $points[$curPoint][0] + myRand($walkDist*2) - $walkDist;
    $newY = $points[$curPoint][1] + myRand($walkDist*2) - $walkDist;
    $points[] = array($newX, $newY, (myRand(5) / 10) + 0.5);
    $lines[] = array($curPoint, $nPoint);
}

$points[] = array(0,0,0);
$points[] = array(0,$size/2,0);
$points[] = array(0,$size,0);
$points[] = array($size/2,0,0);
$points[] = array($size/2,$size,0);
$points[] = array($size,0,0);
$points[] = array($size,$size/2,0);
$points[] = array($size,$size,0);

// Create an image
$canvas = imagecreatetruecolor($size, $size);

// Allocate colors
$c = array();
for ($i = 0; $i < 256; $i++) {
    $c[$i] = imagecolorallocate($canvas, $i, $i, $i);
}
$black = imagecolorallocate($canvas, 0,0,0);
$grey = imagecolorallocate($canvas, 200,200, 200);

// Fill canvas
imagefilledrectangle($canvas, 0, 0, $size-1, $size-1, $grey);

// Gradient
function dist($x1, $y1, $x2, $y2) {
    $xDist2 = pow(($x1 - $x2), 2);
    $yDist2 = pow(($y1 - $y2), 2);
    return ($xDist2 + $yDist2);
}

for ($j = 0; $j < $size; $j++) {
    for ($k = 0; $k < $size; $k++) {
        $val = 0;
        $closePoint = array(0, 1, 2);
        $closeDist = array(dist($j, $k, $points[0][0], $points[0][1]),
            dist($j, $k, $points[1][0], $points[1][1]),
            dist($j, $k, $points[2][0], $points[2][1]));
        for($n = 3; $n < count($points); $n++) {
            $newDist = dist($j, $k, $points[$n][0], $points[$n][1]);
            if ($newDist < $closeDist[0]) {
                $closeDist[2] = $closeDist[1];
                $closeDist[1] = $closeDist[0];
                $closeDist[0] = $newDist;
                $closePoint[2] = $closePoint[1];
                $closePoint[1] = $closePoint[0];
                $closePoint[0] = $n;
            }
        }
        
        $val = $points[$closePoint[0]][2] * $closeDist[0];
        $val += $points[$closePoint[1]][2] * $closeDist[1];
        $val += $points[$closePoint[2]][2] * $closeDist[2];
        
        $totalDist = ($closeDist[0] + $closeDist[1] + $closeDist[2]);
        $val = intval($val / $totalDist * 255);
        imagesetpixel($canvas, $j, $k, $c[$val]);
    }
}

// Draw lines
for ($i = 0; $i < count($lines); $i++) {
    $x1 = $points[$lines[$i][0]][0];
    $y1 = $points[$lines[$i][0]][1];
    $x2 = $points[$lines[$i][1]][0];
    $y2 = $points[$lines[$i][1]][1];
    imageline($canvas, $x1, $y1, $x2, $y2, $black);
}

// Output and free from memory
header('Content-Type: image/png');

imagepng($canvas);
imagedestroy($canvas);

?>