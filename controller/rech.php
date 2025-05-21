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
            <input type="text" name="query" placeholder="Recherche client...">
            <button type="submit">Rechercher</button>
        </form>
    </div>

    <?php
    // Connexion à la base de données (ajuster les paramètres selon votre configuration)
    $servername = "localhost";
    $username = "root"; // Remplacez par votre nom d'utilisateur de la base de données
    $password = ""; // Remplacez par votre mot de passe de la base de données
    $dbname = "jirama"; // Remplacez par le nom de votre base de données

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (isset($_GET['query'])) {
            $searchQuery = $_GET['query'];
            $stmt = $conn->prepare("SELECT * FROM CLIENT WHERE nom LIKE :query ");
            $searchQuery = '%' . $searchQuery . '%';
            $stmt->bindParam(':query', $searchQuery, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($results) {
                echo '<div class="results-container">';
                foreach ($results as $row) {
                    echo '<div class="result-item">';
                    echo 'Nom: ' . htmlspecialchars($row['nom']) . '<br>';

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

    $conn = null;
    ?>
</body>
</html>
