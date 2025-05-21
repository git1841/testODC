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
            <th>Nom du client</th>
            <th>Date de paiement</th>
            <th>État de paiement</th>
        </tr>
    </thead>
    <tbody>
<?php
foreach ($clients as $client) {
    $codecli = $client['codecli'];
    $nom = $client['nom'];

    // Récupérer les dates de paiement pour le client courant
    $queryPayer = $pdo->prepare("SELECT datepaie FROM PAYER WHERE codecli = :codecli");
    $queryPayer->execute([':codecli' => $codecli]);
    $datesPaie = $queryPayer->fetchAll(PDO::FETCH_COLUMN);

    foreach ($datesPaie as $datepaie) {
        // Récupérer le codecompteur pour la date de paiement
        $queryCompteur = $pdo->prepare("SELECT codecompteur FROM COMPTEUR WHERE datepaie = :datepaie");
        $queryCompteur->execute([':datepaie' => $datepaie]);
        $codecompteur = $queryCompteur->fetchColumn();

        if ($codecompteur) {
            // Récupérer les dates de présentation et de limite de paiement pour le codecompteur
            $queryElec = $pdo->prepare("SELECT date_presentation, date_limite_paie FROM ELEC WHERE codecompteur = :codecompteur");
            $queryElec->execute([':codecompteur' => $codecompteur]);
            $elecData = $queryElec->fetch(PDO::FETCH_ASSOC);

            if ($elecData) {
                $date_presentation = new DateTime($elecData['date_presentation']);
                $date_limite_paie = new DateTime($elecData['date_limite_paie']);
                $datePaieObj = new DateTime($datepaie);

                // Vérifier si la date de paiement est entre les dates de présentation et de limite
                if ($datePaieObj >= $date_presentation && $datePaieObj <= $date_limite_paie) {
                    $etatPaiement = 'deja payer';
                    $class = 'deja-payer';
                } else {
                    $etatPaiement = 'pas encore payé';
                    $class = 'pas-encore-payer';
                }
            } else {
                $etatPaiement = 'données manquantes';
                $class = '';
            }
        } else {
            $etatPaiement = 'codecompteur non trouvé';
            $class = '';
        }

        echo "<tr>
                <td>$codecli</td>
                <td>$nom</td>
                <td>$datepaie</td>
                <td class='$class'>$etatPaiement</td>
              </tr>";
    }
}
?>
    </tbody>
</table>

</body>
</html>
