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
        /* Style général */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f0f9f4;
    color: #333;
    display: flex;
    flex-direction: column;
    align-items: center;
}

h1 {
    font-size: 2em;
    margin: 20px 0;
    color: #388e3c;
}

/* Tableau */
table {
    width: 90%;
    max-width: 1200px;
    margin-top: 20px;
    border-collapse: collapse;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 128, 0, 0.1);
}

th, td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #a5d6a7;
    color: #1b5e20;
}

tbody tr:hover {
    background-color: #f1f8f5;
}

/* État de paiement */
.deja-payer {
    color: green;
    font-weight: bold;
}

.pas-encore-payer {
    color: red;
    font-weight: bold;
}

/* Boutons "Envoyer mail" */
button {
    background-color: #2196f3;
    color: white;
    padding: 8px 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #1976d2;
}

button:focus {
    outline: none;
}

/* Ajout des marges pour le tableau */
td {
    vertical-align: middle;
}

/* Espacement des en-têtes */
thead th {
    font-size: 1.1em;
}

/* Mobile responsif */
@media (max-width: 768px) {
    table {
        width: 100%;
    }

    th, td {
        font-size: 0.9em;
    }

    h1 {
        font-size: 1.6em;
    }
}

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
                <td>" . (($reste >= 0) ? "<span class='deja-payer'>À jour</span>" : "<span class='pas-encore-payer'>Impayé</span>") . "</td>
                <td>" . number_format($reste, 2, ',', ' ') . " Ar</td>
                <td><button onclick=\"window.location.href='../controller/mail.php?codecli=$codecli';\">Envoyer mail</button></td>
              </tr>";
    }
}

// Ajouter les clients sans paiement
$queryClientsSansPaiement = $pdo->query("
    SELECT codecli, nom 
    FROM CLIENT 
    WHERE codecli NOT IN (SELECT DISTINCT codecli FROM PAYER)
");

$clientsSansPaiement = $queryClientsSansPaiement->fetchAll(PDO::FETCH_ASSOC);

foreach ($clientsSansPaiement as $client) {
    $codecli = $client['codecli'];
    $nom = $client['nom'];
    $montant = 0;

    // Récupérer pu_eau
    $queryPuEau = $pdo->prepare("SELECT pu, codecompteur FROM COMPTEUR WHERE codecli = ? AND type = 'EAU'");
    $queryPuEau->execute([$codecli]);
    $resultEau = $queryPuEau->fetch(PDO::FETCH_ASSOC);
    $pu_eau = $resultEau['pu'] ?? 0;
    $codecompteur_eau = $resultEau['codecompteur'] ?? null;

    // Récupérer pu_elec
    $queryPuElec = $pdo->prepare("SELECT pu, codecompteur FROM COMPTEUR WHERE codecli = ? AND type = 'ELECTRICITE'");
    $queryPuElec->execute([$codecli]);
    $resultElec = $queryPuElec->fetch(PDO::FETCH_ASSOC);
    $pu_elec = $resultElec['pu'] ?? 0;
    $codecompteur_elec = $resultElec['codecompteur'] ?? null;

    // valeur2 (eau)
    $valeur2 = 0;
    if ($codecompteur_eau) {
        $queryValEau = $pdo->prepare("SELECT valeur2 FROM EAU WHERE codecompteur = ?");
        $queryValEau->execute([$codecompteur_eau]);
        $valEau = $queryValEau->fetch(PDO::FETCH_ASSOC);
        $valeur2 = $valEau['valeur2'] ?? 0;
    }

    // valeur1 (elec)
    $valeur1 = 0;
    if ($codecompteur_elec) {
        $queryValElec = $pdo->prepare("SELECT valeur1 FROM ELEC WHERE codecompteur = ?");
        $queryValElec->execute([$codecompteur_elec]);
        $valElec = $queryValElec->fetch(PDO::FETCH_ASSOC);
        $valeur1 = $valElec['valeur1'] ?? 0;
    }

    // Calcul du reste
    $reste = $montant - (($pu_eau * $valeur2) + ($pu_elec * $valeur1));
    $x = $reste;

    // Affichage
    echo "<tr>
            <td>$codecli</td>
            <td>$nom</td>
            <td>-</td>
            <td class='pas-encore-payer'>Jamais payé</td>
            <td>" . number_format($reste, 2, ',', ' ') . " Ar</td>
            <td><button onclick=\"window.location.href='../controller/mail.php?codecli=$codecli';\">Envoyer mail</button></td>
          </tr>";


          
}
?>

    </tbody>
</table>

</body>
</html>
