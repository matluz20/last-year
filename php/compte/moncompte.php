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

?>





<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Efrei MarketPlace - Ventes</title>
    <link rel="stylesheet" href="../../css/style.css">


  </head>
  <body>
    <header>
      <div class="h1">
                <h1><a href="/">Efrei MarketPlace</a></h1>
                <h1 class="account"><a href="/php/compte/moncompte.php"><img src="/image/person.svg" class="accountsvg"></a></h1>
      </div>
      <nav class="navbar">
        <ul class="menu">
          <li><a href="/">Tout Parcourir</a></li>
          <li><a href="/php/compte/notification.php">Notifications</a></li>
          <li><a href="/php/paiement.php">Panier</a></li>
          <li><a href="/php/devenirvendeur.php">Vendre</a></li>
          <li class="account2" onclick="toggleDarkMode()" class="night"><a href="#"><img src="/image/night-empty.svg" id="nightimg"></a></li>
          
          
        </ul>
      </nav>
    </header>


    <div id="UserCard">
        <?php
            require_once('../bdd/connexion_bdd.php');
            $nom = $_SESSION["username"];
            $sql = "SELECT * FROM `Utilisateur` WHERE username = '$nom'";
            $resultat = $conn->query($sql);
            $row = $resultat->fetch_assoc();
                echo "<div class='username'> Username : ".$row["username"]."</div>";
                echo "<div class='statusUser'> Statut : ".$row["statut"]."</div>";
                $_SESSION["statut"] = $row["statut"];
        ?>
    </div>
    

    <style>
    .historique {
      position: absolute;
      top: -15px;
      right: 0px;
    }
  </style>

    <div class="filtre">
      <form action="historique.php" method="POST">
       <div class="historique">
        <button type="submit" id="boutonHistorique">Historique</button>
       </div> 
    </form>
    <form action="#" method="GET">

      <label for="statut" class="filtrer">Filtrer par statut :</label>
      <select id="statut" name="statut">
        <option value="en_vente">Articles encore en vente</option>
        <option value="vendu">Articles vendus</option>
      </select>
      <button type="submit">Filtrer</button>
      <div class="historique">
</div>


  </form>
  </div>

  
  
  
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

                require_once('../bdd/connexion_bdd.php');
                $nom_user = @$_SESSION["username"];

                $statut = isset($_GET['statut']) ? $_GET['statut'] : 'en_vente';

                if ($statut == 'en_vente') {

                  echo '<h3 class="pending" >Voici vos articles encore en vente </h3>';
                  $sql = "SELECT * FROM `Articles` WHERE `ID_compte` = '$nom_user' AND `envente` = 'oui' ORDER BY `Id_articles` DESC";

                    $resultat = $conn->query($sql);
                    $toto = "roro";

                    if ($resultat->num_rows > 0) {

                    // Affichage des résultats
                    echo '<div class="container">';
                    echo '<div class="row">';
                    
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
                        echo '<p class="card-text">Description: ' . $article["Description"] . '</p>';
                        echo '<div class="d-flex justify-content-between align-items-center">';
                        echo '<span class="price">Prix: ' . $article["Prix"] .'€</span></br>';
                        echo '<span class="dateArticle">Date ajout: ' . $article["Date"] ;
                        $nom_article = $article["nom_article"];

                        

                        echo '<button id="modal-btn" class="but" onclick="openModal()">Modifier</button>';
                        
                        echo '<a class="sup" href="../articles/suppression/alert_supprimer.php?id=' . $article["Id_articles"] . '">';
                        echo '<p >Supprimer <p>';
                        echo '</a>';
                        
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';





                        echo '<div id="modal" class="modal">';
                        echo '<div class="modal-content">';
                        echo '<span class="close">&times;</span>';
                        echo '<h3>Saisisez ci-dessous les nouvelles informations concernant votre article :</h3><br>';

                        echo '<form action="/php/articles/modifier/traitement.php" method="post" enctype="multipart/form-data">';
                        echo '<label for="titre">Titre :</label><br>';
                        echo '<input type="text" id="titre" name="titre" value="' . $article["nom_article"] . '" required><br>';

                        echo '<label for="description">Description :</label><br>';
                        echo '<textarea id="description" name="description" required>' . $article["Description"] . '</textarea><br>';

                        echo '<label for="prix">Prix :</label><br>';
                        echo '<input type="number" id="prix" name="prix" value="' . $article["Prix"] . '" required><br>';

                        echo '<label for="categorie">Catégorie :</label><br>';
                        echo '<select name="categorie" id="categorieArticle" required>';
                        echo '<option value="vetement">Vêtement</option>';
                        echo '<option value="informatique">Matériel informatique</option>';
                        echo '<option value="electromenager">Appareils électroménagers</option>';
                        echo '<option value="vehicule">Véhicule</option>';
                        echo '<option value="fitness">Appareils de fitness</option>';
                        echo '<option value="jeuxvideo">Jeux-vidéos</option>';
                        echo '<option value="console">Console de jeu</option>';
                        echo '</select><br>';

                        echo '<p>Voulez-vous modifier la photo de l\'article ?</p>';

                        echo '<label for="choix">Choix :</label>';
                        echo '<select id="choix" name="choix">';
                        echo '<option value="non">Non</option>';
                        echo '<option value="oui">Oui</option>';
                        echo '</select>';

                        echo '<div id="insertion-image" style="display: none;">';
                        echo '<label for="image">Sélectionnez une nouvelle image :</label>';
                        echo '<input type="file" id="image" name="image" accept="image/*">';
                        echo '</div>';

                        echo '<br><br>';
                        echo '<input type="hidden" name="nom_article" value="' . $nom_article . '">'; 
                        echo '<button type="submit" class="but">Enregistrer</button>';
                        echo '<br><br>';

                        echo '</form>';

                        echo '</div>';
                        echo '</div>';


                    }
                    
                    // Fermeture la balise <div> de la classe "row"
                    echo '</div>';
                    echo '</div>';


                }else { echo "<div class='pending'>Vous n'avez aucun arclicle en vente</div>";}

               }
                
                
                elseif($statut == 'vendu')  {
                  $sql = "SELECT * FROM `Articles` WHERE `ID_compte` = '$nom_user' AND `envente` = 'non' ORDER BY `Id_articles` DESC";

                    $resultat = $conn->query($sql);


                    if ($resultat->num_rows > 0) {

                    // Affichage des résultats
                    echo '<div class="container">';
                    echo '<div class="row">';
                    
                    foreach ($resultat as $article) {
                        // Sélectionner toutes les images correspondantes à l'article
                        $chemins_images = glob('../articles/depot/images/*' . $article["nom_article"] . '.*');
                    
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
                        echo '<span class="dateArticle">Date ajout: ' . $article["Date"] . '</span><br> <img src="../../image/supprimer.png">';
                        
                        
                        
                        // Inclure la fenêtre modale de chat
                        
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                    
                    // Fermer la balise <div> de la classe "row"
                    echo '</div>';
                    echo '</div>';


                }else { echo "<div class='pending'>Vous n'avez vendu aucun article</div>";}
                } else{

                }

                




?>

<br><br><button class="btnDeco"><a href="deconnexion.php">Deconnexion</a></button>


            <div id="modal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h3>Saisisez ci-dessous les nouvelles informations concernant votre article :</h3><br>

               









 <script>

                                // Récupérer la référence de la fenêtre modale
                var modal = document.getElementById("modal");

                // Récupérer la référence de l'élément qui ouvre la fenêtre modale
                var modalTrigger = document.getElementById("modal-btn");

                // Récupérer la référence de l'élément pour fermer la fenêtre modale
                var closeBtn = document.getElementsByClassName("close")[0];

                // Fonction pour ouvrir la fenêtre modale
                function openModal() {
                modal.style.display = "block";
                }

                // Fonction pour fermer la fenêtre modale
                function closeModal() {
                modal.style.display = "none";
                }

                // Écouter l'événement clic pour ouvrir la fenêtre modale
                modalTrigger.addEventListener("click", openModal);

                // Écouter l'événement clic pour fermer la fenêtre modale en cliquant sur le bouton de fermeture
                closeBtn.addEventListener("click", closeModal);


                const choixSelect = document.getElementById('choix');
                const insertionImage = document.getElementById('insertion-image');

                choixSelect.addEventListener('change', function() {
                  if (this.value === 'oui') {
                    insertionImage.style.display = 'block';
                  } else {
                    insertionImage.style.display = 'none';
                  }
                });



        </script>










  
 
  <footer>

<br><br><br><br>
<div class="footer-container">
<div class="name-group">
  <a href="https://www.linkedin.com/in/toufik-laouamen-27808a203/" target="_blank">LAOUAMEN Toufik</a>
  <a href="https://www.linkedin.com/in/smrohman/" target="_blank">ROHMAN Majed</a>
</div>
<div class="name-group">
  <a href="https://www.linkedin.com/in/matondo-luzolo-6a40891b2/" target="_blank">LUZOLO Matondo</a>
  <a href="https://www.linkedin.com/in/moctar-sahande/" target="_blank">SAHANDE Mohamed</a>
</div>
</div>
<div class="photo-container">
<img src="../../image/LOGO PROJECT.png" alt="Photo" class="footer-photo">
</div>
<p>&copy; Efrei MarketPlace - Tous droits réservés</p>
<br><br><br><br>
</footer>
<!-- Style pour la page mon compte -->

  <style> 

.container{
  width: 90em;
  
}




.mod{
  color : blue;
}

  .sup{
    color : red;
    text-decoration: none;

  }


  .but {

  border-radius: 20px;
  border: 1px solid #004FFF;
  color: white;
  padding: 10px 20px;
  font-size: 16px;
  border-radius: 20px; /* Ajout de la propriété border-radius avec une valeur de 20px */
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.but:hover {
  transition: 0.6s ease;
  border: 1px solid #360ed4;
  background-color: #004FFF;
  color: #fff;
}

  

    #UserCard {
        background-color: #F2F2F2;
        border: 1px solid #CCCCCC;
        border-radius: 5px;
        padding: 10px;
        width: 300px;
        margin: 10px;
        font-family: Arial, sans-serif;
        color: #333333;
    }

  .filtre {
  position: absolute;
  top: 15%;
  right: 0;
  margin: 20px; 

  }

  label {
    margin-right: 10px;
  }

  select {
    padding: 5px;
  }

  button {
    padding: 5px 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    cursor: pointer;
  }




  /* Styles pour la fenêtre modale */
  #modal-btn{
        border-radius: 20px;
        border: 1px solid #360ed4;
        background-color: #5311ed;
        color: #FFFFFF;
        font-size: 12px;
        font-weight: bold;
        padding: 12px 45px;
        margin-top: 30px;
        letter-spacing: 1px;
        text-transform: uppercase;
        transition: transform 80ms ease-in;
}


/* style pour le formulaire d'ajout*/

  form {
    margin-top: 20px;
  }
  
  form label,
  form input,
  form textarea,
  form select {
    margin-bottom: 10px;
  }
  
  form input[type="submit"] {
    position: relative;
    left: 50%;
    margin-top: 60px;
    transform: translate(-50%, -50%);
    width:120px;
    height: 60px;
    background: #1044c7;
	background: -webkit-linear-gradient(to right, #290ab4, #0b7bcb);
	background: linear-gradient(to right, #290ab4, #0b7bcb);
	background-position: 0 0;
	color: #FFFFFF;
    border-radius: 10%;
   
  }


  .modal {
    display: none;
    position: fixed;
    z-index: 999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
  }
  
  .modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 70%;
  }
  
  .blur-effect {
    filter: blur(4px);
  }
  
  .modal-content .close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
  }
  
  .modal-content .close:hover,
  .modal-content .close:focus {
    color: #000;
    text-decoration: none;
  }
  
  #modal-btn {
    margin-top: 20px;
  }
  
  #modal-btn:focus {
    outline: none;
  }

</style>
    
  <script src="/js/script.js"></script>
    </body>
</html>
