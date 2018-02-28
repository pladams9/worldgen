/*
  GLOBAL VARIABLES
  ================
*/

var Settings = {
  Global : new Object(),
  Height : new Object(),
  Moisture : new Object(),
  Biomes : new Object()
};

/*
  FUNCTIONS
  =========
*/

// Save & Edit Butttons
// --------------------

// Takes data from inputs and copies it to .display div
function updateDisplayValues(category) {
  $( category ).children('.controls').children("input").each(function() {
    $( '#' + $( this ).attr('id') + '-val' ).text($( this ).val());
  });
}

// Other Page Functions
// --------------------

// Random Seed Generator
function randSeed() {
  var newSeed = "";
  var chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

  for (var i = 0; i < 8; i++)
    newSeed += chars.charAt(Math.floor(Math.random() * chars.length));

  return newSeed;
}

// Server Communication
// --------------------

// Pull Input Data Into JS Variables
function pullVars(varsToSet) {
  if ((varsToSet == 'global') || (varsToSet == 'all')) {
    Settings.Global.worldSize = $( "#world-size" ).val();
    Settings.Global.pixelSize = $( "#pixel-size" ).val();
  }
  
  if ((varsToSet == 'height') || (varsToSet == 'all')) {
    Settings.Height.Shape = $( "input[name=height-shape]:checked" ).val();
    Settings.Height.NoiseSeed = $( "#height-noise-seed" ).val();
    Settings.Height.NoiseDetail = $( "#height-noise-detail" ).val();
    Settings.Height.NoiseOctaves = $( "#height-noise-octaves" ).val();
    Settings.Height.NoisePersistance = $( "#height-noise-persistance" ).val();
    Settings.Height.NoiseWeight = $( "#height-noise-weight" ).val();
  }
  
  if ((varsToSet == 'moisture') || (varsToSet == 'all')) {
    Settings.Moisture.Shape = $( "input[name=moisture-shape]:checked" ).val();
    Settings.Moisture.NoiseSeed = $( "#moisture-noise-seed" ).val();
    Settings.Moisture.NoiseDetail = $( "#moisture-noise-detail" ).val();
    Settings.Moisture.NoiseOctaves = $( "#moisture-noise-octaves" ).val();
    Settings.Moisture.NoisePersistance = $( "#moisture-noise-persistance" ).val();
    Settings.Moisture.NoiseWeight = $( "#moisture-noise-weight" ).val();
  }
  
  if ((varsToSet == 'biomes') || (varsToSet == 'all')) {
    Settings.Biomes.heightLowBreak = $( "#height-low-break" ).val();
    Settings.Biomes.heightHighBreak = $( "#height-high-break" ).val();
    Settings.Biomes.moistureLowBreak = $( "#moisture-low-break" ).val();
    Settings.Biomes.moistureHighBreak = $( "#moisture-high-break" ).val();
    Settings.Biomes.seaLevel = $( "#sea-level" ).val();
  }
}

// AJAX Request
function UpdateMap(mapName) {
  $( '.edit' ).attr('disabled', true);
  $.post('worldgen.php',  // Updates backend data
    {
      map : mapName,
      data : JSON.stringify(Settings),
    },
    function() {  // Updates image link  on page
      if ((mapName == 'global') || (mapName == 'all')) {
        $( '#height-img' ).attr('src', 'map2img.php?name=height&time=' + (new Date().getTime()));
        $( '#moisture-img' ).attr('src', 'map2img.php?name=moisture&time=' + (new Date().getTime()));
      }
      else if (mapName != "biomes") {
        $( '#' + mapName + '-img' ).attr('src', 'map2img.php?name=' + mapName +'&time=' + (new Date().getTime()));
      }
      else {
        $( '#height-img' ).attr('src', 'map2img.php?name=height&time=' + (new Date().getTime()));
      }
      $( '#biomes-img' ).attr('src', 'map2img.php?name=biomes&time=' + (new Date().getTime()));
      $( '.edit' ).attr('disabled', false);
    });
}

// INITIALIZATION

function Initialize() {
  // Set Initial Seed Values
  $( "#height-noise-seed" ).val(randSeed());
  $( "#moisture-noise-seed" ).val(randSeed());
  
  // Noise Seed Buttons
  $( "#height-noise-seed-button").click(
    function() {
      $( "#height-noise-seed" ).val(randSeed());
    });
    
  $( "#moisture-noise-seed-button").click(
    function() {
      $( "#moisture-noise-seed" ).val(randSeed());
    });
    
  // Edit & Save Buttons
  $( ".save" ).hide();
  $( ".controls").hide();
  updateDisplayValues($( '.global' ));
  updateDisplayValues($( '.height' ));
  updateDisplayValues($( '.moisture' ));
  updateDisplayValues($( '.biomes' ));
  
  $( ".edit" ).click(function()
    {
      $( this ).hide();
      $( this ).siblings(".display").hide();
      $( this ).siblings(".save").show();
      $( this ).siblings(".controls").show();
    } );
  $( ".save" ).click(function()
    {
      $( this ).hide();
      $( this ).siblings(".controls").hide();
      $( this ).siblings(".edit").show();
      $( this ).siblings(".display").show();
      
      updateDisplayValues($( this ).parent());
      
      var section = $( this ).parent().attr('class');
      pullVars(section);
      UpdateMap(section);
    } );
  
  // Generate Initial Maps
  pullVars('all');
  UpdateMap('all');
}

$( document ).ready(Initialize);