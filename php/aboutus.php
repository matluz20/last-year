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
<html>
<head>
    <meta charset="UTF-8">
    <title>About us</title>
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

      // Fait appel à la base de données
      require_once('bdd/connexion_bdd.php');
      $nom_user = @$_SESSION["username"];
      
      // Requete sql pour récupérer le nombre d'article du panier de l'utilisateur
      $sql1 = "SELECT COUNT(*) as total FROM `Panier` WHERE username = '$nom_user'";
      $resultat1 = $conn->query($sql1);

      // Affiche le nombre dans le header
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
    <main>
        <section class="sales">
            <h2>About Us</h2><hr><br>
            <div class="container">
                <div class="row">
                    <div class="col-md-25">
                        <div class="card mb-4 shadow-m article">
                            <div class="imgAboutUs">
                                <div class="circle">
                                    <img class="tailleAboutUS mat" src="/image/matondo.jpeg">
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="card-head">
                                    <strong>Matondo Luzolo</strong>
                                    <p class="card-text">Project manager / Developper <br><br> JavaScript<br> PHP <br> MySQL </p>
                                    <p class="linkedin">
                                        <a href="https://www.linkedin.com/in/matondo-luzolo-6a40891b2/"><img src="/image/linkedin.svg"></a>
                                    </p>
                                </div>
                            </div>  
                        </div>
                    </div>
                    <div class="col-md-25">
                        <div class="card mb-4 shadow-m article">
                            <div class="imgAboutUs">
                                <div class="circle">
                                    <img class="tailleAboutUS" src="/image/joker.jpg">
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="card-head">
                                    <strong>Sheikh Majed Rohman</strong>
                                    <p class="card-text"> Developper / Desginer <br><br> JavaScript<br> PHP <br> CSS </p>
                                    <p class="linkedin">
                                        <a href="https://www.linkedin.com/in/smrohman/"><img src="/image/linkedin.svg"></a>
                                    </p>
                                </div>
                            </div>  
                        </div>
                    </div>
                    <div class="col-md-25">
                        <div class="card mb-4 shadow-m article">
                            <div class="imgAboutUs">
                                <div class="circle">
                                    <img class="tailleAboutUS" src="/image/toufik.jpg">
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="card-head">
                                    <strong>Toufik Laouamen</strong>
                                    <p class="card-text"> Designer<br><br> Figma<br> CSS <br> JS </p>
                                    <p class="linkedin">
                                        <a href="https://www.linkedin.com/in/toufik-laouamen-27808a203/"><img src="/image/linkedin.svg"></a>
                                    </p>
                                </div>
                            </div>  
                        </div>
                    </div>
                    <div class="col-md-25">
                        <div class="card mb-4 shadow-m article">
                            <div class="imgAboutUs">
                                <div class="circle">
                                    <img class="tailleAboutUS" src="/image/sahande.jpg">
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="card-head">
                                    <strong>Mohamed Sahande</strong>
                                    <p class="card-text">Developper <br><br> JavaScript<br> PHP <br> CSS </p>
                                    <p class="linkedin">
                                        <a href="https://www.linkedin.com/in/moctar-sahande/"><img src="/image/linkedin.svg"></a>
                                    </p>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
            
        </section>
    </main>

    <footer>
        <br>
        <p>&copy; Efrei Marketplace  - Tous droits réservés</p>
        <br>
    </footer>
      <script src="/js/script.js"></script>
</body>
</html>
