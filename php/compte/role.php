<?php
	require_once('../bdd/connexion_bdd.php');

    $id_user = $_GET["id"];
    $role = "vendeur";
    
    $sql = "UPDATE Utilisateur SET statut='$role' WHERE username='$id_user'";
    
    if ($conn->query($sql) === TRUE) {
        $sql1 = "DELETE FROM devenirvendeur WHERE Nom= '$id_user'";
        $conn->query($sql1);
    
        $sql2 = "INSERT INTO `message` (`username`,`expediteur`, `message`, `date`)
        VALUES ('$id_user', 'Administrateurs','Votre demande d\'accéder au statut de vendeur a été validée', CURRENT_TIMESTAMP())";
        $conn->query($sql2);
    
        echo '<script type="text/javascript">'; 
        echo "alert(\"$id_user est désormais un vendeur.\");";
        echo 'window.location.href = "demandes.php"'; // redirection vers la page de connexion 
        echo '</script>';
    } else {
        echo "Une erreur s'est produite lors de la modification du statut de l'utilisateur : " . $conn->error;
    }
    
?>
