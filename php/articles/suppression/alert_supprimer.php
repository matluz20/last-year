
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>


        <div id="chatModal" class="modal">
        <div class="modal-content">

            <h3>Voulez vous vraiment supprimer l'article ?</h3>



            <div id=""></div>

            

              <?php



                    // Démarrage de la session
                    session_start();
                      
                    // Vérification de la variable de session "connecter"
                    if(@$_SESSION["connecter"]!="oui"){ 
                        // Redirection vers la page d'accueil si l'utilisateur n'est pas connecté
                        header ('Location: ../index.php');
                        // Arrêt de l'exécution du code
                        exit();
                    }

                   
                    if (isset($_GET['id'])) {
                      $id_article = $_GET['id'];

                      // Utilisez l'ID de l'article comme vous le souhaitez dans votre logique de suppression
                      // ...
                    } else {
                      // L'ID de l'article n'est pas défini, affichez un message d'erreur ou redirigez l'utilisateur
                      // ...
                    }
                    echo '<button id="cancelBtn"><a href="supprimer.php?id=' . $id_article . '">Oui</a></button>';


              ?>



              <button id="cancelBtn"><a href="../../compte/moncompte.php">Non </button>

             
        </div>
        </div>

</body>
</html>






<style>

a {

  text-decoration: none;
  color: black;
}

.modal {
  display: none;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
  background-color: #fefefe;
  margin: 15% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}


#chatMessages {
  height: 0px;
  overflow-y: scroll;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  padding: 10px;
}

#messageInput {
  width: 100%;
  height: 200px;
  padding: 5px;
  margin-bottom: 10px;
}

#sendBtn,
#cancelBtn {
  padding: 5px 10px;
  margin-right: 10px;
}

</style>


<script>


    // Afficher la fenêtre modale au chargement de la page
    window.addEventListener('load', function() {
      document.getElementById('chatModal').style.display = 'block';
    });

    
</script>