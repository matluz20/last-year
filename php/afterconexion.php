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
        <h1><a href="/">Efrei MarketPlace</a></h1>
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

          <li><a href="/php/encheres.php">Enchères</a></li>
          <li><a href="/php/aboutus.php">About Us</a></li>

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
    
        
    <div class="article">

    <?php
   
        include("index.php")

    ?></div>
   
   
   <footer>
            <br>
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
                <img src="/image/LOGO PROJECT.png" alt="Photo" class="footer-photo">
              </div>
              
              <p>&copy; Efrei MarketPlace - Tous droits réservés</p>
              <br>
  </footer>
  <script src="/js/script.js"></script>

  </body>

</html>
