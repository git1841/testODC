<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de Recherche</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .search-results {
            margin-top: 20px;
        }
        .result-item {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<?php
// Connexion à la base de données MySQL avec PDO
$servername = "localhost";
$username = "root"; 
$password = "";   
$dbname = "jirama"; 

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Définir le mode d'erreur PDO à exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['query']) && !empty($_GET['query'])) {
        $searchTerm = $_GET['query'];

        // Préparation et exécution de la requête SQL pour rechercher des clients
        $sql = "SELECT * FROM CLIENT WHERE nom LIKE :query ";
        $stmt = $conn->prepare($sql);
        $searchQuery = '%' . htmlspecialchars($searchTerm) . '%';
        $stmt->bindParam(':query', $searchQuery, PDO::PARAM_STR);
        $stmt->execute();

        // Récupération des résultats
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($results) {
            echo '<div class="search-results">';
            foreach ($results as $row) {
                echo '<div class="result-item">';
                echo 'Nom: ' . htmlspecialchars($row['nom']) . '<br>';
                echo 'sexe: ' . htmlspecialchars($row['sexe']) . '<br>';
                echo 'quartier: ' . htmlspecialchars($row['quartier']) . '<br>';
                echo 'niveau: ' . htmlspecialchars($row['niveau']) . '<br>';
                echo 'mail: ' . htmlspecialchars($row['mail']) . '<br>';
                
                // Ajoutez ici d'autres champs que vous souhaitez afficher
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<p>Aucun résultat trouvé pour la recherche "' . htmlspecialchars($searchTerm) . '".</p>';
        }
    } else {
        echo '<p>Aucune requête de recherche fournie.</p>';
    }

} catch (PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}

// Fermeture de la connexion à la base de données
$conn = null;
?>

</body>
</html>
