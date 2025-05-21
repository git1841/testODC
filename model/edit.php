<?php 
include_once "connect.php"; // Connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codecli = isset($_POST['codecli']) ? intval($_POST['codecli']) : 0;
    $nom = htmlspecialchars($_POST['nom']);
    $sexe = htmlspecialchars($_POST['sexe']);
    $quartier = htmlspecialchars($_POST['quartier']);
    $niveau = htmlspecialchars($_POST['niveau']);
    $mail = htmlspecialchars($_POST['mail']);

    if ($codecli > 0) {
        $sql = "UPDATE CLIENT SET nom = ?, sexe = ?, quartier = ?, niveau = ?, mail = ? WHERE codecli = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'sssssi', $nom, $sexe, $quartier, $niveau, $mail, $codecli);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: ../view/client.php"); // Rediriger vers la liste des clients
            exit();
        } else {
            echo "Erreur lors de la mise à jour du client : " . mysqli_error($conn);
        }
    } else {
        echo "Paramètre incorrect.";
    }
}
?>
