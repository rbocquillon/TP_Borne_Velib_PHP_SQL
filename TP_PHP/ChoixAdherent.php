<html>
	<head>
		<title>Page de choix d'adhérent</title>
	</head>
	
	<body>
		<?php
		include ('./sql_con.php');
		$station=$_POST["num_station"];
		$username=$_POST["username"];
		$pass=$_POST["motdepasse"];
		$requete="SELECT mot_de_passe, ID_utilisateur, type FROM utilisateur WHERE username='".$username."'";
		$res=mysqli_query($con,$requete);
		$nb=mysqli_num_rows($res);
		$ligne=mysqli_fetch_object($res);
		if($nb==0){
			echo "Username incorrect <br>";
			?>
			<form method="post" action="./Authentification.php">
				<button type="submit">
					Retour à l'authentification
				</button>
				<input type="hidden" name="station" value="<?php echo $station ?>">
			</form>
			<?php
		}
		elseif($ligne->mot_de_passe!=$pass){
			echo "Mot de passe incorrect <br>";
			?>
			<form method="post" action="./Authentification.php">
				<button type="submit">
					Retour à l'authentification
				</button>
				<input type="hidden" name="station" value="<?php echo $station ?>">
			</form>
			<?php
		}
		else{
			if($ligne->type=="admin"){
				?>
				<form method="post" action="./TraitAdmin.php"> 
					<button type="submit" name="NewUser"> INSCRIRE DE NOUVEAUX UTILISATEURS </button> </br>
					<button type="submit" name="resilier"> RESILIER UTILISATEUR </button> </br>
					<button type="submit" name="NewStation"> CREER STATION </button> </br>
					<button type="submit" name="ModifyStation"> MODIFIER STATION </button> </br>
				</form>
			<?php
			}
			elseif($ligne->type=="abonne"){
				$requete2="SELECT * FROM emprunt WHERE abonne=$ligne->ID_utilisateur AND dateheure_r IS NULL";
				$res2=mysqli_query($con,$requete2);
				$nb2=mysqli_num_rows($res2);
				$ligne2=mysqli_fetch_object($res2);
				if($nb2==0){ // pas de location en cours
				?>
					<form method="post" action="./TraitAdherent.php">
						<button type="submit">
							PRENDRE UN VELO 
						</button>
						<input type="hidden" name="station" value="<?php echo $station ?>">
						<input type="hidden" name="id_utilisateur" value="<?php echo $ligne->ID_utilisateur ?>">
					</form>
				<?php
				}
				else{ // une location en cours
					?>
					<form method="post" action="./TraitAdherent.php"> 
						<button type="submit">
							RENDRE UN VELO 
						</button>
						<input type="hidden" name="station" value="<?php echo $station ?>">
						<input type="hidden" name="id_utilisateur" value="<?php echo $ligne->ID_utilisateur ?>">
						<input type="hidden" name="id_emprunt" value="<?php echo $ligne2->ID_emprunt ?>">
					</form>
				<?php
				}
				?>
					<form method="post" action="./TraitAdherent.php">
						<button type="submit">
							MODIFIER MES DONNEES PERSONNELLLES 
						</button>
						<input type="hidden" name="station" value="<?php echo $station ?>">
						<input type="hidden" name="id_utilisateur" value="<?php echo $ligne->ID_utilisateur ?>">
						<input type="hidden" name="modif" value="true">
					</form>
				<?php
			}
		}
		mysqli_close($con);
		?>
	</body>
</html>
