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

?>


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
      <div class="article">
  <section class="sales">
        <h2>Nos Ventes par enchère</h2><hr><br>
        <div class="sales-container"> 
          <?php
                require_once('bdd/connexion_bdd.php');
                // Déclaration des variables pour les filtres
                $tri = isset($_GET['tri']) ? $_GET['tri'] : 'id_enchere';
                $order = isset($_GET['order']) && $_GET['order'] == 'ASC' ? 'ASC' : 'DESC';
                $chevron = $order === 'ASC' ? '&#x25B2;' : '&#x25BC;';

                $nom_user = @$_SESSION["username"];
                $id_compte = @$_SESSION["id_compte"];



                // requete permettant de récuperer les encheres encore disponibles

                $sql = "SELECT * FROM `enchere`";
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
                echo '<option value="id_enchere">Date</option>';
                echo '<option value="nom_article">Nom d\'article</option>';
                echo '<option value="prix_actuel">Prix</option>';
                echo '</select>';
                echo '<a class="chevron" href="?tri=' . $tri . '&order=' . ($order === 'ASC' ? 'DESC' : 'ASC') . '">' . $chevron . '</a>';
                echo '</form>';


                foreach ($resultat as $article) {


                // requete pour supprimer les enchères qui ont expirés 

                
                $sql3 = "SELECT * FROM `participations` WHERE `id_enchere` = " . $article['id_enchere'];
                $resultat3 = $conn->query($sql3);
                $row3 = $resultat3->fetch_assoc();
                $date_fin = $row3['date_fin'];


                // recuperer le prix max pour l'enchere

                $sql2 = "SELECT MAX(prix_propose) AS prix_max FROM `participations` WHERE `id_enchere` = " . $article['id_enchere'];
                $resultat2 = $conn->query($sql2);
                $row2 = $resultat2->fetch_assoc();


                // recuper la date du jour et comparé avec la date de fin ! 

                $date_jour = date('Y-m-d H:i:s');
                



                if ($date_jour = $date_fin) {

              // envoyer une notification à celui qui a mis la somme la plus importante avant la date de fin 

              $sql4 = "SELECT `id_acheteur` FROM `participations` WHERE `id_enchere` = " . $article['id_enchere'] . " AND `prix_propose` = (SELECT MAX(prix_propose) FROM `participations` WHERE `id_enchere` = " . $article['id_enchere'] . ")";
              $resultat4 = $conn->query($sql4);
              $row4 = $resultat4->fetch_assoc();
              $id_acheteur_max_prix = $row4['id_acheteur'];


              // recuperer le nom de l'utilisateur 

              $sql5 = "SELECT * FROM `Utilisateur` WHERE `ID_compte` = " . $row4['id_acheteur'];
              $resultat5 = $conn->query($sql5);
              $row5 = $resultat5->fetch_assoc();
              $nom_useer = $row5['username'];

              // envoyer le message

              $message = "Félicitations, vous avez remporté la vente aux enchères sur le produit " . $article["nom_article"] . " avec un montant de " . $row4['prix_propose'] . "!";


              $sql6 = "INSERT INTO `message` (`username`,`expediteur`, `message`, `date`)
              VALUES ('$$nom_useer', '$nom_user ','$message', CURRENT_TIMESTAMP())";
              $conn->query($sql6);



              // supprimer touts les participants 
                
              $sql7 = "DELETE FROM `participations` WHERE `id_enchere` = " . $article['id_enchere'] ;
              $result = $conn->query($sql7);


              // supprimer l'enchere 

              $sql8 = "DELETE FROM `enchere` WHERE `id_enchere` = " . $article['id_enchere'] ;
              $result2 = $conn->query($sql8);




           
              }
          









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
                  echo '<p class="card-text">Description: ' . $article["description"] . '</p>';
                  echo '</div>';
                  echo '<div class="d-flex justify-content-between align-items-center">';
                  echo '<span class="price">Prix du départ: ' . (!empty($article["prix_depart"]) ? $article["prix_depart"] : $article["prix_depart"]) . '€</span></br>';
                  echo '<span class="vendeurArticle">Prix max actuel : ' . $row2['prix_max'] . '</span><br>';
                  echo '<span class="vendeurArticle">Vendeur : ' . $article["nom_vendeur"] . '</span><br>';
                  echo '<span class="dateArticle">Date de fin: ' . $article["date_fin"] . '</span>';
    
                  echo '<form method="post" action="message/message.php" class="chat-form" id="chatForm_' . $article["Id_articles"] . '">';
                  echo '<input type="hidden" name="id_article" value="' . $article["id_enchere"] . '">';
                  echo '<button type="submit" class="buttonMsg btnArticle">Contact</button>';
                  echo '</form>';
    
                  echo '<button onclick="openModal(' . $article["id_enchere"] . ', \'' . $article["nom_vendeur"] . '\')" class="buttonMsg2 btnArticle">Signaler</button>';

                  
                  // verifier si l'utilisateur fait déjà parti des participants pour l'enchère, si non afficher le boutton participer ! si oui afficher augmenter la proposition

                  

                  $sql10 = "SELECT DISTINCT * FROM `participations` WHERE `id_enchere` = " . $article['id_enchere'];
                  $resultat10 = $conn->query($sql10);
                  $acheteurs = array(); // Tableau pour stocker les id_acheteur déjà rencontrés

                  if ($resultat10->num_rows > 0) {
                      while ($row10 = $resultat10->fetch_assoc()) {
                          $id_acheteur = $row10['id_acheteur'];

                          if ($id_acheteur == $id_compte) {
                            echo '<button onclick="openModal2(' . $article["id_enchere"] . ')" class="buttonMsg3 btnArticle">surencherir</button>';
                            
                          } elseif (!in_array($article['id_enchere'], $acheteurs)) {
                              $acheteurs[] = $article['id_enchere']; // Ajouter l'id_enchere au tableau des acheteurs
                              echo '<button type="submit" class="buttonMsg3 btnArticle" name="participerBtn" onclick="event.preventDefault(); openModal3(' . $article["id_enchere"] . ', \'' . $article["nom_vendeur"] . '\', \'' . $article["nom_article"] . '\');">Participer</button>';
                          }
                      }
                  } else {
                      echo '<button type="submit" class="buttonMsg3 btnArticle" name="participerBtn" onclick="event.preventDefault(); openModal3(' . $article["id_enchere"] . ', \'' . $article["nom_vendeur"] . '\', \'' . $article["nom_article"] . '\');">Participer</button>';
                  }






    
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


      <!-- fenetre modale pour le surenhere -->


      <div id="modal" class="modal">
  <div class="modal-content">
    <h2>Surenchérir</h2>
    <form id="surencherir-form" action="articles/enchere/traitement.php" method="POST">
      <input type="hidden" id="id_enchere" name="id_enchere">
      <label for="prix_surenchere">Prix :</label>
      <input type="number" id="prix_surenchere" name="prix_surenchere" required>
      <button type="submit">Envoyer</button>
    </form>
  </div>
</div>










      <!-- fenetre modal du paiment  -->


          <!-- Modal -->
          <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Paiement</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form id="paymentForm" action="articles/enchere/traitement.php" method="POST">
                
                <label for="prix">Prix :</label>
                <input type="number" id="prix" name="prix" step="0.01" required>

                <div class="form-group">
                        <label for="cardType">Type de carte</label>
                        <select class="form-control" id="cardType" name="cardType">
                            <option value="visa">Visa</option>
                            <option value="mastercard">MasterCard</option>
                            <option value="amex">American Express</option>
                            <option value="bimpli">Bimpli</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cardHolder">Nom sur la carte</label>
                        <input type="text" class="form-control" id="cardHolder" name="cardHolder">
                        <div id="nameError" class="invalid-feedback"></div>
                    </div>
                  


                    <input type="hidden" id="id_enchere2" name="id_enchere2">
                    <input type="hidden" id="nom_vendeur" name="nom_vendeur">
                    <input type="hidden" id="nom_article" name="nom_article">



                    <div class="form-group">
                        <label for="cardNumber">Numéro de carte</label>
                        <input type="text" class="form-control" id="cardNumber" name="cardNumber">
                        <div id="cardNumberError" class="invalid-feedback"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="expirationDate">Date d'expiration</label>
                        <input type="text" class="form-control" id="expirationDate" name="expirationDate" placeholder="MM/AA">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="cvv">Code CVV/CVC</label>
                        <input type="text" class="form-control" id="cvv" name="cvv" placeholder="123">
                        <div id="cvvError" class="invalid-feedback"></div>
                    </div>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <!-- Autres champs du formulaire de paiement -->
                </form>

                </div>
                <div class="modal-footer">

                <button id="closeModalBtn" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                


                    <!-- <button type="button" class="btn btn-primary" onclick="afficherMessage()">Payer</button> -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   
      <script src="/js/pay.js"></script>
    <script src="script.js"></script>


<script>




function openModal2(idEnchere) {
  var modal = document.getElementById("modal");
  modal.style.display = "block";

  // Mettre à jour la valeur de l'élément caché pour l'ID de l'article
  var hiddenArticleInput = document.getElementById('id_enchere');
  hiddenArticleInput.value = idEnchere;
}

// Lorsque le formulaire est soumis, vous pouvez récupérer la valeur du prix et effectuer les actions nécessaires
document.getElementById("surencherir-form").addEventListener("submit", function(event) {
  // Empêche l'envoi du formulaire par défaut pour effectuer des actions personnalisées
  event.preventDefault();

  var prix = document.getElementById("prix_surenchere").value;

  // Vous pouvez effectuer des actions supplémentaires avec la valeur du prix ici

  // Soumettre le formulaire vers articles/enchere/traitement.php
  document.getElementById("surencherir-form").submit();
});








function openModal3(articleId, accountId, nomarticle) {
  // Mettre à jour la valeur de l'élément caché pour l'ID de l'article
  var hiddenArticleInput = document.getElementById('id_enchere2');
  hiddenArticleInput.value = articleId;

  // Mettre à jour la valeur de l'élément caché pour l'ID du compte
  var hiddenAccountInput = document.getElementById('nom_vendeur');
  hiddenAccountInput.value = accountId;

  var hiddenAccountInput = document.getElementById('nom_article');
  hiddenAccountInput.value = nomarticle;

  var modal = document.getElementById('paymentModal');
  modal.classList.add('show');
  modal.style.display = 'block';
  document.body.classList.add('modal-open');
}



var closeModalBtn = document.getElementById('closeModalBtn');
closeModalBtn.addEventListener('click', closeModal);

function closeModal() {
  var paymentModal = document.getElementById('paymentModal');
  paymentModal.classList.remove('show');
  paymentModal.style.display = 'none';
  var backdrop = document.getElementsByClassName('modal-backdrop')[0];
  backdrop.parentNode.removeChild(backdrop);
}


document.getElementById('participerBtn').addEventListener('click', function(event) {
    event.preventDefault(); // Empêche le formulaire de se soumettre normalement
    openModal3();
});



</script>



          

    </main>
  </body>

</html>
