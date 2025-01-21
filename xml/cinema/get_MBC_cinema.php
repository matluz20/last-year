<?php
$movies = json_decode(file_get_contents("http://91.173.60.180/API/rest.php?ville=".$_GET['ID']));
ob_start();
?>
<div class="container">
<h2>Séances à <?=$movies[0]->adresse ?></h2>
    <div class="row">
        <?php foreach ($movies as $movie): ?>
            <div class="col-md-6">
                <div class="film">
                    <div class="card">
                        <div class="imgArticle">
                            <a href="?nom=<?= $movie->id?>">
                                <img class="taille" src="/cinema/img/<?= $movie->miniature ?>"
                                    onerror="this.onerror=null;this.src='/cinema/img/default/Cinema.png';">
                            </a>

                            <div class="title">
                                <?= $movie->titre ?>
                            </div>
                            <div class="seanceInfo">
                                <div class="cinema"><?= $movie->nom_du_cinema ?></div>
                                <div class="ville"><?= $movie->adresse ?></div>
                            </div>
                            <div class="seanceInfo">
                                <div class="cinema"><?= $movie->durée ?></div>
                                <div class="ville"><?= $movie->séance ?> <?= $movie->heure ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</div>

<?php
$content = ob_get_clean();
require_once("apres_conn.php");
?>