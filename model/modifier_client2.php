<?php 
session_start();
include_once "connect_pdo.php"; // Connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $codecli = htmlspecialchars($_POST['codecli']);
    $nom = htmlspecialchars($_POST['nom']);
    $sexe = htmlspecialchars($_POST['sexe']);
    $quartier = htmlspecialchars($_POST['quartier']);
    $niveau = htmlspecialchars($_POST['niveau']);
    $mail = htmlspecialchars($_POST['mail']);


    // Préparer une requête SQL pour mettre à jour les détails du client
    $stmt = $pdo->prepare("UPDATE CLIENT SET nom = :nom, sexe = :sexe, quartier = :quartier, 
niveau = :niveau, mail = :mail WHERE codecli = :codecli");
    
    if ($stmt->execute(['codecli' => $codecli, 'nom' => $nom, 'sexe' => $sexe, 'quartier' => 
$quartier, 'niveau' => $niveau, 'mail' => $mail])) {
        echo "Client modifié avec succès.";
        header("Location: ../view/client.php");
    } else {
        echo "Erreur lors de la modification du client.";
    }
} else {
    echo "Méthode incorrecte.";
}
?>
