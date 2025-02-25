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
    
    if($statut != "admin" && $statut != "coach"){
        header ('Location: /');
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
    <!-- <link rel="stylesheet" type="text/css" href="../../css/demandes.css"> -->
    <link rel="stylesheet" href="/css/style.css">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        table,
        th,
        td {
            border: 1px solid black;
            flex: 1; /* Chaque élément prend la même largeur */
            text-align: center; /* Centrer le texte */
        }

        th,
        td {
            padding: 5px;
        }

        .delete-btn {
            background-color: red;
            color: white;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
        }
        

        
    </style>
    <style>
        .user-table {
            border-collapse: collapse;
            width: 100%;
        }

        .user-table th,
        .user-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .user-table th {
            background-color: #f2f2f2;
            text-align: left;
        }

        .user-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .user-table tr:hover {
            background-color: #ddd;
        }
        .rowLine{
            border : 0;
            display: flex;
            justify-content: space-between; /* Espace uniforme */
            align-items: center; /* Centrage vertical */
            padding: 10px;
        }
        .rowLine > a{
            flex: 1; /* Chaque élément prend la même largeur */
            text-align: center; /* Centrer le texte */
            border-right: 1px solid #000;
        }
        .rowLine > a:last-child{
            border-right: none;
        }
    </style>

    <title>Demandes</title>
</head>

<body>
    <header>
        <div class="h1">
            <h1><a href="admin.php">Facil'Access</a></h1>
            <h1 class="account"><a href="/php/compte/moncompte.php"><img src="/image/person.svg" class="accountsvg"></a>
            </h1>
        </div>
        <nav class="navbar">
            <ul class="menu">
                <li><a href="/php/compte/notification.php">Notifications</a></li>
                <li><a href="demandes.php">Demandes</a></li>
                <li><a href="user.php">Liste des utilisateurs</a></li>
                <li><a href="admin_creation.php">Créer un compte</a></li> 


            </ul>
        </nav>
    </header>


    <main>

    <h1>Listes des demandes</h1>


    <table>
        <tr>
            <th>Date de creation</th>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Mail</th>
            <th>Télephone</th>
            <th>Photo</th>
            <th>Type</th>
            <th>Action</th>
        </tr>

        <?php
    require_once('../bdd/connexion_bdd.php');

    $sql = "SELECT * FROM `Utilisateur` WHERE `statut` = 'pending'";
    $resultat = $conn->query($sql);

    if ($resultat->num_rows > 0) {
        while($row = $resultat->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row["date"]."</td>";
            echo "<td>".$row["name"]."</td>";
            echo "<td>".$row["last_name"]."</td>";
            echo "<td>".$row["username"]."</td>";
            echo "<td>".$row["telephone"]."</td>";
            $imageData = base64_encode($row["image_data"]);
            $imageMimeType = $row["mime_type"];
            $imageSrc = "data:$imageMimeType;base64,$imageData";  // URL de l'image encodée

            // Affichage de l'image avec l'événement onclick pour ouvrir le modal
            echo "<td><img src='$imageSrc' alt='Photo' style='width:50px; height:50px; object-fit:cover;' onclick='openModal(\"$imageSrc\")'></td>";


            echo "<td> Création de compte </td>";
            echo "<td class='rowLine'>";
            echo '<a onclick="upgradeUtilisateur(\'' . $row["ID_compte"] . '\', \'' . $row["username"] . '\', \'' . $row["name"] . '\')">Accepter</a>';

            echo "<a href='refuser.php?username=".$row["username"]."'> Refuser</a>";
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


    <script>


            function upgradeUtilisateur(idUtilisateur, username, name) {
                // Demander une confirmation à l'utilisateur avant de modifier le rôle
                if (confirm("Êtes-vous sûr de approuver la demande de l'utilisateur ? " + name + " (" + username + ") ?")) {
                    // Créer une requête AJAX pour modifier le rôle de l'utilisateur
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "modifier_utilisateur.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === XMLHttpRequest.DONE) {
                            if (xhr.status === 200) {
                                
                                location.reload(); // Recharger la page pour mettre à jour les changements
                            } else {
                                // La modification a échoué, afficher un message d'erreur
                                location.reload(); 
                            }
                        }
                    };

                    // Envoyer les données au serveur
                    var data = "idUtilisateur=" + encodeURIComponent(idUtilisateur) + 
                            "&mail=" + encodeURIComponent(username) + 
                            "&name=" + encodeURIComponent(name);
                    console.log("Données envoyées : " + data); // Debugging dans la console
                    xhr.send(data);
                }
            }

            </script>












    
</main>

<!-- Modal -->
<script>
    // Fonction pour ouvrir le modal avec l'image
    function openModal(imageSrc) {
        var modal = document.getElementById("simpleModal");
        var modalImage = document.getElementById("modalImage");
        
        modal.style.display = "block";
        modalImage.src = imageSrc;
    }

    // Fonction pour fermer le modal
    function closeModal() {
        document.getElementById("simpleModal").style.display = "none";
    }
</script>
<!-- Modal -->
<div id="simpleModal" class="modal" style="display: none;">
    <span class="close" onclick="closeModal()">&times;</span>
    <img class="modal-content" id="modalImage">
</div>

<!-- Style du modal -->
<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        padding-top: 100px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
    }
    .modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 600px;
    }
    .close {
        position: absolute;
        top: 20px;
        right: 30px;
        color: #fff;
        font-size: 36px;
        font-weight: bold;
        cursor: pointer;
    }
</style>


</body>

</html>