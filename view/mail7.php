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

// Requêtes pour récupérer les clients
$queryClients = $pdo->query("SELECT codecli, nom FROM CLIENT");
$clients = $queryClients->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paiement des clients</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; }
        .deja-payer { color: green; }
        .pas-encore-payer { color: red; }
    </style>
</head>
<body>

<h1>Liste des clients et leur état de paiement</h1>

<table>
    <thead>
        <tr>
            <th>Code Client</th>
            <th>Nom</th>
            <th>Date Paiement</th>
            <th>État Paiement</th>
            <th>Reste</th>
            <th>Envoyer Mail</th>
        </tr>
    </thead>
    <tbody>

<?php
foreach ($clients as $client) {
    $codecli = $client['codecli'];
    $nom = $client['nom'];

    // Récupérer les paiements
    $queryPayer = $pdo->prepare("SELECT datepaie, montant FROM PAYER WHERE codecli = ?");
    $queryPayer->execute([$codecli]);
    $paiements = $queryPayer->fetchAll(PDO::FETCH_ASSOC);

    foreach ($paiements as $paiement) {
        $datepaie = $paiement['datepaie'];
        $montant = $paiement['montant'];

        // --- Récupérer pu_eau ---
        $queryPuEau = $pdo->prepare("SELECT pu, codecompteur FROM COMPTEUR WHERE codecli = ? AND type = 'EAU'");
        $queryPuEau->execute([$codecli]);
        $resultEau = $queryPuEau->fetch(PDO::FETCH_ASSOC);
        $pu_eau = $resultEau['pu'] ?? 0;
        $codecompteur_eau = $resultEau['codecompteur'] ?? null;

        // --- Récupérer pu_elec ---
        $queryPuElec = $pdo->prepare("SELECT pu, codecompteur FROM COMPTEUR WHERE codecli = ? AND type = 'ELECTRICITE'");
        $queryPuElec->execute([$codecli]);
        $resultElec = $queryPuElec->fetch(PDO::FETCH_ASSOC);
        $pu_elec = $resultElec['pu'] ?? 0;
        $codecompteur_elec = $resultElec['codecompteur'] ?? null;

        // --- valeur2 (EAU) ---
        $valeur2 = 0;
        if ($codecompteur_eau) {
            $queryValEau = $pdo->prepare("SELECT valeur2 FROM EAU WHERE codecompteur = ?");
            $queryValEau->execute([$codecompteur_eau]);
            $valEau = $queryValEau->fetch(PDO::FETCH_ASSOC);
            $valeur2 = $valEau['valeur2'] ?? 0;
        }

        // --- valeur1 (ELEC) ---
        $valeur1 = 0;
        if ($codecompteur_elec) {
            $queryValElec = $pdo->prepare("SELECT valeur1 FROM ELEC WHERE codecompteur = ?");
            $queryValElec->execute([$codecompteur_elec]);
            $valElec = $queryValElec->fetch(PDO::FETCH_ASSOC);
            $valeur1 = $valElec['valeur1'] ?? 0;
        }

        // --- Calcul du reste ---
        $reste = $montant - (($pu_eau * $valeur2) + ($pu_elec * $valeur1));

        // --- Affichage ---
        echo "<tr>
                <td>$codecli</td>
                <td>$nom</td>
                <td>$datepaie</td>
                <td>" . (($reste >= 0) ? "<span class='deja-payer'>Déja payer</span>" : "<span class='pas-encore-payer'>pas encore payer</span>") . "</td>
                <td>" . number_format($reste, 2, ',', ' ') . " Ar</td>
                <td><button onclick=\"window.location.href='../controller/mail.php?codecli=$codecli';\">Envoyer mail</button></td>
              </tr>";
    }
}
?>

    </tbody>
</table>

</body>
</html>
