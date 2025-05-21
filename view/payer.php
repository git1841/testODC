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


$sql = "SELECT * FROM PAYER"; // Requête pour récupérer les entrées
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
    <title>Liste des Paiements</title>

    <style>
        /* Style général */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f1fdf3;
            color: #2e4d34;
            display: flex;
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
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
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
        }

        .container h1 {
            color: #2e7d32;
            font-size: 2em;
            margin-bottom: 20px;
        }

        /* Boutons */
        .bouton {
            margin-bottom: 20px;
        }

        .bouton a {
            text-decoration: none;
            color: white;
            background-color: #4caf50;
            padding: 10px 15px;
            border-radius: 5px;
            margin-right: 10px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .bouton a:hover {
            background-color: #388e3c;
        }

        /* Tableau */
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,128,0,0.1);
        }

        thead {
            background-color: #a5d6a7;
            color: #1b5e20;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        tbody tr:hover {
            background-color: #f0fdf4;
        }

        td a {
            text-decoration: none;
            color: #2e7d32;
            font-weight: bold;
            margin-right: 10px;
            transition: color 0.3s ease;
        }

        td a:hover {
            color: #1b5e20;
        }
    </style>
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
                        <h1>Gestion des Paiements</h1>

        <!-- Bouton pour ajouter un paiement -->
        <div class="bouton">
            <a href="../model/ajouter_un_paiement.php">Ajouter un Paiement</a>
        </div>

        <!-- Tableau pour afficher les paiements -->
                  <table>
            <thead>
                <tr>
                    <th>ID Paiement</th>
                    <th>Code Client</th>
                    <th>Date Paiement</th>
                    <th>Montant payer</th>
                    <th>Actions</th>
               </tr>
            </thead>
            <tbody>
                <?php
                // Vérifier si des résultats existent
                if (!empty($result)){
                    // Afficher chaque paiement dans une ligne du tableau
                       foreach ($result as $payer) {
                        echo "<tr>
                            <td>" . htmlspecialchars($payer['idpaye']) . "</td>
                            <td>" . htmlspecialchars($payer['codecli']) . "</td>
                            <td>" . htmlspecialchars($payer['datepaie']) . "</td>
                            <td>" . htmlspecialchars($payer['montant']) . " Ar</td>
                            <td>
                                <a href='../model/modifier_payer1.php?idpaye=" . htmlspecialchars($payer['idpaye']) . "'>Modifier</a>
                                <a href='../model/sup_payer.php?idpaye=" . htmlspecialchars($payer['idpaye']) . "'>Supprimer</a>
                         </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Aucun paiement trouvé</td></tr>";
                }
                ?>
            </tbody>
       </div>
</body>
</html>

<?php
?>