<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
$base = pg_connect("host=192.168.207.125 dbname=vehicules_sinistre user=postgres password=postgres");    
$sql = "SELECT * FROM public.maps WHERE type='arret'";
$req = pg_query($base ,$sql) or die('Erreur SQL !<br />'.$sql.'<br />'.pgsql_error());
$sql2 = "SELECT * FROM public.maps WHERE type='sinistre'";
$req2 = pg_query($base ,$sql2) or die('Erreur SQL !<br />'.$sql.'<br />'.pgsql_error());
$arretnb = 0;
$sinistrenb = 0;
?>
<html>
  <head>
    <title>Remove arrets</title>
    <link rel="stylesheet" href="css/maps.css"></link>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
<!---------------------------
      INFORMATION MAPS + LISTE ARRET.
      ----------------------------------------------->
    <script src="js/maps.js"></script>
<!---------------------------
      INFORMATION SINISTRE
      ----------------------------------------------->
     <script src="js/sinistre.js"></script>
  </head>
    <?php
while ($data = pg_fetch_array($req)){
    $arretnb = $arretnb+1;
    echo "<script>var pt".$arretnb." = new google.maps.LatLng(".$data['x'].", ".$data['y'].");
           addarret(pt".$arretnb.", '".$data['nom']."');
            </script>\n";
}
while ($rowSinistre = pg_fetch_array($req2)){
    $sinistrenb = $sinistrenb+1;
    echo "<script>var pts".$sinistrenb." = new google.maps.LatLng(".$rowSinistre['x'].", ".$rowSinistre['y'].");
           addsinistre(pts".$sinistrenb.", '".$rowSinistre['nom']."');
            </script>\n";
}
    ?>
  <body>
    <div id="panel">
      <input onclick="clearArrets();" type=button value="Cacher les Arrêts">
      <input onclick="showArrets();" type=button value="Afficher les Arrêts">
        <input onclick="showSinistre();" type=button value="Afficher les Sinistres" id="Btn_Sinistre">
    </div>
    <div id="map-canvas"></div>
  </body>
</html>