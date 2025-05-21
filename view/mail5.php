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
            <th>Reste</th>
            <th>   Envoyer de mail  </th>
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
            // Récupérer les dates de présentation et limite pour le codecompteur
            $queryElec = $pdo->prepare("SELECT date_presentation, date_limite_paie FROM ELEC WHERE codecompteur = ?");
            $queryElec->execute([$codecompteur]);
            $elecData = $queryElec->fetch(PDO::FETCH_ASSOC);

            if ($elecData) {
                $datePresentation = new DateTime($elecData['date_presentation']);
                $dateLimitePaie = new DateTime($elecData['date_limite_paie']);
                $datePaie = new DateTime($datepaie);

                // Vérifier si la date de paiement est entre les deux dates
                if ($datePaie >= $datePresentation && $datePaie <= $dateLimitePaie) {
                    echo "<tr>
                            <td>$codecli</td>
                            <td>$nom</td>
                            <td>$datepaie</td>
                            <td class='deja-payer'>Déjà payé (Électricité)</td>
                            <td class='a completer '>a completer </td>
                            <td><button onclick=\"window.location.href='../controller/mail.php?codecli=$codecli';\">Envoyer mail</button></td>
                          </tr>";
                } else {
                    echo "<tr>
                            <td>$codecli</td>
                            <td>$nom</td>
                            <td>$datepaie</td>
                            <td class='pas-encore-payer'>Pas encore payé (Électricité)</td>
                            <td class='a completer '>a completer </td>
                            <td><button onclick=\"window.location.href='../controller/mail.php?codecli=$codecli';\">Envoyer mail</button></td>
                          </tr>";
                }
            }

            // Récupérer les données de la table EAU pour le codecompteur
            $queryEau = $pdo->prepare("SELECT date_releve2, date_presentation2, date_limite_paie2 FROM EAU WHERE codecompteur = ?");
            $queryEau->execute([$codecompteur]);
            $eauData = $queryEau->fetch(PDO::FETCH_ASSOC);

            if ($eauData) {
                $datePresentationEau = new DateTime($eauData['date_presentation2']);
                $dateLimitePaieEau = new DateTime($eauData['date_limite_paie2']);
                $datePaieEau = new DateTime($datepaie);

                // Vérifier si la date de paiement est entre les deux dates
                if ($datePaieEau >= $datePresentationEau && $datePaieEau <= $dateLimitePaieEau) {
                    echo "<tr>
                            <td>$codecli</td>
                            <td>$nom</td>
                            <td>$datepaie</td>
                            <td class='deja-payer'>Déjà payé (Eau)</td>
                            <td class='a completer '>a completer </td>
                            <td><button onclick=\"window.location.href='../controller/mail.php?codecli=$codecli';\">Envoyer mail</button></td>
                          </tr>";
                } else {
                    echo "<tr>
                            <td>$codecli</td>
                            <td>$nom</td>
                            <td>$datepaie</td>
                            <td class='pas-encore-payer'>Pas encore payé (Eau)</td>
                            <td class='a completer '>a completer </td>
                            <td><button onclick=\"window.location.href='../controller/mail.php?codecli=$codecli';\">Envoyer mail</button></td>
                          </tr>";
                }
            }
        }
    }
}
?>


    </tbody>
</table>

</body>
</html>

