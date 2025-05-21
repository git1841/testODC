<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche Client</title>
    <link rel="stylesheet" href="../view/css/styles.css">
</head>
<body>
    <div class="search-bar">
        <form action="recherche.php" method="GET">
            <input type="text" name="query" placeholder="Recherche client..." value="<?php echo isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>">
            <button type="submit">Rechercher</button>
        </form>
    </div>

    <?php
    // Connexion à la base de données MySQL avec PDO
    $servername = "localhost";
    $username = "root"; // Remplacez par votre nom d'utilisateur
    $password = "";   // Remplacez par votre mot de passe
    $dbname = "jirama"; // Remplacez par le nom de votre base de données

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // Définir le mode d'erreur PDO à exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (isset($_GET['query']) && !empty($_GET['query'])) {
            $searchTerm = $_GET['query'];
            
            // Préparation et exécution de la requête SQL pour rechercher des clients
            $sql = "SELECT * FROM CLIENT WHERE nom LIKE :query OR prenom LIKE :query";
            $stmt = $conn->prepare($sql);
            $searchQuery = '%' . $searchTerm . '%';
            $stmt->bindParam(':query', $searchQuery, PDO::PARAM_STR);
            $stmt->execute();

            // Récupération des résultats
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($results) {
                echo '<div class="results-container">';
                foreach ($results as $row) {
                    echo '<div class="result-item">';
                    echo 'Nom: ' . htmlspecialchars($row['nom']) . '<br>';
                    echo 'Prénom: ' . htmlspecialchars($row['prenom']) . '<br>';
                    // Ajoutez ici d'autres champs que vous souhaitez afficher
                    echo '</div>';
                }
                echo '</div>';
            } else {
                echo '<p>Aucun résultat trouvé.</p>';
            }
        }
    } catch (PDOException $e) {
        die("Erreur de connexion: " . $e->getMessage());
    }

    // Fermeture de la connexion à la base de données
    $conn = null;
    ?>
</body>
</html>
