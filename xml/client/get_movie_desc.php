<?php
$movies = json_decode(file_get_contents("http://91.173.60.180/API/rest.php?id=" . $_GET['nom']));
ob_start();

?>
<div class="container">
    <div class="row">
        <?php
        $movie = $movies[0]; ?>
        <div class="col-md-6">
            <div class="film">

                <div class="card2">
                    <br>
                    <br>
                    <div class="imgArticle2">
                        <a href="?id=<?= $movie->id ?>">
                            <img class="taille" src="/cinema/img/<?= $movie->miniature ?>"
                                onerror="this.onerror=null;this.src='/cinema/img/default/Cinema.png';">
                        </a>
                        <div class="title">
                            <?= $movie->titre ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-7">
            <div class="film">

                <div class="card2">
                    <br>
                    <h2>
                        <?= $movie->titre ?>
                    </h2>
                    <hr>
                    <br>
                    <h3>Synopsis</h3>
                    <br>
                    <p class="synopsis"><?= $movie->synopsis ?></p><br>
                    <div class="infos">

                        <div class="duree">Durée : <?= $movie->durée ?></div>
                        <div class="diffusion">Diffusé à partir de : <?= $movie->date_debut ?></div>
                        <div class="realisateur">Réalisé par : <?= $movie->réalisateur ?></div>
                        <div class="acteurs">Avec : <?= $movie->acteurs ?></div>
                        <div class="langue">Langue : <?= $movie->langue ?></div>
                        <div class="sous_titres">Sous-titres : <?= $movie->sous_titres ?></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php
$content = ob_get_clean();
require_once("index.php");
?>