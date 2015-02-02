<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
$base = pg_connect("host=192.168.207.125 dbname=vehicules_sinistre user=postgres password=postgres");    
$sql = "SELECT * FROM public.maps WHERE type='arret'";
$req = pg_query($base ,$sql) or die('Erreur SQL !<br />'.$sql.'<br />'.pgsql_error());
$q=0;
if(isset($_GET['q'])){
    $sql2 = "SELECT * FROM public.vehicules WHERE coordonnees_sinistre IS NOT NULL ORDER BY CASE WHEN coordonnees_sinistre LIKE '%".$_GET['q']."%' THEN 0 ELSE 5 END, coordonnees_sinistre";
    $q=1;
}else{
    $sql2 = "SELECT * FROM public.vehicules WHERE coordonnees_sinistre IS NOT NULL";
}
$req2 = pg_query($base ,$sql2) or die('Erreur SQL !<br />'.$sql.'<br />'.pgsql_error());
$arretnb = 0;
$sinistrenb = 0;
$SplitSinistre = 0;
?>
<html>
  <head>
    <title>Cartographie des Sinistres</title>
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
    if($rowSinistre['photo'] == ""){
        $rowSinistre['photo'] = "NO";
    }
    $SplitSinistre = explode(", ", $rowSinistre['coordonnees_sinistre']);
    echo "<script>var pts".$sinistrenb." = new google.maps.LatLng(".$SplitSinistre[0].", ".$SplitSinistre[1].");
           addsinistre(pts".$sinistrenb.", '".urldecode(base64_decode($rowSinistre['motif']))."', '".$rowSinistre['vehicule']."', '".$rowSinistre['date_sinistre']."', '".$rowSinistre['date']."', '".$rowSinistre['controleur']."', '".$rowSinistre['photo']."');
           //console.log(x='".$SplitSinistre[0]."' et y='".$SplitSinistre[1]."');
            </script>\n";
}
if($q == 0){
    echo "<script>setTimeout(function(){showSinistre();},3000);</script>";
}else{
    echo "<script>setTimeout(function(){showSinistre(); google.maps.event.trigger(sinistres[0], 'click');},3000);</script>";
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
<?php
pg_free_result ($req2);
pg_close ();
?>
</html>