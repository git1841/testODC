<?php 
include_once "connect.php"; // Connexion à la base de données

$sql = "SELECT * FROM CLIENT"; // Requête pour récupérer les entrées
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
    <title>Liste des Clients</title>
    <link rel="stylesheet" href="client.css"> <!-- Lien vers votre fichier CSS pour le style -->
</head>
<body>
    <div class="container">
   <h1>Liste des Clients</h1>
        
        <!-- Bouton pour ajouter un client -->
        <div class="bouton">
            <a href="ajouter_client.php">Ajouter un Client</a>
        </div>

        <!-- Tableau pour afficher les clients -->
  <table>
            <thead>
                <tr>
                    <th>Code Client</th>
                    <th>Nom</th>
                    <th>Sexe</th>
                    <th>Quartier</th>
                    <th>Niveau</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Afficher les clients
                if (count($result) > 0) {
                foreach ($result as $client) {
                        echo "<tr>
                            <td>" . htmlspecialchars($client['codecli']) . "</td>
                            <td>" . htmlspecialchars($client['nom']) . "</td>
                            <td>" . htmlspecialchars($client['sexe']) . "</td>
                            <td>" . htmlspecialchars($client['quartier']) . "</td>
                            <td>" . htmlspecialchars($client['niveau']) . "</td>
                            <td>" . htmlspecialchars($client['mail']) . "</td>
                            <td>
                                <a href='modifier.php?codecli=" . htmlspecialchars($client['codecli']) . "'>Modifier</a>
                                <a href='sup_client.php?codecli=" . htmlspecialchars($client['codecli']) . "'>Supprimer</a>             
                            </td>
                        </tr>";
                    }
                } else {
                     echo "<tr><td colspan='7'>Aucun client trouvé.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

