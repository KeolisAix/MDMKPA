<?php error_reporting(1);
 include('config.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<title>Hastus2Chouette</title>
    <!--- STYLE DEBUT -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link href="css/style.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/jquery.min.js"></script>
<script type="text/javascript" src="scripts/cycle.js"></script>
<script type="text/javascript" src="scripts/jquery.prettyPhoto.js"></script>
<script type="text/javascript" src="scripts/custom.js"></script>
<script type="text/javascript" src="scripts/cufon.js"></script>
<script type="text/javascript" src="scripts/cufon.font.js"></script>
<script type="text/javascript" src="scripts/vcard.packed.js"></script>
    <!--- STYLE FIN -->
    <!--- SCRIPT DEBUT -->
<script>
    function Confirm_MEP(){ // Freeze / Défreeze bouton Valider
        if(document.getElementById("ConfirmMEP").disabled == true){
          document.getElementById("ConfirmMEP").disabled = false;
        }else{
            document.getElementById("ConfirmMEP").disabled = true;
        }
    }
    function ConfirmIMPORT(){ // Freeze / Défreeze bouton Valider
        if(document.getElementById("ImportValider").disabled == true){
          document.getElementById("ImportValider").disabled = false;
        }else{
            document.getElementById("ImportValider").disabled = true;
        }
    }
    function ConfirmBILL(){ // Freeze / Défreeze bouton Valider
        if(document.getElementById("BillValider").disabled == true){
          document.getElementById("BillValider").disabled = false;
        }else{
            document.getElementById("BillValider").disabled = true;
        }
    }
    function ConfirmEXPORT(){ // Freeze / Défreeze bouton Valider
        if(document.getElementById("ExportValider").disabled == true){
          document.getElementById("ExportValider").disabled = false;
        }else{
            document.getElementById("ExportValider").disabled = true;
        }
    }
    $(function(){ // ALERT VALIDATION JOB
  $('#contentok').on('click', '.notify', function(){
    $(this).fadeOut(350, function(){
      $(location).attr('href','#home');
    });
  });
});

    $(function(){ // ALERT MAUVAIS MDP
  $('#contentko').on('click', '.notify', function(){
    $(this).fadeOut(350, function(){
      $(location).attr('href','#home');
    });
  });
});
    function show(){ // ALERT VALIDATION JOB
document.getElementById("contentok").style.display = 'inline';
}
    function error(){ // ALERT MAUVAIS MDP
document.getElementById("contentko").style.display = 'inline';
}
</script>
     <!--- SCRIPT FIN -->
<!--[if lt IE 8]><script> iexplorer = 1; </script><![endif]--><meta name="title" content="John Doe" />
<meta name="description" content="description" />
<link rel="image_src" type=" image/jpeg" href="images/vcard/profile.jpg" />
<link rel="stylesheet" href="./css/prettyPhoto.css" type="text/css" media="screen"/>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

</head>
   <body>
<div id="contentok" style="display: none">     <!--- ALERT JOB  -->
      <div class="notify successbox">
        <h1>Job validé !</h1>
        <span class="alerticon"><img src="images/check.png" alt="checkmark" /></span>
        <p>Le job demandé a bien été envoyé au serveur Talend.</p>
          <p>Vous allez recevoir un mail une fois le job terminé.</p>
      </div>
</div>
<div id="contentko" style="display: none">    <!--- ALERT ERROR  -->
      <div class="notify errorbox">
        <h1><center>Echec d'Authentification !</center></h1>
        <span class="alerticon"><img src="images/error.png" alt="errormark" /></span>
        <p>Le nom d'utilisateur ou le Mot de passe est incorrect.</p>
          <p>En cas d'oubli de mot de passe prévenez MALDI Patrice .</p>
      </div>
</div>
       <!-- Wrapper --><div id="wrapper">
	<!-- Vcard --><div id="vcard">
		<div class="clearpx"></div>



<!-- Header -->
   <div id="header">
   	<div id="logo">Hastus2Chouette</div>
		<ul id="menu">
			<li class="active"><a href="#home">Accueil</a></li>
		</ul>
	</div><!-- End Header -->

	<hr/>

		<!-- Content --><div id="content">

<!-- Scroller -->
   <div id="scroller">
	<!-- Menu Home -->
	<div id="menu_home" class="contentitem">
		<div class="main">
			<div class="pagetitle">Hastus2Chouette - Bienvenue</div>
            <?php // A VOIR SI UNE AUTHENTIFICATION VIA AD EST POSSIBLE
                @$Auth = $_POST['Auth']; //Test l'Authentification
                if ($Auth == 1){ // Si une authentification est demander alors on test les informations.
                    $user = $_POST['user'];
                    $pass = $_POST['psw'];
                    $ds = ldap_connect("kiwi.private");  // On initialise la connexion au domaine (doit être un serveur LDAP valide !)
                    $r = ldap_bind($ds,"$user@kiwi.private","$pass");
                    $sr = ldap_search($ds,"OU=Comptes standards,OU=Utilisateurs,OU=13_K_PAYS_AIX,OU=Filiales,OU=DDMED,OU=KEOLISPROD,DC=kiwi,DC=private","sAMAccountName=".$user);
                    $nb = ldap_get_entries($ds, $sr);	
                    if($r){ // Si l'email && psw correspond alors le nombre de ligne de la requete sera 1 
                        $mail = $nb["0"]["mail"]["0"]; // du coup on défini email du demandeur et ont lui affiche le men   
                        ?>
                                        <center><h1>Choix du Job !</h1>
                                        <p><a href="#import" style="text-decoration: none"><input type="button" value="JOB : D'IMPORT" /></a></p>
                                        <p><a href="#export" style="text-decoration: none"><input type="button" value="JOB : D'EXPORT"/></a></p>
                                        <p><a href="#MEP" style="text-decoration: none"><input type="button" value="JOB : MISE EN PRODUCTION"/></a></p>
                                        <p><a href="#Bill" style="text-decoration: none"><input type="button" value="JOB : EXPORT BILLETTIQUE"/></a></p></div></center>
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
		<h2>Hastus2Chouette</h2>
			<ul>
				<li>Migration automatique</li>
				<li>Completement autonome</li>
				<li>Suivi des actions</li>
				<li>Gestion d'accès</li>
			</ul>

		<hr class="spacer"/>

			<a class="button" href="./Logs/ChouetteLog.csv">Logs Hastus2Chouette</a>
		</div>
	</div><!-- End Menu Home -->

	<div id="menu_import" class="contentitem">
			<div class="pagetitle">Hastus2Chouette - Import</div>
				<div class="main">
		<center><h1>JOB : IMPORTATION</h1></center>
			<ul class="import">
              <form action="requete.php" method="get">
				<li><span class="topic">Date debut :</span><span class="stars"><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /></span><input type="text" value="JJ/MM/AAAA" name="ImportDateDebut" style="padding: 0 0 0 0;margin: 0 0 0 0;width: auto;text-align: center" /></li>
				<li><span class="topic">Date fin :</span><span class="stars"><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /></span><input type="text" value="JJ/MM/AAAA" name="ImportDateFin" style="padding: 0 0 0 0;margin: 0 0 0 0;width: auto;text-align: center" /></li>
                <li><span class="topic">Purger : </span><span class="stars"><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /></span></center><input type="checkbox" checked="true" name="PurgeOui" style="padding: 0 0 0 0;margin: 0 0 0 0;width: 170px;text-align: center"/></li>
				<li><span class="topic">Confirmer : </span><span class="stars"><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /></span><input type="checkbox" id="CheckConfirmIMPORT" name="ImportConfirmOui" onclick="ConfirmIMPORT();" style="padding: 0 0 0 0;margin: 0 0 0 0;width: 170px;text-align: center"/></li>
				<li><span class="topic">Lancer le job :</span><span class="stars"><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /></span><input type="submit" value="Valider" onclick="show();" disabled id="ImportValider" style="padding: 0 0 0 0;margin: 0 0 0 0;width: 170px;text-align: center" /></li>
			    <li style="visibility: hidden"><input type="text" name="Job" value="Import" /></li>
    <?php echo '<li style="visibility: hidden"><input type="text" name="mail" value="'.$mail.'" /></li>' ?>
                </form>
            </ul>
				</div>

		<div class="sidebar">

		<h2>Explications :</h2>
			<ul>	
			<li class="li-moreinfo">
				<p class="nopadding">Le job d'exportation billettique permet de faire la liaison entre Hastus et la "Billettique"</p></p>
				<p>Il permet d'avoir accès a un jeu de fichier pour la billettique</p>
			</li>
			</ul>
		</div>
	</div><!-- Menu BILL -->
       
       	<div id="menu_Bill" class="contentitem">
			<div class="pagetitle">JOB : EXPORT BILLETTIQUE</div>
				<div class="main">
		<center><h1>JOB : EXPORT BILLETTIQUE</h1></center>
			<ul class="Bill">
              <form action="requete.php" method="get">
				<li><span class="topic">Date debut :</span><span class="stars"><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /></span><input type="text" value="JJ/MM/AAAA" name="BillDateDebut" style="padding: 0 0 0 0;margin: 0 0 0 0;width: auto;text-align: center" /></li>
				<li><span class="topic">Date fin :</span><span class="stars"><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /></span><input type="text" value="JJ/MM/AAAA" name="BillDateFin" style="padding: 0 0 0 0;margin: 0 0 0 0;width: auto;text-align: center" /></li>
                <li><span class="topic">Nom du Fichier :</span><span class="stars"><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /></span><input type="text" value="Bill_2015" name="BillName" style="padding: 0 0 0 0;margin: 0 0 0 0;width: auto;text-align: center" /></li>
				<li><span class="topic">Confirmer : </span><span class="stars"><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /></span><input type="checkbox" id="CheckConfirmIMPORT" name="BillConfirmOui" onclick="ConfirmBILL();" style="padding: 0 0 0 0;margin: 0 0 0 0;width: 170px;text-align: center"/></li>
				<li><span class="topic">Lancer le job :</span><span class="stars"><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /></span><input type="submit" value="Valider" onclick="show();" disabled id="BillValider" style="padding: 0 0 0 0;margin: 0 0 0 0;width: 170px;text-align: center" /></li>
			    <li style="visibility: hidden"><input type="text" name="Job" value="Bill" /></li>
    <?php echo '<li style="visibility: hidden"><input type="text" name="mail" value="'.$mail.'" /></li>' ?>
                </form>
            </ul>
				</div>

		<div class="sidebar">

		<h2>Explications :</h2>
			<ul>	
			<li class="li-moreinfo">
				<p class="nopadding">Le job d'importation permet de faire la liaison entre Hastus et Chouette</p></p>
				<p>Il permet d'intégrer directement les données de Hastus directement dans Chouette.</p>
			</li>
			</ul>
                        		<hr class="spacer"/>

			<a class="button" href="./bill/">Export Billettique</a>
		</div>
	</div><!-- Menu export -->

		<div id="menu_export" class="contentitem">
			<div class="pagetitle">Hastus2Chouette - Export</div>
		<!-- work mask -->
				<div class="main">
		            <center><h1>JOB : EXPORTATION</h1></center>
			            <ul class="import">
                            <form action="requete.php" method="get">
				                <li><span class="topic">Format de l'Export :</span><span class="stars"><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /></span><input type="text" title="NEPTUNE / GTFS" class="tooltip" value="NEPTUNE" name="ExportFormat" style="padding: 0 0 0 0;margin: 0 0 0 0;width: auto;text-align: center" /></li>
                                <li><span class="topic">Nom du Fichier :</span><span class="stars"><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /></span><input type="text" value="Export_2015" name="ExportName" style="padding: 0 0 0 0;margin: 0 0 0 0;width: auto;text-align: center" /></li>
				                <li><span class="topic">Base :</span><span class="stars"><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /></span><input type="text" value="Production" name="ExportBase" style="padding: 0 0 0 0;margin: 0 0 0 0;width: auto;text-align: center" /></li>
				                <li><span class="topic">Confirmer :</span><span class="stars"><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /></span><input type="checkbox" id ="CheckConfirmExport"value="ExportConfirmOui" onclick="ConfirmEXPORT();" style="padding: 0 0 0 0;margin: 0 0 0 0;width: 170px;text-align: center"/></li>
				                <li><span class="topic">Valider :</span><span class="stars"><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /><img src="images/vcard/espace.png" alt="star" width="16" height="16" /></span><input type="submit" value="Valider" onclick="show();" disabled id="ExportValider" style="padding: 0 0 0 0;margin: 0 0 0 0;width: 170px;text-align: center" /></li>
			                    <li style="visibility: hidden"><input type="text" name="Job" value="Export" /></li>
                    <?php echo '<li style="visibility: hidden"><input type="text" name="mail" value="'.$mail.'" /></li>' ?>
			                </form>
                        </ul>
				</div>
            		<div class="sidebar">
		            <h2>Explications :</h2>
			            <ul>	
			            <li class="li-moreinfo">
				            <p class="nopadding">L'exportation permet de récupérer un fichier .Zip sous un format défini afin de pouvoir récuperer le contenu d'une base.</p>
				            <p>Il n'efface pas les données actuellement en ligne.</p>
			            </li>
			            </ul>
                    <hr class="spacer"/>
                        <center><a class="button" href="./exports/">Exports H2C</a></center>
		            </div>
	</div><!-- End menu work -->

		<!-- Menu MEP -->
       <div id="menu_MEP" class="contentitem">
			<div class="pagetitle">Hastus2Chouette - MEP</div>
		<!-- work mask -->
				<div class="main">
		            <center><h1>JOB : MISE EN PRODUCTION</h1>
			            <ul class="import"><br />
                            <form action="requete.php" method="get">
                                <ul><span class="topic">Pour la mise en Production, cliquer sur le bouton "Mise en Production"</span></ul></center>
                                <ul><span class="topic">Voici les details :</span></ul>
                                <ul><span class="topic">        - Une "PreProd" doit exister.</span></ul>
                                <ul><span class="topic">        - La base de "Production" actuelle sera supprimee.</span></ul>
                                <ul><span class="topic">        - La mise en production est irreversible</span></ul>
                                <ul><span class="topic">Pour Confirmer, cochez la case suivante : <input type="checkbox" id="CheckConfirmMEP" value="CheckConfirm" onchange="Confirm_MEP();"></span></span></ul>
                                <ul><span class="topic"><input type="submit" id="ConfirmMEP" onclick="show();" value="JOB : Mise en Production" disabled /></span></ul>
			                    <li style="visibility: hidden"><input type="text" name="Job" value="MEP" /></li>
                    <?php echo '<li style="visibility: hidden"><input type="text" name="mail" value="'.$mail.'" /></li>' ?>
                            </form>
			           </ul>
				</div>
            		<div class="sidebar">
		            <h2>Explications :</h2>
			            <ul>	
			            <li class="li-moreinfo">
				            <p class="nopadding">La mise en production permet a la base de pré-production de devenir la base de production</p>
				            <p>Ce procéder prends quelques minutes et efface completement la base actuelle.</p>
			            </li>
			            </ul>
		            </div>
	</div><!-- End Menu MEP -->
	</div><!-- End Scroller -->
	</div><!-- End Content -->
	</div><!-- End Vcard -->
	</div><!-- End Wrapper -->


</body>
</html>