<!DOCTYPE html>
<?php
$base = pg_connect("host=192.168.207.125 dbname=vehicules_sinistre user=postgres password=postgres");
$bus = $_GET['bus'];
$sql = "SELECT * FROM public.vehicules WHERE vehicule = '".$bus."'";
$req = pg_query($base ,$sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
$controleur = $_GET['controleur'];
$modele = $_GET['modele'];
echo '<div id="controleurHidden" style="display:none">'.$controleur.'</div>';
echo '<div id="busHidden" style="display:none">'.$bus.'</div>';
echo '<div id="modeleHidden" style="display:none">'.$modele.'</div>';
?>

<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<html>
<link rel="stylesheet" type="text/css" href="./css/style.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<!--<link rel="stylesheet" type="text/css" href="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">-->
<?php echo" 
<style>
canvas { 
	background:url('images/".$modele.".png'); cursor: crosshair;
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
</head>
<body onload="init();window.setInterval('parsedate()', 1000);">
<canvas id="myCanvas" width="1150" height="805">Votre Navigateur ne fonctionne pas avec cette technologie.</canvas>
<center><button onClick="window.location.href='http://mdmkpa/vehicules/'" class="myButton">Retour &agrave; l'accueil</button></center><br>
<table id="tableau" border="1">
  <thead>
    <tr>
      <th>Num&eacute;ro</th>
      <th>Date</th>
      <th>Descriptif</th>
      <th>Nom du Controleur</th>
      <th>Heures</th>
      <th>Constat</th>
      <th>Numero Keorisk</th>
      <th>Photo</th>
      <th>Supprimer</th>
      <th style='display: none;'>>X</th>
      <th style='display: none;'>>Y</th>
      <th>R&eacute;paration</th>
    </tr>
    <?php
while ($data = pg_fetch_array($req)) {
	echo '<td>'.$data['id'].'</td>';
	echo '<td>'.$data['date'].'</td>';
	echo '<td>'.urldecode(base64_decode($data['motif'])).'</td>';
	echo '<td>'.$data['controleur'].'</td>';
	echo '<td>'.$data['heure'].'</td>';
	if($data['constat'] ==0){echo'<td><a onclick="modifierConstat(this)"><u>Non</u></a></td>';}else{echo'<td><a onclick="modifierConstat(this)"><u>Oui</u></td>';};
	echo '<td>'.$data['num_keorisk'].'</td>';
	if($data['photo'] == NULL){?>
	<td><br><span class="btn btn-success fileinput-button">
        <i class="glyphicon glyphicon-plus"></i>
        <span>Choisir la photo.</span>
        <input class="fileupload" name="<?php echo $data['id']; ?>" type="file" name="files[]">
    	</span>
    	<br><div id="progress" class="progress">
        <div class="progress-bar progress-bar-success"></div>
    	</div>
    	<div id="files" class="files"></div><?php echo'<script>uploadByjQuery("'.$data['motif'].'", '.$data['coordx'].', '.$data['coordy'].')</script>';?></td>
	<?php }else{echo'<td><a href="http://192.168.207.125/sinistre/photo_sinistre/files/'.$data['photo'].'">Oui</td>';};
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
<form action="requete.php" name="form" id="recherche" method="POST">
</body>
</html>

