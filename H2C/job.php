<!doctype html>
<html lang="en-US">
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
  <title>Success</title>
  <link rel="stylesheet" type="text/css" media="all" href="style.css">
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>

<body>
    <div id="content">
      <div class="notify successbox">
        <h1>Job validé !</h1>
        <span class="alerticon"><img src="images/check.png" alt="checkmark" /></span>
        <p>Le job d'import a bien été envoyé au serveur Talend.</p>
          <p>Vous allez recevoir un mail une fois le job terminé.</p>
      </div>
    </div><!-- @end #content -->
<script type="text/javascript">
$(function(){
  $('#content').on('click', '.notify', function(){
    $(this).fadeOut(350, function(){
      $(location).attr('href','http://google.com/');
    });
  });
});
</script>
    <iframe src="http://localhost:34676/H2C/requete.php"></iframe>
</body>

</html>