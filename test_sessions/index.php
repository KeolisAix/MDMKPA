<?php
    
session_start();
if(!$_SESSION['old']){
    $_SESSION['old'] = "ok";
    echo "IF OK<br>";
    echo "old : ".$_SESSION['old'];
    echo "<br>";
    echo "New : ".$_SESSION['md5'];
    session_unset('old');
    echo "old : ".$_SESSION['old'];
}else{
    echo "IF NOK<br>";
    echo "Old : ".$_SESSION['old'];
    echo "<br>";
    echo "New : ".$_SESSION['md5'];
}
?>