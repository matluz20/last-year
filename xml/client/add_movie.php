<?php
session_start();
if ($_SESSION['connexion'] != "ok"){
    header("Location: ../cinema/index.php");
    exit();
}
require_once("../cinema/apres_conn.php");
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';


// Vérifiez si la requête est de type POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérez les données du formulaire
    $titre = $_POST['titre'];
    $duree = $_POST['duree'];
    $langue = $_POST['langue'];
    $sous_titres = $_POST['sous_titres'];
    $realisateur = $_POST['realisateur'];
    $acteurs_principaux = $_POST['acteurs_principaux'];
    $age_minimum = $_POST['age_minimum'];
    $date_sortie = $_POST['date_sortie'];
    $synopsis = $_POST['synopsis'];
    $titreMajuscules = strtoupper($titre);

    // Créez un tableau avec les données
    $data = [
        'titre' => $titre,
        'duree' => $duree,
        'langue' => $langue,
        'sous_titres' => $sous_titres,
        'realisateur' => $realisateur,
        'acteurs_principaux' => $acteurs_principaux,
        'age_minimum' => $age_minimum,
        'date_sortie' => $date_sortie,
        'synopsis' => $synopsis,
    ];

    // Convertissez les données en format JSON
    $data_json = json_encode($data);

    // Configuration de la requête POST avec le contexte stream
    $context = stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/json',
            'content' => $data_json,
        ],
    ]);

    $api_url = "http://91.173.60.180/API/rest.php"; // Assurez-vous que l'URL est correcte

    // Envoyez la requête POST
    $response = file_get_contents($api_url, false, $context);

    if($response == 0){
        echo '<script>
        Swal.fire({
            title: "' . $titreMajuscules .' \existe",
            text: "Vous pouvez créer une séance",
            icon: "sucess",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Oui",
            cancelButtonText: "Annuler"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "/cinema/apres_conn.php?openModal3=1&titre=' . urlencode($titre) . '";
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                window.location.href = "#";

            }
        });
        </script>';

    }  elseif ($response == 12) {
        echo '<script>
        Swal.fire({
            title: "' . $titreMajuscules .' \a été ajouté",
            text: "Souhaitez-vous créer une séance de diffusion ?",
            icon: "sucess",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Oui",
            cancelButtonText: "Annuler"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "/cinema/apres_conn.php?openModal3=1&titre=' . urlencode($titre) . '";
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                window.location.href = "#";

            }
        });
        </script>';
    }elseif($response == 1) {
        echo $response;
    }else {
        echo $response;
    }
}

?>
