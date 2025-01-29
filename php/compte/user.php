<?php 
// Démarrage de la session
session_start();

// Vérification de la variable de session "connecter"
if (@$_SESSION["connecter"] != "oui") {
    // Redirection vers la page d'accueil si l'utilisateur n'est pas connecté
    header('Location: ../index.php');
    // Arrêt de l'exécution du code
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <title>Efrei Marketplace  - Ventes</title>
    <link rel="stylesheet" href="/css/paiement.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
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
</head>
<body>
    <header>
                        <div class="h">
                            <h1><a href="/">Facil'Access </a></h1>
                            <h1 class="account"><a href="/php/compte/moncompte.php"><img src="/image/person.svg" class="accountsvg"></a></h1>
                        </div>
                        <nav class="navbar2">
                            <ul class="menu">
            <li><a href="/php/compte/notification.php">Notifications</a></li>
          <li><a href="demandes.php">Demandes</a></li>
          <li><a href="admin_creation.php">Créer un compte</a></li> 


                            </ul>
                        </nav>
                    
        </header>
        <main>

        <h1>La liste des utilisateurs</h1>

        <table>
            <tr>
                <th>ID_compte</th>
                <th>Username</th>
                <th>Statut</th>
                <th>Photo</th>
                <th>Action</th>
            </tr>

                    <?php
                        require_once('../bdd/connexion_bdd.php');
                        if (@$_SESSION["connecter"] != "oui") {
                            // Redirection vers la page d'accueil si l'utilisateur n'est pas connecté
                            header('Location: ../index.php');
                            // Arrêt de l'exécution du code
                            exit();
                        }
                        $nom_user = @$_SESSION["username"];
                        $sql = "SELECT `ID_compte`, `username`, `statut`, `image_data` FROM `Utilisateur`";
                        $resultat = $conn->query($sql);

                        if ($resultat->num_rows > 0) {
                            

                            while ($row = $resultat->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["ID_compte"] . "</td>";
                                echo "<td>" . $row["username"] . "</td>";
                                echo "<td>" . $row["statut"] . "</td>";

                                if (isset($row["image_data"]) && !empty($row["image_data"])) {
                                    // Vérification et conversion de l'image en base64
                                    $imageData = base64_encode($row["image_data"]);
                                    $imageMimeType = $row["mime_type"];
                                    $imageSrc = "data:$imageMimeType;base64,$imageData";  // URL de l'image encodée
                        
                                    // Affichage de l'image avec l'événement onclick pour ouvrir le modal
                                    echo "<td><img src='$imageSrc' alt='Photo' style='width:50px; height:50px; object-fit:cover;' onclick='openModal(\"$imageSrc\")'></td>";
                                } else {
                                    // Si aucune image n'est présente
                                    echo "<td>Pas d'image</td>";
                                }
                                echo "<td class='rowLine'>";
                                echo "<a onclick='supprimerUtilisateur(" . $row["ID_compte"] . ", \"" . $row["username"] . "\", \"" . $row["name"] . "\")'>Supprimer</a>";
                                echo "<a onclick='upgradeUtilisateur(" . $row["ID_compte"] . ", \"" . "coach" . "\", \"" . "coach" . "\")'>Passer coach</a>";

                                
                                echo "</td>";
                                echo "</tr>";
                            }

                          
                        } else {
                            echo "Aucun utilisateur trouvé.";
                        }

                        
                    ?>
                    </table>




                    
                </div>
                </table>

            </div>









            <script>
                function supprimerUtilisateur(idUtilisateur, username, name) {
                    // Demander une confirmation à l'utilisateur avant de supprimer
                    if (confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur ?")) {
                        // Envoyer une requête AJAX pour supprimer l'utilisateur
                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", "supprimer_utilisateur.php", true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === XMLHttpRequest.DONE) {
                                if (xhr.status === 200) {
                                    // La suppression a réussi, actualiser la page ou effectuer d'autres actions nécessaires
                                    location.reload(); // Exemple : Recharger la page
                                 } 
                                 else {
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



                
                function upgradeUtilisateur(idUtilisateur, idRole) {
                    // Demander une confirmation à l'utilisateur avant de supprimer
                    if (confirm("Êtes-vous sûr de vouloir modifier le rôle de cet utilisateur ?")) {
                        // Envoyer une requête AJAX pour supprimer l'utilisateur
                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", "modifier_utilisateur.php", true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === XMLHttpRequest.DONE) {
                                if (xhr.status === 200) {
                                    // La suppression a réussi, actualiser la page ou effectuer d'autres actions nécessaires
                                    location.reload(); // Exemple : Recharger la page
                                 } //
                                 else {
                                    location.reload();
                                //     // La suppression a échoué, afficher un message d'erreur ou effectuer d'autres actions nécessaires
                                //     alert("Erreur lors de la suppression de l'utilisateur.");
                                }
                            }
                        };
                        console.log(idUtilisateur);
                        xhr.send("idUtilisateur=" + encodeURIComponent(idUtilisateur) + "&idRole=" + encodeURIComponent(idRole));
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