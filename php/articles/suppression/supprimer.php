<?php
session_start();

if (!isset($_SESSION["connecter"]) || $_SESSION["connecter"] != "oui") {
    // Redirection vers la page d'accueil si l'utilisateur n'est pas connecté
    header('Location: /');
    exit();
}

if (isset($_GET['id'])) {
    require_once('../../bdd/connexion_bdd.php');
    $nom_user = @$_SESSION["username"];

    $id_article = $_GET['id'];

    $sql = "DELETE FROM `Articles` WHERE `Id_articles` = '$id_article'";
    $resultat = $conn->query($sql);
    
    $sql1 = "DELETE FROM `Panier` WHERE `id_article` = '$id_article'";
    $resultat1 = $conn->query($sql1);
    

    header('Location: /');
    

} else {
    // L'ID de l'article n'est pas défini, affichez un message d'erreur ou redirigez l'utilisateur
    // ...
}



?>
