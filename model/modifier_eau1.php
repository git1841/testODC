<?php 
session_start();
include_once "connect_pdo.php"; // Connexion à la base de données

$codeEau = isset($_GET['codeEau']) ? $_GET['codeEau'] : '';

if (!empty($codeEau)) {
    // Préparer une requête SQL pour récupérer les détails du client
    $stmt = $pdo->prepare("SELECT * FROM EAU WHERE codeEau = :codeEau");
    $stmt->execute(['codeEau' => $codeEau]);
    
    // Récupérer le client correspondant
    $client = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Vérifier si un client a été trouvé
if (empty($client)) {
    echo "Client non trouvé.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Client </title>

    <style>


body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f1fdf3; /* fond vert très clair */
    margin: 0;
    padding: 0;
}

.container {
    max-width: 500px;
    margin: 40px auto;
    padding: 30px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    color: #2e7d32; /* vert foncé */
    margin-bottom: 25px;
}

form label {
    display: block;
    margin-top: 15px;
    color: #2e4d34; /* vert plus foncé */
    font-weight: bold;
}

form input,
form select {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #b2dfdb;
    border-radius: 6px;
    font-size: 14px;
    box-sizing: border-box;
}

form input:focus,
form select:focus {
    outline: none;
    border-color: #2e7d32;
    box-shadow: 0 0 4px rgba(46, 125, 50, 0.3);
}

button {
    margin-top: 25px;
    width: 100%;
    padding: 12px;
    background-color: #2e7d32;
    color: white;
    font-size: 16px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #388e3c; /* vert plus clair */
}

p {
    color: #c62828; /* rouge foncé pour erreurs */
    font-weight: bold;
    text-align: center;
}


</style>
</head>
<body>

   <!-- <a href='modifier.php?codecli=<?php echo htmlspecialchars($client['codecli']); ?>'>Modifier</a> -->

    <div class="container">
        <h1>Modifier Client : <?php echo htmlspecialchars($client['codeEau']); ?></h1>
        
        <form action="modifier_eau2.php" method="post">
            <input type="hidden" name="codeEau" value="<?php echo htmlspecialchars($client['codeEau']); ?>">
            
            <label for="codecompteur">codecompteur:</label>
            <input type="text" id="codecompteur" name="codecompteur" value="<?php echo htmlspecialchars($client['codecompteur']); ?>" required><br>

            <label for="valeur2">valeur2:</label>
            <input type="number" id="valeur2" name="valeur2" value="<?php echo htmlspecialchars($client['valeur2']); ?>" required><br>

            <label for="date_releve2">date_releve2:</label>
            <input type="date" id="date_releve2" name="date_releve2" value="<?php echo htmlspecialchars($client['date_releve2']); ?>" required><br>

            <label for="date_presentation2">date_releve2:</label>
            <input type="date" id="date_presentation2" name="date_presentation2" value="<?php echo htmlspecialchars($client['date_presentation2']); ?>" required><br>

            <label for="date_limite_paie2">date_limite_paie2:</label>
            <input type="date" id="date_limite_paie2" name="date_limite_paie2" value="<?php echo htmlspecialchars($client['date_limite_paie2']); ?>" required><br>


            <button type="submit">Modifier</button>
        </form>
    </div>

</body>
</html>
