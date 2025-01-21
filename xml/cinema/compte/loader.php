<?php 
session_start();
if ($_SESSION['connexion'] != "ok"){
    header("Location: /cinema/index.php");
    exit();
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="../css/loader.css">
    <title>Document</title>
</head>
<body>
    <div class="bar">
        <h1>Connexion en cours</h1>
        <div class="progress"></div>
    </div>

    <script>
        // Attendre 3 secondes avant de rediriger
        setTimeout(function () {
            window.location.href = '../apres_conn.php';
        }, 4000); 
    </script>
</body>
</html>
