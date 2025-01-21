<?php
session_start(); 
// ce script en php permet l'insertion et la creation du compte acheteur ou vendeur



//verification de l'envoi des données 



if(isset($_POST['envoi'])){


    // recuperation du username et du password

    $recup_username = $_POST['username'];
    $recup_password = $_POST['password'];

    if($recup_username != "" && $recup_password != ""){

    
    // connexion à la base de données 

    $host = 'terraform-20250121115406880900000010.cxymgguk68ge.eu-west-3.rds.amazonaws.com'; 
    $dbname = 'testdb';   
    $username = 'admin';  
    $password = 'SuperSecretPassword123';
    

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        // définir le mode exception d'erreur PDO 
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        // verification de la combinaison mdp username : 

            $req1= $conn-> query("SELECT * FROM `Utilisateur` WHERE username = '$recup_username'");
            $donnes=$req1->fetch();
            $aa= $donnes['username'];

            if  ($aa != null) {

            if(password_verify($recup_password, $donnes['password'])){


                $_SESSION["connecter"] = "oui";
                $_SESSION['username'] = $recup_username;
                $_SESSION["statut"] = $donnes['statut'];
                $_SESSION["id_compte"] = $donnes['ID_compte'];



                // rediriger en fonction du statut du compte : 

                if($donnes['statut'] == "acheteur"){



                   
                    echo '<script type="text/javascript">'; 
                    echo 'alert("Bienvenu sur Efrei marketplace ! faites des bons achats ! ");';  
                    echo 'window.location.href = "../afterconexion.php"'; // redirection vers la page de connexion (mettre le chemin)
                    echo '</script>';
                   
                }

                if($donnes['statut'] == "vendeur"){

                    echo '<script type="text/javascript">'; 
                    echo 'alert("Bienvenu sur Efrei marketplace ! faites des bonnes achats ! ");';  
                    echo 'window.location.href = "../afterconexion.php"'; // redirection vers la page de connexion (mettre le chemin)
                    echo '</script>';
                    
                }

                if($donnes['statut'] == "admin"){

                    echo '<script type="text/javascript">'; 
                    echo 'alert("Bienvenu cher admin ! ");';  
                    echo 'window.location.href = "/php/compte/admin.php"'; // redirection vers la page de connexion (admin)
                    echo '</script>';
                    
                }

                }
                
                else{
                echo "Mot de passe incorrect.";
                }
            }
            else{
                echo "Nom d'utilisateur incorrect.";
            }

        

        // utiliser la fonction exec() car aucun résultat n'est renvoyé
        $conn->exec($sql);
            
        }catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
        }
        $conn = null;





}
// renvoyer un message d'erreur si les variables n'ont pas été saisies et redirection à la page d'inscription : 
else{
    echo '<script type="text/javascript">'; 
    echo 'alert("Veillez saisir toutes les informations");';
    echo 'window.location.href = "index.php";'; // mettre le lien de la page d'inscription
}



}



?>