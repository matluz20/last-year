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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifiez si l'ID de l'article a été envoyé en tant que champ masqué
    if (isset($_POST['id_transaction'])) {
        $id_article = $_POST['id_transaction'];
        // echo "$id_article";

        // // Effectuez les opérations de suppression de l'article dans votre base de données
        // // Assurez-vous de prendre les mesures de sécurité appropriées, comme la validation et la désinfection des données
        // // Vous devez écrire le code spécifique pour supprimer l'article de votre table Panier

        // // Exemple de requête SQL pour supprimer l'article
        $sql = "DELETE FROM `Panier` WHERE `id_transaction` = '$id_article'";
        $result = $conn->query($sql);

        $sql_h = "DELETE FROM `Commandes` WHERE `id_transaction` = '$id_article'";
        $result_h = $conn->query($sql_h);
    }
}
header('Location: ../../paiement.php');

?>
