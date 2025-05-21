

<?php 

// Récupérer les paramètres de l'URL actuelle
//const params = new URLSearchParams(window.location.search);

// Récupérer la valeur du paramètre 'codecli'
//const codecli = params.get('codecli');

//console.log(codecli); // Afficher la valeur dans la console


include_once "connect.php"; // Connexion à la base de données

// Récupérer le paramètre 'codecli' depuis l'URL
if (isset($_GET['codecli'])) {
    $codecli = intval($_GET['codecli']);

   
    
} else {
    
    die("Paramètre 'codecli' manquant.");
}

echo "CodeCLI récupéré : " . htmlspecialchars($codecli) . "<br>";


$sql = "SELECT * FROM CLIENT WHERE codecli = ?"; // Requête pour récupérer le client spécifié
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $codecli);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($client = mysqli_fetch_assoc($result)) {
    // Afficher les données du client trouvé
    echo "<tr>
            <td>" . htmlspecialchars($client['codecli']) . "</td>
            <td>" . htmlspecialchars($client['nom']) . "</td>
            <td>" . htmlspecialchars($client['sexe']) . "</td>
            <td>" . htmlspecialchars($client['quartier']) . "</td>
            <td>" . htmlspecialchars($client['niveau']) . "</td>
            <td>" . htmlspecialchars($client['mail']) . "</td>
            
        </tr>";
} else {
    echo "<tr><td colspan='7'>Aucun client trouvé avec le codecli spécifié.</td></tr>";
}





?>





<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Client</title>
    <link rel="stylesheet" href="modifier.css"> <!-- Lien vers votre fichier CSS pour le style -->
</head>
<body>

    <a href='modifier.php?codecli=<?php echo htmlspecialchars($client['codecli']); ?>'>Modifier</a>

    

    <div class="container">
        <h1>Modifier Client</h1>
        
        <form action="modifier_client.php" method="post">
            <input type="hidden" name="codecli" value="<?php echo htmlspecialchars($client['codecli']); ?>">
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" value="<?php  htmlspecialchars($client['nom']); ?>" required><br>

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
