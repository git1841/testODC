
<?php

include_once "connect.php"; 

if (isset($_POST['boutton'])) {
    $codeElec = $_POST['codeElec'];
    $codecompteur = $_POST['codecompteur'];
    $valeur1 = $_POST['valeur1'];
    $date_releve = $_POST['date_releve'];
    $date_presentation = $_POST['date_presentation'];
    $date_limite_paie = $_POST['date_limite_paie'];

    // Vérifier si le codeElec existe déjà dans la table ELEC
    $req_check_codeElec = "SELECT COUNT(*) as count FROM ELEC WHERE codeElec = '$codeElec'";
    $result_check_codeElec = mysqli_query($conn, $req_check_codeElec);
    $row_check_codeElec = mysqli_fetch_assoc($result_check_codeElec);

    if ($row_check_codeElec['count'] > 0) {
        // Le codeElec existe déjà
        $message = "Le code électrique '$codeElec' est déjà utilisé.";
    } else {
        // Vérifier si le codecompteur existe dans la table COMPTEUR
        $req_check_compteur = "SELECT COUNT(*) as count FROM COMPTEUR WHERE codecompteur = '$codecompteur'";
        $result_check_compteur = mysqli_query($conn, $req_check_compteur);
        $row_check_compteur = mysqli_fetch_assoc($result_check_compteur);

        if ($row_check_compteur['count'] > 0) {
            // Le codecompteur existe, on peut insérer les données
            $req_insert = "INSERT INTO ELEC(codeElec, codecompteur, valeur1, date_releve, date_presentation, date_limite_paie)
                           VALUES ('$codeElec', '$codecompteur', '$valeur1', '$date_releve', '$date_presentation', '$date_limite_paie')";

            if (mysqli_query($conn, $req_insert)) {
                // Redirection après l'ajout réussi
                header("Location: releve_elec.php");
                exit();
            } else {
                $message = "Erreur d'insertion : " . mysqli_error($conn);
            }
        } else {
            // Le codecompteur n'existe pas
            $message = "Le code compteur '$codecompteur' n'existe pas dans la table COMPTEUR.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un compteur</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 600;
        }
        input[type="text"],
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
        }
        input[type="text"]:focus {
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
    </style>
</head>

<body>
<div class="container">
    <h2>Ajouter un Releve</h2>

    <?php if (isset($message)) echo '<p class="error">' . $message . '</p>'; ?>

    <form action="" method="POST">
        <label>Code Electricité</label>
        <input type="text" name="codeElec" required>

        <label>Code compteur</label>
        <input type="text" name="codecompteur" required>

        <label>Valeur</label>
        <input type="number" name="valeur1" required>

        <label>Date releve</label>
        <input type="date" name="date_releve" required>

        <label>Date présentation</label>
        <input type="date" name="date_presentation" required>

        <label>Date limite paiement</label>
        <input type="date" name="date_limite_paie" required>

        <input type="submit" value="Ajouter" name="boutton">
    </form>
</div>
</body>



</html>



