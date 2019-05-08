<html>
	<head>
		<title> Borne de sélection </title>
	</head>

	<body>
		<h1> Bienvenue sur la borne de sélection ! </h1>

		<?php
			include ('./sql_con.php');
			$requete="SELECT ID_station, nom_station FROM station";
			$res=mysqli_query($con,$requete);
			$nb=mysqli_num_rows($res);
		?>
		
		<form method='post' action='Authentification.php'>
			<select name='station'>
			<?php
			while($ligne=mysqli_fetch_object($res)){
				echo "<option name='station' value=$ligne->ID_station>$ligne->nom_station</option>";
			}
			mysqli_close($con);
			?>
			</select>
		<input type="submit" value="Envoyer">
		</form>

	</body>
</html>
