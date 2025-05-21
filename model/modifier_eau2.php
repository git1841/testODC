<?php 
session_start();
include_once "connect_pdo.php"; // Connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $codeEau = htmlspecialchars($_POST['codeEau']);
    $codecompteur = htmlspecialchars($_POST['codecompteur']);
    $valeur2 = htmlspecialchars($_POST['valeur2']);
    $date_releve2 = htmlspecialchars($_POST['date_releve2']);
    $date_presentation2 = htmlspecialchars($_POST['date_presentation2']);
    $date_limite_paie2 = htmlspecialchars($_POST['date_limite_paie2']);


    // Préparer une requête SQL pour mettre à jour les détails du client
    $stmt = $pdo->prepare("UPDATE EAU SET codecompteur = :codecompteur, valeur2 = :valeur2, date_releve2 = :date_releve2, date_presentation2 = :date_presentation2, date_limite_paie2 = :date_limite_paie2 WHERE codeEau = :codeEau");
    
    if ($stmt->execute(['codeEau' => $codeEau, 'codecompteur' => $codecompteur, 'valeur2' => $valeur2, 'date_releve2' => 
$date_releve2,'date_presentation2' => $date_presentation2 , 'date_limite_paie2' => $date_limite_paie2])) {
        echo "Client modifié avec succès.";
        header("Location: ../view/releve_eau.php");
    } else {
        echo "Erreur lors de la modification du client.";
    }
} else {
    echo "Méthode incorrecte.";
}
?>
