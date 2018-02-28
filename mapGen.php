<?php
namespace mapGen;

/*
    FUNCTIONS
    =============
*/

function noiseInt($intX, $intY, $seed) {
    $result = (abs(crc32($seed . $intX . $intY)) % 1000) / 1000;
    return $result;
}

function noiseInterpolated($x, $y, $seed) {
    $intX = intval($x);
    $intY = intval($y);
    $weightX = $x - $intX;
    $weightX = (1 - cos($weightX * 3.1415927)) * 0.5;
    $weightY = $y - $intY;
    $weightY = (1 - cos($weightY * 3.1415927)) * 0.5;
    
    $r1 = noiseInt($intX, $intY, $seed);
    $r2 = noiseInt($intX+1, $intY, $seed);
    $r3 = noiseInt($intX, $intY+1, $seed);
    $r4 = noiseInt($intX+1, $intY+1, $seed);
    
    $result += ($r1 * (1-$weightX) * (1-$weightY));
    $result += ($r2 * $weightX * (1-$weightY));
    $result += ($r3 * (1-$weightX) * $weightY);
    $result += ($r4 * $weightX * $weightY);
    
    return $result;
}

function layeredNoise($size, $seed, $octaves = 1, $startingPeriod = 1, $persistance = 0.5) {
    $result = array();
    $octaveMap = array();
    
    /*$totalAmp = 0;
    for ($i = 0; $i < intval($octaves); $i++) {
        $period = $startingPeriod / pow(2, $i);
        $amp = pow($persistance, $i);
        $totalAmp += $amp;
        $result += (noiseInterpolated($x/$period, $y/$period, $seed)) * $amp;
    }
    $result /= $totalAmp;*/
    
    //************ MAKE THIS RETURN ARRAY INSTEAD
    
    for ($k = 0; $k < $size; $k++) {
        for ($j = 0; $j < $size; $j++) {
            $totalAmp = 0;
            for ($i = 0; $i < intval($octaves); $i++) {
                $period = $startingPeriod / pow(2, $i);
                $amp = pow($persistance, $i);
                $totalAmp += $amp;
                $result[$j+($k * $size)] += (noiseInterpolated($j/$period, $k/$period, $seed)) * $amp;
            }
            $result[$j+($k * $size)] /= $totalAmp;
        }
    }
    return $result;
}

function distFunc($x, $y, $scale, $shape) {
    $xDist = abs(($scale/2)-$x);
    $yDist = abs(($scale/2)-$y);
    switch($shape) {
        case 'square' :
            return -max($xDist, $yDist);
        case 'circle' :
            return -sqrt(pow($xDist, 2) + pow($yDist, 2));
        case 'horizontal' :
            return $yDist;
        case 'vertical' :
            return $xDist;
        default : return 0;
    }
}

function normalize(&$map) {
    $len = count($map);
    $min = $map[0];
    $max = $map[0];
    for ($i = 1; $i < $len; $i++) {
        if ($map[$i] < $min) $min = $map[$i];
        if ($map[$i] > $max) $max = $map[$i];
    }
    $range = $max - $min;
    for ($i = 0; $i < $len; $i++) {
        $map[$i] = ($map[$i]-$min)/$range;
    }
}

/*
    GENERATE MAP FUNCTION
    =====================
*/

function GenerateMap($mapName, $mapSettings) {
    $size = $_SESSION['worldSize'];
    $seed = $mapSettings['NoiseSeed'];
    $shape = $mapSettings['Shape'];
    $detail = $mapSettings['NoiseDetail'];
    $octaves = $mapSettings['NoiseOctaves'];
    $persistance = $mapSettings['NoisePersistance'];
    $noiseWeight = $mapSettings['NoiseWeight'];
    
    // Actual map
    $pixels = array();
    // Array of X-offsets
    $randMapX = layeredNoise($size, 'X' . $seed, $octaves, $size/$detail, $persistance);
    // Array of y-offsets
    $randMapY = layeredNoise($size, 'Y' . $seed, $octaves, $size/$detail, $persistance);
    
    for ($i = 0; $i < pow($size, 2); $i++) $randMapX[$i] = ($randMapX[$i] - 0.5) * $size * $noiseWeight;
    for ($i = 0; $i < pow($size, 2); $i++) $randMapY[$i] = ($randMapY[$i] - 0.5) * $size * $noiseWeight;

    for($y = 0; $y < $size; $y++) {
        for($x = 0; $x < $size; $x++) {
            $tempPix = distFunc(
                $x + $randMapX[($y * $size) + $x],
                $y + $randMapY[($y * $size) + $x],
                $size, $shape);
            $pixels[($y*$size)+$x] = $tempPix;
        }   
    }

    normalize($pixels);

    for ($i = 0; $i < pow($size, 2); $i++) {
        $pixels[$i] = intval($pixels[$i]*100);
    }

    $_SESSION[$mapName]['pixelArray'] = $pixels;
    unset($pixels);
}

?>