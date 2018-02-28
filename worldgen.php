<?php

session_start();

/*
    GLOBAL VARIABLES
    ====================
*/

$settings = json_decode($_POST['data'], true);
$map = $_POST['map'];

$_SESSION['worldSize'] = intval($settings['Global']['worldSize']);
$_SESSION['pixelSize'] = intval($settings['Global']['pixelSize']);

include('biomes.php');
include('palette.php');

switch ($map) {
    case 'height' :
        //update height map and image
        //update biomes map and image
        include('mapGen.php');
        mapGen\GenerateMap('height', $settings['Height']);
        UpdateBiomes($settings['Biomes']);
        GenerateHeightColors($settings['Biomes']['seaLevel']);
        GenerateBiomesColors();
        break;
    case 'moisture' :
        //update moisture map and image
        //update biomes map and image
        include('mapGen.php');
        mapGen\GenerateMap('moisture', $settings['Moisture']);
        UpdateBiomes($settings['Biomes']);
        GenerateBiomesColors();
        break;
    case 'biomes' :
        //update biomes map
        UpdateBiomes($settings['Biomes']);
        GenerateHeightColors($settings['Biomes']['seaLevel']);
        GenerateBiomesColors();
        break;
    case 'global' :
    case 'all' :
        //update all maps and images
        include('mapGen.php');
        mapGen\GenerateMap('height', $settings['Height']);
        mapGen\GenerateMap('moisture', $settings['Moisture']);
        UpdateBiomes($settings['Biomes']);
        GenerateHeightColors($settings['Biomes']['seaLevel']);
        GenerateMoistureColors();
        GenerateBiomesColors();
        break;
}

?>