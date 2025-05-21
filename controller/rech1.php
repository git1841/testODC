<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de Recherche</title>
    <style>

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 20px;
        background-color: #f3fdf5;
        color: #2e4d34;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        box-shadow: 0 2px 10px rgba(0, 100, 0, 0.1);
        background-color: #ffffff;
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    table:hover {
        transform: scale(1.01);
    }

    th, td {
        border-bottom: 1px solid #e2f0e6;
        padding: 12px 15px;
        text-align: left;
        transition: background-color 0.2s ease;
    }

    th {
        background-color: #4CAF50;
        color: white;
        position: sticky;
        top: 0;
        z-index: 2;
    }

    tr:nth-child(even) {
        background-color: #f0faf2;
    }

    tr:hover td {
        background-color: #d3f5dd;
        cursor: pointer;
    }

    p {
        font-size: 1.1em;
        padding: 10px;
        background-color: #e8f5e9;
        border-left: 5px solid #4CAF50;
        border-radius: 4px;
        max-width: 600px;
        margin: 20px auto;
    }


</style>

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
            echo '<table>';
            echo 
'<thead><tr><th>Nom</th><th>Sexe</th><th>Quartier</th><th>Niveau</th><th>Mail</th></tr></thead>';
            echo '<tbody>';

            foreach ($results as $row) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['nom']) . '</td>';
                echo '<td>' . htmlspecialchars($row['sexe']) . '</td>';
                echo '<td>' . htmlspecialchars($row['quartier']) . '</td>';
                echo '<td>' . htmlspecialchars($row['niveau']) . '</td>';
                echo '<td>' . htmlspecialchars($row['mail']) . '</td>';
                echo '</tr>';
            }

            echo '</tbody></table>';
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
