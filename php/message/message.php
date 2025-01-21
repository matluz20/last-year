
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

            <h3>Envoyer un message à 



            <?php 
            require_once('../bdd/connexion_bdd.php');

            $id_article = isset($_POST["id_article"]) ? $_POST["id_article"] : '';

            $sql1 = "SELECT * FROM `Articles` WHERE `Id_articles` = '$id_article'";
            $resultat1 = $conn->query($sql1);
            $row1 = $resultat1->fetch_assoc();

            $destinateur = $row1["ID_compte"];

            echo $destinateur;

            ?>

            </h3>



            <div id=""></div>

            


              <form method="post" action="envoi.php">
              <textarea id="messageInput" name="message" rows="4" placeholder="Saisissez votre message..."></textarea>
              <input type="hidden" name="id_article" value="<?php echo $destinateur; ?>">

              <button id="cancelBtn"><a href="../afterconexion.php"> Annuler</a></button>
              <button type="submit" id="sendBtn">Envoyer </button>

              </form>
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