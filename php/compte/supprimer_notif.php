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

    $id_user = $_GET["id"];

    
    
        $sql1 = "DELETE FROM message WHERE idmessage= '$id_user'";
        $conn->query($sql1);
    
    
        echo '<script type="text/javascript">'; 
        echo "alert(\"Le message a été supprimé\");";
        echo 'window.location.href = "notification.php"';  
        echo '</script>';
    
    
?>
