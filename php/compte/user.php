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
    <title>Efrei MarketPlace - Ventes</title>
    <link rel="stylesheet" href="/css/paiement.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <style>
        table {
            border-collapse: collapse;
        }
        
        table, th, td {
            border: 1px solid black;
        }
        
        th, td {
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

                .user-table th, .user-table td {
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

            </style>
</head>
<body>
    <header>
                        <div class="h">
                            <h1><a href="/">Efrei MarketPlace</a></h1>
                            <h1 class="account"><a href="/php/compte/moncompte.php"><img src="/image/person.svg" class="accountsvg"></a></h1>
                        </div>
                        <nav class="navbar2">
                            <ul class="menu">
                            
                                <li><a href="/php/compte/admin.php">Admin</a>

                            </ul>
                        </nav>
                    <!-- <h1>Efrei MarketPlace</h1> -->
        </header>
        <main>
            <style>
                .use {
                    text-align: center;
                    padding: 20px;
                    background-color: #f2f2f2;
                    border-radius: 10px;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                    max-width: 600px;
                    margin: 0 auto;
                }
            </style>

            <div class="use">
                <h1>La liste des utilisateurs</h1>
            </div>

            <div class="container">
                <div class="row">
                    <?php
                        require_once('../bdd/connexion_bdd.php');
                        if (@$_SESSION["connecter"] != "oui") {
                            // Redirection vers la page d'accueil si l'utilisateur n'est pas connecté
                            header('Location: ../index.php');
                            // Arrêt de l'exécution du code
                            exit();
                        }
                        $nom_user = @$_SESSION["username"];
                        //echo "$nom_user";


                        // Requête pour récupérer tous les utilisateurs
                        $sql = "SELECT `ID_compte`, `username`, `statut` FROM `Utilisateur`";
                        $resultat = $conn->query($sql);

                        if ($resultat->num_rows > 0) {
                            echo "<table class='user-table'>";
                            echo "<thead>";
                            echo "<tr>";
                            echo "<th>ID_compte</th>";
                            echo "<th>Username</th>";
                            echo "<th>Statut</th>";
                            echo "<th>Action</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";

                            while ($row = $resultat->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["ID_compte"] . "</td>";
                                echo "<td>" . $row["username"] . "</td>";
                                echo "<td>" . $row["statut"] . "</td>";
                                echo "<td><button onclick='supprimerUtilisateur(" . $row["ID_compte"] . ")'>Supprimer</button></td>";
                                echo "</tr>";
                            }

                            echo "</tbody>";
                            echo "</table>";
                        } else {
                            echo "Aucun utilisateur trouvé.";
                        }

                        
                    ?>
                </div>
            </div>
            <script>
                function supprimerUtilisateur(idUtilisateur) {
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
                                 } //else {
                                //     // La suppression a échoué, afficher un message d'erreur ou effectuer d'autres actions nécessaires
                                //     alert("Erreur lors de la suppression de l'utilisateur.");
                                // }
                            }
                        };
                        xhr.send("idUtilisateur=" + idUtilisateur);
                    }
                }
            </script>


        </main>
</body>
</html>