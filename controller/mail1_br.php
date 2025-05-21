<?php
// Connexion à la base de données
$host = 'localhost';
$dbname = 'jirama';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Requêtes pour récupérer les données nécessaires
$queryClients = $pdo->query("SELECT codecli, nom FROM CLIENT");
$clients = $queryClients->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paiement des clients</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        .deja-payer {
            color: green;
        }
        .pas-encore-payer {
            color: red;
        }
    </style>
</head>
<body>

<h1>Liste des clients et leur état de paiement</h1>

<table>
    <thead>
        <tr>
            <th>Code Client</th>
            <th>Nom du Client</th>
            <th>Date de Paiement</th>
            <th>État du Paiement</th>
            <th>Envoyer de mail</th>
        </tr>
    </thead>
    <tbody>
<?php
foreach ($clients as $client) {
    $codecli = $client['codecli'];
    $nom = $client['nom'];

    // Récupérer les dates de paiement pour le client
    $queryPayer = $pdo->prepare("SELECT datepaie FROM PAYER WHERE codecli = ?");
    $queryPayer->execute([$codecli]);
    $datesPaie = $queryPayer->fetchAll(PDO::FETCH_COLUMN);

    foreach ($datesPaie as $datepaie) {
        // Récupérer le codecompteur pour le client
        $queryCompteur = $pdo->prepare("SELECT codecompteur FROM COMPTEUR WHERE codecli = ?");
        $queryCompteur->execute([$codecli]);
        $codecompteurs = $queryCompteur->fetchAll(PDO::FETCH_COLUMN);

        foreach ($codecompteurs as $codecompteur) {
            // Récupérer les dates de paiement pour le service Eau
            $queryPayerEau = $pdo->prepare("SELECT datepaie FROM PAYER WHERE codecli = ? AND service = 'Eau'");
            $queryPayerEau->execute([$codecli]);
            $datesPaieEau = $queryPayerEau->fetchAll(PDO::FETCH_COLUMN);

            // Récupérer les dates de paiement pour le service Eau
            $queryPayerCompteur = $pdo->prepare("SELECT datepaie FROM PAYER WHERE codecompteur = ? AND service = 'Compteur'");
            $queryPayerCompteur->execute([$codecompteur]);
            $datesPaieCompteur = $queryPayerCompteur->fetchAll(PDO::FETCH_COLUMN);

            // Vérifier si le paiement est encore en cours pour Eau
            if (empty($datesPaieEau)) {
                echo "<tr>";
                echo "<td>$codecli</td>";
                echo "<td>$nom</td>";
                echo "<td>$datepaie</td>";
                echo "<td class='pas-encore-payer'>Pas encore payé (Eau)</td>";
                echo "<td><a href='mail.php?codecli=$codecli'>Envoyer mail</a></td>";
                echo "</tr>";
            } else {
                echo "<tr>";
                echo "<td>$codecli</td>";
                echo "<td>$nom</td>";
                echo "<td>$datepaie</td>";
                echo "<td class='deja-payer'>Déjà payé (Eau)</td>";
                echo "<td>Mail pas disponible</td>";
                echo "</tr>";
            }

            // Vérifier si le paiement est encore en cours pour Compteur
            if (empty($datesPaieCompteur)) {
                echo "<tr>";
                echo "<td>$codecli</td>";
                echo "<td>$nom</td>";
                echo "<td>$datepaie</td>";
                echo "<td class='pas-encore-payer'>Pas encore payé (Compteur)</td>";
                echo "<td><a href='mail.php?codecli=$codecli'>Envoyer mail</a></td>";
                echo "</tr>";
            } else {
                echo "<tr>";
                echo "<td>$codecli</td>";
                echo "<td>$nom</td>";
                echo "<td>$datepaie</td>";
                echo "<td class='deja-payer'>Déjà payé (Compteur)</td>";
                echo "<td>Mail pas disponible</td>";
                echo "</tr>";
            }
        }
    }
}
?>
    </tbody>
</table>

</body>
</html>
