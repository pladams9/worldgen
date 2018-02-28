<?php

session_start();
session_unset();

?>

<!DOCTYPE html>
<html>

<head>
    <title>WorldGen GUI</title>
    <link rel="stylesheet" type="text/css" href="worldgenGUI.css">
    <script src="jquery.js"></script>
    <script src="worldgenGUI.js"></script>
</head>

<body>

<div id="header">
    <h1>WorldGen GUI</h1>
    <p>This page requires a [modern version of] Chrome (probably) and JavaScript to run properly.</p>
</div>

<div id="page-content">
    <div class="global">
        <div class="controls">
            World Size: <input type="number" id="world-size" min="10" max="320" value="50">
            Pixel Size: <input type="number" id="pixel-size" min="1" max="10" value="5">
        </div>
        <div class="display">
            World Size: <span id="world-size-val"></span>
            Pixel Size: <span id="pixel-size-val"></span>
        </div>
        <button class="edit">Edit</button>
        <button class="save">Save</button>
    </div>

    <hr>

    <div class="height">
        <img id="height-img">
        <h2>Height Map</h2>
        <div class="controls">
            Shape:<br>
            <input type="radio" name="height-shape" id="hsquare" value="square" checked="checked">
            <label for="hsquare">Square</label><br>
            <input type="radio" name="height-shape" id="hcircle" value="circle">
            <label for="hcircle">Circle</label><br>
            Noise Seed: <input type="text" size="12" id="height-noise-seed">
            <button type="button" id="height-noise-seed-button">Random Seed</button><br>
            Detail: <input type="number" id="height-noise-detail" min="1" max="10" value="3"><br>
            Octaves: <input type="number" id="height-noise-octaves" min="1" max="10" value="6"><br>
            Persistance: <input type="number" id="height-noise-persistance" min="0.1" max="1" step="0.01" value="0.55"><br>
            Noise Power: <input type="number" id="height-noise-weight" min="0" max="1" step="0.01" value="0.5">
        </div>
        <div class="display">
            Shape: <span id="height-shape-val"></span><br>
            Noise Seed: <span id="height-noise-seed-val"></span><br>
            Detail: <span id="height-noise-detail-val"></span><br>
            Octaves: <span id="height-noise-octaves-val"></span><br>
            Persistance: <span id="height-noise-persistance-val"></span><br>
            Noise Power: <span id="height-noise-weight-val"></span><br>
        </div>
        <button class="edit">Edit</button>
        <button class="save">Save</button>
        <div class="float-clear"></div>
    </div>

    <hr>

    <div class="moisture">
        <img id="moisture-img">
        <h2>Moisture Map</h2>
        <div class="controls">
            Shape:<br>
            <input type="radio" name="moisture-shape" id="mhorizontal" value="horizontal" checked="checked">
            <label for="mhorizontal">Horizontal</label><br>
            <input type="radio" name="moisture-shape" id="mvertical" value="vertical">
            <label for="mvertical">Vertical</label><br>
            <input type="radio" name="moisture-shape" id="msquare" value="square">
            <label for="msquare">Square</label><br>
            <input type="radio" name="moisture-shape" id="mcircle" value="circle">
            <label for="mcircle">Circle</label><br>
            Noise Seed: <input type="text" size="12" id="moisture-noise-seed">
            <button type="button" id="moisture-noise-seed-button">Random Seed</button><br>
            Detail: <input type="number" id="moisture-noise-detail" min="1" max="10" value="3"><br>
            Octaves: <input type="number" id="moisture-noise-octaves" min="1" max="10" value="6"><br>
            Persistance: <input type="number" id="moisture-noise-persistance" min="0.1" max="1" step="0.01" value="0.55"><br>
            Noise Power: <input type="number" id="moisture-noise-weight" min="0" max="1" step="0.01" value="0.5"><br>
        </div>
        <div class="display">
            Shape: <span id="moisture-shape-val"></span><br>
            Noise Seed: <span id="moisture-noise-seed-val"></span><br>
            Detail: <span id="moisture-noise-detail-val"></span><br>
            Octaves: <span id="moisture-noise-octaves-val"></span><br>
            Persistance: <span id="moisture-noise-persistance-val"></span><br>
            Noise Power: <span id="moisture-noise-weight-val"></span><br>
        </div>
        <button class="edit">Edit</button>
        <button class="save">Save</button>
        <div class="float-clear"></div>
        
    </div>

    <hr>

    <div class="biomes">
        <img id="biomes-img">
        <h2>Biomes</h2>
        <div class="controls">
            Sea Level: <input type="number" min="0" max="1" step="0.01" id="sea-level" value="0.35">
            <h3>Height Breaks</h3><br>
            <input type="number" id="height-low-break" size="4" min="0" max="1" step="0.02" value="0.55">
            <input type="number" id="height-high-break" size="4" min="0" max="1" step="0.02" value="0.8"><br>
            <h3>Moisture Breaks</h3><br>
            <input type="number" id="moisture-low-break" size="4" min="0" max="1" step="0.02" value="0.3">
            <input type="number" id="moisture-high-break" size="4" min="0" max="1" step="0.02" value="0.7">
        </div>
        <div class="display">
            Sea Level: <span id="sea-level-val"></span>
            <h3>Height Breaks</h3>
            <span id="height-low-break-val"></span> - <span id="height-high-break-val"></span><br>
            <h3>Moisture Breaks</h3>
            <span id="moisture-low-break-val"></span> - <span id="moisture-high-break-val"></span>
        </div>
        <button class="edit">Edit</button>
        <button class="save">Save</button>
        <div class="float-clear"></div>
    </div>

</div>

</body>
</html>