<?php


// Démarrage de la session
session_start();


	$statut = @$_SESSION["statut"];
	if($statut == "admin"){
	header ('Location: /php/compte/admin.php');
	//Arrêt de l'exécution du code
	exit();
	}
    // Vérification de la variable de session "connecter"
    if(@$_SESSION["connecter"]=="oui"){ 
        // Redirection vers la page d'accueil si l'utilisateur n'est pas connecté
        header ('Location: /php/compte/moncompte.php');
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
    <title>Facil'Access </title> 
</head>


    <body>
		
	
        <h1>Bienvenue sur Facil'Access !</h1>


        <div class="container" id="container">
	<div class="form-container sign-up-container">
		<form action="php/compte/insertion.php" method="POST" enctype="multipart/form-data">
			<h1>inscrivez-vous</h1>
			<input type="username" name="name" placeholder="Nom" required/>
			<input type="username" name="last_name" placeholder="Prenom" required/>
			<input type="email" name="email" placeholder="Adresse e-mail" required pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" />
			<input type="text" id="telephone" name="telephone" placeholder="Entrez votre numéro" required>
			<br><label for="photo">Veuillez insérer ci-dessous votre photo de face, bien visible.</label>
			<input type="file" name="image" id="image" accept="image/*" required />		
			
			<br>
			<label for="rgpd" style="font-size: 12px; color: red; display: inline-block;">
				<span style="vertical-align: middle;">J'accepte que mes données soient collectées conformément à la politique RGPD.</span>
				<input type="checkbox" id="rgpd" name="rgpd" required style="vertical-align: middle; margin-left: 5px;">
			</label><br><br>

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
					<h3 class="typewriter">Bienvenue sur Facil'Access .</h3>
					<div class="bodywriter"></div>
				 </div> 
				<p>Inscrivez-vous des maintenant</p>
				<button class="ghost" id="signUp">Rejoignez-Nous</button>
			</div>
		</div>
	</div>
</div>

<script src="https://unpkg.com/typewriter-effect@latest/dist/core.js"></script>
<script src="js/Inscreption.js"></script>
</body>
</html>