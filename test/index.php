<?php
$login = htmlentities($_GET["login"]); //Récupération de la variable login
$pass = htmlentities($_GET["pass"]); //Récupération de la variable pass
$ds = ldap_connect("kiwi.private");  // On initialise la connexion au domaine (doit être un serveur LDAP valide !)
$r = ldap_bind($ds,"$login@kiwi.private","$pass") or die("Connexion impossible"); // connexion avec user et password

if ($ds<>0)
	{ 
		$sr = ldap_search($ds,"OU=KEOLISPROD,DC=kiwi,DC=private","sAMAccountName=".$login);
		$nb = ldap_get_entries($ds, $sr);		
		echo "Name : ". $nb[0]["cn"][0] ."<br>";// afichier DN des user
        echo "Mail : ". $nb[0]["mail"][0] ."<br>";// afichier DN des user
        echo "Groupes : ". $nb[0]["memberof"][0] ."<br>";// afichier DN des user
        echo "Fonction : ". $nb[0]["title"][0] .",". $nb[0]["department"][0] ."<br>";// afichier DN des user
        echo "Société : ". $nb[0]["company"][0] ."<br>";// afichier DN des user
        echo "Tel : ". $nb[0]["telephonenumber"][0] ."<br>";// afichier DN des user
		ldap_close($ds);
 
	}
	 else
		{
			echo  "Impossible de se connecter au serveur LDAP";
		}		
?>