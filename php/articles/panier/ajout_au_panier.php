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

    

require_once('../../bdd/connexion_bdd.php');

// Vérification que l'ID de l'article a bien été envoyé en POST
if(isset($_POST['id_article'])) {
    $id_article = $_POST['id_article'];
    $nom_article = $_POST['nom_article'];
    $prix_article = $_POST['prix_article'];
    $user= @$_SESSION["username"];
    
    

    // Insertion de l'article sélectionné dans la table "panier"
    $sql = "INSERT INTO `Panier` (`id_article`, `nom_article`, `prix_article`,`username`) 
    VALUES ('$id_article', '$nom_article', '$prix_article', '$user')";
    $resultat = $conn->query($sql);

    // // Insertion de l'article sélectionné dans la table "panier"
    $sql_h = "INSERT INTO `Commandes` (`id_article`, `nom_article`, `prix_article`,`username`) 
    VALUES ('$id_article', '$nom_article', '$prix_article', '$user')";
    $resultat_h = $conn->query($sql_h);
    
}
header ('Location: ../../afterconexion.php');



?>