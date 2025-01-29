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
            if (isset($_POST['idRole'])){
                $role = $_POST['idRole'];
            }else{
                $role = "membre";
            }
            $sql = "UPDATE Utilisateur SET statut='$role' WHERE ID_compte='$idUtilisateur'";

            if ($conn->query($sql) === TRUE) {


                $subject = "Bienvenue sur Facil'Access !";
                $message = "Bonjour " . $name . ",\n\n" .
                           "Nous sommes ravis de vous informer que votre inscription a été approuvée.\n" .
                           "Vous pouvez désormais accéder à la salle de sport sans vous soucier de votre carte ou de votre QR code.\n" .
                           "Venez comme vous êtes !\n\n" .
                           "N’hésitez pas à nous contacter si vous avez des questions ou rencontrez des problèmes lors de l’utilisation de notre service.\n\n" .
                           "Encore une fois, merci pour votre confiance, et à bientôt !\n\n" .
                           "Cordialement,\n" .
                           "L’équipe Facil’Access";
                
                $headers = "From: ne.pas.repondre.choose.me@gmail.com\r\n";
                $headers .= "Reply-To: matondoluzolo20@gmail.com\r\n";
                $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
                $mail_sent = mail($to, $subject, $message, $headers);



                $sql3 = "INSERT INTO `message` (`username`,`expediteur`, `message`, `date`)
                VALUES ('$to', 'Administrateurs' ,'$message' , CURRENT_TIMESTAMP())";

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
    header('Location: /');

?>

