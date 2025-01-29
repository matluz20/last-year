<?php


// Démarrage de la session
session_start();
    
    $host = '91.173.60.180'; 
    $dbname = 'projet_web';   
    $username = 'rs2';  
    $password = 'Toto123#';
    // Vérification de la variable de session "connecter"
    if(@$_SESSION["connecter"]!="oui"){ 
        // Redirection vers la page d'accueil si l'utilisateur n'est pas connecté
        header ('Location: ../index.php');
        // Arrêt de l'exécution du code
        exit();
    }

    // if(isset($_POST['date_fin'])){

    if(isset($_FILES['image'])){
        $titre = $_POST['titre']; 
        
        $nom_user = @$_SESSION["username"];
        $id_compte = @$_SESSION["id_compte"];
    
        $target_dir = "images/";
        $imageFileType = strtolower(pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION));
    
        // Nouveau nom de fichier avec le titre et le nom d'utilisateur
        $new_filename = $nom_user . "_" . $titre . "." . $imageFileType;
    
        $target_file = $target_dir . basename($new_filename);
    
        $uploadOk = 1;
        
        // Vérification du type de fichier
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "webp" && $imageFileType != "gif" ) {
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

                //          
                $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);    
                $description = $_POST['description']; 
                $prix = $_POST['prix']; 
                $categorie = $_POST['categorie']; 
                $date = date("d-m-Y");


                // effectuer ces actions si le type de vente choisi est l'enchere
                if(isset($_POST['date_fin'])){

                    $titre_article = $_POST['titre']; 
                    $description2 = $_POST['description'];
                    $prix_départ =  $_POST['prix']; 
                    $date_expriration = $_POST['date_fin'];
                    $categorie2 = $_POST['categorie']; 
                    $dateDuJour = date('Y-m-d');

                   

                    // insertion dans la table enchère


                    $sql = "INSERT INTO `enchere` ( `id_vendeur`, `nom_article`, `description`, `prix_depart`,`date_debut` , `date_fin`,`categorie`,`nom_vendeur`)
                    VALUES( '$id_compte','$titre_article','$description2', '$prix_départ', '$dateDuJour','$date_expriration','$categorie2','$nom_user')";
                    $conn->query($sql);

                
                }
                
                else{
                
                $sql = "INSERT INTO `Articles` ( `nom_article`, `Description`, `Prix`, `Catégorie`, `Date`, `ID_compte`,`envente`)
                    VALUES( '$titre','$description','$prix','$categorie', '$date', '$nom_user','oui')";
                $conn->exec($sql);}
            } else {
                echo "Une erreur est survenue lors de l'upload du fichier.";
            }
            echo '<script type="text/javascript">'; 
            echo 'alert("Votre article a été créé avec succès! Vous pouvez desormais le voir en cliquant ci-dessous ");'; 
            echo 'window.location.href = "../../afterconexion.php";'; // mettre le lien de la page avec tous les articles
            echo '</script>';
        }
    }
    
