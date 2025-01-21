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

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../css/demandes.css">
    <title>Notifications</title>
</head>
<body>



<h1>Notifications</h1>

<br><br><a href="../afterconexion.php" class="btn-retour">Retour</a>

<table>
    <tr>
        <th>Expediteur</th>
        <th>Message</th>
        <th>Date de reception</th>
        <th>Action</th>
    </tr>

    <?php

    require_once('../bdd/connexion_bdd.php');
    session_start();
    

    // Vérification de la variable de session "connecter"
    if(@$_SESSION["connecter"]!="oui"){ 
        // Redirection vers la page d'accueil si l'utilisateur n'est pas connecté
        header ('Location: ../index.php');
        // Arrêt de l'exécution du code
        exit();
    }

    $user= @$_SESSION["username"];

    $sql = "SELECT * FROM `message` WHERE `username` LIKE '%$user%' ORDER BY `date` DESC";


    $resultat = $conn->query($sql);
    

    if ($resultat->num_rows > 0) {
        while($row = $resultat->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row["expediteur"]."</td>";
            echo "<td>".$row["message"]."</td>";
            echo "<td>".$row["date"]."</td>";
            echo "<td>";
            echo "<a href='supprimer_notif.php?id=".$row["idmessage"]."'>Supprimer</a> ";
            
            echo '<form method="post" action="../message/reponse.php" ">';
            echo '<input type="hidden" name="message" value="' . $row["message"] . '">';
            echo '<input type="hidden" name="expediteur" value="' . $row["expediteur"] . '">';

            $_SESSION["des"] = $row["expediteur"];
            define('DES_VARIABLE', $_SESSION["des"]);

            echo  '<button type="submit">Repondre</button>';
            echo '</form>';
            
            
            echo "</td>";
           
            echo "</tr>";
            
        }
    } else {
        echo "<tr><td colspan='3'>Aucune notifications trouvée.</td></tr>";
    }

    
    ?>
</table>


</div>


    </table>




</body>
</html>


     