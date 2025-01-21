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
    <div class="container">
        <div class="row">
            <?php
            require_once('bdd/connexion_bdd.php');
            if (@$_SESSION["connecter"] != "oui") {
                // Redirection vers la page d'accueil si l'utilisateur n'est pas connecté
                header('Location: ../index.php');
                // Arrêt de l'exécution du code
                exit();
            }
            $nom_user = @$_SESSION["username"];


            // Requête pour récupérer tous les articles
            $sql = "SELECT * FROM `Panier` WHERE username = '$nom_user'  ORDER BY `id_article` DESC";
            $resultat = $conn->query($sql);

            foreach ($resultat as $article) {
                // Sélectionner toutes les images correspondantes à l'article
                $chemins_images = glob('articles/depot/images/*' . $article["nom_article"] . '.*');

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
                echo '<form method="post" action="articles/suppression/supprimer_article.php">';
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
    <div class="total">
                    <h3> le total de votre panier est : 
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

                        require_once('bdd/connexion_bdd.php');
                        $nom_user = @$_SESSION["username"];
                        $sql1 = "SELECT SUM(prix_article) as total FROM `Panier` WHERE username = '$nom_user'";
                        $resultat1 = $conn->query($sql1);

                        if ($resultat1) {
                            $row = $resultat1->fetch_assoc();
                            $nombreLignes = $row['total'];
                            if ($nombreLignes){
                                echo $nombreLignes.'€';
                            }
                            else{
                                echo "0€";
                            }
                        } else {
                          echo "0";
                        }


                        ?>
                    </h3>
                </div>
    <div class="buttons-container">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#paymentModal">Procéder au paiement</button>
        <button type="button" class="btn btn-secondary" onclick="goBack()">Retour à l'achat</button>
    </div>
    </main>
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
                    <form id="paymentForm" action="articles/suppression/supression_panier.php" method="POST">
                        
                        <div class="form-group">
                          <label for="cardType">Type de carte</label>
                          <select class="form-control" id="cardType">
                            <option value="visa">Visa</option>
                            <option value="mastercard">MasterCard</option>
                            <option value="amex">American Express</option>
                            <option value="bimpli">Bimpli</option>
                          </select>
                        </div>
                        <div class="form-group">
                            <label for="cardHolder">Nom sur la carte</label>
                            <input type="text" class="form-control" id="cardHolder">
                            <div id="nameError" class="invalid-feedback"></div>
                        </div>                      
                        <div class="form-group">
                            <label for="cardNumber">Numéro de carte</label>
                            <input type="text" class="form-control" id="cardNumber">
                            <div id="cardNumberError" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6">
                        <label for="expirationDate">Date d'expiration</label>
                        <input type="text" class="form-control" id="expirationDate" placeholder="MM/AA">
                        </div>
                        <div class="form-group col-md-6">
                        <label for="cvv">Code CVV/CVC</label>
                        <input type="text" class="form-control" id="cvv" placeholder="123">
                        <div id="cvvError" class="invalid-feedback"></div>
                        </div>
                        <button type="submit" class="btn btn-primary">Payer</button>
                        <!-- Autres champs du formulaire de paiement -->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <!-- <button type="button" class="btn btn-primary" onclick="afficherMessage()">Payer</button> -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
       function goBack() {
         window.location.href = "afterconexion.php";
       }
    </script>

    <script> //condition pour que tous les champs soient remplis
                document.getElementById('paymentForm').addEventListener('submit', function(event) {
            var cardHolderInput = document.getElementById('cardHolder');
            var cardHolderValue = cardHolderInput.value.trim();
            var nameErrorElement = document.getElementById('nameError');
            if (cardHolder === '') {
                nameErrorElement.innerText = 'Le nom doit être saisi.';
                cardHolderInput.classList.add('is-invalid');
                event.preventDefault(); // Empêche la soumission du formulaire
                } else {
                nameErrorElement.innerText = '';
                cardHolderInput.classList.remove('is-invalid');
                }
            });
    </script>

<script>
  document.getElementById('cardNumber').addEventListener('input', function() {
    var cardNumberInput = document.getElementById('cardNumber');
    var cardNumberValue = cardNumberInput.value.trim();
    var cardNumberErrorElement = document.getElementById('cardNumberError');

    // Vérifier si la valeur dépasse 16 chiffres
    if (cardNumberValue.length !== 16) {
      cardNumberInput.value = cardNumberValue.slice(0, 16); // Tronquer la valeur à 16 chiffres
    }

    // Vérifier si la valeur contient exactement 16 chiffres
    if (cardNumberValue.length < 16) {
      cardNumberErrorElement.innerText = 'Le numéro de carte doit contenir exactement 16 chiffres.';
      cardNumberInput.classList.add('is-invalid');
    } else {
      cardNumberErrorElement.innerText = '';
      cardNumberInput.classList.remove('is-invalid');
    }
  });
</script>



<script>
  document.getElementById('cvv').addEventListener('input', function() {
    var cvvInput = document.getElementById('cvv');
    var cvvValue = cvvInput.value.trim();
    var cvvErrorElement = document.getElementById('cvvError');

    // Vérifier si la valeur dépasse 3 chiffres
    if (cvvValue.length > 3) {
      cvvInput.value = cvvValue.slice(0, 3); // Tronquer la valeur à 3 chiffres
    }

    // Vérifier si la valeur contient exactement 3 chiffres
    if (cvvValue.length !== 3) {
      cvvErrorElement.innerText = 'Le code CVV/CVC doit contenir exactement 3 chiffres.';
      cvvInput.classList.add('is-invalid');
    } else {
      cvvErrorElement.innerText = '';
      cvvInput.classList.remove('is-invalid');
    }
  });
</script>

    <script> //script pour la validation de la date
                document.getElementById('expirationDate').addEventListener('input', function() {
            var expirationDateInput = document.getElementById('expirationDate');
            var expirationDateValue = expirationDateInput.value.trim();
            var errorElement = document.getElementById('expirationDateError');

            // Supprimer tous les caractères non numériques
            expirationDateValue = expirationDateValue.replace(/\D/g, '');

            // Limiter la taille à 4 caractères (MM/YY)
            expirationDateValue = expirationDateValue.slice(0, 4);

            // Ajouter le format MM/YY
            if (expirationDateValue.length > 2) {
                expirationDateValue = expirationDateValue.slice(0, 2) + '/' + expirationDateValue.slice(2);
            }

            // Mettre à jour la valeur du champ
            expirationDateInput.value = expirationDateValue;

            // Vérifier si la valeur est vide ou ne correspond pas au format MM/YY
            if (expirationDateValue === '' || !/^\d{2}\/\d{2}$/.test(expirationDateValue)) {
                errorElement.innerText = 'La date d\'expiration doit être au format MM/YY.';
                expirationDateInput.classList.add('is-invalid');
            } else {
                errorElement.innerText = '';
                expirationDateInput.classList.remove('is-invalid');
            }
        });

    </script>

    <script>
        document.getElementById('paymentForm').addEventListener('submit', function(event) {
            var cardTypeInput = document.getElementById('cardType');
            var cardHolderInput = document.getElementById('cardHolder');
            var cardNumberInput = document.getElementById('cardNumber');
            var expirationDateInput = document.getElementById('expirationDate');
            var cvvInput = document.getElementById('cvv');

            // Vérifier si tous les champs sont vides
            if (
                cardTypeInput.value.trim() === '' ||
                cardHolderInput.value.trim() === '' ||
                cardNumberInput.value.trim() === '' ||
                expirationDateInput.value.trim() === '' ||
                cvvInput.value.trim() === ''
            ) {
                // Empêcher l'envoi du formulaire
                event.preventDefault();
            }
        });
    </script>



    <!-- <script>
        document.querySelector('paymentForm').addEventListener('submit', function(event) {
  var cardType = document.getElementById('cardType').value;
  var cardHolder = document.getElementById('cardHolder').value;
  var cardNumber = document.getElementById('cardNumber').value;
  var expirationDate = document.getElementById('expirationDate').value;
  var cvv = document.getElementById('cvv').value;
  var errorMessage = document.getElementById('errorMessage');
  
  if (cardType === '' || cardHolder === '' || cardNumber === '' || expirationDate === '' || cvv === '') {
    event.preventDefault(); // Empêche la soumission du formulaire
    
    errorMessage.innerText = 'Veuillez remplir tous les champs du formulaire.';
    errorMessage.style.display = 'block';
  } else {
    // Tous les champs sont remplis, vous pouvez continuer avec la soumission du formulaire.
  }
});

    </script> -->

    <!-- <script>
        function afficherMessage() {
            window.open('', '_blank', 'width=400,height=200');
            var win = window.self;
            win.document.write('<html><body>');
            win.document.write('<h1>Votre achat a été effectué avec succès !</h1>');
            win.document.write('</body></html>');
            win.document.close();
        }
    </script> -->

    <footer>
        <p>&copy; Efrei MarketPlace - Tous droits réservés</p>
    </footer>
    <script src="script.js"></script>
</body>
</html>
