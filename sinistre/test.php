<html>
    <head>
        <link rel="stylesheet" href="css/upload.css">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"></script>
        <script src="js/upload.js"></script>
    </head>
    <a href="#?w=500" rel="popup_name" class="poplight">Photo</a>
    <div id="popup_name" class="popup_block">
        <form action="upload.php" method="post" enctype="multipart/form-data">
            Photo du Sinitre :
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Upload Image" name="submit">
        </form>
</div></html>