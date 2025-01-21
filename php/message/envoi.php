<?php
// Démarrage de la session
session_start();
   
    // Vérification de la variable de session "connecter"
    if(@$_SESSION["connecter"]!="oui"){ 
        // Redirection vers la page d'accueil si l'utilisateur n'est pas connecté
        header ('Location: ../../index.php');
        // Arrêt de l'exécution du code
        exit();
    }
    
require_once('../bdd/connexion_bdd.php');
$nom_user = @$_SESSION["username"];


$destinateur = isset($_POST["id_article"]) ? $_POST["id_article"] : '';
$message = isset($_POST["message"]) ? $_POST["message"] : '';

$sql2 = "INSERT INTO `message` (`username`,`expediteur`, `message`, `date`)
        VALUES ('$destinateur', '$nom_user ','$message', CURRENT_TIMESTAMP())";
        $conn->query($sql2);
    
        echo '<script type="text/javascript">'; 
        echo "alert(\"Votre message a bien été transmis à $destinateur.\");";
        echo 'window.location.href = "../afterconexion.php"'; 
        echo '</script>';


?>