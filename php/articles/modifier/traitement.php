<?php

// Démarrage de la session
session_start();

    $host = '91.173.60.180'; 
    $dbname = 'projet_web';   
    $username = 'rs2';  
    $password = 'Toto123#';
   
// Vérification de la variable de session "connecter"
if (!isset($_SESSION["connecter"]) || $_SESSION["connecter"] != "oui") { 
    // Redirection vers la page d'accueil si l'utilisateur n'est pas connecté
    header('Location: ../index.php');
    // Arrêt de l'exécution du code
    exit();
}

require_once('../../bdd/connexion_bdd.php');

$nom_user = @$_SESSION["username"];
$nom_article = isset($_POST["nom_article"]) ? $_POST["nom_article"] : '';
$titre = isset($_POST["titre"]) ? $_POST["titre"] : '';
$choix = isset($_POST["choix"]) ? $_POST["choix"] : '';

$chemins_images = glob("../../articles/depot/images/{$nom_user}_{$nom_article}.*");

if ($choix == "oui") {
    if (isset($_FILES['image'])) {
        // Supprimer l'ancienne photo
        foreach ($chemins_images as $chemin_image) {
            if (file_exists($chemin_image)) {
                unlink($chemin_image);
            }
        }

        // Enregistrer la nouvelle photo
        $target_dir = "../../articles/depot/images/";
        $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));

        // Nouveau nom de fichier avec le titre et le nom d'utilisateur
        $new_filename = $nom_user . "_" . $titre . "." . $imageFileType;
        $target_file = $target_dir . basename($new_filename);
        $uploadOk = 1;
        
        // Vérification du type de fichier
        if (!in_array($imageFileType, array("jpg", "jpeg", "png", "webp", "gif"))) {
            echo "Seuls les fichiers JPG, JPEG, PNG, WEBP et GIF sont autorisés.";
            $uploadOk = 0;
        }
        
        // Vérification si le fichier existe déjà
        if (file_exists($target_file)) {
            echo "Le fichier existe déjà.";
            $uploadOk = 0;
        }
        
        // Vérification de la taille du fichier
        if ($_FILES["image"]["size"] > 500000) {
            echo "Le fichier est trop volumineux.";
            $uploadOk = 0;
        }
        
        // Vérification si $uploadOk est à 0 à cause d'une erreur
        if ($uploadOk == 0) {
            echo "Le fichier n'a pas été uploadé.";
        } else {
            // Si tout est ok, essayer d'uploader le fichier avec le nouveau nom de fichier
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);            
                $description = $_POST['description']; 
                $prix = $_POST['prix']; 
                $categorie = $_POST['categorie']; 
                $date = date("d-m-Y");
                $sql = "UPDATE `Articles` SET `nom_article` = '$titre', `Description` = '$description', `Prix` = '$prix', `Catégorie` = '$categorie', `Date` = '$date', `envente` = 'oui' WHERE `ID_compte` = '$nom_user'";
                $conn->exec($sql);
                
                echo '<script type="text/javascript">'; 
                echo 'alert("Votre article a été mis à jour avec succès! Vous pouvez désormais le voir en cliquant ci-dessous.");'; 
                echo 'window.location.href = "../../afterconexion.php";'; // mettre le lien de la page avec tous les articles
                echo '</script>';
            } else {
                echo "Une erreur est survenue lors de l'upload du fichier.";
            }
        }
    } else {
        echo "Veuillez ajouter une photo.";
    }
} elseif ($choix == "non") {



                if (!empty($chemins_images)) {
                    $ancien_chemin = $chemins_images[0]; // Prend le premier chemin d'image
                    $extension = pathinfo($ancien_chemin, PATHINFO_EXTENSION); // Récupère l'extension de fichier
                
                    $nouveau_nom = "{$nom_user}_{$titre}.{$extension}";
                
                    // Renomme le fichier
                    if (rename($ancien_chemin, "../../articles/depot/images/{$nouveau_nom}")) {
                        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);            
                        $description = $_POST['description']; 
                        $prix = $_POST['prix']; 
                        $categorie = $_POST['categorie']; 
                        $date = date("d-m-Y");
                        $sql = "UPDATE `Articles` SET `nom_article` = '$titre', `Description` = '$description', `Prix` = '$prix', `Catégorie` = '$categorie', `Date` = '$date', `envente` = 'oui' WHERE `ID_compte` = '$nom_user'";
                        $conn->exec($sql);
                        
                        echo '<script type="text/javascript">'; 
                        echo 'alert("Votre article a été mis à jour avec succès! Vous pouvez désormais le voir en cliquant ci-dessous.");'; 
                        echo 'window.location.href = "../../afterconexion.php";'; // mettre le lien de la page avec tous les articles
                        echo '</script>';
                    } else {
                        echo "Impossible de renommer l'image.";
                    }
                } else {
                    echo "Aucune image trouvée pour le nom d'utilisateur et l'article fournis.";
                }


                
    
}

?>
