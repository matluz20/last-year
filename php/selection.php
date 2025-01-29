<!DOCTYPE html>
<html>


  <head>
    <meta charset="UTF-8">
    <title>Efrei Marketplace  - Ventes</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/enchere.css">
    
  </head>


  <body>


    <header>

      <div class="h1">
        <h1><a href="/">Efrei Marketplace </a></h1>
        <h1 class="account"><a href="/php/compte/moncompte.php"><img src="/image/person.svg" class="accountsvg"></a></h1>
      </div>
      <nav class="navbar">
        <ul class="menu">
          <li><a href="/php/selection.php">Selection du jour</a></li>
          <li>
            <form method="get" action="/php/articles/categorie/categorie.php">
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
          <li><a href="/php/devenirvendeur.php">Vendre</a></li>
          
          <li><a href="/php/paiement.php">Panier
          <?php 

          // Démarrage de la session
            session_start();

            // Vérification de la variable de session "connecter"
            if(@$_SESSION["connecter"]!="oui"){ 
                // Redirection vers la page d'accueil si l'utilisateur n'est pas connecté
                header ('Location: /');
                // Arrêt de l'exécution du code
                exit();
            }  

            require_once('bdd/connexion_bdd.php');
            $nom_user = @$_SESSION["username"];
            
            $sql1 = "SELECT COUNT(*) as total FROM `Panier` WHERE username = '$nom_user'";
            $resultat1 = $conn->query($sql1);

            if ($resultat1) {
                $row = $resultat1->fetch_assoc();
                $nombreLignes = $row['total'];
                echo $nombreLignes;
            } else {
              echo "1";
            }
          
          ?>  
          
          <li><a href="/php/compte/notification.php">Notifications</a></li>

          <li class="account2" onclick="toggleDarkMode()" class="night"><a href="#"><img src="/image/night-empty.svg" id="nightimg"></a></li>

          
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
                <li><a href="#" onclick="selectCategory('autres')" class="sub-menu-item">Autres</a></li>
              </ul>
        </div> 


      </nav>
    </header>
    <main>
        <section class="sales">


            <h2>Sélection du jour</h2> 



            

            <hr><br>

            <div class="sales-container"> 
            <!-- Début de la boucle -->
            

            <?php
                require_once('bdd/connexion_bdd.php');
                
                // Déclaration des variables pour les filtres
                $tri = isset($_GET['tri']) ? $_GET['tri'] : 'Id_articles';
                $order = isset($_GET['order']) && $_GET['order'] == 'ASC' ? 'ASC' : 'DESC';
                $chevron = $order === 'ASC' ? '&#x25B2;' : '&#x25BC;';

                // Requête pour récupérer tous les articles
                $date = date('Y-m-d');

                $sql = "SELECT * FROM `Articles` ORDER BY RAND(DATE('$date')) LIMIT 6";
                $resultat = $conn->query($sql);

                // Affichage des résultats
                echo '<div class="container">';
                echo '<div class="row">';

                foreach ($resultat as $article) {
                    // Sélectionner toutes les images correspondantes à l'article
                    $chemins_images = glob('articles/depot/images/*' . $article["nom_article"] . '.*');

                    echo '<div class="col-md-6">';
                    echo '<div class="card mb-4 shadow-sm article">';
                    foreach ($chemins_images as $chemin_image) {
                        echo '<div class="imgArticle"><img class="taille" src="' . $chemin_image . '" class="card-img-top" alt="' . $article["nom_article"] . '"></div>';
                    }
                    echo '<div class="card-body">';
                    echo '<div class="card-head">';
                    echo '<h2 class="card-title">' . $article["nom_article"] . '</h2>';
                    echo '<p class="card-text">Description: ' . $article["Description"] . '</p>';
                    echo '</div>';
                    echo '<div class="d-flex justify-content-between align-items-center">';
                    echo '<span class="price">Prix: ' . $article["Prix"] . '€</span></br>';
                    echo '<span class="vendeurArticle">Vendeur : ' . $article["ID_compte"] . '</span><br>';
                    echo '<span class="dateArticle">' . $article["Date"] . '</span>';

                    echo '<form method="post" action="articles/panier/ajout_au_panier.php">';
                    echo '<input type="hidden" name="id_article" value="' . $article["Id_articles"] . '">';
                    echo '<input type="hidden" name="nom_article" value="' . $article["nom_article"] . '">';
                    echo '<input type="hidden" name="prix_article" value="' . $article["Prix"] . '">';
                    echo '<button type="submit" class="btnPanier btnArticle">Ajouter au panier</button>';
                    echo '</form>';

                    echo '<form method="post" action="message/message.php" class="chat-form" id="chatForm_' . $article["Id_articles"] . '">';
                    echo '<input type="hidden" name="id_article" value="' . $article["Id_articles"] . '">';
                    echo '<button type="submit" class="buttonMsg btnArticle">Contact</button>';
                    echo '</form>';

                    echo '<button onclick="openModal(' . $article["Id_articles"] . ', \'' . $article["ID_compte"] . '\')" class="buttonMsg2 btnArticle">Signaler</button>';

                    echo '</div>';
                    echo '</div>';

                    echo '</div>';
                    echo '</div>';
                }

                echo '</div>';
                echo '</div>';
        ?>
        </div>

        <!-- Fenêtre modale -->
        <form action="articles/signalement/traitement.php" method="post" enctype="multipart/form-data">
            <div id="myModal" class="modal">
                <div class="modal-content">

                    <span class="close" onclick="closeModal()">&times;</span>
                    <h4>Veuillez sélectionner la ou les raisons du signalement</h4><br><br>

                    <div class="reasons-container">
                        <label for="reason1">
                            <input type="checkbox" name="reason[]" id="reason1" value="Contenu inapproprié"> Contenu inapproprié
                        </label>
                        <label for="reason2">
                            <input type="checkbox" name="reason[]" id="reason2" value="Contenu illégal"> Contenu illégal
                        </label>
                        <input type="hidden" name="id_articles" id="id_articles">
                        <input type="hidden" name="id_compte" id="id_compte" value="">

                        <label for="reason3">
                            <input type="checkbox" name="reason[]" id="reason3" value="Spam"> Spam
                        </label>
                        <label for="reason4">
                            <input type="checkbox" name="reason[]" id="reason4" value="Contenu trompeur"> Contenu trompeur
                        </label>
                        <!-- Ajoutez d'autres raisons ici si nécessaire -->
                    </div>

                    <button type="submit" class="submit-btn" onclick="submitForm()">Envoyer le signalement</button>
                </div>
            </div>

        </form>
        <script src="/js/script.js"></script>

        

    </main>
    </body>
    

</html>
