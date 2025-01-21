<?php
require_once('bdd/connexion_bdd.php');

// Vérification que l'ID de l'article a bien été envoyé en POST
if(isset($_POST['id_article'])) {
    $id_article = $_POST['id_article'];
    echo "$id_article";


    

    // Insertion de l'article sélectionné dans la table "panier"
    $sql = "INSERT INTO panier (id_article, nom_article, prix_article) VALUES ('".$article["Id_articles"]."', '".$article["nom_article"]."', '".$article["Prix"]."')";
    $conn->exec($sql);

    // Requête pour récupérer tous les articles

  $sql = "SELECT * FROM `panier` ORDER BY `id_article` DESC";
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
        echo '<img class="taille" src="' . $chemin_image . '" class="card-img-top" alt="' . $article["nom_article"] . '">';
    }
    echo '<div class="card-body">';
    echo '<h2 class="card-title">' . $article["nom_article"] . '</h2>';
    //echo '<p class="card-text">Description: ' . $article["Description"] . '</p>';
    echo '<div class="d-flex justify-content-between align-items-center">';
    echo '<span class="price">Prix: ' . $article["prix_article"] .'€</span></br>';
    //echo '<span class="dateArticle">Date ajout: '. $article["Date"] .'</span><br>';
    echo '<button type="button" class="btn btn-sm btn-outline-secondary" onclick="addToCart(\'' . $article["id_article"] . '\')">Ajouter au panier</button><br>';
    echo '<button><a href="paiement.php?id=' . $article["id_article"] . '"> Acheter</a></button>';


    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}
echo '</div>';
echo '</div>';
}
else {
    echo "toto";
}
?>
