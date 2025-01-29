<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Catégorie</title>
        <link rel="stylesheet" href="/css/style.css">
    </head>
    <body>
        <header>
            <div class="h1">
                <h1><a href="/">Efrei Marketplace </a></h1>
                <h1 class="account"><a href="/php/compte/moncompte.php"><img src="/image/person.svg" class="accountsvg"></a></h1>
            </div>
            <nav class="navbar">
                <ul class="menu">
                    <li>
                        <form method="get" action="categorie.php">
                        <a href="#" onclick="toggleCategoryMenu()" id="categorie">Catégorie</a>
                        <input type="hidden" name="selectedCategory" id="selectedCategory">
                        </form>
                        <script>
                            // Fonction permettant de soumettre le formulaire implicite en récupérant la page sélectionné (balise <a>) et en l'envoyant (méthode get)
                        function selectCategory(category) {
                            document.getElementById('selectedCategory').value = category;
                            document.forms[0].submit();
                        }
                            // Fonction permettant d'ouvrir et de fermer le sous-menu (on lui enlève/met la classe hidden) catégorie au clique de ce dernier
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
        </header>
        <?php
        // Appel de la base de données
        require_once('../../bdd/connexion_bdd.php');
        
        // Vérification que le champ récupérer n'est pas vide
        if (isset($_GET['selectedCategory'])) {
        $selectedCategory = $_GET['selectedCategory'];
        echo "<main><h1 class='selectedCategory col-md-6'>  " . ucfirst($selectedCategory) . "</h1>";
        echo "<hr>";
        $sql = "SELECT * FROM `Articles` WHERE `Catégorie` = '$selectedCategory'";
        $resultat = $conn->query($sql);

        // Affichage des résultats
        echo '<div class="row">';
        foreach ($resultat as $article) {
            // Sélectionner toutes les images correspondantes à l'article
            $chemins_images = glob('../depot/images/*' . $article["nom_article"] . '.*');
            
            echo '<div class="col-md-6">';
            echo '<div class="card mb-4 shadow-sm article">';
            foreach ($chemins_images as $chemin_image) {
                echo '<img class="taille" src="' . $chemin_image . '" class="card-img-top" alt="' . $article["nom_article"] . '">';
            }
            echo '<div class="card-body">';
            echo '<h2 class="card-title">' . $article["nom_article"] . '</h2>';
            echo '<p class="card-text">Description: ' . $article["Description"] . '</p>';
            echo '<div class="d-flex justify-content-between align-items-center">';
            echo '<span class="price">Prix: ' . $article["Prix"] .'€</span></br>';
            echo '<span class="dateArticle">Date ajout: '. $article["Date"] .'</span><br>';

            echo '<form method="post" action="/php/articles/panier/ajout_au_panier.php">';
            echo '<input type="hidden" name="id_article" value="' . $article["Id_articles"] . '">';
            echo '<input type="hidden" name="nom_article" value="' . $article["nom_article"] . '">';
            echo '<input type="hidden" name="prix_article" value="' . $article["Prix"] . '">';
            echo '<button type="submit" class="btnPanier btnArticle">Ajouter au panier</button>';
            echo '</form>';

            

            echo '<form method="post" action="/php/message/message.php" class="chat-form" id="chatForm_' . $article["Id_articles"] . '">';
            echo '<input type="hidden" name="id_article" value="' . $article["Id_articles"] . '">';
            echo  '<button type="submit" class="buttonMsg btnArticle">Contact</button>';
            echo '</form>';

            echo '</div>';
            echo '</div>';
            
            echo '</div>';
            echo '</div>';
            
        }
        echo '</main>';
        }
        ?>
        
        <script src="/js/script.js"></script>   
    </body>
</html>
