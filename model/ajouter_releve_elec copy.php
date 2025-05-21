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
input[type="email"] {
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
    include_once "connect.php"; // Connexion à la base  date_presentation

    if (isset($_POST["boutton"])) {
        // Récupérer les données du formulaire en s'assurant qu'elles existent
        $codeElec= mysqli_real_escape_string($conn, $_POST["codeElec"]);
        $codecompteur = mysqli_real_escape_string($conn, $_POST["codecompteur"]);
        $valeur1 = mysqli_real_escape_string($conn, $_POST["valeur1"]);
        //$date_releve = mysqli_real_escape_string($conn, $_POST["date_releve"]);  
        //$date_presentation= mysqli_real_escape_string($conn, $_POST["date_presentation"]);
        //$date_limite_paie = mysqli_real_escape_string($conn, $_POST["date_limite_paie"]);

        // Récupérer les dates en tant que chaînes de caractères
        $date_releve_str = $_POST["date_releve"];
        $date_presentation_str = $_POST["date_presentation"];
        $date_limite_paie_str = $_POST["date_limite_paie"];

        // Convertir les chaînes de caractères en objets DateTime
        $date_releve = new DateTime($date_releve_str);
        $date_presentation = new DateTime($date_presentation_str);
        $date_limite_paie = new DateTime($date_limite_paie_str);

        // Formater les dates au format Y-m-d pour insertion dans la base de données
        $date_releve_formatted = $date_releve->format('Y/m/d');
        $date_presentation_formatted = $date_presentation->format('Y/m/d');
        $date_limite_paie_formatted = $date_limite_paie->format('Y/m/d');

        $date_releve = $date_releve_formatted;
        $date_presentation = $date_presentation_formatted;
        $date_limite_paie = $date_limite_paie_formatted;




        // Vérifier que tous les champs sont remplis
        if (!empty($codeElec) && !empty($codecompteur) && !empty($valeur1) && !empty( $date_releve) && !empty( $date_presentation) && !empty( $date_limite_paie )) {
            // Requête d'insertion corrigée
            $req = "INSERT INTO ELEC(codeElec, codecompteur, valeur1, date_releve, date_presentation, date_limite_paie) 
            VALUES ('$codeElec', '$codecompteur', '$valeur1', '$date_releve', '$date_presentation', '$date_limite_paie')";

            // Exécuter la requête
            if (mysqli_query($conn, $req)) {
                // Redirection après l'ajout réussi
                header("Location: releve_elec.php");
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
        <h2>Ajouter un Releve</h2>
        <p style="color:red;">
            <?php if (isset($message)) echo $message; ?>
        </p>
        <form action="" method="POST">
            <label>code Electricité</label>
            <input type="text" name="codeElec" required>
    
            <label>code compteur</label>
            <input type="text" name="codecompteur" required>
    
            <label>valeur</label>
            <input type="text" name="valeur1" required>

            <label> date releve</label>
            <input type="date" name="date_releve" required>

            <label>date présentaton</label>
            <input type="date" name="date_presentation" required>
             
            <label>date limite paiement</label>
            <input type="date" name="date_limite_paie" required>

            <input type="submit" value="Ajouter" name="boutton">
        </form>
    </div>
</body>
</html>

