<?php 
session_start();
include_once "connect_pdo.php"; // Connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $codeElec = htmlspecialchars($_POST['codeElec']);
    $codecompteur = htmlspecialchars($_POST['codecompteur']);
    $valeur1 = htmlspecialchars($_POST['valeur1']);
    $date_releve = htmlspecialchars($_POST['date_releve']);
    $date_presentation = htmlspecialchars($_POST['date_presentation']);
    $date_limite_paie = htmlspecialchars($_POST['date_limite_paie']);
   
    

    // Préparer une requête SQL pour mettre à jour les détails du client
    $stmt = $pdo->prepare("UPDATE ELEC SET codecompteur = :codecompteur, valeur1 = :valeur1, date_releve = :date_releve,date_presentation = :date_presentation, date_limite_paie = :date_limite_paie WHERE codeElec = :codeElec");
    
    if ($stmt->execute(['codeElec' => $codeElec, 'codecompteur' => $codecompteur, 'valeur1' => $valeur1, 'date_releve' => $date_releve,'date_presentation' => $date_presentation, 'date_limite_paie' => $date_limite_paie])) {
        echo "Client modifié avec succès.";
        header("Location: ../view/releve_elec.php");
    } else {
        echo "Erreur lors de la modification du client.";
    }
} else {
    echo "Méthode incorrecte.";
}
?>
