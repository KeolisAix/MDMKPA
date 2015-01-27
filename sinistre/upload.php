<?php
$bus = $_GET['bus'];
$motif = $_GET['motif'];
$target_dir = "photo_sinistre/files/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

$info = getimagesize($_FILES['fileToUpload']['tmp_name']);
echo $info['mime']."<br><br>";

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        $base = pg_connect("host=192.168.207.125 dbname=vehicules_sinistre user=postgres password=postgres");
        $sql = "UPDATE vehicules SET photo = '".$_FILES["fileToUpload"]["name"]."' WHERE motif = '".$motif."' AND vehicule = '".$bus."'";
        $req = pg_query($base ,$sql) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_error());
        echo $sql;
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
        echo "Sorry, there was an error uploading your file.";
	echo $_FILES["fileToUpload"]["tmp_name"];
	echo "<br><br>".$target_file;	
    }
}

?>
