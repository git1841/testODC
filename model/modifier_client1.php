<?php 
session_start();
include_once "connect_pdo.php"; // Connexion à la base de données

$codecli = isset($_GET['codecli']) ? $_GET['codecli'] : '';

if (!empty($codecli)) {
    // Préparer une requête SQL pour récupérer les détails du client
    $stmt = $pdo->prepare("SELECT * FROM CLIENT WHERE codecli = :codecli");
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
    <title>Modifier Client </title>
    <style>



body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f1fdf3;
    color: #2e4d34;
    display: flex;
    flex-direction: column;
    align-items: center;
}

/* Sidebar */
.sidebar {
    width: 220px;
    background-color: #2e7d32;
    color: white;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    padding: 20px 15px;
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
}

.sidebar .logo h2 {
    text-align: center;
    margin-bottom: 30px;
    color: #c8e6c9;
}

.sidebar nav ul {
    list-style: none;
    padding: 0;
}

.sidebar nav ul li {
    margin: 15px 0;
}

.sidebar nav ul li a {
    color: white;
    text-decoration: none;
    font-weight: bold;
    padding: 10px;
    display: block;
    border-radius: 6px;
    transition: background 0.3s ease;
}

.sidebar nav ul li a:hover {
    background-color: #388e3c;
}

/* Contenu principal */
.container {
    margin-left: 240px;
    padding: 30px;
    width: 100%;
    text-align: center;
}

.container h1 {
    color: #2e7d32;
    font-size: 2em;
    margin-bottom: 20px;
    text-align: center;
}

form {
    background-color: #ffffff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    max-width: 600px;
    margin: 0 auto;
}

form label {
    display: block;
    font-weight: bold;
    margin-top: 10px;
}

form input, form select {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border-radius: 5px;
    border: 1px solid #ddd;
}

form button {
    background-color: #2e7d32;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 20px;
    transition: background 0.3s ease;
}

form button:hover {
    background-color: #388e3c;
}

/* Responsive */
@media screen and (max-width: 768px) {
    .sidebar {
        width: 200px;
    }

    .container {
        margin-left: 220px;
        padding: 15px;
    }

    .sidebar .logo h2 {
        font-size: 1.5em;
    }

    .sidebar nav ul li a {
        font-size: 0.9em;
    }

    form {
        padding: 15px;
    }
}

@media screen and (max-width: 480px) {
    .sidebar {
        width: 180px;
    }

    .container {
        margin-left: 200px;
        padding: 10px;
    }

    .sidebar .logo h2 {
        font-size: 1.2em;
    }

    .sidebar nav ul li a {
        font-size: 0.8em;
    }

    form {
        width: 100%;
    }
}

</style>
</head>
<body>

   <!-- <a href='modifier.php?codecli=<?php echo htmlspecialchars($client['codecli']); ?>'>Modifier</a> -->

    <div class="container">
        <h1>Modifier Client : <?php echo htmlspecialchars($client['codecli']); ?></h1>
        
        <form action="modifier_client2.php" method="post">
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
