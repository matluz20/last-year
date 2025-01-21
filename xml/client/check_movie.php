<?php
session_start();
if ($_SESSION['connexion'] != "ok"){
    header("Location: cinema/index.php");
    exit();
}

$titre = $_GET['titre'];
$response = json_decode(file_get_contents("http://91.173.60.180/API/rest.php?titre=" . $titre));
$titreMajuscules = strtoupper($titre);

if ($response !== false) {
    require_once("/var/www/projetweb/xml/cinema/apres_conn.php");

    // Vous incluez le fichier JavaScript comme suit
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';

    if ($response == "1") {
        // afficher le film n'existe pas et donner la possibilité de le créer
        echo '<script>
        Swal.fire({
            title: "' . $titreMajuscules . ' n\'existe pas",
            text: "Vous pouvez le créer.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Oui, créez-le",
            cancelButtonText: "Annuler"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "/cinema/apres_conn.php?openModal1=1";
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                window.location.href = "#";
            }
        });
        </script>';
    } elseif ($response == "0") {
        // afficher le film existe et donner la possibilité de créer la séance
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
    }
} else {
    echo "Erreur lors de la requête GET vers le service REST distant.";
}
?>
