<?php 
include_once "../model/connect.php"; // Connexion à la base de données

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
    <link rel="stylesheet" href="css/fact.css"> <!-- Lien vers votre fichier CSS pour le style -->
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
   <h1>Liste des Clients</h1>
        
        <!-- Bouton pour ajouter un client -->


        <!-- Tableau pour afficher les clients -->
  <table>
            <thead>
                <tr>
                    <th>Code Client</th>
                    <th>Nom</th>
     
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
                         
                            <td>
                                <a href='../model/gen_pdf.php?codecli=" . htmlspecialchars($client['codecli']) . "'>Facture</a>
                                <a href='../model/historique.php?codecli=" . htmlspecialchars($client['codecli']) . "'>Historique 3 dernier facture</a>             
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

