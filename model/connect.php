<?php
$host = 'localhost';
$dbname = 'jirama';  // Assurez-vous que la base est bien créée
$username = 'root';
$password = '';

// Connexion à MySQL
$conn = mysqli_connect($host, $username, $password, $dbname);

// Vérifier la connexion
if (!$conn) {
    die("Échec de la connexion : " . mysqli_connect_error());
}
//echo "Connexion réussie !";
?>
