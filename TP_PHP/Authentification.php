<html>
	<head>
		<title> Page d'authentification </title>
	</head>
	
	<body>
		<?php
		include ('./sql_con.php');
		$station=$_POST["station"];
		$requete="SELECT velos_dispos, nbre_places, nom_station FROM station WHERE ID_station=$station";
		$res=mysqli_query($con,$requete);
		$ligne=mysqli_fetch_object($res);
		if($ligne->velos_dispos==0){
			echo "<h4>Attention, plus de vélo disponible pour cette station !</h4>" ;
			echo "<a href='./Accueil.php'>Retour à la sélection de la station </a> <br>";
		}
		elseif($ligne->nbre_places==$ligne->velos_dispos){
			echo "<h4>Attention, plus de place pour déposer votre vélo !</h4>" ;
			echo "<a href='./Accueil.php'>Retour à la sélection de la station </a> <br>";
		}
		echo "<p>Vous avez choisi la station $ligne->nom_station.</br> 
		<a href='./Accueil.php'>Cliquez ici pour changer de station </a> <br>
		Pour continuer, veuillez vous identifier.</p>";
		?>
		<form method='post' action='ChoixAdherent.php'>
			Username : <input type="text" name="username" value=""><br>
			Mot de passe : <input type="password" name="motdepasse" value=""><br>
			<input type="hidden" name="num_station" value="<?php echo $station ?>">
			<input type="submit" name="connexion" value="Connexion">
		</form>
		<?php
		mysqli_close($con);
		?>
	</body>
</html>
