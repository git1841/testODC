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
    <link rel="stylesheet" href="acceuille.css">
   <!--<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet"> -->
   <style>
    header k.ok {
    margin-left: 30px; /* Aligne le texte à 30 pixels de la gauche */
};

   </style>
</head>
<body>

    <!-- Barre latérale -->
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
                <li><a href="diver.php">diver</a></li>
            </ul>
        </nav>
    </div>

    <!-- Contenu principal -->
    <div class="main-content">
        <header>
            
            <k class ="ok">
                <h1>Diver options</h1>
            </k>

            
          <!--  <div class="search-bar">
                <input type="text" placeholder="Recherche client...">
                <img src="lopeb.ico" alt="Lope" class="search-icon"> 

                <form action="rech1.php" method="GET">
                    <input type="text" name="query" placeholder="Recherche client...">
                    <button type="submit">rechercher</button>
                </form>
            </div> -->
        </header>

        <!-- Cartes de navigation -->
        <div class="card-container">
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