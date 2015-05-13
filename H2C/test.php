<?php
$host = "192.168.207.22";
$port = "5432";
$BDDUser = "postgres";
$BDDPass = "postgres";
$Database = "authentification";
$user = "patrice.maldi@keolis.com";
$pass = "Ilete1fois";
$base = pg_connect("host=".$host." port=".$port." dbname=".$Database." user=".$BDDUser." password=".$BDDPass);
                    $sql = "SELECT \"public\".auth.utilisateur, \"public\".auth.pass FROM \"public\".auth WHERE \"public\".auth.utilisateur = '".$user."' AND \"public\".auth.pass = '".$pass."'";
                    $req = pg_query($base ,$sql);
                    $row = pg_num_rows($req);
                    if($row == 1)
                    {
                        echo "oui";
                        echo $row;
                    }
                    else
                    {
                        echo "non";
                        echo $row;
                    }
?>
