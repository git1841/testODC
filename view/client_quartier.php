<?php 
include_once "../model/connect.php"; // Connexion à la base de données

$sql = "SELECT quartier, GROUP_CONCAT(nom SEPARATOR ', ') AS noms FROM CLIENT GROUP BY quartier ORDER BY 
quartier"; // Requête pour récupérer les entrées par quartier
$query = mysqli_query($conn, $sql); 

if (!$query) {
    die("Erreur SQL : " . mysqli_error($conn));
}

// Récupérer les résultats sous forme de tableau associatif
$result = mysqli_fetch_all($query, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Clients par Quartier</title>
    <link rel="stylesheet" href="css/client.css"> <!-- Lien vers votre fichier CSS pour le style -->
</head>
<body>
    <div class="container">
        <h1>Liste des Clients par Quartier</h1>

        <!-- Tableau pour afficher les clients par quartier -->
        <table>
            <thead>
                <tr>
                    <th>Quartier</th>
                    <th>Clients</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Afficher les clients par quartier
                if (count($result) > 0) {
                    foreach ($result as $row) {
                        echo "<tr>
                            <td>" . htmlspecialchars($row['quartier']) . "</td>
                            <td>" . htmlspecialchars($row['noms']) . "</td>
                        </tr>";
                    }
                } else {
                     echo "<tr><td colspan='2'>Aucun client trouvé.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Retourner à la liste des clients -->
        <div class="bouton">
            <a href="client.php">Retourner à la Liste des Clients</a>
        </div>
    </div>
</body>
</html>
