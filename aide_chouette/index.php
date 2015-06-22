<!DOCTYPE html>
<?php
//CONNECTION ZONE
$base = pg_connect("host=192.168.207.22 dbname=chouette2 user=postgres password=postgres");
$schema = $_GET['schema'];
echo "<script>var schema = document.URL.split('?schema=')[1]; </script>";
?>
<html lang="en">
    <head>
		<meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
        <link rel="shortcut icon" href="../favicon.ico"> 
        <link rel="stylesheet" type="text/css" href="css/demo.css" />
        <link rel="stylesheet" type="text/css" href="css/style.css" />
		<script type="text/javascript" src="js/modernizr.custom.29473.js"></script>
        	<script>
             var dateRecherche;
             var ajaxRequest;
             var ajaxCalendrier;
             var ajaxAffiner;
             var ExDay = document.getElementById('InputYesNoEx').value;
             var cal = document.getElementById('tableau').rows[1].cells[0].innerHTML;
             function purge() {
                 document.getElementById('Form2').innerHTML = "";
             }
             function purge2() {
                 document.getElementById('Form3').innerHTML = "";
             }
             function temps(date) {
                 var JourARenvoyer;
                 var DateDuJour = new Date(date[0], date[1] - 1, date[2]);
                 if (DateDuJour.getDay() == "1") { JourARenvoyer = "Lundi" }
                 if (DateDuJour.getDay() == "2") { JourARenvoyer = "Mardi" }
                 if (DateDuJour.getDay() == "3") { JourARenvoyer = "Mercredi" }
                 if (DateDuJour.getDay() == "4") { JourARenvoyer = "Jeudi" }
                 if (DateDuJour.getDay() == "5") { JourARenvoyer = "Vendredi" }
                 if (DateDuJour.getDay() == "6") { JourARenvoyer = "Samedi" }
                 if (DateDuJour.getDay() == "0") { JourARenvoyer = "Dimanche" }
                 return JourARenvoyer;
             }
             function JourDeLaDate() {
                 var date1 = document.forms['FormDate'].elements['DateChoix'].value
                 dateRecherche = date1;
                 var date2 = temps(date1.split("-"));
                 document.forms['FormDate'].elements['jour'].value = date2;
                 AjaxExceptionDay()
             }
             function ChoixSchema(schema) {
                 var URL = document.URL.split('?')[0];
                 document.location.href = URL + "?schema=" + schema;
             }
             function AjaxExceptionDay() {
                 try {
                     ajaxRequest = new XMLHttpRequest();
                 } catch (e) {
                     // Internet Explorer Browsers
                     try {
                         ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
                     } catch (e) {
                         try {
                             ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
                         } catch (e) {
                             // Something went wrong
                             alert("Your browser broke!");
                             return false;
                         }
                     }
                 }
                 var queryString = "?date=" + dateRecherche;
                 queryString += "&ajax=1" + "&schema=" + schema;
                 ajaxRequest.open("GET", "requete.php" + queryString, false);
                 ajaxRequest.send(null);
                 console.log("---- R1 ----");
                 console.log(queryString);
                 console.log(ajaxRequest.responseText);
                 console.log("------------");
                 var Reponse = ajaxRequest.responseText;
                 if (Reponse == 0) {
                     document.getElementById('ExceptionDay').value = 'Le Jour n\'est pas un jour particulier.';
                     document.getElementById('InputYesNoEx').value = "0";
                     document.getElementById("tableauEx").style.display = "none";
                 }
                 else {
                     document.getElementById('ExceptionDay').value = 'Ce jour est un jour particulier.';
                     document.getElementById('resultatEx').innerHTML = Reponse;
                     document.getElementById('InputYesNoEx').value = "1";
                 }
             }
             function AjaxListeCalendrier(ligne) {
                 try {
                     ajaxCalendrier = new XMLHttpRequest();
                 } catch (e) {
                     // Internet Explorer Browsers
                     try {
                         ajaxCalendrier = new ActiveXObject("Msxml2.XMLHTTP");
                     } catch (e) {
                         try {
                             ajaxCalendrier = new ActiveXObject("Microsoft.XMLHTTP");
                         } catch (e) {
                             // Something went wrong
                             alert("Your browser broke!");
                             return false;
                         }
                     }
                 }
                 if (document.getElementById('ExceptionDay').value == 'Ce jour est un jour particulier.') {
                     Exday = 1;
                     cal = document.getElementById("tableauEx").rows[1].cells[0].innerHTML;
                 } else {
                     Exday = 0;
                     cal = 0;
                 }
                 var queryString = "?ligne=" + ligne;
                 queryString += "&ajax=2&date=" + dateRecherche + "&Ex=" + Exday + "&cal=" + cal + "&schema=" + schema;
                 //alert(queryString);
                 ajaxCalendrier.open("GET", "requete.php" + queryString, false);
                 ajaxCalendrier.send(null);
                 console.log("---- R2 ----");
                 console.log(queryString);
                 console.log(ajaxCalendrier.responseText);
                 console.log("------------");
                 var Reponse = ajaxCalendrier.responseText;
                 document.getElementById('Form3').innerHTML = ajaxCalendrier.responseText;
             }
             function Affine() {
                 var nbLigneTab = document.getElementById('tableau').rows.length - 1;
                 try {
                     ajaxAffiner = new XMLHttpRequest();
                 } catch (e) {
                     // Internet Explorer Browsers
                     try {
                         ajaxAffiner = new ActiveXObject("Msxml2.XMLHTTP");
                     } catch (e) {
                         try {
                             ajaxAffiner = new ActiveXObject("Microsoft.XMLHTTP");
                         } catch (e) {
                             // Something went wrong
                             alert("Your browser broke!");
                             return false;
                         }
                     }
                 }
                 ExDay = document.getElementById('InputYesNoEx').value;
                 var queryString = "?ajax=4";
                 if (ExDay == "0") {
                     queryString += "&nbligne=" + nbLigneTab + "&date=" + dateRecherche + "&jourSemaine=" + document.getElementById('joursemaine').value + "&Ex=" + ExDay + "&ligne=" + document.getElementById("date").options[document.getElementById('date').selectedIndex].text + "&schema=" + schema;
                 } else {
                     queryString += "&cal=" + cal + "&nbligne=" + nbLigneTab + "&date=" + dateRecherche + "&jourSemaine=" + document.getElementById('joursemaine').value + "&Ex=" + ExDay + "&ligne=" + document.getElementById("date").options[document.getElementById('date').selectedIndex].text + "&schema=" + schema;
                 }
                 console.log(queryString);
                 ajaxAffiner.open("GET", "requete.php" + queryString, false);
                 ajaxAffiner.send(null);
                 console.log("---- R4 ----");
                 console.log(queryString);
                 console.log(ajaxAffiner.responseText);
                 console.log("------------");
                 var Reponse = ajaxAffiner.responseText;
                 document.getElementById('resultat').innerHTML = ajaxAffiner.responseText;
             }
    </script>
    </head>
    <body>
        <div class="container">
			<header>
				<h1>Aide <span>Pour Chouette</span></h1>
				<h2>Une aide simple pour des explications claires.</h2>
			</header>
			<section class="ac-container">
				<div>
					<input id="ac-1" style="display: none" name="accordion-1" type="radio" checked />
					<label for="ac-1">Quel jour ? Quelle ligne ?</label>
					<article class="ac-exlarge">
                        <form method="post" action="#" name="FormDate">
                        <center><p>Base de Donnée : <select onChange='ChoixSchema(this.value);' name="schema" id="schema"></p></center>
                        <option selected>Choisir Base</option>  
				                <?php 
                                    $sqlSc= 'SELECT SCHEMA_NAME FROM information_schema.schemata LIMIT (SELECT "count"(*)	SCHEMA_NAME FROM information_schema.schemata)-6;'; 
                                    $listeSc = pg_query($sqlSc); 
                                        while ($valeurSc=pg_fetch_array($listeSc)){ 
                	                        echo "<option>".$valeurSc["schema_name"]."</option>"; 
                                        } 
                                ?>
                        <html> 
			            </select><font size="1" id="label" style="display: none" color="red"> BASE : </font>
						<center><p>Date à Rechercher : <br><input type="date" name="DateChoix" onChange="return JourDeLaDate()"><font size="1">ex : 2015-01-01</font></p>
                        <center><p>Jour de la Semaine : <br><input type="text" name="jour" id="joursemaine" style="width:200px;text-align:center" readonly></p></center>
                        <center><p>Numéro de Ligne :<br><select onChange='AjaxListeCalendrier(this.value);' name="type" id="date"></p></center>
                        <option selected>Choisir</option>  
				                <?php 
                                    $sql= 'SELECT "number" FROM "'.$schema.'"."lines" ORDER BY "number" ASC'; 
                                    $liste = pg_query($sql); 
                                        while ($valeur=pg_fetch_array($liste)){ 
                	                        echo "<option>".$valeur["number"]."</option>"; 
                                        } 
                                ?>
                        <html> 
			            </select>
                            </form>
					</article>
				</div>
                <?php
                    if($schema){
                        echo "<script>document.getElementById('label').innerHTML = ' BASE : ".$schema."'</script>";
                        echo "<script>document.getElementById('label').style.display = 'block'</script>";
                    }
                ?>
				<div>
					<input id="ac-2" style="display: none" name="accordion-1" type="radio" />
					<label for="ac-2">Jour Particulier ? <i>(Information)</i></label>
					<article id="Form2" class="ac-medium">
                        <center><p>Particulier : <br><input type="text" name="jour" id="ExceptionDay" style="width:300px;text-align:center" readonly></p></center>
                        <center><div id="resultatEx"></div>
                            <input type="text" style="display: none" id="InputYesNoEx" value="0"></input>
                    </article>
				</div>
				<div>
					<input id="ac-3" style="display: none" name="accordion-1" type="radio" />
					<label for="ac-3">Liste des Calendriers de la ligne <i>(Information)</i></label>
					<article id="Form3" class="ac-large">
						
					</article>
				</div>
				<div>
					<input id="ac-4" style="display: none" name="accordion-1" type="radio" onclick='Affine();' />
					<label for="ac-4">Liste des Parcours</label>
					<article id="Form4" class="ac-exlarge">
						<div id="resultat"></div>
					</article>
				</div>
			</section>
        </div>
    </body>
</html>