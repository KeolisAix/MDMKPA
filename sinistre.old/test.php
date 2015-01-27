<head>
    <style>
		 .groupProgress{ width:100px;height:10px;border:1px solid #999;background:#eee;}
		 #barreProgress{width:0px;height:10px;background:red;}
    </style>
    <script>
		function enProgression(e){
			 var pourcentage = Math.round((e.loaded * 100) / e.total);
			 _("barreProgress").style.width=pourcentage+"%";
		}
		 
		function actionTerminee(e){
			 _("status").innerHTML = e.target.responseText;
		}
		function enErreur(e){
		 	_("status").innerHTML = "Upload Failed";
		}
		function operationAnnulee(e){
		 	_("status").innerHTML = "Upload Aborted";
		}
</script>
</head>

<body>
    <form id="test.php" enctype="multipart/form-data" method="post">
         <input type="file" name="champsFichier" id="champsFichier"><br>
         <input type="button" value="Uploader" onclick="uploadFile()">
         <h3 id="status"></h3>
    </form>
    <div><div id="barreProgress"></div></div>
</body>