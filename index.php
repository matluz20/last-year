<?php

// Démarrage de la session
session_start();

    // Vérification de la variable de session "connecter"
    if(@$_SESSION["connecter"]=="oui"){ 
        // Redirection vers la page d'accueil si l'utilisateur n'est pas connecté
        header ('Location: /php/afterconexion.php');
        // Arrêt de l'exécution du code
        exit();
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/Inscreption.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <title>Efrei MarketPlace</title> 
</head>


    <body>c
		
	
        <h1>Bienvenue sur efrei MarketPlace !</h1>


        <div class="container" id="container">
	<div class="form-container sign-up-container">
		<form action="php/compte/insertion.php" method="POST">
			<h1>inscrivez-vous</h1>
			<input type="username" name="username" placeholder="Username" required/>
			<input type="password" name="password" placeholder="Password" required/>
			<button name="envoi">Inscription</button>
		</form>
	</div>
	<div class="form-container sign-in-container">
		<form action="php/compte/verification.php" method="POST">
			<h1>Connecte-toi !</h1>
			<input type="text" id="username" name="username" placeholder="Username" required/>
			<input type="password" name="password" placeholder="Password" required/>
			<button name="envoi">Connexion</button>
		</form>
	</div>
	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-left">
				<h1>Connecte toi</h1>
				<p>Pour vous connecter à un compte déja existant</p>
				<button class="ghost" id="signIn">Connexion</button>
			</div>
			<div class="overlay-panel overlay-right">
				 <div id="typewriter"> 
					<h3 class="typewriter">Bienvenue sur Efrei Marketplace.</h3>
					<div class="bodywriter"></div>
				 </div> 
				<p>Inscrivez-vous avec vos infos personnels</p>
				<button class="ghost" id="signUp">Rejoins-Nous</button>
			</div>
		</div>
	</div>
</div>

<script src="https://unpkg.com/typewriter-effect@latest/dist/core.js"></script>
<script src="js/Inscreption.js"></script>
</body>
</html>