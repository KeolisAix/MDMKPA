<?php
$fileName = $_FILES["fichier"]["name"];
$fileTmp = $_FILES["fichier"]["tmp_name"];
$fileType = $_FILES["fichier"]["type"];
$fileSize = $_FILES["fichier"]["size"];
$fileErrorMsg = $_FILES["fichier"]["error"];

if (!$fileTmp) { // if file not chosen
	 echo $fileType.'message derreur';
	 exit();
}
if(move_uploaded_file($fileTmp, 'photo_sinistre/'.$fileName)){
 	echo $fileName.' upload reussi';
} else {
 	echo 'Upload php Failed';
}
?>