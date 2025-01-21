<?php

function getConnexion()
{
    $host = 'terraform-20250121115406880900000010.cxymgguk68ge.eu-west-3.rds.amazonaws.com'; 
    $dbname = 'testdb';   
    $username = 'admin';  
    $password = 'SuperSecretPassword123';

    try {
        return new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    } catch (PDOException $e) {
        echo "Erreur de connexion à la base de données : " . $e->getMessage();
    }
}

function getAllMovies()
{
    $pdo = getConnexion();
    $req = "SELECT
    séances.date_seance AS séance,
    film.titre AS titre,
    film.durée AS durée,
    film.langue AS langue,
    film.réalisateur AS réalisateur,
    film.age_minimum_requis AS age_minimum_requis,
    cinéma.nom_du_cinema AS nom_du_cinema,
    cinéma.adresse
FROM
    séances
INNER JOIN cinéma ON séances.id_cinema = cinéma.id
INNER JOIN film ON séances.id_film = film.id;"; // All Movies
    $stmt = $pdo->prepare($req);
    try {
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Erreur de connexion à la base de données : " . $e->getMessage();
    }
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    echo json_encode($movies);
}

function getMoviesByCity($city)
{
    $pdo = getConnexion();
    $req = "SELECT
    séances.date_seance, film.titre AS nom_du_film, cinéma.nom_du_cinema AS nom_du_cinema, cinéma.adresse AS adresse FROM séances INNER JOIN cinéma ON séances.id_cinema = cinéma.id 
    INNER JOIN film ON séances.id_film = film.id WHERE cinéma.adresse = :city";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":city", $city, PDO::PARAM_STR);
    try {
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Erreur de connexion à la base de données : " . $e->getMessage();
    }
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    echo json_encode($movies);
}


function addmovie($titre, $duree, $langue, $sous_titres, $realisateur, $acteurs_principaux, $age_minimum, $date_debut)
{
    $pdo = getConnexion();

    // Requête d'insertion
    $query = "INSERT INTO `film` (`titre`, `durée`, `langue`, `sous_titres`, `réalisateur`, `acteurs_principaux`, `age_minimum_requis`, `date_debut`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    // Préparation de la requête
    $stmt = $pdo->prepare($query);

    // Exécution de la requête avec les données fournies
    $result = $stmt->execute([$titre, $duree, $langue, $sous_titres, $realisateur, $acteurs_principaux, $age_minimum, $date_debut]);

    if ($result) {
        $response = ['message' => 'movie add success']; // Réponse JSON en cas de succès
    } else {
        $response = ['message' => 'Échec de l\'ajout du film']; // Réponse JSON en cas d'échec
    }

    // Configuration de l'en-tête de réponse pour indiquer le type JSON
    header('Content-Type: application/json');

    // Envoi de la réponse JSON
    echo json_encode($response);
}

function checkmovie($titre){
    $pdo = getConnexion();
    $req = "SELECT `titre` FROM `film` WHERE `titre` = :titre"; // Correction de la requête SQL
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":titre", $titre, PDO::PARAM_STR); // Correction du paramètre lié

    if ($stmt->execute()) {
        $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($movies)) {
            $response = 0;
        } else {
            $response = 1;
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // Gérer l'erreur d'exécution de la requête ici
        echo json_encode("Erreur lors de l'exécution de la requête.");
    }

    $stmt->closeCursor();
}


function addseance($titre,$username,$date_seance){
    $pdo = getConnexion();

    // recuperation de l'id du film
    $req = "SELECT `id` FROM `film` WHERE `titre` = :titre";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":titre", $titre, PDO::PARAM_STR); 
    if ($stmt->execute()) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $id_film = $result['id'];

        // recuperation de l'id du cinéma
        $req2 = "SELECT `cinema_id` FROM `users` WHERE `nom` = :username";
        $stmt2 = $pdo->prepare($req2);
        $stmt2->bindValue(":username", $username, PDO::PARAM_STR); 
        if ($stmt->execute()) {
            $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            $id_cinema = $result2['cinema_id'];

            // insertion dans la table seance
            $query = "INSERT INTO `séances` (`id_film`, `id_cinema`, `date_seance`) VALUES (?, ?, ?,)";
            // Préparation de la requête
            $stmt3 = $pdo->prepare($query);

            // Exécution de la requête avec les données fournies
            $result3 = $stmt3->execute([$id_film, $id_cinema, $date_seance]);

            if ($result3) {
                $response = ['message' => 'movie add success']; // Réponse JSON en cas de succès
            } else {
                $response = ['message' => 'Échec de l\'ajout du film']; // Réponse JSON en cas d'échec
            }

            header('Content-Type: application/json');
            echo json_encode($response);    
        }     
        }

    $stmt->closeCursor();

}



// execution des fonctions

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérez les données de la requête POST
    $request_body = file_get_contents('php://input');         
    // Convertissez les données JSON en tableau associatif
    $data = json_decode($request_body, true);

    if ($data['date_seance']) {
        // definir le username
        addseance($data['titre'],$data['titre'],$data['date_seance']);
    }else{
        if ($data) {
            addmovie($data['titre'], $data['duree'], $data['langue'], $data['sous_titres'], $data['realisateur'], $data['acteurs_principaux'], $data['age_minimum'], $data['date_debut']);
        } else {
            echo "Erreur d'analyse des données JSON.";
        }
    }
   
}


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!empty($_GET['ville'])) {
        getMoviesByCity($_GET['ville']);
    }elseif(!empty($_GET['titre'])){
        checkmovie($_GET['titre']);
    } 
     else {
        getAllMovies();
    }
}



?>