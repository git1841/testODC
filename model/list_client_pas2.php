<?php
// Connexion à la base de données (à personnaliser selon votre configuration)
$host = 'localhost';
$dbname = 'jirama';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Tableau des noms de mois en français
$mois_noms = [
    1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
    5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
    9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
];

// Récupération du mois depuis l'URL
$mois = isset($_GET['mois']) ? (int)$_GET['mois'] : null;

if ($mois !== null && $mois >= 1 && $mois <= 12) {

    // On utilise DISTINCT pour éviter les doublons
    $sql = "SELECT DISTINCT c.nom, c.codecli 
    FROM CLIENT c 
    JOIN COMPTEUR cp ON c.codecli = cp.codecli 
    LEFT JOIN ELEC e ON cp.codecompteur = e.codecompteur 
        AND MONTH(e.date_limite_paie) = :mois AND YEAR(e.date_limite_paie) = 2025
    LEFT JOIN EAU a ON cp.codecompteur = a.codecompteur 
        AND MONTH(a.date_limite_paie2) = :mois AND YEAR(a.date_limite_paie2) = 2025
    WHERE e.date_limite_paie IS NOT NULL OR a.date_limite_paie2 IS NOT NULL";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':mois', $mois, PDO::PARAM_INT);
    $stmt->execute();

    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "<p>Mois invalide. Veuillez entrer un mois entre 1 et 12.</p>";
    $clients = [];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Clients</title>
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
    text-align: center;  /* Centre le contenu du container */
}

/* Titre centré en haut de la page */
.container h2 {
    color: #2e7d32;
    font-size: 2em;
    margin-bottom: 20px;
    text-align: center;
}

/* Tableau */
table {
    width: 100%;
    border-collapse: collapse;
    background-color: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 128, 0, 0.1);
}

th {
    background-color: #a5d6a7;
    color: #1b5e20;
    padding: 12px;
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

/* Message d'erreur */
.message {
    font-size: 1.2em;
    color: #d32f2f;
}

/* Ajustement des éléments dans la sidebar pour le responsive */
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
}

    </style>
</head>
<body>

    <?php if ($mois !== null && isset($mois_noms[$mois])) : ?>
        <h2>Liste des Clients pour le Mois de <?= htmlspecialchars($mois_noms[$mois]) ?> 2025</h2>
    <?php endif; ?>

    <?php if (!empty($clients)) : ?>
        <table>
            <thead>
                <tr>
                    <th>Nom du Client</th>
                    <th>Code du Client</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clients as $client) : ?>
                    <tr>
                        <td><?= htmlspecialchars($client['nom']) ?></td>
                        <td><?= htmlspecialchars($client['codecli']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif ($mois !== null) : ?>
        <p>Aucun client trouvé pour ce mois.</p>
    <?php endif; ?>

</body>
</html>
