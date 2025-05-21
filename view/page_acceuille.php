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
echo "Connexion réussie !";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion d'Eau et d'Électricité</title>
    <link rel="stylesheet" href="css/acceuille.css">
   <!--<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet"> -->
</head>
<body>

    <!-- Barre latérale -->
    <div class="sidebar">
        <div class="logo">
            <h2>Gestion</h2>
        </div>
        <nav>
            <ul>
                <li><h1>acceuille</h1></li>
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

    <!-- Contenu principal -->
    <div class="main-content">
        <header>
            <h1>Bienvenue dans le système de gestion de paiement d'eau et d'électricité</h1>
            
            <div class="search-bar">
                <!--<input type="text" placeholder="Recherche client...">
                <img src="lopeb.ico" alt="Lope" class="search-icon"> -->

                <form action="../controller/rech1.php" method="GET">
                    <input type="text" name="query" placeholder="Recherche client...">
                    <button type="submit"><img src="icon/lopeb.ico" alt="Lope" class="search-icon"></button>
                </form> 
            </div>
        </header>

        <!-- Cartes de navigation -->
        <div class="card-container">
            <div class="card">
                <h3>Clients</h3>
                <p>Gérer les informations des clients.</p>
                <a href="client.php" class="btn">Voir les clients</a>
            </div>
            <div class="card">
                <h3>Compteurs</h3>
                <p>Ajouter et gérer les compteurs.</p>
                <a href="compteur.php" class="btn">Voir les compteurs</a>
            </div>
            <div class="card">
                <h3>Relevé Électrique</h3>
                <p>Gérer les relevés de consommation d'électricité.</p>
                <a href="releve_elec.php" class="btn">Voir les relevés</a>
            </div>
            <div class="card">
                <h3>Relevé Eau</h3>
                <p>Gérer les relevés de consommation d'eau.</p>
                <a href="releve_eau.php" class="btn">Voir les relevés</a>
            </div>
            <div class="card">
                <h3>Payer</h3>
                <p>Gérer les paiements des clients.</p>
                <a href="payer.php" class="btn">Voir les paiements</a>
            </div>
          <!--  <div class="card">
                <h3>Diver</h3>
                <p>Gérer les paiements des clients.</p>
                <a href="diver.php" class="btn">Diver</a>
            </div> -->
            <div class="card">
                <h3>Facture</h3>
                <p>Gérer les informations des Facture.</p>
                <a href="fact.php" class="btn">facture</a>
            </div>
            <div class="card">
                <h3>autres list</h3>
                <p>Gliste de client pas encore payer dans un moi.</p>
                <a href="list_client_pas1.php" class="btn">facture</a>
 
            </div>
            <div class="card">
                <h3>Envoi de mail</h3>
                <p>notification par mail</p>
                <a href="mail8.php" class="btn">facture</a>
            </div>
        </div>
    </div>

    

</body>
</html>