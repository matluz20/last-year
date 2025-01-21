<?php
session_start(); // On démarre la session

// On supprime toutes les variables de session
$_SESSION = array();

// Si vous voulez détruire complètement la session, effacez également le cookie de session.
// Notez que cela détruira la session et pas seulement les données de session !
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// On détruit la session
session_destroy();

// Redirection vers la page d'accueil ou une autre page de votre choix
header("Location: ../../index.php");
exit();
?>
