<?php 
session_start();
include_once "connect_pdo.php"; // Connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $codecompteur = htmlspecialchars($_POST['codecompteur']);
    $type = htmlspecialchars($_POST['type']);
    $pu = htmlspecialchars($_POST['pu']);
    $codecli = htmlspecialchars($_POST['codecli']);



    // Préparer une requête SQL pour mettre à jour les détails du client
    $stmt = $pdo->prepare("UPDATE COMPTEUR SET type = :type, pu = :pu, codecli = :codecli WHERE codecompteur = :codecompteur");
    
    if ($stmt->execute(['codecompteur' => $codecompteur, 'type' => $type, 'pu' => $pu, 'codecli' => 
$codecli])) {
        echo "Client modifié avec succès.";
        header("Location: ../view/compteur.php");
    } else {
        echo "Erreur lors de la modification du client.";
    }
} else {
    echo "Méthode incorrecte.";
}
?>
