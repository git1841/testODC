<?php 
include_once "connect.php"; // Connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $codecli = intval($_POST['codecli']);
    $nom = htmlspecialchars($_POST['nom']);
    $sexe = htmlspecialchars($_POST['sexe']);
    $quartier = htmlspecialchars($_POST['quartier']);
    $adresse = htmlspecialchars($_POST['adresse']);
    $email = htmlspecialchars($_POST['email']);
    $telephone = htmlspecialchars($_POST['telephone']);

    if ($codecli > 0) {
        $sql = "UPDATE CLIENT SET nom=?, sexe=?, quartier=?, adresse=?, email=?, telephone=? WHERE codecli=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ssssssi', $nom, $sexe, $quartier, $adresse, $email, $telephone, $codecli);

        if (mysqli_stmt_execute($stmt)) {
            echo "Client modifié avec succès.";
        } else {
            echo "Erreur lors de la mise à jour du client : " . mysqli_error($conn);
        }
    } else {
        echo "Paramètre incorrect.";
    }
} else {
    echo "Méthode incorrecte.";
}
?>
