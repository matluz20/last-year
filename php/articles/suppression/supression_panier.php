<?php
    // Démarrage de la session
    session_start();

    if (@$_SESSION["connecter"] != "oui") {
        // Redirection vers la page d'accueil si l'utilisateur n'est pas connecté
        header('Location: ../index.php');
        // Arrêt de l'exécution du code
        exit();
    }

    require_once('../../bdd/connexion_bdd.php');

    $nom_user = @$_SESSION["username"];

    // Effectuer une requête pour obtenir la somme des prix dans la table "Panier" pour l'utilisateur actuel
    $sql_sum = "SELECT SUM(prix_article) AS somme_prix FROM `Panier` WHERE username = '$nom_user'";
    $result_sum = $conn->query($sql_sum);
    $row_sum = $result_sum->fetch_assoc();
    $somme_prix = 0;
    $somme_prix = $somme_prix + $row_sum['somme_prix'];
    //echo "$somme_prix";

    if ($somme_prix !== 0) {
            
        

        // Supprimer les éléments du panier de l'utilisateur actuel
        $sql_delete = "DELETE FROM `Panier` WHERE `username` = '$nom_user'";
        $result_delete = $conn->query($sql_delete);

        echo '<script type="text/javascript">';
        echo 'alert("Votre Achat a été effectué avec succès !");';
        echo 'window.location.href = "../../afterconexion.php";';
        echo '</script>';
    } else {
        echo '<script type="text/javascript">';
        echo 'alert("Votre Panier est vide !");';
        echo 'window.location.href = "../../afterconexion.php";';
        echo '</script>';
        //exit(); // Arrêt de l'exécution du code
    }
?>
