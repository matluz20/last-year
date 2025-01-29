<?php



$host = '91.173.60.180'; 
$dbname = 'projet_web';   
$username = 'rs2';  
$password = 'Toto123#';


// Connexion à la base de données
$conn = new mysqli($host, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données : " . $conn->connect_error);
}
?>





