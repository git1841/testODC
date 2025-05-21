
<?php
$codecli = $_GET['codecli'];

// Connexion à la base de données (à remplacer par vos informations)
$conn = new mysqli('localhost', 'root', '', 'jirama');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Préparation et exécution de la requête SQL pour récupérer l'adresse e-mail du client
$stmt = $conn->prepare("SELECT mail FROM CLIENT WHERE codecli = ?");
$stmt->bind_param("s", $codecli);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Récupération de l'adresse e-mail du client
    $row = $result->fetch_assoc();
    $email = $row['mail'];

    // Envoi de l'e-mail
    $to = $email;
    $subject = "Bonjour";
    $message = "Bonjour, je vous rapelle just que votre facture n'est pas encore envoyer !";
    $headers = 'From: webmaster@example.com' . "\r\n" .
               'Reply-To: webmaster@example.com' . "\r\n" .
               'X-Mailer: PHP/' . phpversion();

    if(mail($to, $subject, $message, $headers)) {
        echo "<h1>L'email a été envoyé avec succès.</h1>";
        echo "<h3> $email</h3>";
    } else {
        echo "<h1>Il semble que vous n'êtes pas connecté à Internet</h1>";
        echo "<h3>Échec de l'envoi de l'email au : $email</h3>";
        
    }
} else {
    echo "Aucun client trouvé pour ce codecli.";
}

$stmt->close();
$conn->close();
?>

