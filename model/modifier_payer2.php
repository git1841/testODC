<?php 
session_start();
include_once "connect_pdo.php"; // Connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idpaye = htmlspecialchars($_POST['idpaye']);
    $codecli = htmlspecialchars($_POST['codecli']);
    $datepaie = htmlspecialchars($_POST['datepaie']);
    $montant = htmlspecialchars($_POST['montant']);



    // Préparer une requête SQL pour mettre à jour les détails du client
    $stmt = $pdo->prepare("UPDATE PAYER SET codecli = :codecli, datepaie = :datepaie, montant = :montant WHERE idpaye = :idpaye");
    
    if ($stmt->execute(['idpaye' => $idpaye, 'codecli' => $codecli, 'datepaie' => $datepaie, 'montant' => 
$montant])) {
        echo "Client modifié avec succès.";
        header("Location: ../view/payer.php");
    } else {
        echo "Erreur lors de la modification du client.";
    }
} else {
    echo "Méthode incorrecte.";
}
?>
