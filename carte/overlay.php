<?php
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);    

$base = pg_connect("host=192.168.207.125 dbname=vehicules_sinistre user=postgres password=postgres");    
$sql2 = "SELECT * FROM public.vehicules WHERE coordonnees_sinistre IS NOT NULL";
$req2 = pg_query($base ,$sql2) or die('Erreur SQL !<br />'.$sql.'<br />'.pgsql_error());
while ($rowSinistre = pg_fetch_array($req2)){
    $SplitSinistre = explode(", ", $rowSinistre['coordonnees_sinistre']);
    echo "-----<br>";
    echo "Coord = ".$rowSinistre['coordonnees_sinistre']."<br>";
    echo "x = ".$SplitSinistre[0]."<br>";
    echo "y = ".$SplitSinistre[1]."<br>";
    echo "photo = ".$rowSinistre['photo']."<br>";

}
?>