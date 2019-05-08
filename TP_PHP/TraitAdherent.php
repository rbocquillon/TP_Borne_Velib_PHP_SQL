<html>
	<head>
		<title>Page adhérent</title>
	</head>
	
	<body>
		<?php
		include ('./sql_con.php');
		$station=$_POST["station"];
		$utilisateur=$_POST["id_utilisateur"];
		if (isset($_POST["ToUpdate"])){
			$mail=$_POST["mail"];
			$password=$_POST["password"];
			$requete='UPDATE utilisateur SET mail="'.$mail.'", mot_de_passe='.$password.' WHERE ID_utilisateur='.$utilisateur;
			mysqli_query($con,$requete);
			echo "Données modifiées";
		}
		$requete="SELECT nbre_places, velos_dispos, nom_station FROM station WHERE ID_station=$station";
		$res=mysqli_query($con,$requete);
		$ligne=mysqli_fetch_object($res);
		if(isset($_POST["id_emprunt"])){ //location en cours -> RENDRE UN VELO
			$emprunt=$_POST["id_emprunt"];
			if($ligne->nbre_places-$ligne->velos_dispos==0){ //plus de place pour rendre le vélo
				echo "Plus de placeà la station $ligne->nom_station, aller dans une autre station";
				echo "<a href='./Accueil.php'>Retour à la sélection de la station </a> <br>";
			}
			else{ //encore de la place pour rendre le vélo
				$requete="SELECT dateheure_d FROM emprunt WHERE id_emprunt=$emprunt";
				$res=mysqli_query($con,$requete);
				$ligne=mysqli_fetch_object($res);
				$today=date("Y-m-d H:i:s");
				$duree=$today-$ligne->dateheure_d;
				switch(true){
					case ($duree<3000) :
						$prix=0;
						break;
					case ($duree<10000) :
						$prix=1;
						break;
					case ($duree<13000) :
						$prix=3;
						break;
					case ($duree<20000) :
						$prix=5;
						break;
					case ($duree<23000) :
						$prix=7;
						break;
					default :
						$prix=7;
				}
				$requete='UPDATE emprunt SET dateheure_r="'.$today.'", station_r='.$station.', montant='.$prix.' WHERE id_emprunt='.$emprunt;
				mysqli_query($con,$requete);
				$requete="UPDATE station SET velos_dispos=velos_dispos+1 WHERE id_station=$station";
				mysqli_query($con,$requete);
			}
		}
		elseif(isset($_POST["modif"])){ //MODIF DES DONNEES PERSO
			$requete="SELECT mail,mot_de_passe FROM utilisateur WHERE ID_utilisateur=$utilisateur";
			$res=mysqli_query($con,$requete);
			$ligne=mysqli_fetch_object($res);
			$today=date("Y-m-01 00:00:00");
			$requete='SELECT SUM(montant) AS somme FROM emprunt WHERE abonne='.$utilisateur.' AND dateheure_r>="'.$today.'"';
			$res=mysqli_query($con,$requete);
			$ligne2=mysqli_fetch_object($res);
			$dette=$ligne2->somme;
			?>
			<form method="post" action="TraitAdherent.php">
				Mail : <input type="text" name="mail" value=<?php echo $ligne->mail; ?>> <br>
				Mot de passe : <input type="password" name="password" value=<?php echo $ligne->mot_de_passe; ?>> <br>
				Votre dette actuelle : <?php echo $dette."€"; ?> <br>
				<input type="hidden" name="id_utilisateur" value="<?php echo $utilisateur ?>">
				<input type="hidden" name="station" value="<?php echo $station ?>">
				<input type="hidden" name="ToUpdate" value="true">
				<input type="hidden" name="modif" value="true">
				<input type="submit" value="Valider">
			</form>
			<?php
		}
		else{ //pas d'emprunt -> PRENDRE UN VELO
			if($ligne->velos_dispos==0){ //plus de vélo dispo
				echo "Plus de vélo dispo à la station $ligne->nom_station, aller dans une autre station";
				echo "<a href='./Accueil.php'>Retour à la sélection de la station </a> <br>";
			}
			else{ //encore des vélos dispo
				$today=date("Y-m-d H:i:s");
				$requete='INSERT INTO emprunt (abonne,station_d,dateheure_d) VALUES ('.$utilisateur.','.$station.',"'.$today.'")';
				mysqli_query($con,$requete);
				$requete="UPDATE station SET velos_dispos=velos_dispos-1 WHERE id_station=$station";
				mysqli_query($con,$requete);
			}
		}
		mysqli_close($con);
		?>
	</body>
</html>
