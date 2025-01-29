<?php
// Démarrage de la session
session_start();

// Vérification de la variable de session "connecter"
if (@$_SESSION["connecter"] != "oui") {
    // Redirection vers la page d'accueil si l'utilisateur n'est pas connecté
    header('Location: /');
    // Arrêt de l'exécution du code
    exit();
}

// Inclusion du fichier de connexion à la base de données
require_once('bdd/connexion_bdd.php');

// Récupération du nom de l'utilisateur à partir de la variable de session
$nom_user = @$_SESSION["username"];

// Requête SQL pour récupérer les informations de l'utilisateur
$sql1 = "SELECT * FROM `Utilisateur` WHERE username = '$nom_user'";
$resultat1 = $conn->query($sql1);
$row = $resultat1->fetch_assoc();

// Initialisation des variables d'affichage des sections
$afficher_section1 = false;
$afficher_section2 = false;

// Vérification du statut de l'utilisateur
if ($row["statut"] == "membre") {
    // Affichage de la section 1 si l'utilisateur est un acheteur
    $afficher_section1 = true;
} else {
    // Affichage de la section 2 si l'utilisateur n'est pas un acheteur
    $afficher_section2 = true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/devenirvendeur.css">
    <title>Vendez votre article</title>
</head>

<body>


    <!-- Affichage de la section 1 si l'utilisateur n'est pas un vendeur -->
    <?php if ($afficher_section1) : ?>

        <div id="section1">
            <p>Votre compte ne vous permet pas d'effectuer les ventes. <br> Pour devenir vendeur vous devez faire la demande en cliquant sur le boutton dessus</p>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="submit" name="envoi" value="Envoyer la demande">
            </form>

        </div>
        <?php

            require_once('bdd/connexion_bdd.php');



            if(isset($_POST['envoi'])){

                session_start(); 

                $nom_user = @$_SESSION["username"];

                $sql1 = "SELECT * FROM `devenirvendeur` WHERE Nom = '$nom_user'";
                $resultat1 = $conn->query($sql1);

                // Vérification si la requête s'est bien exécutée
                if ($resultat1->num_rows > 0) {
                    echo '<script type="text/javascript">'; 
                    echo 'alert("Vous avez déjà effectué une demande ! veuillez attendre notre reponse ! ");';  
                    echo 'window.location.href = "/"'; // redirection vers la page après connexion 
                    echo '</script>';
                }


                if ($resultat1->num_rows == 0) {
                
                $sql = "INSERT INTO `devenirvendeur` ( `Nom`,`type`)
                VALUES( '$nom_user', 'devenir coach')";
                
                $resultat = $conn->query($sql);
                
                echo '<script type="text/javascript">'; 
                echo 'alert("Votre démande a bien été pris en compte ! nous vous tiendrons informé ");';  
                echo 'window.location.href = "/"'; // redirection vers la page après connexion 
                echo '</script>';
                }
                



            }




        ?>

    <?php endif; ?>


    <!-- Affichage de la section 2 si l'utilisateur est un vendeur -->
    <?php if ($afficher_section2) : ?>
        <div id="section2">

            <header>
                <div class="h1">
                    <h1><a href="/">Facil'Access </a></h1>
                    <h1 class="account"><a href="/php/compte/moncompte.php"><img src="/image/person.svg" class="accountsvg"></a></h1>
                </div>
                <nav class="navbar">
                    <ul class="menu">
                        <li><a href="/php/compte/notification.php">Notifications</a></li>
                        <li><a href="/php/devenirvendeur.php">Devenir Coach</a></li>
                        <li><a href="/php/compte/deconnexion.php">Deconnexion</a></li>
                    </ul>
                </nav>
            </header>

            <div class="depot_articles">
                <h3>Déposer votre article ici </h3>
                <button id="modal-btn">Déposer</button>

            </div>

            <div id="type-modal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h3>Choisissez le type de vente :</h3>
                    <form>
                        <input type="radio" id="normal" name="vente" value="normal" required>
                        <label for="normal">Normal</label><br>

                        <input type="radio" id="enchere" name="vente" value="enchere" required>
                        <label for="enchere">Enchère</label>
                        
                        
                        <br>
                        <input type="submit" value="Continuer">
                    </form>
                </div>
            </div>



            <div id="modal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h3>Saisissez ci-dessous les informations concernant votre article :</h3><br>

                    <form action="/php/articles/depot/traitement.php" method="post" enctype="multipart/form-data">
                        <label for="titre">Titre :</label><br>
                        <input type="text" id="titre" name="titre" required><br>

                        <label for="description">Description :</label><br>
                        <textarea id="description" name="description" required></textarea><br>

                        <label for="prix">Prix :</label><br>
                        <input type="number" id="prix" name="prix" required><br>

                        <label for="photo">Photo :</label><br>
                        <input type="file" name="image" id="image" accept="image/*" required><br>

                        <label for="categorie">Catégorie :</label><br>
                        <select name="categorie" id="categorieArticle" required>
                            <option value="vetement">Vêtement</option>
                            <option value="informatique">Matériel informatique</option>
                            <option value="electromenager">Appareils électroménagers</option>
                            <option value="vehicule">Véhicule</option>
                            <option value="fitness">Appareils de fitness</option>
                            <option value="jeuxvideo">Jeux-vidéos</option>
                            <option value="console">Console de jeu</option>
                            <option value="autres">Autres</option>
                        </select><br>

                        <input type="submit" value="Envoyer">
                    </form>


                </div>
            </div>

            <div id="modal2" class="modal">
                <div class="modal-content">
                    <span class="close2">&times;</span>
                    <h3>Saisissez ci-dessous les informations concernant votre article :</h3><br>

                    <form action="/php/articles/depot/traitement.php" method="post" enctype="multipart/form-data">
                        <label for="titre">Titre :</label><br>
                        <input type="text" id="titre" name="titre" required><br>

                        <label for="description">Description :</label><br>
                        <textarea id="description" name="description" required></textarea><br>

                        <label for="prix">Prix de départ :</label><br>
                        <input type="number" id="prix" name="prix" required><br>

                        <label for="date_fin">Date de fin de l'enchère :</label><br>
                        <input type="datetime-local" id="date_fin" name="date_fin" required><br>

                        <label for="photo">Photo :</label><br>
                        <input type="file" name="image" id="image" accept="image/*" required><br>

                        <label for="categorie">Catégorie :</label><br>
                        <select name="categorie" id="categorieArticle" required>
                            <option value="vetement">Vêtement</option>
                            <option value="informatique">Matériel informatique</option>
                            <option value="electromenager">Appareils électroménagers</option>
                            <option value="vehicule">Véhicule</option>
                            <option value="fitness">Appareils de fitness</option>
                            <option value="jeuxvideo">Jeux-vidéos</option>
                            <option value="console">Console de jeu</option>
                            <option value="autres">Autres</option>
                        </select><br>

                        <input type="submit" value="Envoyer">
                    </form>


                </div>
            </div>

            <script>
                // Récupérer la référence de la fenêtre modale du type de vente
var typeModal = document.getElementById("type-modal");

// Récupérer la référence de l'élément qui ouvre la fenêtre modale du type de vente
var typeModalTrigger = document.getElementById("modal-btn");

// Récupérer la référence de l'élément pour fermer la fenêtre modale du type de vente
var typeModalCloseBtn = typeModal.getElementsByClassName("close")[0];

// Récupérer la référence des boutons radio du type de vente
var venteRadios = document.querySelectorAll('input[name="vente"]');

// Récupérer la référence de la fenêtre modale des informations de l'article
var modal = document.getElementById("modal");
var modal2 = document.getElementById("modal2");

// Récupérer la référence de l'élément pour fermer la fenêtre modale des informations de l'article
var modalCloseBtn = modal.getElementsByClassName("close")[0];
var modal2CloseBtn = modal2.getElementsByClassName("close2")[0];

// Fonction pour ouvrir la fenêtre modale du type de vente
function openTypeModal() {
    typeModal.style.display = "block";
}

// Fonction pour fermer la fenêtre modale du type de vente
function closeTypeModal() {
    typeModal.style.display = "none";
}

// Fonction pour ouvrir la fenêtre modale des informations de l'article
function openModal() {
    modal.style.display = "block";
}

function openModal2() {
    modal2.style.display = "block";
}

// Fonction pour fermer la fenêtre modale des informations de l'article
function closeModal() {
    modal.style.display = "none";
}

function closeModal2() {
    modal2.style.display = "none";
}

// Écouter l'événement clic pour ouvrir la fenêtre modale du type de vente
typeModalTrigger.addEventListener("click", openTypeModal);

// Écouter l'événement clic pour fermer la fenêtre modale du type de vente en cliquant sur le bouton de fermeture
typeModalCloseBtn.addEventListener("click", closeTypeModal);

// Fonction pour afficher la fenêtre modale correspondante en fonction du type de vente sélectionné
function showSelectedModal() {
    var selectedValue = document.querySelector('input[name="vente"]:checked').value;

    if (selectedValue === "enchere") {
        openModal2();
    } else if (selectedValue === "normal") {
        openModal();
    }
}

// Écouter l'événement submit pour afficher la fenêtre modale correspondante
typeModal.querySelector("form").addEventListener("submit", function(event) {
    event.preventDefault();
    showSelectedModal();
    closeTypeModal();
});

// Écouter l'événement clic pour fermer la fenêtre modale des informations de l'article en cliquant sur le bouton de fermeture
modalCloseBtn.addEventListener("click", closeModal);
modal2CloseBtn.addEventListener("click", closeModal2);


            </script>

            <!-- <form action="articles/depot/traitement.php" method="post" enctype="multipart/form-data">
                <input type="file" name="image" id="image">
                <input type="submit" value="Upload">
            </form> -->

        </div>
        

    <?php endif; ?>

</body>

</html>
