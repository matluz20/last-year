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
    if($statut != "admin"){
      header ('Location: /php/afterconexion.php');
       //Arrêt de l'exécution du code
      exit();
    }

?>



<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Efrei MarketPlace - Ventes</title>
    <link rel="stylesheet" href="/css/style.css">
  </head>
  <body>
    <header>
    <div class="h1">
        <h1><a href="admin.php">Efrei MarketPlace</a></h1>
        <h1 class="account"><a href="/php/compte/moncompte.php"><img src="/image/person.svg" class="accountsvg"></a></h1>
      </div>
      <nav class="navbar">
        <ul class="menu">
          <li><a href="signalement.php">Signalements</a></li>
          <li><a href="demandes.php">Demandes</a></li>
          <li><a href="user.php">Liste des utilisateurs</a></li> 

        </ul>
      </nav>
    </header>


    <main>
      <div class="article">

      <?php
    
    require_once('../bdd/connexion_bdd.php');

    // Déclaration des variables pour les filtres
    $tri = isset($_GET['tri']) ? $_GET['tri'] : 'Id_articles';
    $order = isset($_GET['order']) && $_GET['order'] == 'DESC' ? 'DESC' : 'ASC';
    $chevron = $order === 'ASC' ? '&#x25B2;' : '&#x25BC;';
  
  
    // Requête pour récupérer tous les articles
    $sql = "SELECT * FROM `Articles` ORDER BY $tri $order";
    $resultat = $conn->query($sql);
  
    // Affichage des résultats
    echo '<div class="container">';
    echo '<div class="row">';
  
    // Filtre
    echo '<form method="get" action="">';
    echo '<label for="tri">Trier par : </label>';
    echo '<select name="tri" id="tri" onchange="this.form.submit()">';
    echo '<option>---</option>';
    echo '<option value="Date">Date</option>';
    echo '<option value="nom_article">Nom d\'article</option>';
    echo '<option value="Prix">Prix</option>';
    echo '</select>';
    echo '<a class="chevron" href="?tri=' . $tri . '&order=' . ($order === 'ASC' ? 'DESC' : 'ASC') . '">' . $chevron . '</a>';
    echo '</form>';
    
    
    foreach ($resultat as $article) {
      // Sélectionner toutes les images correspondantes à l'article
      $chemins_images = glob('../articles/depot/images/*' . $article["nom_article"] . '.*');
      
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
      echo '<span class="price">Prix: ' . $article["Prix"] .'€</span></br>';
      echo '<span class="vendeurArticle">Vendeur : '. $article["ID_compte"] .'</span><br>';
      echo '<span class="dateArticle">'. $article["Date"] .'</span>';
  
      // echo '<form method="post" action="ajouter_au_panier.php">';
      // echo '<input type="hidden" name="id_article" value="' . $article["Id_articles"] . '">';
      // echo '<button type="submit">Acheter</button>';
      // echo '</form>';
  
      //  echo '<form method="post" action="articles/panier/ajout_au_panier.php">';
      echo '<input type="hidden" name="id_article" value="' . $article["Id_articles"] . '">';
      echo '<input type="hidden" name="nom_article" value="' . $article["nom_article"] . '">';
      echo '<input type="hidden" name="prix_article" value="' . $article["Prix"] . '">';
      echo '<a class="sup" href="../articles/suppression/alert_supprimer.php?id=' . $article["Id_articles"] . '">';
      echo '<button type="submit" class="btnPanier btnArticle">';
      echo 'Supprimer';
      echo '</button>';
      echo '</a>';
      
      //  echo '</form>';
  
      
  
      echo '<form method="post" action="../message/message.php" class="chat-form" id="chatForm_' . $article["Id_articles"] . '">';
      echo '<input type="hidden" name="id_article" value="' . $article["Id_articles"] . '">';
      echo  '<button type="submit" class="buttonMsg btnArticle">Contact</button>';
      echo '</form>';
  
        // Inclure la fenêtre modale de chat
      echo '</div>';
      echo '</div>';
      
      echo '</div>';
      echo '</div>';
      
    }

      ?>
      </div>


      <script src="/js/script.js"></script>
  </main>
  </body>
</html>
