<?php

function GenerateHeightColors($seaLevel) {
    $seaLevel = intval($seaLevel * 100);

    $colors = array();
    for ($i = 0; $i <= 100; $i++) {
        if ($i > $seaLevel) {
            $num = intval(($i/100)*255);
            $colors[$i] = array($num, $num, $num);
        }
        else {
            $colors[$i] = array(0, 0, 120);
        }
    }

    $_SESSION['height']['colorArray'] = $colors;
    unset($colors);
}

function GenerateMoistureColors() {
    $colors = array();
    for ($i = 0; $i <= 100; $i++) {
        $num = intval(($i/100)*255);
        $colors[$i] = array($num, 255-$num, 0);
    }

    $_SESSION['moisture']['colorArray'] = $colors;
    unset($colors);
}

function GenerateBiomesColors() {
    $colors = array(array(0, 100, 200), // 0 - Water
                    array(250, 220, 100), // 1 - Desert
                    array(0, 200, 0), // 2 - Plains
                    array(0, 200, 100), // 3 - Rainforest
                    array(180, 80, 50), // 4 - Canyons
                    array(0, 100, 0), // 5 - Forest
                    array(150, 150, 150), // 6 - Bare
                    array(255, 255, 255)); // 7 - Snow
    $_SESSION['biomes']['colorArray'] = $colors;
    unset($colors);
}

?>