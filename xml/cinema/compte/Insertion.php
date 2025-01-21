<?php
session_start();

if(isset($_POST['envoi'])){
    $recup_username = $_POST['username'];
    $recup_password = $_POST['password'];
    $recup_cinema_name = $_POST['cinema_name'];
    $recup_cinema_adresse = $_POST['cinema_adresse'];

    if(strlen($recup_password) < 8) {
        echo "<script>alert('Le mot de passe doit contenir au moins 8 caractères. Entrez une valeur valide !');</script>";
        exit();
    }

    // Validation des champs :
    if(empty($recup_username) || empty($recup_password) || empty($recup_cinema_name) || empty($recup_cinema_adresse)){
        echo "<script>alert('Veuillez saisir toutes les informations');</script>";
        exit();
    }

    // Chiffrer le mot de passe :
    $hashed_password = password_hash($recup_password, PASSWORD_DEFAULT);

    // Connexion à la base de données :
    $host = 'terraform-20250121115406880900000010.cxymgguk68ge.eu-west-3.rds.amazonaws.com'; 
    $dbname = 'testdb';   
    $username = 'admin';  
    $password = 'SuperSecretPassword123';

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Vérification si l'utilisateur a un compte
        $stmt = $conn->prepare("SELECT * FROM `users` WHERE nom = :username");
        $stmt->bindParam(':username', $recup_username);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            // L'utilisateur n'a pas de compte : 
            $stca = $conn->prepare("SELECT id FROM `cinéma` WHERE nom_du_cinema = :cinema_name");
            $stca->bindParam(':cinema_name', $recup_cinema_name);
            $stca->execute();

            if ($stca->rowCount() > 0) {
                // Le cinéma existe, on recupére que l'id 
                $row = $stca->fetch();
                $cinema_id = $row['id'];
            } else {
                // Le cinéma n'existe pas, on insére dans cinema
                $stca = $conn->prepare("INSERT INTO `cinéma` ( `nom_du_cinema`, `adresse`) VALUES(:cinema_name, :cinema_adresse)");
                $stca->bindParam(':cinema_name', $recup_cinema_name);
                $stca->bindParam(':cinema_adresse', $recup_cinema_adresse);
                $stca->execute();

                // on recupere l'ID du cinéma :
                $cinema_id = $conn->lastInsertId();
            }

            // Insérez l'utilisateur dans la table `users` en utilisant l'ID du cinéma
            $stmt = $conn->prepare("INSERT INTO `users` ( `nom`, `mot_de_passe`, `cinema_id`) VALUES(:username, :password, :cinema_id)");
            $stmt->bindParam(':username', $recup_username);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':cinema_id', $cinema_id);
            $stmt->execute();

            // on récupere le nom du user
            $requete = $conn->prepare("SELECT * FROM `users` WHERE nom = :username");
            $requete->bindParam(':username', $recup_username);
            $requete->execute();
            $utilisateur = $requete->fetch();

            $_SESSION['connexion'] = 'ok';
            $_SESSION['username'] = $utilisateur['nom'];
            header("Location: loader.php");
            exit();
        } else {
            echo "Vous possédez déjà un compte ! Veuillez vous connecter.";
        }
    } catch(PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }

    $conn = null;
}
?>
