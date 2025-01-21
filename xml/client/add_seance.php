<?php
session_start();
if ($_SESSION['connexion'] != "ok"){
    header("Location: cinema/index.php");
    exit();
}
require_once("/var/www/projetweb/xml/cinema/apres_conn.php");
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';


// Vérifiez si la requête est de type POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérez les données du formulaire
    $titre = $_POST['titre'];
    $date_seance = $_POST['date_seance'];
    $add_seance = 1;
    $username = $_SESSION['username'];
    $titreMajuscules = strtoupper($titre);

    // Créez un tableau avec les données
    $data = [
        'titre' => $titre,
        'date_seance' => $date_seance,
        'add_seance' => $add_seance,
        'username' => $username,
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

    // echo "En entente de la mise en place des usernames uniques";

    if ($response !== false) {
        echo '<script>
        Swal.fire({
            title: "la séance pour le film ' . $titreMajuscules .' \a été ajouté",
            icon: "sucess",
            confirmButtonColor: "#3085d6",
            confirmButtonText: "Yeaaah",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "/cinema/apres_conn.php";
            } 
        });
        </script>';
    } else {
        echo "Erreur lors de la requête POST vers le service REST distant.";
    }
}

?>
