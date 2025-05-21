

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Client</title>
    <link rel="stylesheet" href="../view/css/edit.css"> <!-- Lien vers votre fichier CSS pour le style -->
</head>
<body>
    <div class="container">
        <h1>Modifier Client</h1>
        
        <form action="edit.php" method="post">
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

            <label for="niveau">Niveau:</label>
            <input type="text" id="niveau" name="niveau" value="<?php echo htmlspecialchars($client['niveau']); ?>" required><br>

            <label for="mail">Email:</label>
            <input type="email" id="mail" name="mail" value="<?php echo htmlspecialchars($client['mail']); ?>" required><br>

            <button type="submit">Modifier</button>
        </form>
    </div>
</body>
</html>
