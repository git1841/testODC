<?php
include_once "connect.php"; // Connexion à la base

if (isset($_POST["boutton"])) {
    // Récupérer les données du formulaire en s'assurant qu'elles existent
    $codecompteur = mysqli_real_escape_string($conn, $_POST["codecompteur"]);
    $type = mysqli_real_escape_string($conn, $_POST["type"]);
    $pu = mysqli_real_escape_string($conn, $_POST["pu"]);
    $codecli = mysqli_real_escape_string($conn, $_POST["codecli"]);

    // Vérifier que tous les champs sont remplis
    if (!empty($codecompteur) && !empty($type) && !empty($pu) && !empty($codecli)) {
        // Vérifier si codecli existe dans la table CLIENT
        $check_query_client = "SELECT 1 FROM CLIENT WHERE codecli = '$codecli'";
        $result_client = mysqli_query($conn, $check_query_client);

        if (mysqli_num_rows($result_client) > 0) {
            // Vérifier si codecompteur existe déjà dans la table COMPTEUR
            $check_query_compteur = "SELECT 1 FROM COMPTEUR WHERE codecompteur = '$codecompteur'";
            $result_compteur = mysqli_query($conn, $check_query_compteur);

            if (mysqli_num_rows($result_compteur) > 0) {
                $message = "Le code compteur est déjà utilisé.";
            } else {
                // Requête d'insertion corrigée
                $req = "INSERT INTO COMPTEUR (codecompteur, type, pu, codecli) 
                        VALUES ('$codecompteur', '$type', '$pu', '$codecli')";

                // Exécuter la requête
                if (mysqli_query($conn, $req)) {
                    // Redirection après l'ajout réussi
                    header("Location: ../view/compteur.php");
                    exit();
                } else {
                    // Afficher l'erreur SQL en cas d'échec
                    $message = "Erreur d'insertion : " . mysqli_error($conn);
                }
            }
        } else {
            $message = "Le code client est introuvable.";
        }
    } else {
        $message = "Veuillez remplir tous les champs.";
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
        <h2>Ajouter un compteur</h2>
        <p class="error-message">
            <?php if (isset($message)) echo $message; ?>
        </p>
        <form action="" method="POST">
            <label>code compteur</label>
            <input type="text" name="codecompteur" required>
            
            <label for="type">type:</label>
            <select id="type" name="type" required>
                <option value="EAU">Eau</option>
                <option value="ELECTRICITE">Electricité</option>
            </select><br>
            
            <label>pu</label>
            <input type="number" name="pu" required>

            <label>code client</label>
            <input type="text" name="codecli" required>

            <input type="submit" name="boutton" value="Ajouter">
        </form>
    </div>
</body>



</html>

