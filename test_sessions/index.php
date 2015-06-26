<?php
    error_reporting(-1);
$base = pg_connect("host=192.168.207.22 dbname=chouette2 user=postgres password=postgres");
echo "<table border='1' id='Tableau'>";
$sql= 'SELECT aixpreprod_."vehicle_journeys"."id" FROM aixpreprod_."vehicle_journeys" WHERE aixpreprod_."vehicle_journeys"."route_id" = 1174 ORDER BY aixpreprod_."vehicle_journeys"."id" ASC'; 
$liste = pg_query($sql); 
echo "<tr>";
while ($valeur=pg_fetch_array($liste)){ 
            $tableau[] = array($valeur["id"]);
            echo "<th>Parcours : ".$valeur["id"]."</th>";


}
echo "</tr><tr><td>";
for($i=0;$i<sizeof($tableau);$i++) // tant que $i est inferieur au nombre d'éléments du tableau... 
    { 
            $sql2= 'SELECT aixpreprod_."vehicle_journey_at_stops"."arrival_time" FROM aixpreprod_."vehicle_journey_at_stops" WHERE aixpreprod_."vehicle_journey_at_stops"."vehicle_journey_id" = '.$tableau[$i][0]; 
            $liste2 = pg_query($sql2); 
            while ($valeur2=pg_fetch_array($liste2)){ 
            echo $valeur2["arrival_time"]."<td>"; 
        }
        echo "</tr>";
    } 
echo "</tr>";
echo "</table>";
?>