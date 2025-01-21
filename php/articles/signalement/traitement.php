<?php
// Démarrage de la session
session_start();

// Vérification de la variable de session "connecter"
if (!isset($_SESSION["connecter"]) || $_SESSION["connecter"] != "oui") { 
    // Redirection vers la page d'accueil si l'utilisateur n'est pas connecté
    header('Location: ../index.php');
    // Arrêt de l'exécution du code
    exit();
}

require_once('../../bdd/connexion_bdd.php');

$nom_user = @$_SESSION["username"];
$article = $_POST["id_articles"];
$vendeur = $_POST["id_compte"];

if (isset($_POST["reason"])) {
    $reasons = $_POST["reason"];
    // Traitez les raisons du signalement ici
    $reasonsString = implode(", ", $reasons); // Convertir les raisons en une chaîne séparée par des virgules

    try {
        $sql = "INSERT IGNORE INTO `Signalement` (`id_article`, `signaleur`, `vendeur`, `raison`,`date`)
        VALUES ('$article', '$nom_user', '$vendeur', '$reasonsString', CURRENT_TIMESTAMP())";

        $conn->query($sql);

        echo '<script type="text/javascript">';
        echo 'alert("Votre signalement a bien été pris en compte ! Nous vous remercions.");';
        echo 'window.location.href = "../../afterconexion.php";'; // mettre le lien de la page avec tous les articles
        echo '</script>';
    } catch (PDOException $e) {
        echo "Erreur lors de l'insertion du signalement : " . $e->getMessage();
    }
}
?>
