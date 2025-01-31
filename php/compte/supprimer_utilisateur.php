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
        $to = $_POST['mail'];
        $name = $_POST['name'];

            // Requête pour supprimer l'utilisateur
            $sql = "DELETE FROM `Utilisateur` WHERE `ID_compte` = $idUtilisateur";

            if ($conn->query($sql) === TRUE) {


                

                $subject = "Notification de suppression de compte - Facil'Access";
                $message = "Bonjour " . $name . ",\n\n" .
                           "Nous sommes au regret de vous informer que votre compte a été supprimé.\n" .
                           "Nous comprenons que cela puisse être une déception et nous sommes désolés pour la gêne occasionnée.\n\n" .
                           "Si vous avez besoin de plus d'informations ou souhaitez discuter de cette décision, n'hésitez pas à nous contacter. Nous sommes disponibles pour répondre à vos questions et préoccupations.\n\n" .
                           "Nous vous remercions pour le temps que vous avez passé avec nous et vous souhaitons le meilleur pour l'avenir.\n\n" .
                           "Cordialement,\n" .
                           "L’équipe Facil’Access";
                
                $headers = "From: ne.pas.repondre.choose.me@gmail.com\r\n";
                $headers .= "Reply-To: contact@facilaccess.com\r\n";
                $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
                
                $mail_sent = mail($to, $subject, $message, $headers);

                
                $sql3 = "DELETE FROM `message` WHERE `username` = $to";
                $conn->query($sql3);

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

