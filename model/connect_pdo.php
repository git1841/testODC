<?php
$host = 'localhost';
$dbname = 'jirama';  // Assurez-vous que la base est bien créée
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connexion réussie !";
} catch (PDOException $e) {
    die("Échec de la connexion : " . $e->getMessage());
}
?>
