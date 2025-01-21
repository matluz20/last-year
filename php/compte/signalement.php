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

    $nom_user = @$_SESSION["username"];
    $statut = @$_SESSION["statut"];
    if($statut != "admin"){
        header ('Location: ../afterconexion.php');
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
    <title>Signalements</title>
</head>
<body>



<h1>Voici les signalements</h1>
<br><br><a href="admin.php" class="btn-retour">Retour</a>



<table>
    <tr>
        <th>Article</th>
        <th>Motif(s)</th>
        <th>Vendeur</th>
        <th>Dénonciateur</th>
        <th>Date de reception</th>
        <th>Action</th>
    </tr>

    <?php
    require_once('../bdd/connexion_bdd.php');

    $sql = "SELECT * FROM `Signalement` ORDER BY `id_signalement` DESC";
    $resultat = $conn->query($sql);

    if ($resultat->num_rows > 0) {
        while($row = $resultat->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row["id_article"]."</td>";
            echo "<td>".$row["raison"]."</td>";
            echo "<td>".$row["vendeur"]."</td>";
            echo "<td>".$row["signaleur"]."</td>";
            echo "<td>".$row["date"]."</td>";
            echo "<td>";
            echo "<a href='../articles/suppression/supprimer.php?id=".$row["id_article"]."'>Supprimer l'article</a>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='3'>Aucune demande trouvée.</td></tr>";
    }
    ?>
</table>


</div>


    </table>




</body>
</html>