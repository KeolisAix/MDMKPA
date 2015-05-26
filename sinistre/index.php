<!DOCTYPE html>
<?php
$base = pg_connect("host=192.168.207.21 dbname=vehicules_sinistre user=postgres password=postgres");
$bus = $_GET['bus'];
//$bus = "117014";
$sql = "SELECT * FROM public.vehicules WHERE vehicule = '".$bus."' and archive = '0'";
$req = pg_query($base ,$sql) or die('Erreur SQL !<br />'.$sql.'<br />'.pgsql_error());
$controleur = $_GET['controleur'];
$modele = $_GET['modele'];
//$modele = "GX 127C";
echo '<div id="controleurHidden" style="display:none">'.$controleur.'</div>';
echo '<div id="busHidden" style="display:none">'.$bus.'</div>';
echo '<div id="modeleHidden" style="display:none">'.$modele.'</div>';
?>

<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<html>
    <!------- -->
<link rel="stylesheet" href="css/upload.css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"></script>

    
    <!----->
<link rel="stylesheet" type="text/css" href="./css/style.css">
<link rel="stylesheet" href="css/jquery-impromptu.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<!--<link rel="stylesheet" type="text/css" href="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">-->
<?php echo" 
<style>
canvas { 
	background:url('images/".$modele.".png'); cursor: crosshair;
    background-image: -WebKit-canvas('myCanvas');
	background-repeat:no-repeat; 
}
</style>" ?>
<link rel="stylesheet" href="css/jquery.fileupload.css">
<head>
<script type="text/javascript" src="js/script.js" charset="UTF-8"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="js/vendor/jquery.ui.widget.js"></script>
<script src="js/jquery.iframe-transport.js"></script>
<script src="js/jquery.fileupload.js"></script>
<script src="js/jquery-impromptu.js"></script>
    <script src="js/upload.js"></script>
    <script>
        function Fermela(){
    	$('#fade , .popup_block').fadeOut(function() {
		$('#fade, a.close').remove();});
}
    </script>
</head>
<body onload="init();window.setInterval('parsedate()', 1000);" onbeforeprint="test();">
<!--<canvas id="myCanvas" width="1150" height="805">Votre Navigateur ne fonctionne pas avec cette technologie.</canvas>-->
<canvas id="myCanvas" width="1150" height="1020">Votre Navigateur ne fonctionne pas avec cette technologie.</canvas>
<center><button onClick="window.location.href='http://mdmkpa/vehicules/'" class="myButton">Retour &agrave; l'accueil</button><button onClick="window.location.href='http://mdmkpa/carte/'" class="myButton">Carte des Sinistres</button></center><br>
<table id="tableau" border="1">
  <thead>
    <tr>
      <th>Num&eacute;ro</th>
      <th>Date</th>
      <th>Heures</th>
      <th>Nom du Controleur</th>
      <th>Date de l'accident</th>
      <th>Description</th>
      <th>Constat</th>
      <th>Numero Keorisk</th>
      <th>Photo</th>
      <th>Localisation</th>
      <th>Supprimer</th>
      <th style='display: none;'>>X</th>
      <th style='display: none;'>>Y</th>
      <th>R&eacute;paration</th>
    </tr>
    <?php
while ($data = pg_fetch_array($req)) {
    echo '<tr OnMouseOut="clearCercle('.$data['coordx'].','.$data['coordy'].')" OnMouseOver="addCercle('.$data['coordx'].','.$data['coordy'].')">';
	echo '<td>'.$data['id'].'</td>';
	echo '<td>'.$data['date'].'</td>';
	echo '<td>'.$data['heure'].'</td>';
	echo '<td>'.$data['controleur'].'</td>';
    echo '<td>'.$data['date_sinistre'].'</td>';
	echo '<td>'.urldecode(base64_decode($data['motif'])).'</td>';
	if($data['constat'] ==0){echo'<td><a onclick="modifierConstat(this)"><u>Non</u></a></td>';}else{echo'<td><a onclick="modifierConstat(this)"><u>Oui</u></td>';};
	echo '<td>'.$data['num_keorisk'].'</td>';
	if($data['photo'] == NULL){?>
	<td><a href="#?w=500" rel="<?php echo "popup_name".$data['id']; ?>" class="poplight">Non</a>
    <div id="<?php echo "popup_name".$data['id']; ?>" class="popup_block">
        <form action='upload.php?bus=<?php echo $bus."&motif=".$data['motif']?>' method="post" enctype="multipart/form-data">
            Photo du Sinitre :
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Upload Image" name="submit">
        </form><?php echo'<script>uploadByjQuery("'.$data['motif'].'", '.$data['coordx'].', '.$data['coordy'].')</script>';?></td>
	<?php }else{echo'<td><a href="http://192.168.207.21/sinistre/photo_sinistre/files/'.$data['photo'].'">Oui</td>';};
    echo '<td><a href="http://mdmkpa/carte/index.php?q='.$data['coordonnees_sinistre'].'" onclick="window.open(this.href); return false;">'.$data['coordonnees_sinistre'].'</a><input type="button" value="Modifier" onclick="ModifierCoord(this)" /></td>'; 
	echo '<td><img src="./images/supprimer.svg" onclick="deleteRow(this)" /></td>';
	echo '<td style=\'display: none;\'>'.$data['coordx'].'</td>';
	echo '<td style=\'display: none;\'>'.$data['coordy'].'</td>';
	echo '<td><img src="./images/repair.png" onclick="archivage(this)" /></td>';
	echo '</tr>';
}
?>
  </thead>
  <tbody>
  </tbody>
</table>
<?php
pg_free_result ($req);
pg_close ();
?>
</body>
</html>

