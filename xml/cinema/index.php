<?php

// Démarrage de la session
session_start();

// Vérification de la variable de session "connecter"
if (@$_SESSION["connecter"] == "oui") {
	// Redirection vers la page d'accueil si l'utilisateur n'est pas connecté
	header('Lien');
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
	<link rel="stylesheet" type="text/css" href="css/Css-connexion.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
	<title>Efrei Ciné</title>
</head>


<body>


	<h1>Bienvenue sur efrei Ciné !</h1>


	<div class="container" id="container">
		<div class="form-container sign-up-container">
			<form action="compte/Insertion.php" method="POST">
				<h1>inscrivez-vous</h1>
				<input type="username" name="username" placeholder="Nom d'utilisateur" required />
				<input type="password" name="password" placeholder="Mot de passe" required />
				<input type="cinema_name" name="cinema_name" placeholder="Nom du cinéma" required />
				<input type="cinema_adresse" name="cinema_adresse" placeholder="Vile cinéma" required />
				<button name="envoi">Inscription</button>
			</form>
		</div>
		<div class="form-container sign-in-container">
			<form action="compte/Verification.php" method="POST">
				<h1>Connectez-vous !</h1>
				<input type="text" id="username" name="username" placeholder="Nom d'utilisateur" required />
				<input type="password" name="password" placeholder="Mot de passe" required />
				<button name="envoi">Connexion</button>
			</form>
		</div>
		<div class="overlay-container">
			<div class="overlay">
				<div class="overlay-panel overlay-left">
					<h1>Connectez vous</h1>
					<p>Pour vous connecter à un compte déja existant</p>
					<button class="ghost" id="signIn">Connexion</button>
					<button class="ghost" id="myButton1">Acceder au site sans connexion</button>
				</div>
				<div class="overlay-panel overlay-right">
					<div id="typewriter">
						<h3 class="typewriter">Bienvenue sur Efrei Ciné.</h3>
						<div class="bodywriter"></div>
					</div>
					<p>Inscrivez-vous avec vos infos personnels</p>
					<button class="ghost" id="signUp">rejoignez-Nous</button>
					<button class="ghost" id="myButton">Acceder au site sans connexion</button>
				</div>
			</div>
		</div>
	</div>

	<script src="https://unpkg.com/typewriter-effect@latest/dist/core.js"></script>
	<script src="js/Js-inscreption.js"></script>
	<script>
    document.getElementById("myButton").addEventListener("click", function() {
        Swal.fire({
            icon: "info",
            title: "Accès sans connexion",
            text: "Vous allez être redirigé vers le site",
        }).then(function() {
            // Redirection vers la page de déconnexion (ajustez le chemin selon vos besoins)
            window.location.href = "../client";
        });
    });
</script>
<script>
    document.getElementById("myButton1").addEventListener("click", function() {
        Swal.fire({
            icon: "info",
            title: "Accès sans connexion",
            text: "Vous allez être redirigé vers le site",
        }).then(function() {
            // Redirection vers la page de déconnexion (ajustez le chemin selon vos besoins)
            window.location.href = "../client";
        });
    });
</script>
</body>

</html>