<?php
$login = htmlentities($_GET["login"]); //Récupération de la variable login
$pass = htmlentities($_GET["pass"]); //Récupération de la variable pass
$ds = ldap_connect("kiwi.private");  // On initialise la connexion au domaine (doit être un serveur LDAP valide !)
$r = ldap_bind($ds,"$login@kiwi.private","$pass") or die("Connexion impossible"); // connexion avec user et password

if ($ds<>0)
	{ 
		$sr = ldap_search($ds,"OU=Comptes standards,OU=Utilisateurs,OU=13_K_PAYS_AIX,OU=Filiales,OU=DDMED,OU=KEOLISPROD,DC=kiwi,DC=private","sAMAccountName=pmaldi");
		echo "Le résultat de la recherche est ".$sr."<br />";
		$nb = ldap_get_entries($ds, $sr);		
		echo "Nombre de personnes trouvées : ".$nb["count"]. "<p>";
		for ($i=0;$i<$nb["count"];$i++)
			{
				echo "Name : ". $nb[$i]["dn"] ."<br>";// afichier DN des user
			}
		echo "Déconnexion...<br>";
		ldap_close($ds);
 
	}
	 else
		{
			echo  "Impossible de se connecter au serveur LDAP";
		}		
?>