<?php
session_start();

if (isset($_POST['envoi'])) {
    $recup_username = $_POST['username'];
    $recup_password = $_POST['password'];

    if (!empty($recup_username) && !empty($recup_password)) {
        // Connexion à la base de données :
        $host = 'terraform-20250121115406880900000010.cxymgguk68ge.eu-west-3.rds.amazonaws.com'; 
        $dbname = 'testdb';   
        $username = 'admin';  
        $password = 'SuperSecretPassword123';

        try {
            $connexion = new PDO("mysql:host=$hote;dbname=$nom_base_de_donnees", $nom_utilisateur, $mot_de_passe);
            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $requete = $connexion->prepare("SELECT * FROM `users` WHERE nom = :username");
            $requete->bindParam(':username', $recup_username);
            $requete->execute();
            $utilisateur = $requete->fetch();

            if ($utilisateur != "Array"){
            if (password_verify($recup_password, $utilisateur['mot_de_passe'])){
                $_SESSION['connexion'] = 'ok';
                $_SESSION['username'] = $utilisateur['nom'];
                header("Location: loader.php");
                exit();
            } else {
                echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>';
                echo '<script>
                        document.addEventListener("DOMContentLoaded", function() {
                            Swal.fire({
                                icon: "error",
                                title: "Erreur",
                                text: "Le mot de passe est incorrect. Veillez reessayer !",
                            }).then(function() {
                                // Redirection vers une autre page (par exemple, index.php)
                                window.location.href = "../index.php";
                            });
                        });
                      </script>';
            } 
            } else {    
                $message_erreur = "Mot de passe ou nom d'utilisateur inconnu.";
            }
        } catch (PDOException $e) {
            echo "Erreur de base de données : " . $e->getMessage();
        }
    } 
    else {
        $message_erreur = "Veuillez remplir tous les champs.";
    }
}
?>
