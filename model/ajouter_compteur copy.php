<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un compteur</title>
   
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
input[type="text"],
input[type="int"] {
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
    <?php
    echo "Connexion réussie !";
    include_once "connect.php"; // Connexion à la base

    if (isset($_POST["boutton"])) {
        // Récupérer les données du formulaire en s'assurant qu'elles existent
        $codecompteur = mysqli_real_escape_string($conn, $_POST["codecompteur"]);
        $type = mysqli_real_escape_string($conn, $_POST["type"]);
        $pu = mysqli_real_escape_string($conn, $_POST["pu"]);
        $codecli= mysqli_real_escape_string($conn, $_POST["codecli"]);  
       
       


        // Vérifier que tous les champs sont remplis
        if (!empty($codecompteur) && !empty($type) && !empty($pu) && !empty( $codecli)) {
            // Requête d'insertion corrigée
            $req = "INSERT INTO COMPTEUR (codecompteur, type, pu, codecli) 
            VALUES ('$codecompteur', '$type', '$pu', '$codecli')";

            // Exécuter la requête
            if (mysqli_query($conn, $req)) {
                // Redirection après l'ajout réussi
                header("Location: compteur.php");
                exit();
            } else {
                // Afficher l'erreur SQL en cas d'échec
                $message = "Erreur d'insertion : " . mysqli_error($conn);
            }
        } else {
            $message = "Veuillez remplir tous les champs.";
        }
    }
    ?>
    
    <div class="container">
        <h2>Ajouter un compteur</h2>
        <p style="color:red;">
            <?php if (isset($message)) echo $message; ?>
        </p>
        <form action="" method="POST">
            <label>code compteur</label>
            <input type="text" name="codecompteur" required>
    
            <label>type</label>
            <input type="text" name="type" required>
    
            <label>pu</label>
            <input type="text" name="pu" required>

            <label>code client</label>
            <input type="text" name="codecli" required>

        

            <input type="submit" value="Ajouter" name="boutton">
        </form>
    </div>
</body>
</html>

