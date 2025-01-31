<?php
	require_once('../bdd/connexion_bdd.php');

    $username = $_GET["username"];
    $sql1 = "DELETE FROM Utilisateur WHERE username= '$username'";
    $conn->query($sql1);

    echo '<script type="text/javascript">'; 
    echo "alert(\"Vous avez refuser la demande de $username.\");";
    echo 'window.location.href = "demandes.php"'; 
    echo '</script>';
    
?>
