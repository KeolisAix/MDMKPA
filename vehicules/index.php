<!DOCTYPE html>
<!-- CONNECTION ZONE -->
<?php $connect=pg_connect ("host=192.168.207.22 dbname=vehicules user=postgres password=postgres"); ?>
<!-- FIN CONNECTION ZONE -->
<head>
<title>KPA Parc</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link href="css/style.css" rel="stylesheet" type="text/css"/>
<link type="text/css" rel="stylesheet" href="css/lightbox-css.css">
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/jquery.min.js"></script>
<script type="text/javascript" src="scripts/cycle.js"></script>
<script type="text/javascript" src="scripts/jquery.prettyPhoto.js"></script>
<script type="text/javascript" src="scripts/custom.js"></script>
<script type="text/javascript" src="scripts/cufon.js"></script>
<script type="text/javascript" src="scripts/cufon.font.js"></script>
<script type="text/javascript" src="scripts/vcard.packed.js"></script>
<script type="text/javascript" src="scripts/MooTools-Core-1.5.1.js"></script>
<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
<script src="http://www.jqueryscript.net/demo/Responsive-Accessible-jQuery-Modal-Plugin-Popup-Overlay/jquery.popupoverlay.js"></script>
<script>
function controle(){
		var t = document.form.searchbus.value;
		if(t == "" || isNaN(t) == true) {
		document.form.action = "";
		document.getElementById('submitrechercher').type="button";
		document.getElementById('message').innerHTML="Le numéro ne correspond a aucun bus.";
		document.getElementById('message').style.visibility="visible";
		  }
		}
function ok(){
	document.form.action = "#skills";
	document.getElementById('recherche').method = "post";
	document.getElementById("recherche").submit();
}
</script>
</head>
<?php
$Access_detail = 0;
if(isset($_POST['searchbus'])){ //check if form was submitted
$Access_detail = 1;
$ControleurInput = $_POST['ControleurInput'];
$user = $_POST['UserInput'];
$pass = $_POST['PswInput'];
$input = $_POST['searchbus']; //get input text
    $r=pg_query($connect , "SELECT * FROM vehicules.vehicule WHERE parc_keolis = '".$input."'");
    for ($i=0; $i<pg_numrows($r); $i++) {
      $l=pg_fetch_array($r,$i);
    }
}
if(isset($_POST['ExportExcel'])){
	$e=pg_query($connect , "COPY vehicules.vehicule TO '/var/www/html/vehicules/exports/vehicules.csv' DELIMITER ';' CSV HEADER");
	header('location:exports/vehicules.csv');
}
?>
   <body>

<!-- Wrapper --><div id="wrapper">
	<!-- Vcard --><div id="vcard">
		<div class="clearpx"></div>


<!-- Header -->
   <div id="header">
   	<div id="logo">KPA Parc</div>
		<ul id="menu">
			<li class="active"><a href="#home">Recherche</a></li>
			<?php if($Access_detail == 1){
            echo"<li><a href='#skills'>Details</a></li>
			    <li><a href='#work'>Autres Informations</a></li>
                <form id='ViaSinistre' method='post' hidden action='http://mdmkpa/sinistre/index.php'>
                    <input type='hidden' name='bus' value='".$l["parc_keolis"]."'/>
                    <input type='hidden' name='modele' value='".$l["modele"]."'/>
                    <input type='hidden' name='controleur' value='".$ControleurInput."'/>
                    <input type='hidden' name='user' value='".$user."'/>
                    <input type='hidden' name='psw' value='".$pass."'/>
                </form>
			    <li><a href='#' onclick='document.getElementById(\"ViaSinistre\").submit()'>Sinistre</a></li>";
                }?>
		</ul>
	</div><!-- End Header -->

	<hr/>

		<!-- Content --><div id="content">

<!-- Scroller -->
   <div id="scroller">
	<!-- Menu Home -->
	<div id="menu_home" class="contentitem">
		<div class="main">
			<div class="pagetitle">KPA Parc - Bienvenue</div>
            <?php // A VOIR SI UNE AUTHENTIFICATION VIA AD EST POSSIBLE
                @$Auth = $_POST['Auth']; //Test l'Authentification
                if ($Auth == 1 or isset($ControleurInput)){ // Si une authentification est demander alors on test les informations.
                    @$user = $_POST['user'];
                    @$pass = $_POST['psw'];
                    @$ds = ldap_connect("kiwi.private");  // On initialise la connexion au domaine (doit être un serveur LDAP valide !)
                    @$r = ldap_bind($ds,"$user@kiwi.private","$pass");
                    @$sr = ldap_search($ds,"OU=Comptes standards,OU=Utilisateurs,OU=13_K_PAYS_AIX,OU=Filiales,OU=DDMED,OU=KEOLISPROD,DC=kiwi,DC=private","sAMAccountName=".$user);
                    @$nb = ldap_get_entries($ds, $sr);	
                    if($r or isset($ControleurInput)){ // Si l'email && psw correspond alors le nombre de ligne de la requete sera 1 
                        if(isset($ControleurInput)){
                            $Controleur = $ControleurInput;
                        }else{
                            $Controleur = $nb["0"]["cn"]["0"]; // du coup on défini email du demandeur et ont lui affiche le men                               
                        }
            ?>
   <h1><center>Rechercher un bus :</center></h1>
   <form action="" name="form" id="recherche" method="POST">
       <input type="hidden" name="ControleurInput" value="<?php echo $Controleur ?>"></input>
       <input type="hidden" name="UserInput" value="<?php echo $user ?>"></input>
       <input type="hidden" name="PswInput" value="<?php echo $pass ?>"></input>
	<p><input type="text" name="searchbus" id="searchbus" value="Bus ou modèle de bus" onclick="document.getElementById('submitrechercher').type='submit';document.form.action = '#skills'" onfocus="if(this.value == 'Bus ou modèle de bus') {this.value=''}" style="text-align:center"/></p>
    <div id="message" style="visibility: hidden; border:1px solid #FF0000;height:20px; width:420px; text-align:center;line-height:20px; font-weight:bold;" >OFF</div>
	<p><input type="submit" id="submitrechercher" name="Rechercher" onclick="return controle();" value="Rechercher"></p>
    </form>
    <form action="#skills" method="post">
    <input type="submit" name="listbus" value="Liste des bus" class="my_popup_open">
</form>
    <form action="" method="POST">
		<input type="submit" name="ExportExcel" id="ExportExcel" value="Exporter sous Excel" class="excel">
    </form>
      <div id="my_popup" class="white-popup mfp-hide">
<!------------------------->
<?php
$select = 'SELECT * FROM vehicules.vehicule ORDER BY modele';
$vehicules = pg_query($connect,$select) or die ('Error in query procedural --> '.pg_last_error());
$total = pg_num_rows($vehicules);
if($total) {
            echo '<table>'."\n";
            echo '<tr>';
            echo '<td>Numero</td>';
            echo '<td>Modele</td>';
			echo '<td>Immatriculation</td>';
            echo '</tr>'."\n";
        
        
        //
            while($row = pg_fetch_array($vehicules)) {
                echo '<tr>';
                echo '<td><a href="#" onclick="document.getElementById(&quot;searchbus&quot;).value=('.$row["parc_keolis"].');ok();">'.$row["parc_keolis"].'</td>';
                echo '<td>'.$row["modele"].'</td>';
				echo '<td>'.$row["immatriculation"].'</td>';
                echo '</tr>'."\n";
            }
            echo '</table>'."\n";        
        }
        else {
              echo "Une erreur s'est produite.\n";
            echo "Pas d\'enregistrements dans cette table...";
              exit;
        } ?>
  		</div>
        <script>
    $(document).ready(function() {
      $('#my_popup').popup();
    });
  </script>
			<style class="cp-pen-styles">.white-popup {
			  position: relative;
			  background: #FFF;
			  /*padding: 20px;*/
			  width:auto;
			  max-width: 500px;
			  margin: 20px auto;
			}</style>
			</div>
                <?php
                    }
                    else{ // Sinon on lui demande de réessayer (Captcha ? AntiBot ? etc.. A définir) 
        ?>
        <form action="#home" method="post">
            <center><h1>Authentification Requise !</h1>
            <p><input type="text" onFocus="javascript:this.value=''" name="user" style="text-align: center" value="Votre Identifiant Windows" /></p>
            <p><input type="password" onFocus="javascript:this.value=''" name="psw" style="text-align: center" value="Mot de Passe"/></p>
            <p><input type="submit" value="Valider"/></p>
            <p><input type="text" name="Auth" value="1" style="display: none"/></p></div></center></form>
       <script>error();</script>
        <?php
                        }            
                    }
                else{ //Si aucune authentification est demander alors il en demande une... Logique en fin de compte.
        ?>
        <form action="#home" method="post">
            <center><h1>Authentification Requise ! </h1>
            <p><input type="text" onFocus="javascript:this.value=''" name="user" style="text-align: center" value="Votre Identifiant Windows" /></p>
            <p><input type="password" onFocus="javascript:this.value=''" name="psw" style="text-align: center" value="Mot de Passe"/></p>
            <p><input type="submit" value="Valider"/></p>
            <p><input type="text" name="Auth" value="1" style="display: none"/></p></div></center></form>
        <?php
                }
        ?>
	<div class="sidebar">
		<h2>Info bus, kesako ? :</h2>
			<ul>
				<li>Chercher un bus</li>
				<li>Montre son Affectation</li>
				<li>Montre son Immatriculation</li>
				<li>Montre son Modèle</li>
				<li>Et plein d'autres choses !</li>
			</ul>

		<hr class="spacer"/>

		</div>
	</div><!-- End Menu Home -->

	<div id="menu_skills" class="contentitem">
			<div class="pagetitle">KPA Parc - Détails</div>
				<div class="main">
		<h1>Detail du Bus :</h1>
			<ul class="skills">
				<li><span class="topic">Modele</span><span class="stars"><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /></span><?php echo $l["modele"]; ?></li>
                <li><span class="topic">Imatriculation</span><span class="stars"><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /></span><?php echo $l["immatriculation"]; ?></li>
				<li><span class="topic">Numero de Serie</span><span class="stars"><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /></span><?php echo $l["n_de_serie"]; ?></li>
				<li><span class="topic">Mise en Circulation</span><span class="stars"><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /></span><?php echo $l["mise_en_circulation"]; ?></li>
				<li><span class="topic">Affectation</span><span class="stars"><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /></span><?php echo $l["affectation_actuelle"]; ?></li>
			</ul>
				</div>

		<div class="sidebar">

		<h2>Les Details :</h2>
			<ul>	
			<li class="li-moreinfo">
				<p class="nopadding">l'utilitée de cette partie permet d'avoir un coup d'oeil rapide sur les informations des bus. </p>
				<p>Actuellement les informations contenues ici vienne d'une base de donnée alimenté par le fichier Parc.xls ce trouvant sur le commun.</p>
			</li>
			</ul>
		</div>
	</div><!-- Menu Work -->

		<div id="menu_work" class="contentitem">
			<div class="pagetitle">KPA Parc - Autre Infos</div>
				<div class="main">
		<h1>Detail du Bus :</h1>
			<ul class="skills">
				<li><span class="topic">Certificat d'Immatriculation</span><span class="stars"><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /></span><?php echo $l["certificat_immatriculation"]; ?></li>
                <li><span class="topic">Gabarit</span><span class="stars"><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /></span><?php echo $l["gabarit"]; ?></li>
				<li><span class="topic">Nombre de Place</span><span class="stars"><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /></span><?php echo $l["nb_places"]; ?></li>
				<li><span class="topic">Contrat Michelin</span><span class="stars"><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /></span><?php if($l["contrat_michelin"] == "+"){echo "<img src='http://www.akg-solutions.fr/imgs/Ok-icon.png' alt='ok' width='16' height='16'/>";} else{echo "<img src='http://www.mescomptesfaciles.fr/css/icons/16/cross.png' alt='ko' width='16' height='16'/>";}?></li>
                <li><span class="topic">Carte Grise</span><span class="stars"><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /></span>
                <div id="shadowing"></div>
<div id="box">
	<div id="boxheader">
    	Carte Grise :
   <span id="boxclose" onclick="document.getElementById('box').style.display='none';
   document.getElementById('shadowing').style.display='none'"> </span>
	</div>
	<div id="boxcontent">
    <center><img src="grises/grise.jpg" /></center>
	</div>
</div>
                <a href="#" onclick="document.getElementById('shadowing').style.display='block';
	  document.getElementById('box').style.display='block';">Disponnible</a>
                </li>
			</ul>
				</div>

		<div class="sidebar">

		<h2>Les Details :</h2>
			<ul>	
			<li class="li-moreinfo">
				<p class="nopadding">l'utilitée de cette partie permet d'avoir un coup d'oeil rapide sur les informations des bus. </p>
				<p>Actuellement les informations contenues ici vienne d'une base de donnée alimenté par le fichier Parc.xls ce trouvant sur le commun.</p>
			</li>
			</ul>
		</div><!-- End work mask -->
	</div><!-- End menu work -->


		<!-- Menu Networks -->
       	<div id="menu_networks" class="contentitem">
			<div class="pagetitle">KPA Parc - Administratif</div>
						<div class="main">
		<h1>Detail du Bus :</h1>
			<ul class="skills">
				<li><span class="topic">Certificat d'Immatriculation</span><span class="stars"><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /></span><?php echo $l["certificat_immatriculation"]; ?></li>
                <li><span class="topic">Gabarit</span><span class="stars"><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /></span><?php echo $l["gabarit"]; ?></li>
				<li><span class="topic">Sinistre</span><span class="stars"><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /></span><?php echo "<a href='http://mdmkpa/sinistre/index.php?bus=".$l["parc_keolis"]."&modele=".$l["modele"]."&controleur=Willy Boisfer'>Lien vers sinistre</a>" ?></li>
				<li><span class="topic">Contrat Michelin</span><span class="stars"><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /></span><?php echo $l["contrat_michelin"]; ?></li>
			</ul>
				</div>

		<div class="sidebar">

		<h2>Les Details :</h2>
			<ul>	
			<li class="li-moreinfo">
				<p class="nopadding">l'utilitée de cette partie permet d'avoir un coup d'oeil rapide sur les informations des bus. </p>
				<p>Actuellement les informations contenues ici vienne d'une base de donnée alimenté par le fichier Parc.xls ce trouvant sur le commun.</p>
			</li>
			</ul>
		</div><!-- End work mask -->
			</div><!-- End Menu Networks -->

		<!-- Menu Contact --><div id="menu_contact" class="contentitem">
			<div class="pagetitle">John Doe - Let's chat</div>
				<div class="main contact">

		<h1>Contact</h1>
			
					<div id="email_send">
						<h2>Your email has been sent!</h2>
						<p>I'll get back to you as soon as possible.<br/>In the meanwhile check out my <a href="#networks">social network profiles</a>.</p>
					</div>
				</div>

				<div class="sidebar">	
			<h2>John Doe</h2>
			<p>291 Fakestreet<br/>90405 Los Angeles<br/> California USA<br/><br/>Cell: +323 4987373<br/>Email: <a href="mailto:email@email.com">email@email.com</a><br/></p><hr class="spacer" /><a class="button" href="#">Download vCard</a>
	</div>
	</div><!-- End Menu Contact -->
	</div><!-- End Scroller -->
	</div><!-- End Content -->
	</div><!-- End Vcard -->
	</div><!-- End Wrapper -->


</body>
</html>
