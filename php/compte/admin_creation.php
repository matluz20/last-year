<?php
// Démarrage de la session
session_start();

    // Vérification de la variable de session "connecter"
    if(@$_SESSION["connecter"]!="oui"){ 
        // Redirection vers la page d'accueil si l'utilisateur n'est pas connecté
        header ('Location: ../index.php');
        // Arrêt de l'exécution du code
        exit();
    }
    $nom_user = @$_SESSION["username"];
    $statut = @$_SESSION["statut"];
    
    if($statut != "admin" && $statut != "coach"){
        header ('Location: /');
        // Arrêt de l'exécution du code
        exit();
    }

    $_SESSION["admin_creation"] = true;
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" type="text/css" href="../../css/demandes.css"> -->
    <link rel="stylesheet" href="/css/style.css">


    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        table,
        th,
        td {
            border: 1px solid black;
            flex: 1; /* Chaque élément prend la même largeur */
            text-align: center; /* Centrer le texte */
        }

        th,
        td {
            padding: 5px;
        }

        .delete-btn {
            background-color: red;
            color: white;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
        }
        form {

	display: flex;
	align-items: center;
	justify-content: center;
	flex-direction: column;
	padding: 0 50px;
	height: 100%;
	text-align: center;
}

input {
	background-color: #eee;
	border: none;
	padding: 12px 15px;
	margin: 8px 0;
	width: 100%;
}


.form-container {
	height: 100%;
	transition: all 0.6s ease-in-out;
}

.sign-in-container {
	left: 0;
	width: 50%;
	z-index: 2;
}

.container.right-panel-active .sign-in-container {
	transform: translateX(100%);
}



.container.right-panel-active .sign-up-container {
	transform: translateX(100%);
	opacity: 1;
	z-index: 5;
	animation: show 0.6s;
}

@keyframes show {

	0%,
	49.99% {
		opacity: 0;
		z-index: 1;
	}

	50%,
	100% {
		opacity: 1;
		z-index: 5;
	}
}

.overlay-container {
	position: absolute;
	top: 0;
	left: 50%;
	width: 50%;
	height: 100%;
	overflow: hidden;
	transition: transform 0.6s ease-in-out;
	z-index: 100;
}

.container.right-panel-active .overlay-container {
	transform: translateX(-100%);
}

.overlay {
	background: var(--connection);
	background: -webkit-linear-gradient(to right, var(--connection),  var(--connection2));
	background: linear-gradient(to right,  var(--connection),  var(--connection2));
	background-repeat: no-repeat;
	background-size: cover;
	background-position: 0 0;
	color: #FFFFFF;
	position: relative;
	left: -100%;
	height: 100%;
	width: 200%;
	transform: translateX(0);
	transition: transform 0.6s ease-in-out;
}

.container.right-panel-active .overlay {
	transform: translateX(50%);
}

.overlay-panel {
	position: absolute;
	display: flex;
	align-items: center;
	justify-content: center;
	flex-direction: column;
	padding: 0 40px;
	text-align: center;
	top: 0;
	height: 100%;
	width: 50%;
	transform: translateX(0);
	transition: transform 0.6s ease-in-out;
}

.overlay-left {
	transform: translateX(-20%);
}

.container.right-panel-active .overlay-left {
	transform: translateX(0);
}

.overlay-right {
	right: 0;
	transform: translateX(0);
}

/* pour le texte de présentation */

#typewriter {
	user-select: none;

	height: 40%;
	width: 60%;
}

.switch {
	font-weight: bold;
	color: var(--connection);
}

.bodywriter {
	text-align: justify;
	width: 100%;
}

.container.right-panel-active .overlay-right {
	transform: translateX(20%);
}

    

        
    </style>
    <style>
        .user-table {
            border-collapse: collapse;
            width: 100%;
        }

        .user-table th,
        .user-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .user-table th {
            background-color: #f2f2f2;
            text-align: left;
        }

        .user-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .user-table tr:hover {
            background-color: #ddd;
        }
        .rowLine{
            border : 0;
            display: flex;
            justify-content: space-between; /* Espace uniforme */
            align-items: center; /* Centrage vertical */
            padding: 10px;
        }
        .rowLine > a{
            flex: 1; /* Chaque élément prend la même largeur */
            text-align: center; /* Centrer le texte */
            border-right: 1px solid #000;
        }
        .rowLine > a:last-child{
            border-right: none;
        }
    </style>

    <title>Demandes</title>
</head>

<body>
    <header>
        <div class="h1">
            <h1><a href="admin.php">Facil'Access</a></h1>
            <h1 class="account"><a href="/php/compte/moncompte.php"><img src="/image/person.svg" class="accountsvg"></a>
            </h1>
        </div>
        <nav class="navbar">
            <ul class="menu">
                <li><a href="/php/compte/notification.php">Notifications</a></li>
                <li><a href="demandes.php">Demandes</a></li>
                <li><a href="user.php">Liste des utilisateurs</a></li>
            </ul>
        </nav>
    </header>


    <main>

    
    <div class="container" id="container">
            <div class="form-container sign-up-container">
                <form action="insertion.php" method="POST" enctype="multipart/form-data">
                    <h1>Renseignez ci-deesous les informations de l'utilisateur</h1><br>
                    <input type="username" name="name" placeholder="Nom" required/>
                    <input type="username" name="last_name" placeholder="Prenom" required/>
                    <input type="email" name="email" placeholder="Adresse e-mail" required pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" />
                    <input type="text" id="telephone" name="telephone" placeholder="Entrez votre numéro" required>
                    <br><label for="photo">Veuillez insérer ci-dessous une photo de l'utilisateur de face, bien visible.</label>
                    <input type="file" name="image" id="image" accept="image/*" required />		
                    
                    <br>
                    <label for="rgpd" style="font-size: 12px; color: red; display: inline-block;">
                        <span style="vertical-align: middle;">L'utilisateur accepte que ses données soient collectées conformément à la politique RGPD.</span>
                        <input type="checkbox" id="rgpd" name="rgpd" required style="vertical-align: middle; margin-left: 5px;">
                    </label><br><br>

                    <button name="envoi">Inscription</button>
                </form>
            </div>
            
            
            
                </div>
            </div>
        </div>


    </div>


    </table>


    <script>


            function upgradeUtilisateur(idUtilisateur, username, name) {
                // Demander une confirmation à l'utilisateur avant de modifier le rôle
                if (confirm("Êtes-vous sûr de approuver la demande de l'utilisateur ? " + name + " (" + username + ") ?")) {
                    // Créer une requête AJAX pour modifier le rôle de l'utilisateur
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "modifier_utilisateur.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === XMLHttpRequest.DONE) {
                            if (xhr.status === 200) {
                                
                                location.reload(); // Recharger la page pour mettre à jour les changements
                            } else {
                                // La modification a échoué, afficher un message d'erreur
                                location.reload(); 
                            }
                        }
                    };

                    // Envoyer les données au serveur
                    var data = "idUtilisateur=" + encodeURIComponent(idUtilisateur) + 
                            "&mail=" + encodeURIComponent(username) + 
                            "&name=" + encodeURIComponent(name);
                    console.log("Données envoyées : " + data); // Debugging dans la console
                    xhr.send(data);
                }
            }

            </script>












    
</main>

<!-- Modal -->
<script>
    // Fonction pour ouvrir le modal avec l'image
    function openModal(imageSrc) {
        var modal = document.getElementById("simpleModal");
        var modalImage = document.getElementById("modalImage");
        
        modal.style.display = "block";
        modalImage.src = imageSrc;
    }

    // Fonction pour fermer le modal
    function closeModal() {
        document.getElementById("simpleModal").style.display = "none";
    }
</script>
<!-- Modal -->
<div id="simpleModal" class="modal" style="display: none;">
    <span class="close" onclick="closeModal()">&times;</span>
    <img class="modal-content" id="modalImage">
</div>

<!-- Style du modal -->
<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        padding-top: 100px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
    }
    .modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 600px;
    }
    .close {
        position: absolute;
        top: 20px;
        right: 30px;
        color: #fff;
        font-size: 36px;
        font-weight: bold;
        cursor: pointer;
    }
</style>


</body>

</html>
