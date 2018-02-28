<?php

function UpdateBiomes($biomeSettings) {
    $biomes = array(array(3, 2, 1),
                    array(5, 2, 4),
                    array(7, 6, 6));
    $heightBreaks = array(0, $biomeSettings['heightLowBreak']*100, $biomeSettings['heightHighBreak']*100);
    $moistureBreaks = array(0, $biomeSettings['moistureLowBreak']*100, $biomeSettings['moistureHighBreak']*100);
    $seaLevel = intval($biomeSettings['seaLevel']*100);
    
    $pixels = array();
    $n = pow($_SESSION['worldSize'], 2);
    
    for($i = 0; $i < $n; $i++) {
        if ($_SESSION['height']['pixelArray'][$i] <= $seaLevel) {
            $pixels[$i] = 0;
        }
        else {
            $h = 2;
            while($heightBreaks[$h] > $_SESSION['height']['pixelArray'][$i]) {
                $h--;
            }
            $m = 2;
            while($moistureBreaks[$m] > $_SESSION['moisture']['pixelArray'][$i]) {
                $m--;
            }
            $pixels[$i] = $biomes[$h][$m];
        }
    }
    
    $_SESSION['biomes']['pixelArray'] = $pixels;
    unset($pixels);
}

?>