<?php

// Démarrage de la session
session_start();

if (@$_SESSION["connecter"] != "oui") {
    // Redirection vers la page d'accueil si l'utilisateur n'est pas connecté
    header('Location: /');
    // Arrêt de l'exécution du code
    exit();
}

require_once('../../bdd/connexion_bdd.php');
$id_compte = @$_SESSION["id_compte"];

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les valeurs des champs du formulaire
    $enchereId = isset($_POST['id_enchere2']) ? $_POST['id_enchere2'] : '';
    $vendeur = isset($_POST['nom_vendeur']) ? $_POST['nom_vendeur'] : '';
    $prix = isset($_POST['prix']) ? $_POST['prix'] : '';
    $nom_user = @$_SESSION["username"];

    // traitement surenchere

    if (isset($_POST['prix_surenchere'])) {
        $prix_surenchere = isset($_POST['prix_surenchere']) ? $_POST['prix_surenchere'] : '';
        $id_enchere = isset($_POST['id_enchere']) ? $_POST['id_enchere'] : '';

        $sql = "UPDATE `participations` SET prix_propose = '$prix_surenchere' WHERE id_enchere = '$id_enchere' AND id_acheteur = '$id_compte'";
        $result = $conn->query($sql);

        // Instructions lorsque la surenchère est validée
        echo '<script type="text/javascript">'; 
        echo 'alert("Votre nouveau montant a été enregistré avec succès!");'; 
        echo 'window.location.href = "../../encheres.php";'; // mettre le lien de la page avec tous les articles
        echo '</script>';

    } 
    
    // traitement participation
    
    
    elseif (isset($_POST['nom_vendeur'])) {
        // Inscrire l'utilisateur dans la table participations pour signifier sa participation
        $sql = "INSERT INTO `participations` (`id_enchere`, `id_acheteur`, `prix_propose`)
        VALUES ('$enchereId', '$id_compte', '$prix')";
        $result = $conn->query($sql);

        // Instructions lorsque la participation est validée
        echo '<script type="text/javascript">'; 
        echo 'alert("Votre participation a été enregistrée avec succès!");'; 
        echo 'window.location.href = "../../encheres.php";'; // mettre le lien de la page avec tous les articles
        echo '</script>';
    }
}
?>
