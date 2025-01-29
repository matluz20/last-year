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

    $nom_user = @$_SESSION["username"];
    $statut = @$_SESSION["statut"];
    if($statut != "admin" && $statut != "coach"){
      header ('Location: /');
       //Arrêt de l'exécution du code
      exit();
    }

?>



<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Facil'Access</title>
    <link rel="stylesheet" href="/css/style.css">
  </head>
  <body>
    <header>
    <div class="h1">
        <h1><a href="admin.php">Facil'Access</a></h1>
        <h1 class="account"><a href="/php/compte/moncompte.php"><img src="/image/person.svg" class="accountsvg"></a></h1>
      </div>
      <nav class="navbar">
        <ul class="menu">
          <li><a href="/php/compte/notification.php">Notifications</a></li>
          <li><a href="demandes.php">Demandes</a></li>
          <li><a href="user.php">Liste des utilisateurs</a></li> 
          <li><a href="admin_creation.php">Créer un compte</a></li> 


        </ul>
      </nav>
    </header>


    <main>
      <div class="article">

      <br><br><br><h1>Bienvenue sur le Dashboard Facil'Access</h1><br>
      <p>En tant qu'administrateur, vous avez la possibilité de gérer les comptes. <br> Les différentes actions possibles sont : la création et la validation des créations de compte, la suppression de comptes et la liste des utilisateurs.</p>

      </div>


      <script src="/js/script.js"></script>
  </main>
  </body>
</html>
