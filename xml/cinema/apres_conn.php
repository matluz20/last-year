<?php
session_start();
if ($_SESSION['connexion'] != "ok") {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>


<head>
    <meta charset="UTF-8">
    <title>Efrei MarketPlace - Ventes</title>
    <link rel="stylesheet" href="/cinema/css/css/style.css">

</head>


<body>

    <header>

        <div class="h1">
            <h1><a href="/client/main.php">Efrei Cinéma</a></h1>
        </div>


        <nav class="navbar">
            <ul class="menu">
                <li><a href="#" onclick="openModal()" id="open-modal-button2">Ajouter une séance</a></li>
                <li><a href="#" onclick="openModal1()" id="open-modal-button1">Ajouter un film</a></li>
                <li><a href="#" onclick="openModal3()" id="open-modal-button3">Ajouter un film</a></li>
                <li class="Deco"><a href="/cinema/compte/deconnexion.php">Deconnexion</a></li>
            </ul>


        </nav>
    </header>

    <!-- Verification film -->
    <div id="modal2" class="modal">
        <div id="login-form">
            <div id="login-head">
                <p>Saisissez le titre du film</p>
            </div>

            <div id="login-details">
                <form action="/client/main.php" method="GET">
                    <div id="titre">
                        <input type="text" name="titre" placeholder="Titre du film" required>
                    </div>
                    <div id="submit">
                        <input type="submit" value="Ajouter le film">
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- ajout seance -->

    <div id="modal3" class="modal">
        <div id="login-form">
            <div id="login-head">
                <p>Saisissez la date et l'heure de la séance</p>
            </div>

            <div id="login-details">
                <form action="/client/main.php" method="POST" id="seance-form">
                    <div id="titre">
                        <input type="text" name="titre" placeholder="Titre du film" required>
                    </div>

                    <div id="date_debut">
                        <input type="date" name="date_seance" required>
                    </div>

                    <div id="submit">
                        <input type="submit" value="Ajouter la séance">
                    </div>
                </form>

            </div>
        </div>
    </div>


    <!-- Ajout film -->

    <div id="modal1" class="modal">
        <div id="login-form">
            <div id="login-head">
                <p>Renseignez ci-dessous les informations sur le film</p>
            </div>

            <div id="login-details">
                <form action="/client/main.php" method="POST">
                    <div id="titre">
                        <input type="text" name="titre" placeholder="Titre du film" required>
                    </div>
                    <div id="duree">
                        <input type="number" name="duree" placeholder="Durée (en min)" required>
                    </div>
                    <div id="langue">
                        <input type="text" name="langue" placeholder="Langue du film" required>
                    </div>
                    <div id="realisateur">
                        <input type="text" name="realisateur" placeholder="Réalisateur(s)" required>
                    </div>
                    <div id="acteurs_principaux">
                        <input type="text" name="acteurs_principaux" placeholder="Acteurs principaux" required>
                    </div>
                    <div id="age_minimum">
                        <input type="number" name="age_minimum" placeholder="Âge minimum" required>
                    </div>
                    <br>
                    <div id="date_sortie">
                        <label for="sous_titres">Année de parution :</label>
                        <input type="date" name="date_sortie" required>
                    </div>
                    <br>
                    <div id="miniature">
                        <label for="sous_titres">Miniature :</label>
                        <input type="file" name="miniature" accept="image/png, image/jpeg" alt="ajout d'image">
                    </div>
                    <br>
                    <!-- pour les test -->
                    <div id="sous_titres">
                        <label for="sous_titres">Sous titre :</label>
                        <input type="text" name="sous_titres" placeholder="langue">
                    </div>

                    <div id="sous_titres">
                        <label for="sous_titres">Synopsis :</label>
                        <input type="text" name="synopsis" placeholder="synopsis">
                    </div>


                    <!-- <div id="image">
            <label for="image">Image du film :</label>
            <input type="file" name="image" id="image">
      </div> -->
                    <div id="submit">
                        <input type="submit" value="Ajouter le film">
                    </div>
                </form>

            </div>
        </div>
    </div>


    <div class="article">
        <?= $content ?>
    </div>

    <script src="/client/js/script.js"></script>
    <script src="/cinema/js/modal.js"></script>

</body>

</html>