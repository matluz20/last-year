<?php
	require_once('../bdd/connexion_bdd.php');

    $id_user = $_GET["id"];
    $sql1 = "DELETE FROM devenirvendeur WHERE Nom= '$id_user'";
    $conn->query($sql1);

    $sql2 = "INSERT INTO `message` (`username`,`expediteur`, `message`, `date`)
    VALUES ('$id_user', 'Administrateurs','Votre demande d\'accéder au statut de vendeur a été refusée', CURRENT_TIMESTAMP())";
    $conn->query($sql2);

    echo '<script type="text/javascript">'; 
    echo "alert(\"Vous avez refuser la demande de $id_user.\");";
    echo 'window.location.href = "demandes.php"'; // redirection vers la page de connexion 
    echo '</script>';
    
?>
