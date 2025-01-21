<?php

// ce script en php permet l'insertion et la creation du compte acheteur ou vendeur



//verification de l'envoi des données 



if(isset($_POST['envoi'])){

// recuperation des information saisie par l'utilisateur 

if(strlen($_POST['password']) < 8) {
    echo "<script> alert('Le mot de passe doit contenir au moins 8 caractères. Entrez une valeur valide ! ');
    window.location.href = '/'
     </script>";
    exit();
}

$recup_username = $_POST['username'];
$recup_password = $_POST['password'];
$recup_statut = "acheteur" ;// status acheteur par defaut ! pour avoir le statut vendeur il faut faire une demande aux administrateurs.





//_________________________________________________________

// verification de la bonne saisie des informations 


if($recup_username != ""){


    // nous allons chiffrer le mot de passe : 


    // chiffrement du mot de passe
    $hashed_password = password_hash($recup_password, PASSWORD_DEFAULT);


    
    // connexion à la base de données 

    $host = 'terraform-20250121115406880900000010.cxymgguk68ge.eu-west-3.rds.amazonaws.com'; 
    $dbname = 'testdb';   
    $username = 'admin';  
    $password = 'SuperSecretPassword123';


    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        // définir le mode exception d'erreur PDO 
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //verfifier si l'utilisateur possède déjà un compte 


            $req1= $conn-> query("SELECT * FROM `Utilisateur` WHERE username = '$recup_username'");
            $donnes=$req1->fetch();
            $aa= $donnes['username'];

            if  ($aa == "") {

                    // insertion des données de l'utilisateur dans la base de données : 

                    $sql = "INSERT INTO `Utilisateur` ( `username`, `password`, `statut`)
                    VALUES( '$recup_username','$hashed_password', 'acheteur')";
            }else{
                echo "Vous possedez déjà un compte ! veillez vous connecter";
                //echo 'window.location.href = ".php";'; // mettre le lien de la page de connexion
            }



        // utiliser la fonction exec() car aucun résultat n'est renvoyé
        $conn->exec($sql);
            
        }catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
        }
        $conn = null;



        // l'envoi du message confirmant l'inscription du user

        
        if($recup_statut == "acheteur"){

            echo '<script type="text/javascript">'; 
            echo 'alert("Votre compte acheteur a été créé avec succès! Vous pouvez desormais vous connecter ");'; 
            echo 'window.location.href = "/";'; // mettre le lien de la page de connexion
            echo '</script>';

        }

        



}
// renvoyer un message d'erreur si les variables n'ont pas été saisies et redirection à la page d'inscription : 
else{
    echo '<script type="text/javascript">'; 
    echo 'alert("Veillez saisir toutes les informations");';
    echo 'window.location.href = "inscription.php";'; // mettre le lien de la page d'inscription
}



}



?>