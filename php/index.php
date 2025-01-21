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

    $nom_user = @$_SESSION["username"];
    $statut = @$_SESSION["statut"];
    if($statut == "admin"){
      header ('Location: /php/compte/admin.php');
       //Arrêt de l'exécution du code
      exit();
    }

?>
<main>
  <section class="sales">

    <div class="search-bar">

        <form method="get" action="">
          <input type="text" name="query" placeholder="Rechercher...">
          <button  class='btn-rech' type="submit">Rechercher</button>
        </form>
        
    </div>

    <h2>Nos Ventes</h2>
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
          $sql = "SELECT * FROM `Articles`";

          if (isset($_GET['query'])) {
              $query = $_GET['query'];
              $sql .= " WHERE `nom_article` LIKE '%$query%'";
          }

          $sql .= " ORDER BY $tri $order";
          $resultat = $conn->query($sql);

          // Affichage des résultats
          echo '<div class="container">';
          echo '<div class="row">';

          // Filtre
          echo '<form method="get" action="">';
          echo '<label for="tri" class="tri">Trier par :</label>';
          echo '<select name="tri" id="tri" onchange="this.form.submit()">';
          echo '<option>---</option>';
          echo '<option value="Id_articles">Date</option>';
          echo '<option value="nom_article">Nom d\'article</option>';
          echo '<option value="Prix">Prix</option>';
          echo '</select>';
          echo '<a class="chevron" href="?tri=' . $tri . '&order=' . ($order === 'ASC' ? 'DESC' : 'ASC') . '">' . $chevron . '</a>';
          echo '</form>';

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
