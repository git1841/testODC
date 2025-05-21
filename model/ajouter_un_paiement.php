<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un paiement</title>
   
<style>
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

.container {
    background-color: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 450px;
}

h2 {
    text-align: center;
    margin-bottom: 30px;
    color: #333;
    font-size: 28px;
}

label {
    display: block;
    margin-bottom: 8px;
    color: #555;
    font-weight: 600;
}

input[type="text"],
input[type="date"],
input[type="email"], 
input[type="number"]{
    width: calc(100% - 22px);
    padding: 12px;
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 6px;
    box-sizing: border-box;
    font-size: 16px;
    transition: border-color 0.3s ease;
}

input[type="text"]:focus,
input[type="date"]:focus,
input[type="email"]:focus {
    border-color: #007bff;
    outline: none;
}

input[type="submit"] {
    background-color: #007bff;
    color: white;
    padding: 14px 20px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    width: 100%;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

.error-message {
    color: #d9534f;
    margin-bottom: 20px;
    text-align: center;
    font-size: 16px;
}

/</style>
</head>
<body>
<?php
include_once "connect.php"; // Connexion à la base

if (isset($_POST["boutton"])) {
    // Récupérer les données du formulaire en s'assurant qu'elles existent
    $idpaye = mysqli_real_escape_string($conn, $_POST["idpaye"]);
    $codecli = mysqli_real_escape_string($conn, $_POST["codecli"]);
    $datepaie_str = $_POST["datepaie"];
    $montant = mysqli_real_escape_string($conn, $_POST["montant"]);

    // Vérifier si le code client existe dans la table CLIENT
    $check_codecli_query = "SELECT * FROM CLIENT WHERE codecli = '$codecli'";
    $result_check_codecli = mysqli_query($conn, $check_codecli_query);

    if (mysqli_num_rows($result_check_codecli) == 0) {
        // Le code client n'existe pas
        $message = "Le code client spécifié n'existe pas.";
    } else {
        // Vérifier si l'idpaye existe déjà dans la table PAYER
        $check_idpaye_query = "SELECT * FROM PAYER WHERE idpaye = '$idpaye'";
        $result_check_idpaye = mysqli_query($conn, $check_idpaye_query);

        if (mysqli_num_rows($result_check_idpaye) > 0) {
            // L'idpaye existe déjà
            $message = "L'ID de paiement spécifié est déjà utilisé.";
        } else {
            // Si le code client existe et l'idpaye n'existe pas, vérifier que tous les champs sont remplis
            if (!empty($idpaye) && !empty($codecli) && !empty($datepaie_str) && !empty($montant)) {
                $datepaie = new DateTime($datepaie_str);
                $datepaie_formatted = $datepaie->format('Y/m/d');
                $datepaie = $datepaie_formatted;

                // Requête d'insertion corrigée
                $req = "INSERT INTO PAYER (idpaye, codecli, datepaie, montant) 
                        VALUES ('$idpaye', '$codecli', '$datepaie', '$montant')";

                // Exécuter la requête
                if (mysqli_query($conn, $req)) {
                    // Redirection après l'ajout réussi
                    header("Location: ../view/payer.php");
                    exit();
                } else {
                    // Afficher l'erreur SQL en cas d'échec
                    $message = "Erreur d'insertion : " . mysqli_error($conn);
                }
            } else {
                $message = "Veuillez remplir tous les champs.";
            }
        }
    }
}
?>

<div class="container">
    <h2>Ajouter un paiement</h2>
    <p style="color:red;">
        <?php if (isset($message)) echo $message; ?>
    </p>
    <form action="" method="POST">
        <label>idpaye</label>
        <input type="text" name="idpaye" required>

        <label>code client</label>
        <input type="text" name="codecli" required>

        <label>datepaie</label>
        <input type="date" name="datepaie" required>

        <label>montant</label>
        <input type="number" name="montant" required>

        <input type="submit" value="Ajouter" name="boutton">
    </form>
</div>

</body>
</html>




