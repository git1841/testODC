
<?php 
session_start();
include_once "connect.php"; // Connexion à la base de données

$codecli = isset($_GET['codecli']) ? $_GET['codecli'] : '';

if (!empty($codecli)) {
    // Préparer une requête SQL pour récupérer les détails du client
    $stmt = $pdo->prepare("SELECT * FROM clients WHERE codecli = :codecli");
    $stmt->execute(['codecli' => $codecli]);
    
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
    <title>Modifier Client</title>
    <link rel="stylesheet" href="../view/css/modifier.css"> <!-- Lien vers votre fichier CSS pour le style -->
</head>
<body>

    <a href='modifier.php?codecli=<?php echo htmlspecialchars($client['codecli']); ?>'>Modifier</a>

    

    <div class="container">
        <h1>Modifier Client</h1>
        
        <form action="modifier_client.php" method="post">
            <input type="hidden" name="codecli" value="<?php echo htmlspecialchars($client['codecli']); ?>">
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($client['nom']); ?>" required><br>

            <label for="sexe">Sexe:</label>
            <select id="sexe" name="sexe" required>
                <option value="M" <?php if ($client['sexe'] == 'M') echo 'selected'; ?>>Masculin</option>
                <option value="F" <?php if ($client['sexe'] == 'F') echo 'selected'; ?>>Féminin</option>
            </select><br>

            <label for="quartier">Quartier:</label>
            <input type="text" id="quartier" name="quartier" value="<?php echo htmlspecialchars($client['quartier']); ?>" required><br>

            <label for="adresse">Adresse:</label>
            <input type="text" id="adresse" name="adresse" value="<?php echo htmlspecialchars($client['adresse']); ?>" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($client['email']); ?>" required><br>

            <label for="telephone">Téléphone:</label>
            <input type="text" id="telephone" name="telephone" value="<?php echo htmlspecialchars($client['telephone']); ?>" required><br>

            <button type="submit">Modifier</button>
        </form>
    </div>
</body>
</html>

