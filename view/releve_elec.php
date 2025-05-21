<?php
$host = 'localhost';
$dbname = 'jirama';  // Assurez-vous que la base est bien créée
$username = 'root';
$password = '';

// Connexion à MySQL
$conn = mysqli_connect($host, $username, $password, $dbname);

// Vérifier la connexion
if (!$conn) {
    die("Échec de la connexion : " . mysqli_connect_error());
}
//echo "Connexion réussie !";

$sql = "SELECT * FROM ELEC"; // Requête pour récupérer les entrées
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
    <title>Liste des Relevés Électriques</title>
    <link rel="stylesheet" href="css/releve_elec.css">  <!-- Lien vers le fichier CSS -->
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
          <h1>Gestion des Relevés Électriques</h1>

        <!-- Bouton pour ajouter un relevé -->
        <div class="bouton">
            <a href="../model/ajouter_releve_elec.php">Ajouter un Relevé</a>
        </div>
         <!-- Tableau pour afficher les relevés électriques -->
        <table>
            <thead>
                <tr>
                    <th>Code Relevé</th>
                    <th>Code Compteur</th>
                    <th>Valeur 1 (kWh)</th>
                    <th>Date Relevé</th>
                    <th>Date presentation</th>
                    <th>Date Limite Paiement</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                 // Vérifier si des résultats existent
                if (! empty($result) > 0) {
                    // Afficher chaque relevé dans une ligne du tableau
                    foreach ($result as $releve) {
                        echo "<tr>
                            <td>" . htmlspecialchars($releve['codeElec']) . "</td>
                            <td>" . htmlspecialchars($releve['codecompteur']) . "</td>
                            <td>" . htmlspecialchars($releve['valeur1']) . "</td>
                            <td>" . htmlspecialchars($releve['date_releve']) . "</td>
                            <td>" . htmlspecialchars($releve['date_presentation']) . "</td>
                            <td>" . htmlspecialchars($releve['date_limite_paie']) . "</td>
                            <td>
                                 <a href='../model/modifier_elec1.php?codeElec=" . htmlspecialchars($releve['codeElec']) . "'>Modifier</a>
                                 <a href='../model/sup_elec.php?codeElec=" . htmlspecialchars($releve['codeElec']) . "'>Supprimer</a>
                            </td>
                        </tr>";
                    }
                } else {
               echo "<tr><td colspan='6'>Aucun relevé trouvé</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
?>

