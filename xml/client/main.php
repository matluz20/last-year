
<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!empty($_GET['ville'])){
        require 'get_movie.php';
    }elseif(!empty($_GET['titre'])){
        require 'check_movie.php';
    }elseif(!empty($_GET['id'])){
        require 'get_seance.php';
    }elseif(!empty($_GET['nom'])){
        require 'get_movie_desc.php';
    }
    else{
        require 'get_movies.php';
    }

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!empty($_POST['date_seance'])){
        require 'add_seance.php';
    }
    if(!empty($_POST['synopsis'])){
        require 'add_movie.php';
    }
    // else{
    //     require 'add_movie.php';
    // }
}

// à faire si on a le temps

//  elseif ($_SERVER['REQUEST_METHOD'] === 'PUT' && preg_match('#/movies/(\d+)#', $_SERVER['REQUEST_URI'], $matches)) {
//     // Requête PUT pour mettre à jour un film par son ID
//     $movieId = $matches[1];
//     require 'update_movie.php';

// } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE' && preg_match('#/movies/(\d+)#', $_SERVER['REQUEST_URI'], $matches)) {
//     // Requête DELETE pour supprimer un film par son ID
//     $movieId = $matches[1];
//     require 'delete_movie.php';

// }
 else {
    // Gérer les erreurs et renvoyer une réponse appropriée
    http_response_code(404);
    echo json_encode(['message' => 'Ressource non trouvée']);
}

?>