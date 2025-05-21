<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un releve electricite </title>
   
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
input[type="number"],
        select,
        input[type="number"]{
            width: calc(100% - 22px);
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 16px;
            transition: border-color 0.3s ease;
        } {
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
}

.error {
    color: red;
}
</style>
</head>
<body>
    
<?php

include_once "connect.php"; 
$message = ""; // Initialiser le message vide

if (isset($_POST['boutton'])) {
    $codeEau = $_POST['codeEau'];
    $codecompteur = $_POST['codecompteur'];
    $valeur2 = $_POST['valeur2'];
    $date_releve2 = $_POST['date_releve2'];
    $date_presentation2 = $_POST['date_presentation2'];
    $date_limite_paie2 = $_POST['date_limite_paie2'];

    // Vérifier si le codeEau existe déjà dans la table EAU
    $req_check_codeeau = "SELECT COUNT(*) as count FROM EAU WHERE codeEau = '$codeEau'";
    $result_check_codeeau = mysqli_query($conn, $req_check_codeeau);
    $row_check_codeeau = mysqli_fetch_assoc($result_check_codeeau);

    if ($row_check_codeeau['count'] > 0) {
        // Le codeEau existe déjà
        $message = "Le code eau '$codeEau' est déjà utilisé.";
    } else {
        // Vérifier si le codecompteur existe dans la table COMPTEUR
        $req_check_compteur = "SELECT COUNT(*) as count FROM COMPTEUR WHERE codecompteur = '$codecompteur' AND type = 'EAU' ";
        $result_check_compteur = mysqli_query($conn, $req_check_compteur);
        $row_check_compteur = mysqli_fetch_assoc($result_check_compteur);

        if ($row_check_compteur['count'] > 0) {
            // Vérifier l'ordre des dates
            if ($date_releve2 < $date_presentation2 && $date_presentation2 < $date_limite_paie2) {
                // Le codecompteur existe, on peut insérer les données
                $req_insert = "INSERT INTO EAU(codeEau, codecompteur, valeur2, date_releve2, date_presentation2, date_limite_paie2)
                               VALUES ('$codeEau', '$codecompteur', '$valeur2', '$date_releve2', '$date_presentation2', '$date_limite_paie2')";

                if (mysqli_query($conn, $req_insert)) {
                    // Redirection après l'ajout réussi
                    header("Location: ../view/releve_eau.php");
                    exit();
                } else {
                    $message = "Erreur d'insertion : " . mysqli_error($conn);
                }
            } else {
                $message = "Veuillez vérifier vos dates.";
            }
        } else {
            // Le codecompteur n'existe pas
            $message = "Le code compteur '$codecompteur' n'existe pas dans la table COMPTEUR de type EAU.";
        }
    }
}

?>

<div class="container">
    <h2>Ajouter un Releve</h2>
    <form action="" method="POST">
        <label>Code eau</label>
        <input type="text" name="codeEau" required>

        <label>Code compteur</label>
        <input type="text" name="codecompteur" required>

        <label>Valeur</label>
        <input type="number" name="valeur2" required>

        <label>Date releve</label>
        <input type="date" name="date_releve2" required>

        <label>Date présentation</label>
        <input type="date" name="date_presentation2" required>

        <label>Date limite paiement</label>
        <input type="date" name="date_limite_paie2" required>

        <input type="submit" value="Ajouter" name="boutton">
    </form>

    <?php if (!empty($message)) echo '<p class="error">' . $message . '</p>'; ?>
</div>


</body>

</html>





