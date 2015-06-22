<?php
header('Content-Type: text/html; charset=utf-8');
$date = $_GET['date'];
$motif = $_GET['descriptif'];
$controleur = $_GET['controleur'];
$heure = $_GET['heure'];
$bus = $_GET['bus'];
$x = $_GET['x'];
$y = $_GET['y'];
$update = $_GET['update'];
$dateAccident = $_GET['DateSinistre'];
$coordAcc = $_GET['CoordAcc'];


//echo $date."/".$motif."/".$controleur."/".$heure."/";
$db = pg_connect("host=192.168.207.22 dbname=vehicules_sinistre user=postgres password=postgres");

if ($update == 0){
	$sql = "INSERT INTO vehicules (id,vehicule,motif,controleur,date,heure,constat,num_keorisk,coordx,coordy,date_sinistre,coordonnees_sinistre, archive) VALUES (DEFAULT, '".$bus."', '".$motif."', '".$controleur."', '".$date."', '".$heure."', '0', NULL, '".$x."', '".$y."', '".$dateAccident."', '".$coordAcc."', '0')";
}

if ($update == 1){
	// ZONE UPDATE
	echo $update;
	$motifUpdate = $_GET['motifUpdate'];
	$numKeorisk = $_GET['NumKeo'];
	$sql = "UPDATE vehicules SET constat = '1', num_keorisk = '".$numKeorisk."' WHERE motif = '".$motifUpdate."'";
}

if ($update == 2){
	$motifUpdate = $_GET['motifUpdate'];
	$sql = "DELETE FROM vehicules WHERE motif = '".$motifUpdate."' AND vehicule = '".$bus."'";
	echo" Oui 2";
}

if ($update == 3){
	$motifArchive = $_GET['motifArchive'];
	$sql = "UPDATE vehicules SET archive = '1' WHERE motif = '".$motifArchive."' AND vehicule = '".$bus."' AND coordx = '".$x."' AND coordy = '".$y."'";
	//$req = pg_query($sql2) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
	echo $sql;
    echo "<br>Oui 3";
	//$sql = "DELETE FROM vehicules WHERE motif = '".$motifArchive."' AND vehicule = '".$bus."' AND coordx = '".$x."' AND coordy = '".$y."'";
}

if ($update == 4){
	$photo = $_GET['photo'];
	$motifUpdate = $_GET['motifUpdate'];
	$sql = "UPDATE vehicules SET photo = '".$photo."' WHERE motif = '".$motifUpdate."' AND vehicule = '".$bus."'";
	echo" Oui 4";
}

if ($update == 5){
	$coord = urldecode(base64_decode($_GET['coord']));
	$motifUpdate = $_GET['motifUpdate'];
	$sql = "UPDATE vehicules SET coordonnees_sinistre = '".$coord."' WHERE motif = '".$motifUpdate."' AND vehicule = '".$bus."'";
	echo" Oui 5";
}

$req = pg_query($db,$sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
?>