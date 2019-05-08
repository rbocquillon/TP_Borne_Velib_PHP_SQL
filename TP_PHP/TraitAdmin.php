<html>
	<head>
		<title>Page administrateur</title>
	</head>
	
	<body>
		<?php
		include ('./sql_con.php');
		if(isset($_POST["NewUser"])){
			if(isset($_POST["ToAdd"])){
				$username=$_POST["username"];
				$nom=$_POST["nom"];
				$prenom=$_POST["prenom"];
				$ref_bancaire=$_POST["ref"];
				$mail=$_POST["mail"];
				$mot_de_passe=$_POST["pwd"];
				$type=$_POST["type"];
				$requete='INSERT INTO utilisateur (username,nom,prenom,ref_bancaire,mail,mot_de_passe,type) VALUES ("'.$username.'","'.$nom.'","'.$prenom.'",'.$ref_bancaire.',"'.$mail.'","'.$mot_de_passe.'","'.$type.'")';
				mysqli_query($con,$requete);
				echo (mysqli_error($con));
				echo "Utilisateur ajouté ! <br><br>";
			}
			?> <h5>Créer un nouvel utilisateur</h5>
			<form method="post" action="TraitAdmin.php">
				Username : <input type="text" name="username"><br>
				Nom : <input type="text" name="nom"><br>
				Prénom : <input type="text" name="prenom"><br>
				Ref bancaire : <input type="text" name="ref"><br>
				Mail : <input type="text" name="mail"><br>
				Mot de passe : <input type="password" name="pwd"><br>
				Type d'utilisateur : <select name="type">
										<option name="type" value="abonne">abonne</option>
										<option name="type" value="admin">admin</option>
									</select> <br><br>
				<input type="hidden" name="NewUser" value="true">
				<input type="submit" name="ToAdd" value="Ajouter cet utilisateur">
			</form>
			<?php
		}
		elseif(isset($_POST["resilier"])){
			if(isset($_POST["ToResilier"])){
				$ancien_user=$_POST["user"];
				$requete="UPDATE utilisateur SET type='ancien_user' WHERE ID_utilisateur=$ancien_user";
				mysqli_query($con,$requete);
				echo "Utilisateur résilié.<br><br>";
			}
			$requete="SELECT ID_utilisateur, username FROM utilisateur WHERE type='abonne'";
			$res=mysqli_query($con,$requete);
			$nb=mysqli_num_rows($res);
			?>
			<form method='post' action='TraitAdmin.php'>
				<select name='user'>
					<?php
						while($ligne=mysqli_fetch_object($res)){
						echo "<option name='user' value=$ligne->ID_utilisateur>$ligne->username</option>";
						}
					?>
				</select> <br> <br> 
				<input type="hidden" name="resilier" value="true">
				<input type="submit" name="ToResilier" value="Résilier cet utilisateur">
			</form>
			<?php
		}
		elseif(isset($_POST["NewStation"])){
			//� finir
		}
		elseif(isset($_POST["ModifyStation"])){
			//� finir
		}
		mysqli_close($con);
		?>
	</body>
</html>
