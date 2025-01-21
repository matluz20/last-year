<?php 
// Démarrage de la session
session_start();

// Vérification de la variable de session "connecter"
if (@$_SESSION["connecter"] != "oui") {
    // Redirection vers la page d'accueil si l'utilisateur n'est pas connecté
    header('Location: ../index.php');
    // Arrêt de l'exécution du code
    exit();
}
?> 

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <title>Efrei MarketPlace - Ventes</title>
    <link rel="stylesheet" href="/css/paiement.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <header>
                    <div class="h">
                        <h1><a href="/">Efrei MarketPlace</a></h1>
                        <h1 class="account"><a href="/php/compte/moncompte.php"><img src="/image/person.svg" class="accountsvg"></a></h1>
                    </div>
                    <nav class="navbar2">
                        <ul class="menu">
                            <li>
                                <form method="get" action="articles/categorie/categorie.php">
                                <a href="#" onclick="toggleCategoryMenu()" id="categorie">Catégorie</a>
                                <input type="hidden" name="selectedCategory" id="selectedCategory">
                                </form>
                                <script>
                                function selectCategory(category) {
                                    document.getElementById('selectedCategory').value = category;
                                    document.forms[0].submit();
                                }
                                function toggleCategoryMenu() {
                                    var categorie = document.getElementById('categorie');
                                    categorie.classList.toggle('selected');
                                    var menu = document.getElementById('category-menu');
                                    menu.classList.toggle('hidden');
                                }
                                </script>
                            </li>
                            <li><a href="/">Tout Parcourir</a></li>

                            <li><a href="/php/devenirvendeur.php">Vendre</a></li>
                        
                            <li><a href="/php/paiement.php">Panier</a>

                        </ul>
                        <div class="sub-menu-container">
                            <ul id="category-menu" class="menu sub-menu hidden">
                                <li><a href="#" onclick="selectCategory('vetement')" class="sub-menu-item">Vêtement</a></li>
                                <li><a href="#" onclick="selectCategory('informatique')" class="sub-menu-item">Matériel informatique</a></li>
                                <li><a href="#" onclick="selectCategory('electromenager')" class="sub-menu-item">Appareils Eléctromenager</a></li>
                                <li><a href="#" onclick="selectCategory('vehicule')" class="sub-menu-item">Véhicule</a></li>
                                <li><a href="#" onclick="selectCategory('fitness')" class="sub-menu-item">Appareils de fitness</a></li>
                                <li><a href="#" onclick="selectCategory('jeuxvideo')" class="sub-menu-item">Jeux-vidéos</a></li>
                                <li><a href="#" onclick="selectCategory('console')" class="sub-menu-item">Console de jeu</a></li>
                            </ul>
                        </div> 
                    </nav>
                <!-- <h1>Efrei MarketPlace</h1> -->
    </header>
    <main>
    <style>
        .his {
            text-align: center;
            padding: 20px;
            background-color: #f2f2f2;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }
    </style>
        <div class="his">
            <h1>L'historique de vos achats</h1>
        </div>
        <div class="container">
            <div class="row">
                <?php
                require_once('../bdd/connexion_bdd.php');
                if (@$_SESSION["connecter"] != "oui") {
                    // Redirection vers la page d'accueil si l'utilisateur n'est pas connecté
                    header('Location: ../index.php');
                    // Arrêt de l'exécution du code
                    exit();
                }
                $nom_user = @$_SESSION["username"];


                // Requête pour récupérer tous les articles
                $sql = "SELECT * FROM `Commandes` WHERE username = '$nom_user'  ORDER BY `id_article` DESC";
                $resultat = $conn->query($sql);

                foreach ($resultat as $article) {
                    // Sélectionner toutes les images correspondantes à l'article
                    $chemins_images = glob('../articles/depot/images/*' . $article["nom_article"] . '.*');

                    echo '<div class="case">';
                    echo '<div class="card mb-4 shadow-sm article">';
                    foreach ($chemins_images as $chemin_image) {
                        echo '<img class="taille" src="' . $chemin_image . '" class="card-img-top" alt="' . $article["nom_article"] . '">';
                    }
                    echo '<div class="card-body">';
                    echo '<h2 class="card-title">' . $article["nom_article"] . '</h2>';
                    //echo '<p class="card-text">Description: ' . $article["Description"] . '</p>';
                    echo '<div class="d-flex justify-content-between align-items-center">';
                    echo '<span class="price">Prix: ' . $article["prix_article"] . '€</span></br>';
                    // echo '<span class="dateArticle">Date ajout: ' . $article["Date"] . '</span><br>';
                    //echo '<form method="post" action="articles/panier/ajout_au_panier.php">';
                    echo '<input type="hidden" name="id_article" value="' . $article["id_article"] . '">';
                    echo '<input type="hidden" name="nom_article" value="' . $article["nom_article"] . '">';
                    echo '<input type="hidden" name="prix_article" value="' . $article["prix_article"] . '">';
                    //echo '<button type="submit">Ajouter au panier</button>';
                    // echo '</form>';
                    // echo '<form method="post" action="ajouter_au_panier.php">';
                    // echo '<input type="hidden" name="id_article" value="' . $article["Id_articles"] . '">';
                    // echo '<button type="submit">Acheter</button>';
                    // echo '</form>';

                    // Ajout du formulaire de suppression
                    echo '<form method="post" action="../articles/suppression/supprimer_article.php">';
                    echo '<input type="hidden" name="id_transaction" value="' . $article["id_transaction"] . '">';
                    echo '<button type="submit" class="btn btn-danger">Supprimer</button>';
                    echo '</form>';

                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </main>
</body>
</html>