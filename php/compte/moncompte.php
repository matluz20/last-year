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
    

?>





<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Facil'Access</title>
    <link rel="stylesheet" href="../../css/style.css">


  </head>
  <body>
    <header>
      <div class="h1">
                <h1><a href="/">Facil'Access </a></h1>
                <h1 class="account"><a href="/php/compte/moncompte.php"><img src="/image/person.svg" class="accountsvg"></a></h1>
      </div>
      <nav class="navbar">
        <ul class="menu">
          <li><a href="/php/compte/notification.php">Notifications</a></li>
          <?php
            if($_SESSION["statut"]=="coach"){ 
              echo '<li><a href="user.php">Liste des utilisateurs</a></li>';
            }
          ?>
          
          
        </ul>
      </nav>
    </header>

    <div class="flexcard">

      <div class="UserCard">
          <?php
              require_once('../bdd/connexion_bdd.php');
              $nom = $_SESSION["username"];
              $sql = "SELECT * FROM `Utilisateur` WHERE username = '$nom'";
              $resultat = $conn->query($sql);
              $row = $resultat->fetch_assoc();
              $imageData = base64_encode($row["image_data"]);
              $imageMimeType = $row["mime_type"];
              $imageSrc = "data:$imageMimeType;base64,$imageData";  // URL de l'image encodée
              echo "<div><img class='photoCard' src='$imageSrc' alt='Photo' style='width:50px; object-fit:cover;' onclick='openModal(\"$imageSrc\")'></div>";

                  echo "<div><div class='username'> Username : ".$row["username"]."</div>";
                  echo "<div class='statusUser'> Statut : ".$row["statut"]."</div></div>";
                  $_SESSION["statut"] = $row["statut"];
          ?>
      </div>
      
    </div>
      <div class="flexcard">

      <div class="UserCard">
          <form action="modif_password.php" method="POST" enctype="multipart/form-data">
              Changement de mot de passe<br><br>
              <input type="password" name="password" placeholder="Mot de passe" required minlength="8"/>
              <br>
              <input type="password" name="confirm_password" placeholder="Confirmation" required minlength="8"/>
              <br>
              <button name="envoi" class="change">Modifier</button>
          </form>
      </div>
      </div>
    

    <style>
    .change {
      padding:2px;
      border-radius: 20px;
      background-color: #F2F2F2;
      color: black;
    }
    .change:hover {
      color: var(--header-text);
    }
  </style>

<button class="btnDeco"><a href="deconnexion.php">Deconnexion</a></button>

<!-- Style pour la page mon compte -->

  <style> 

.container{
  width: 90em;
  
}




.mod{
  color : blue;
}

  .sup{
    color : red;
    text-decoration: none;

  }


  .but {

  border-radius: 20px;
  border: 1px solid #004FFF;
  color: white;
  padding: 10px 20px;
  font-size: 16px;
  border-radius: 20px; /* Ajout de la propriété border-radius avec une valeur de 20px */
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.but:hover {
  transition: 0.6s ease;
  border: 1px solid #360ed4;
  background-color: #004FFF;
  color: #fff;
}

  



  .filtre {
  position: absolute;
  top: 15%;
  right: 0;
  margin: 20px; 

  }

  label {
    margin-right: 10px;
  }

  select {
    padding: 5px;
  }

  button {
    padding: 5px 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    cursor: pointer;
  }




  /* Styles pour la fenêtre modale */
  #modal-btn{
        border-radius: 20px;
        border: 1px solid #360ed4;
        background-color: #5311ed;
        color: #FFFFFF;
        font-size: 12px;
        font-weight: bold;
        padding: 12px 45px;
        margin-top: 30px;
        letter-spacing: 1px;
        text-transform: uppercase;
        transition: transform 80ms ease-in;
}


/* style pour le formulaire d'ajout*/

  
  form label,
  form input,
  form textarea,
  form select {
    margin-bottom: 10px;
  }
  
  form input[type="submit"] {
    position: relative;
    left: 50%;
    margin-top: 60px;
    transform: translate(-50%, -50%);
    width:120px;
    height: 60px;
    background: #1044c7;
	background: -webkit-linear-gradient(to right, #290ab4, #0b7bcb);
	background: linear-gradient(to right, #290ab4, #0b7bcb);
	background-position: 0 0;
	color: #FFFFFF;
    border-radius: 10%;
   
  }


  .modal {
    display: none;
    position: fixed;
    z-index: 999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
  }
  
  .modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 70%;
  }
  
  .blur-effect {
    filter: blur(4px);
  }
  
  .modal-content .close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
  }
  
  .modal-content .close:hover,
  .modal-content .close:focus {
    color: #000;
    text-decoration: none;
  }
  
  #modal-btn {
    margin-top: 20px;
  }
  
  #modal-btn:focus {
    outline: none;
  }

</style>
    
  <script src="/js/script.js"></script>
    </body>
</html>
