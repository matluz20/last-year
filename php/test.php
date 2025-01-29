<?php



// connexion à la base de données 

$host = '91.173.60.180'; 
$dbname = 'projet_web';   
$username = 'rs2';  
$password = 'Toto123#';
$default_statut = "pending" ;

$recup_name = $_POST['name'];
$recup_last_name = $_POST['last_name'];
$recup_password = "toto123";
$recup_email = $_POST['email'];
$recup_image = $_POST['image'];
$image_tmp = $_FILES['image']['tmp_name'];
$image_data = file_get_contents($image_tmp);
$imageFileType = strtolower(pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION));
$hashed_password = password_hash($recup_password, PASSWORD_DEFAULT);

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


try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérification si l'utilisateur a un compte
    $stmt = $conn->prepare("SELECT * FROM `Utilisateur` WHERE username = :username");
    $stmt->bindParam(':username', $recup_username);
    $stmt->execute();

    if ($stmt->rowCount() == 0) {
        
        $stmt = $conn->prepare("INSERT INTO `Utilisateur` ( `username`, `password`, `statut`,`email`, `name`, `last_name`, `image_data`) VALUES(:username, :password, :statut, :email, :name, :last_name, :image_data )");
        $stmt->bindParam(':username', $recup_email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':statut', $default_statut);
        $stmt->bindParam(':email', $recup_email);
        $stmt->bindParam(':name', $recup_name);
        $stmt->bindParam(':last_name', $recup_last_name);
        $stmt->bindParam(':image_data', $image_data);
        $stmt->execute();


        if($recup_email != ""){

            $subject = "Bienvenue sur Facil'Access !";
            $message = 'Bonjour ' . $recup_name . ",


            Nous sommes ravis de vous accueillir sur notre outil ! Votre inscription a été prise en compte et nous sommes impatients 
            de vous accompagner dans votre utilisation de nos services.
            
            Afin de valider la création de votre compte, nous vous demandons de bien vouloir vous rendre à la salle de sport voulu.

            Nhésitez pas à nous contacter si vous avez des questions ou des problèmes lors de votre utilisation de notre service.

            Encore une fois, merci de votre confiance et à bientôt !

            Cordialement,
            L'équipe Facil'Access ";


            $headers = "From: ne.pas.repondre.choose.me@gmail.com\r\n";
            $headers .= "Reply-To: matondoluzolo20@gmail.com\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";


            $mail_sent = mail($recup_email, $subject, $message, $headers);

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






<table>
        <tr>
                <th>ID_compte</th>
                <th>Username</th>
                <th>Statut</th>
                <th>Photo</th>
                <th>Action</th>
        </tr>

        <?php
    require_once('../bdd/connexion_bdd.php');

    $sql = "SELECT * FROM `Utilisateur` WHERE `statut` = 'pending'";
    $resultat = $conn->query($sql);

    if ($resultat->num_rows > 0) {
        while($row = $resultat->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["ID_compte"] . "</td>";
            echo "<td>" . $row["username"] . "</td>";
            echo "<td>" . $row["statut"] . "</td>";
            $imageData = base64_encode($row["image_data"]);
            $imageMimeType = $row["mime_type"];
            $imageSrc = "data:$imageMimeType;base64,$imageData";  // URL de l'image encodée

            // Affichage de l'image avec l'événement onclick pour ouvrir le modal
            echo "<td><img src='$imageSrc' alt='Photo' style='width:50px; height:50px; object-fit:cover;' onclick='openModal(\"$imageSrc\")'></td>";


            echo "<td>".$row["type"]."</td>";
            echo "<td class='rowLine'>";
            echo '<a onclick="upgradeUtilisateur(\'' . $row["ID_compte"] . '\', \'' . $row["username"] . '\', \'' . $row["name"] . '\')">Accepter</a>';


            echo "<a href='refuser.php?id=".$row["Nom"]."'> Refuser</a>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='3'>Aucune demande trouvée.</td></tr>";
    }
    ?>
    </table>


    </div>


    </table>