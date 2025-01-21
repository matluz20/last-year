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

require_once ('../bdd/connexion_bdd.php');

    // Vérification que l'ID de l'article a bien été envoyé en POST
    if (isset($_POST['idUtilisateur'])) {
        $idUtilisateur = $_POST['idUtilisateur'];

                // Requête pour supprimer l'utilisateur
            $sql = "DELETE FROM `Utilisateur` WHERE `ID_compte` = $idUtilisateur";

            if ($conn->query($sql) === TRUE) {
                // La suppression a réussi
                http_response_code(200); // Réponse HTTP 200 - OK
            } else {
                // La suppression a échoué
                http_response_code(500); // Réponse HTTP 500 - Erreur interne du serveur
            }

            // Fermer la connexion à la base de données
            $conn->close();
    } else {
        // L'ID de l'utilisateur n'est pas fourni, renvoyer une erreur
        http_response_code(400); // Réponse HTTP 400 - Requête incorrecte
    }
    header('Location: /user.php');

?>

