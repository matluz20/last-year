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
    if (isset($_POST['password'])) {
        $mdp = $_POST['password'];
        $c_mdp = $_POST['confirm_password'];
        if ($mdp == $c_mdp) {
            $hashed_password = password_hash($mdp, PASSWORD_DEFAULT);
            $nom = $_SESSION["username"];
            $sql = "UPDATE `Utilisateur` SET password = '$hashed_password' WHERE username = '$nom'";
            $resultat = $conn->query($sql);
            echo '<script type="text/javascript">'; 
            echo 'alert("Modification effectuée.");'; 
            echo 'window.location.href = "moncompte.php";'; // mettre le lien de la page de connexion
            echo '</script>';

        } else {
            echo '<script type="text/javascript">'; 
            echo 'alert("les 2 mots de passes ne correspondent pas.");'; 
            echo 'window.location.href = "moncompte.php";'; // mettre le lien de la page de connexion
            echo '</script>';
        }
    } else {
        // L'ID de l'utilisateur n'est pas fourni, renvoyer une erreur
        http_response_code(400); // Réponse HTTP 400 - Requête incorrecte
    }

?>

