<?php
echo "<h2><a href='./Accueil.php'>Retour à l'accueil </a></h2><br>";
$host="web-bdd.telecom-lille.fr";
$user="USER5";
$pwd="xxxxx";
$base="projet5";
$con=mysqli_connect($host,$user,$pwd,$base) or die("erreur de connexion au serveur $host");
?>
