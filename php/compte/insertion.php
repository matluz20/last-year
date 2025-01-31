<?php

// Démarrage de la session
session_start();



// connexion à la base de données 

$host = '91.173.60.180'; 
$dbname = 'projet_web';   
$username = 'rs2';  
$password = 'Toto123#';
$default_statut = "pending" ;

$recup_name = $_POST['name'];
$recup_last_name = $_POST['last_name'];

$recup_email = $_POST['email'];
$recup_telephone = $_POST['telephone'];
$recup_image = $_POST['image'];
$image_tmp = $_FILES['image']['tmp_name'];
$image_data = file_get_contents($image_tmp);
$imageFileType = strtolower(pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION));

$admin_creation = $_SESSION["admin_creation"];

if ($_FILES["image"]["size"] > 3145728) {

    echo '<script type="text/javascript">'; 
    echo 'alert("Le fichier est trop volumineux (taille maximale : 500 Ko).<br>");'; 
    echo 'window.location.href = "/";'; // mettre le lien de la page de connexion
    echo '</script>';
    exit;
}

if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
    echo '<script type="text/javascript">'; 
    echo 'alert("Seuls les fichiers JPG, JPEG, PNG, WEBP et GIF sont autorisés.<br>");'; 
    echo 'window.location.href = "/";'; // mettre le lien de la page de connexion
    echo '</script>';
    exit;
}
function generateRandomPassword($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $password;
}

$recup_password = generateRandomPassword(12);
$hashed_password = password_hash($recup_password, PASSWORD_DEFAULT);


try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérification si l'utilisateur a un compte
    $stmt = $conn->prepare("SELECT * FROM `Utilisateur` WHERE username = :username");
    $stmt->bindParam(':username', $recup_email);
    $stmt->execute();

    if ($stmt->rowCount() == 0) {
        
        $stmt = $conn->prepare("INSERT INTO `Utilisateur` ( `username`, `password`, `statut`,`email`, `name`, `last_name`, `image_data`,`telephone`,`date`) VALUES(:username, :password, :statut, :email, :name, :last_name, :image_data, :telephone, CURRENT_TIMESTAMP)");
        $stmt->bindParam(':username', $recup_email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':statut', $default_statut);
        $stmt->bindParam(':email', $recup_email);
        $stmt->bindParam(':name', $recup_name);
        $stmt->bindParam(':last_name', $recup_last_name);
        $stmt->bindParam(':image_data', $image_data);
        $stmt->bindParam(':telephone', $recup_telephone);
        $stmt->execute();

        if($recup_email != ""){

            $subject = "Bienvenue sur Facil'Access !";
            $message = 'Bonjour ' . $recup_name . ",\n\n" .
           "Nous sommes ravis de vous accueillir sur notre outil ! Votre inscription a été prise en compte et nous sommes impatients " .
           "de vous accompagner dans votre utilisation de nos services.\n\n" .
           "Afin de valider la création de votre compte, nous vous demandons de bien vouloir vous rendre à la salle de sport souhaitée.\n\n" .
           "Ci-dessous vos informations de connexion :\n\n" .
           "Username: " . $recup_email . "\n" .
           "Password Temporaire: " . $recup_password . "\n\n" .
           "N'hésitez pas à nous contacter si vous avez des questions ou des problèmes lors de votre utilisation de notre service.\n\n" .
           "Encore une fois, merci de votre confiance et à bientôt !\n\n" .
           "Cordialement,\n" .
           "L'équipe Facil'Access";


            $headers = "From: ne.pas.repondre.choose.me@gmail.com\r\n";
            $headers .= "Reply-To: matondoluzolo20@gmail.com\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";


            $mail_sent = mail($recup_email, $subject, $message, $headers);

            }

            if($admin_creation == 1){
                if($default_statut == "pending"){

                    echo '<script type="text/javascript">'; 
                    echo 'alert("La création du compte est lancée. Vous allez être rédiriger dans l\'onglet demande pour finaliser la création.");';
                    echo 'window.location.href = "/php/compte/demandes.php";'; // mettre le lien de la page de connexion
                    echo '</script>';
                    exit;
            
                }
            }
            
            if($default_statut == "pending"){

                echo '<script type="text/javascript">'; 
                echo 'alert("Votre compte est en cours de validation. Un e-mail va vous être communiqué.");'; 
                echo 'window.location.href = "/";'; // mettre le lien de la page de connexion
                echo '</script>';
        
            }


    } else {
        echo '<script type="text/javascript">'; 
        echo 'alert("Un compte est déjà associé à votre adresse mail. Veuillez vous connecter.");'; 
        echo 'window.location.href = "/";'; // mettre le lien de la page de connexion
        echo '</script>';
        exit;
    }
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

$conn = null;


?>
