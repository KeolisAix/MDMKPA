//VARIABLE GLOBALE
	  var canvas;
      var ctx;
	  var ContenuDuSinistre;
	  var DateAccident = "00/00/0000";
	  var CoordonneesAccident;
	  var WinLogon;
	  var Constat;
	  var KeoRisk;
	  var i;
	  var x;
	  var y;
	  var img = new Image();
		img.height = 24; 
		img.width = 24;
		img.setAttribute("src","images/red.png");
	  var cercleNoir = new Image();
	  cercleNoir.height = 24;
	  cercleNoir.width = 24;
      cercleNoir.setAttribute("src","images/cercle.png");
	  var numday, month, numyear, numhours, numminutes, numseconds, nowtoday;
	  var heureSinistre;
	  var ajaxRequest;
	  var ajaxRequestUpdate;
	  var ajaxRequestDel;
	  var ajaxPhoto;
	  var ctx;
function init() {
        canvas = document.getElementById("myCanvas");
        ctx = canvas.getContext("2d");
		i=0;
		canvas.addEventListener('click', function (evt) {
		    i = i + 1;
		    var mousePos = getMousePos(canvas, evt);
		    var message = mousePos.x + ',' + mousePos.y + '= ' + i;
		    y = mousePos.y;
		    x = mousePos.x;

		    writeMessage(canvas, message);

		    var statesdemo = {
		        state0: {
		            title: 'Ajout d\'un Sinistre ! Aïe Aïe Aïe !',
		            html: '<center><img src="http://www.iconsbase.net/images/icones/9bf813902e963aa47a2be9882547662f/9bf813902e963aa47a2be9882547662f_64.png"><label>Description du Sinistre : </label><center><br><input type="text" id="MotifDuSinistre" style="width:100%;" value="" autofocus><br />',
		            buttons: { Annuler: false, Suivant: true },
		            focus: 1,
		            submit: function (e, v, m, f) {
		                if (v) {
		                    e.preventDefault();
		                    $.prompt.goToState('state1');
		                    ctx.drawImage(img, mousePos.x, mousePos.y);
		                    Constat = "Non";
		                    KeoRisk = "";
		                    ContenuDuSinistre = document.getElementById("MotifDuSinistre").value;
		                    return false;
		                }
		                $.prompt.close();
		            }
		        },
		        state1: {
                    title: 'Ajout d\'un Sinistre ! Aïe Aïe Aïe !',
		            html: '<center><img src="http://www.iconsbase.net/images/icones/9bf813902e963aa47a2be9882547662f/9bf813902e963aa47a2be9882547662f_64.png"><label>Date du Sinistre : </label><center><br><input type="text" id="DateDuSinistre" style="width:100%;" value="01/01/2015" autofocus><br />',
		            buttons: { Retour: -1, "Suivant": 0 },
		            focus: 1,
		            submit: function (e, v, m, f) {
		                e.preventDefault();
		                if (v == 0) {
                            e.preventDefault();
		                    $.prompt.goToState('state2');
                            DateAccident = document.getElementById("DateDuSinistre").value;
		                    return false;
		                }
		                else if (v == -1)
		                    $.prompt.goToState('state0');
		            }
		        },
                state2: {
                    title: 'Ajout d\'un Sinistre ! Aïe Aïe Aïe !',
		            html: '<center><img src="http://www.icone-png.com/png/15/14854.png"><label>Coordonnées du Sinistre :<br><a href="https://www.google.fr/maps/place/Aix-en-Provence/@43.535974,5.387947,12z/data=!3m1!4b1!4m2!3m1!1s0x12c98da304b91259:0x5cb953bec8b688a3" onclick="window.open(this.href); return false;">Ouvrir Google Maps</a></label><center><br><input type="text" id="CoordonneesSinistre" style="width:100%;" value="48.858388, 2.294481" autofocus><br />',
		            buttons: { Retour: -1, "Enregistrer le sinistre": 0 },
		            focus: 1,
		            submit: function (e, v, m, f) {
		                e.preventDefault();
		                if (v == 0) {
                            CoordonneesAccident = document.getElementById("CoordonneesSinistre").value;
		                    ajouterLigne();
		                    $.prompt.close();
		                }
		                else if (v == -1)
		                    $.prompt.goToState('state1');
		            }
		        }
		    };

		    $.prompt(statesdemo);
		}, false);
			draw(ctx);
       
      }

function test(){
    window.location = canvas.toDataURL("image/png");
}
function initdate() {
        var now = new Date();
 
        numday = now.getDate();
        nummonth = now.getMonth();
        month = nummonth+1;
        numyear = now.getFullYear();
        numhours = now.getHours();
        numminutes = now.getMinutes();
        numseconds = now.getSeconds();        
        if(numday<10) {
                numday = "0"+numday;
        }       
        if(month<10) {
                month = "0"+month;
        }        
        if(numhours < 10) {
                numhours = "0"+numhours;
        }        
        if(numminutes < 10) {
                numminutes = "0"+numminutes;
        }        
        if(numseconds < 10) {
                numseconds = "0"+numseconds;
        }
}
function parsedate() {
        numseconds++;
        if(numseconds < 10) {
                numseconds = "0"+numseconds;
        }
        if(numseconds >= 60)
        {
                numseconds = "00";
                numminutes++;
                if(numminutes < 10) {
                        numminutes = "0"+numminutes;
                }
        }        
        if(numminutes >= 60)
        {
                numminutes = "00";
                numhours++;
                if(numhours < 10) {
                        numhours = "0"+numhours;
                }
        }       
        if(numhours >= 24)
        {
                numhours = "00";
                initdate();
        }
        // AFFICHAGE DU COUPLE DATE/HEURE
        nowtoday = "Nous sommes le ";
        nowtoday += numyear+"-"+month+"-"+numday;
        nowtoday += " et il est ";
        nowtoday += numhours+":"+numminutes+":"+numseconds;  
        //document.getElementById('dateheure').innerHTML = nowtoday;
}
initdate();
function addCercle(X,Y){
    X = X - 10;
    Y = Y - 6;
    ctx.drawImage(cercleNoir,X,Y);
}
function clearCercle(X,Y){
    X = X - 10;
    Y = Y - 6;
    ctx.clearRect(X, Y, 32, 32);
    ctx.drawImage(img, X + 10, Y + 6);
}
function ajouterLigne()
{
	WinLogon = document.getElementById("controleurHidden").innerHTML;
	var tableau = document.getElementById("tableau");
	var ligne = tableau.insertRow(-1);
	
	var colonne0 = ligne.insertCell(0);
	colonne0.innerHTML += i;//ID
	
	var colonne1 = ligne.insertCell(1);
	colonne1.innerHTML += numday+"/"+month+"/"+numyear;//DATE Declaration
	
	var colonne2 = ligne.insertCell(2);
    heureSinistre = numhours+"H"+numminutes;
	colonne2.innerHTML += heureSinistre;//HEURE DE LA DECLARATION
	
	
	var colonne3 = ligne.insertCell(3);
	colonne3.innerHTML += WinLogon;//NOM D'UTILISATEUR
	
	var colonne4 = ligne.insertCell(4);
	colonne4.innerHTML += DateAccident; //Date Accident

	var colonne5 = ligne.insertCell(5);
	colonne5.innerHTML += ContenuDuSinistre; //CONTENU DU SINISTRE
	
	var colonne6 = ligne.insertCell(6);
	colonne6.innerHTML += "<a onclick='modifierConstat(this)'><u>"+Constat+"</u></a>"; // CONSTAT ?
	
	var colonne12 = ligne.insertCell(7);
	colonne12.innerHTML += KeoRisk; // NUMERO KEORISK ?

	var colonne11 = ligne.insertCell(8);
	colonne11.innerHTML +=
    	'<br><span class="btn btn-success fileinput-button">'+
        '<i class="glyphicon glyphicon-plus"></i>'+
        '<span>Choisir la photo.</span>'+
        '<input id="fileupload" type="file" name="files[]">'+
    	'</span>'+
    	'<br><div id="progress" class="progress">'+
        '<div class="progress-bar progress-bar-success"></div>'+
    	'</div>'+
    	'<div id="files" class="files"></div>';
	
    var colonne13 = ligne.insertCell(9);
    colonne13.innerHTML += "<a href='http://maps.google.com?q="+CoordonneesAccident+"'>Lien</a>";
    	
	var colonne7 = ligne.insertCell(10);
	colonne7.innerHTML += "<img src='./images/supprimer.svg' onclick='deleteRow(this)' />"; // SUPP ?
	
	var colonne8 = ligne.insertCell(11);
	colonne8.innerHTML += x; // X ?
	colonne8.style.display = 'none';
	
	var colonne9 = ligne.insertCell(12);
	colonne9.innerHTML += y; // Y ?
	colonne9.style.display = 'none';
	
	var colonne10 = ligne.insertCell(13);
	colonne10.innerHTML += "<img src='./images/repair.png' onclick='archivage(this)' />"; // ARCHIVER ?	
	try{
		ajaxRequest = new XMLHttpRequest();
		}catch (e){
		   // Internet Explorer Browsers
		   try{
			  ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		   }catch (e) {
			  try{
				 ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			  }catch (e){
				 // Something went wrong
				 alert("Your browser broke!");
				 return false;
			  }
		   }
		 }
 var date = numday+"/"+month+"/"+numyear;
 var descriptif = encode64(ContenuDuSinistre);
 var controleur = WinLogon;
 var heure = heureSinistre;
 var bus = document.getElementById("busHidden").innerHTML;
 var queryString = "?date=" + date ;
 queryString +=  "&update=0&descriptif=" + descriptif + "&controleur=" + controleur + "&bus=" + bus + "&heure=" + heure + "&x=" + x + "&y=" + y + "&DateSinistre=" + DateAccident + "&CoordAcc="+ CoordonneesAccident;
 ajaxRequest.open("GET", "requete.php" + queryString, true);
 ajaxRequest.send(null); 
 uploadByjQuery(descriptif, x, y);
}

function writeMessage(canvas, message) {
	var context = canvas.getContext('2d');
	//draw(context);
	context.clearRect(0, 0, 220, 40);
	context.font = '14px Calibri';
	context.fillStyle = 'black';
	context.fillText(message, 10, 25);
} //writeMessage
	  
function getMousePos(canvas, evt) {
	var rect = canvas.getBoundingClientRect();
	return {
	  x: evt.clientX - rect.left - 10,
	  y: evt.clientY - rect.top - 11
	};
} //getMouse

function draw(ctx) {
	  		ctx.fillStyle = '#dedede';
		ctx.strokeStyle= 'red';
		
		ctx.fillStyle= 'black';
		ctx.font = '40px Arial';
		if(document.getElementById("modeleHidden").innerHTML == "CROSSWAY LE"){
			ctx.fillText(document.getElementById("busHidden").innerHTML+' - '+document.getElementById("modeleHidden").innerHTML, 350, 430);
		}
		if(document.getElementById("modeleHidden").innerHTML == "CITARO"){
			ctx.fillText(document.getElementById("busHidden").innerHTML+' - '+document.getElementById("modeleHidden").innerHTML, 350, 500);
		}
		if(document.getElementById("modeleHidden").innerHTML == "CITY 21"){
			ctx.fillText(document.getElementById("busHidden").innerHTML+' - '+document.getElementById("modeleHidden").innerHTML, 450, 430);
		}
		if(document.getElementById("modeleHidden").innerHTML == "SETRA 415 NF"){
			ctx.fillText(document.getElementById("busHidden").innerHTML+' - '+document.getElementById("modeleHidden").innerHTML, 350, 500);
		}
		if(document.getElementById("modeleHidden").innerHTML == "GX 127C"){
			ctx.fillText(document.getElementById("busHidden").innerHTML+' - '+document.getElementById("modeleHidden").innerHTML, 450, 420);
		}		
		for(var i= 1; i < document.getElementById('tableau').rows.length; i++)
		{
			 ctx.drawImage(img, document.getElementById("tableau").rows[i].cells[9].innerHTML,document.getElementById("tableau").rows[i].cells[12].innerHTML);
		}
} //draw

function deleteRow(r) {
            $.prompt("<img src='http://upload.wikimedia.org/wikipedia/commons/thumb/b/bb/Danger.png/40px-Danger.png'><center>Etes-vous sur de vouloir supprimer ce sinistre ?</center>", {
	        title: "Attention ! Risque de Sinistre ! :-O",
	        buttons: { "Oui, je suis sur": true, "Non, ne pas supprimer": false },
	        submit: function(e,v,m,f){
		        if(v){
		        var i = r.parentNode.parentNode.rowIndex;
					var xtab = document.getElementById("tableau").rows[i].cells[11].innerHTML ;
					var ytab = document.getElementById("tableau").rows[i].cells[12].innerHTML ;
					ctx.clearRect(xtab, ytab, 16, 16);
					try{
						ajaxRequestDel = new XMLHttpRequest();
						}catch (e){
						   // Internet Explorer Browsers
						   try{
							  ajaxRequestDel = new ActiveXObject("Msxml2.XMLHTTP");
						   }catch (e) {
							  try{
								 ajaxRequestDel = new ActiveXObject("Microsoft.XMLHTTP");
							  }catch (e){
								 // Something went wrong
								 alert("Your browser broke!");
								 return false;
							  }
						   }
						 }
				 var bus = document.getElementById("busHidden").innerHTML;
				 var motifupdate = encode64(document.getElementById("tableau").rows[i].cells[5].innerHTML);
				 var queryString = "?update=2";
				 queryString +=  "&motifUpdate=" + motifupdate + "&bus=" + bus;
				 ajaxRequestDel.open("GET", "requete.php" + queryString, true);
				 ajaxRequestDel.send(null);
				 document.getElementById("tableau").deleteRow(i);
                }
	        }
        });
} //deleterow

function modifierConstat(w){
		var j = w.parentNode.parentNode.rowIndex;
		var NumKeorisk = prompt("Numero KeoRisk : ", "")
		if(NumKeorisk != null){
		document.getElementById("tableau").rows[j].cells[6].innerHTML = "<u>Oui</u>";
		document.getElementById("tableau").rows[j].cells[7].innerHTML = NumKeorisk;
			try{
			ajaxRequestUpdate = new XMLHttpRequest();
			}catch (e){
			   // Internet Explorer Browsers
			   try{
				  ajaxRequestUpdate = new ActiveXObject("Msxml2.XMLHTTP");
			   }catch (e) {
				  try{
					 ajaxRequestUpdate = new ActiveXObject("Microsoft.XMLHTTP");
				  }catch (e){
					 // Something went wrong
					 alert("Your browser broke!");
					 return false;
				  }
			   }
			 }
	 var bus = document.getElementById("busHidden").innerHTML;
	 var x = document.getElementById("tableau").rows[j].cells[11].innerHTML;
	 var y = document.getElementById("tableau").rows[j].cells[12].innerHTML;
	 var motifupdate = encode64(document.getElementById("tableau").rows[j].cells[5].innerHTML);
	 var queryString = "?update=1";
	 queryString +=  "&motifUpdate=" + motifupdate + "&bus=" + bus + "&NumKeo=" + NumKeorisk + "&x=" + x + "&y=" + y;
	 ajaxRequestUpdate.open("GET", "requete.php" + queryString, true);
	 ajaxRequestUpdate.send(null);
		}
} //constat

function ModifierCoord(w){
		var j = w.parentNode.parentNode.rowIndex;
		var NvlCoord = prompt("Nouvelles Coordonnées : ", "48.858388, 2.294481")
		if(NvlCoord != null){
		document.getElementById("tableau").rows[j].cells[9].innerHTML = '<a href="http://mdmkpa/carte/index.php?q='+NvlCoord+'" onclick="window.open(this.href); return false;">'+NvlCoord+'</a><input type="button" value="Modifier" onclick="ModifierCoord(this)" />'
			try{
			ajaxRequestUpdate = new XMLHttpRequest();
			}catch (e){
			   // Internet Explorer Browsers
			   try{
				  ajaxRequestUpdate = new ActiveXObject("Msxml2.XMLHTTP");
			   }catch (e) {
				  try{
					 ajaxRequestUpdate = new ActiveXObject("Microsoft.XMLHTTP");
				  }catch (e){
					 // Something went wrong
					 alert("Your browser broke!");
					 return false;
				  }
			   }
			 }
	 var bus = document.getElementById("busHidden").innerHTML;
	 var x = document.getElementById("tableau").rows[j].cells[11].innerHTML;
	 var y = document.getElementById("tableau").rows[j].cells[12].innerHTML;
	 var motifupdate = encode64(document.getElementById("tableau").rows[j].cells[5].innerHTML);
	 var NvlCoord64 = encode64(NvlCoord);
	 var queryString = "?update=5";
	 queryString +=  "&motifUpdate=" + motifupdate + "&bus=" + bus + "&coord=" + NvlCoord64 + "&x=" + x + "&y=" + y;
	 ajaxRequestUpdate.open("GET", "requete.php" + queryString, true);
	 ajaxRequestUpdate.send(null);
		}
} //constat


function archivage(w){
		userConfirm = confirm('Etes-vous sur que le véhicule a été réparé ?');
			if (userConfirm == true) {
				var k = w.parentNode.parentNode.rowIndex;
					try{
					ajaxArchive = new XMLHttpRequest();
					}catch (e){
					   // Internet Explorer Browsers
					   try{
						  ajaxArchive = new ActiveXObject("Msxml2.XMLHTTP");
					   }catch (e) {
						  try{
							 ajaxArchive = new ActiveXObject("Microsoft.XMLHTTP");
						  }catch (e){
							 // Something went wrong
							 alert("Your browser broke!");
							 return false;
						  }
					   }
					 }
			 var bus = document.getElementById("busHidden").innerHTML;
			 var x = document.getElementById("tableau").rows[k].cells[11].innerHTML;
			 var y = document.getElementById("tableau").rows[k].cells[12].innerHTML;
				 ctx.clearRect(x, y, 16, 16);
			 var motifArchive = encode64(document.getElementById("tableau").rows[k].cells[5].innerHTML);
			 var queryString = "?update=3";
			 queryString +=  "&motifArchive=" + motifArchive + "&bus=" + bus + "&x=" + x + "&y=" + y;
			 ajaxArchive.open("GET", "requete.php" + queryString, true);
			 ajaxArchive.send(null);
			document.getElementById("tableau").deleteRow(k);
			}
	} //archive
	
function uploadByjQuery(descriptif, x, y){
	$(function () {
		'use strict';
		// Change this to the location of your server-side upload handler:
		var url = window.location.hostname === 'blueimp.github.io' ?
					'//jquery-file-upload.appspot.com/' : 'photo_sinistre/';
		var motif = descriptif;
		var filename;
		$('#fileupload').fileupload({
			url: url,
			dataType: 'json',
			done: function (e, data) {
				$.each(data.result.files, function (index, file) {
					$('<a href="http://192.168.207.125/sinistre/photo_sinistre/files/'+file.name+'" id="PhotoDone" name="'+file.name+'"><p/>').text(file.name).appendTo('#files');
					filename =  file.name;
				});
				
			try{
		ajaxPhoto = new XMLHttpRequest();
		}catch (e){
		   // Internet Explorer Browsers
		   try{
			  ajaxPhoto = new ActiveXObject("Msxml2.XMLHTTP");
		   }catch (e) {
			  try{
				 ajaxPhoto = new ActiveXObject("Microsoft.XMLHTTP");
			  }catch (e){
				 // Something went wrong
				 alert("Your browser broke!");
				 return false;
			  }
		   }
		 }
			var bus = document.getElementById("busHidden").innerHTML;
			var queryString = "?date=" + motif ;
			queryString +=  "&update=4&motifUpdate=" + motif + "&photo=" + filename + "&bus=" + bus;
			ajaxPhoto.open("GET", "requete.php" + queryString, true);
			ajaxPhoto.send(null); 																
			},
			progressall: function (e, data) {
				var progress = parseInt(data.loaded / data.total * 100, 10);
				$('#progress .progress-bar').css(
					'width',
					progress + '%'
				);
			}
		}).prop('disabled', !$.support.fileInput)
			.parent().addClass($.support.fileInput ? undefined : 'disabled');
	});	
}
  function encode64(input) {
	    var keyStr = "ABCDEFGHIJKLMNOP" +
               "QRSTUVWXYZabcdef" +
               "ghijklmnopqrstuv" +
               "wxyz0123456789+/" +
               "=";
     input = escape(input);
     var output = "";
     var chr1, chr2, chr3 = "";
     var enc1, enc2, enc3, enc4 = "";
     var i = 0;

     do {
        chr1 = input.charCodeAt(i++);
        chr2 = input.charCodeAt(i++);
        chr3 = input.charCodeAt(i++);

        enc1 = chr1 >> 2;
        enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
        enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
        enc4 = chr3 & 63;

        if (isNaN(chr2)) {
           enc3 = enc4 = 64;
        } else if (isNaN(chr3)) {
           enc4 = 64;
        }

        output = output +
           keyStr.charAt(enc1) +
           keyStr.charAt(enc2) +
           keyStr.charAt(enc3) +
           keyStr.charAt(enc4);
        chr1 = chr2 = chr3 = "";
        enc1 = enc2 = enc3 = enc4 = "";
     } while (i < input.length);

     return output;
  }
   function decode64(input) {
	   	    var keyStr = "ABCDEFGHIJKLMNOP" +
               "QRSTUVWXYZabcdef" +
               "ghijklmnopqrstuv" +
               "wxyz0123456789+/" +
               "=";
     var output = "";
     var chr1, chr2, chr3 = "";
     var enc1, enc2, enc3, enc4 = "";
     var i = 0;

     // remove all characters that are not A-Z, a-z, 0-9, +, /, or =
     var base64test = /[^A-Za-z0-9\+\/\=]/g;
     if (base64test.exec(input)) {
        alert("There were invalid base64 characters in the input text.\n" +
              "Valid base64 characters are A-Z, a-z, 0-9, '+', '/',and '='\n" +
              "Expect errors in decoding.");
     }
     input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

     do {
        enc1 = keyStr.indexOf(input.charAt(i++));
        enc2 = keyStr.indexOf(input.charAt(i++));
        enc3 = keyStr.indexOf(input.charAt(i++));
        enc4 = keyStr.indexOf(input.charAt(i++));

        chr1 = (enc1 << 2) | (enc2 >> 4);
        chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
        chr3 = ((enc3 & 3) << 6) | enc4;

        output = output + String.fromCharCode(chr1);

        if (enc3 != 64) {
           output = output + String.fromCharCode(chr2);
        }
        if (enc4 != 64) {
           output = output + String.fromCharCode(chr3);
        }

        chr1 = chr2 = chr3 = "";
        enc1 = enc2 = enc3 = enc4 = "";

     } while (i < input.length);

     return unescape(output);
  }