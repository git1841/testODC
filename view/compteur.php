<?php 
include_once "../model/connect.php"; // Connexion à la base de données

$sql = "SELECT * FROM COMPTEUR"; // Requête pour récupérer les entrées
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
    <title>Liste des Compteurs</title>
    <link rel="stylesheet" href="css/compteur.css">  <!-- Assurez-vous que le fichier CSS est dans le bon répertoire -->
</head>
<body>

<div class="sidebar">
        <div class="logo">
            <h2>Gestion</h2>
        </div>
        <nav>
            <ul>
            <li><a href="page_acceuille.php">Acceuille</a></li>
                <li><a href="client.php">Clients</a></li>
                <li><a href="compteur.php">Compteurs</a></li>
                <li><a href="releve_elec.php">Relevé Électrique</a></li>
                <li><a href="releve_eau.php">Relevé Eau</a></li>
                <li><a href="payer.php">Payer</a></li>
                <li><a href="fact.php">Facture</a></li>
                <li><a href="list_client_pas1.php">Autre list</a></li>
                <li><a href="mail8.php">Email</a></li>
            </ul>
        </nav>
</div> 





    <div class="container">
        <h1>Gestion des Compteurs</h1>
<!-- Bouton pour ajouter un compteur -->
        <div class="bouton">
            <a href="../model/ajouter_compteur.php">Ajouter un Compteur</a>
        </div>

        <!-- Tableau pour afficher les compteurs -->
        <table>
            <thead><tr>
                    <th>Code Compteur</th>
                    <th>Type</th>
                    <th>PU</th>
                    <th>Code Client</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Vérifier si des résultats existent
                 if (!empty($result))
                {
                    // Afficher chaque compteur dans une ligne de tableau
                foreach ($result as $compteur) {
                        echo "<tr>
                            <td>" . htmlspecialchars($compteur['codecompteur']) . "</td>
                            <td>" . htmlspecialchars($compteur['type']) . "</td>
                            <td> " . htmlspecialchars($compteur['pu']) . " Ar (Kwh/m³) </td>
                            <td>" . htmlspecialchars($compteur['codecli']) . "</td>
                            <td>
                            <a href='../model/modifier_compteur1.php?codecompteur=" . htmlspecialchars($compteur['codecompteur']) . "'>Modifier</a>
                            <a href='../model/sup_compteur.php?codecompteur=" . htmlspecialchars($compteur['codecompteur']) . "'>Supprimer</a>
                            </td>
                        </tr>";
                    }
                } else {
                    "<tr><td colspan='5'>Aucun compteur trouvé</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
