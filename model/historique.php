<?php
// Vérifier si le paramètre codecli est présent dans l'URL
if (isset($_GET['codecli']) && !empty($_GET['codecli'])) {
    $codecli = $_GET['codecli'];
    $fichier_csv = "data.csv";

    // Tableau pour stocker les lignes correspondantes
    $occurrences = [];

    // Ouvrir le fichier CSV en mode lecture
    if (($handle = fopen($fichier_csv, 'r')) !== FALSE) {
        // Lire chaque ligne du fichier
        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
            // Vérifier si la première colonne correspond au codecli recherché
            if ($data[0] === $codecli) {
                // Ajouter la ligne à la liste des occurrences
                $occurrences[] = $data;
            }
        }

        // Fermer le fichier CSV
        fclose($handle);

        // Prendre les 3 dernières occurrences
        $dernieres_occurrences = array_slice(array_reverse($occurrences), 0, 3);
    } else {
        echo "Erreur : Impossible d'ouvrir le fichier CSV.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Historique des Transactions</title>
    <style>
        body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f1fdf3;
    color: #2e4d34;
    display: flex;
    flex-direction: column;
    align-items: center;
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
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
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
    text-align: center;
}

.container h1 {
    color: #2e7d32;
    font-size: 2em;
    margin-bottom: 20px;
    text-align: center;
}

table {
    width: 60%;
    margin-top: 20px;
    border-collapse: collapse;
    margin: 0 auto;
}

table th, table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}

table th {
    background-color: #f2f2f2;
}

table td {
    font-size: 1em;
    color: #2e4d34;
}

table td strong {
    font-weight: bold;
}

p {
    font-size: 1.2em;
    font-weight: bold;
    margin-top: 20px;
}

/* Responsive */
@media screen and (max-width: 768px) {
    .sidebar {
        width: 200px;
    }

    .container {
        margin-left: 220px;
        padding: 15px;
    }

    .sidebar .logo h2 {
        font-size: 1.5em;
    }

    .sidebar nav ul li a {
        font-size: 0.9em;
    }

    table {
        width: 80%;
    }
}

@media screen and (max-width: 480px) {
    .sidebar {
        width: 180px;
    }

    .container {
        margin-left: 200px;
        padding: 10px;
    }

    .sidebar .logo h2 {
        font-size: 1.2em;
    }

    .sidebar nav ul li a {
        font-size: 0.8em;
    }

    table {
        width: 90%;
    }
}

    </style>
</head>
<body>

<h1>Historique des Transactions pour le code client <?php echo htmlspecialchars($codecli ?? ''); ?></h1>

<?php
if (isset($dernieres_occurrences) && !empty($dernieres_occurrences)) {
    $total = 0;
    ?>
    <table>
        <thead>
            <tr>
                <th>Code Client</th>
                <th>Nom du Client</th>
                <th>Somme</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dernieres_occurrences as $occurrence) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($occurrence[0]); ?></td>
                    <td><?php echo htmlspecialchars($occurrence[1]); ?></td>
                    <td><?php 
                        $somme = floatval($occurrence[2]);
                        echo number_format($somme, 2, ',', ' ') . ' Ar';
                        $total += $somme;
                    ?></td>
                    <td><?php echo htmlspecialchars($occurrence[3]); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <p><strong>Total des 3 dernières transactions : </strong> <?php echo number_format($total, 2, ',', ' ') . ' Ar'; ?></p>
<?php
} else {
    echo "<p>Aucune transaction trouvée pour le code client $codecli.</p>";
}
?>

</body>
</html>
