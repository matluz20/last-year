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
require_once '../compte/notification.php';
$nom_user = @$_SESSION["username"];






$reponse = isset($_POST["reponse"]) ? $_POST["reponse"] : '';
$message = isset($_POST["message"]) ? $_POST["message"] : '';
$per = isset($_POST["person"]) ? $_POST["person"] : '';





if ($reponse && $message) {





    $sql3 = "INSERT INTO `message` (`username`,`expediteur`, `message`, `date`)
        VALUES ('" . DES_VARIABLE . "', '$nom_user', 'reponse au message $message : $reponse', CURRENT_TIMESTAMP())";

        $conn->query($sql3);
    
        echo '<script type="text/javascript">'; 
        echo "alert(\"Votre reponse a bien été transmis à $destinateur\");";
        echo 'window.location.href = "../compte/notification.php"'; 
        echo '</script>';
  }else {
    echo "Toutes les variables requises ne sont pas présentes.";
  }






?>