<?php
session_start();
?>
<!DOCTYPE html>
<html>


<head>
    <meta charset="UTF-8">
    <title>Efrei MarketPlace - Ventes</title>
    <link rel="stylesheet" href="/client/css/style.css">

</head>


<body>


    <header>

        <div class="h1">
            <h1><a href="/client/main.php">Efrei Cinéma</a></h1>
            <!-- <h1 class="account"><a href="/php/compte/moncompte.php"><img src="/client/image/person.svg"
                        class="accountsvg"></a></h1> -->
        </div>
        <nav class="navbar">
            <ul class="menu">
                <li><a href="/client/main.php">Tous les films</a></li>
                <li>
                    <!-- <form method="get" action="/php/articles/categorie/categorie.php"> -->
                    <form method="get" action="main.php">
                        <a href="#" onclick="toggleSearchBar()" id="ville">Ville</a>
                        <input type="text" class="search-bar hidden" name="ville" placeholder="Rechercher..." id="selectedVille">
                    </form>
                    <script>
                        function selectVille(ville) {
                        document.getElementById('selectedVille').value = ville;
                        document.forms[0].submit();
                        }
                        function toggleSearchBar() {
                            var ville = document.getElementById('ville');
                            ville.classList.toggle('selected');
                            var menu = document.getElementById('selectedVille');
                            menu.classList.toggle('hidden');
                        }
                    </script>
                <li class="connexion"><a href="/cinema/">Connexion</a></li>
                </li>


            </ul>


        </nav>
    </header>


    <div class="article">
        <?= $content?>
    </div>
    
    <script src="/client/js/script.js"></script>

</body>

</html>