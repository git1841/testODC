<?php
// Inclure l'autoloader de Composer (doit être la première chose)
require '/opt/lampp/htdocs/pjphp/controller/vendor/autoload.php';

// Importer les classes PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$codecli = $_GET['codecli'];

// Connexion à la base de données
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

    // Initialiser PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configuration du serveur SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ramanandraibemariojoseph6@gmail.com'; // Ton adresse Gmail
        $mail->Password = 'rqsd iwia uvko hobe'; // Ton mot de passe d'application
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('ramanandraibemariojoseph6@gmail.com', 'Projet 7 PHP');
        $mail->addAddress($email);
        $mail->addReplyTo('ramanandraibemariojoseph6@gmail.com', 'Support Client');

        $mail->isHTML(false);
        $mail->Subject = utf8_decode("Rappel de paiement de consommations d'eau et d'électricité");
        $mail->Body    = "Bonjour ,
Nous espérons que vous allez bien.
Nous souhaitons vous rappeler que votre paiement pour la consommation d'eau et d'électricité est toujours en attente. Nous vous prions de bien vouloir procéder au règlement de votre part afin d'éviter toute interruption de service.
Merci de prendre les dispositions nécessaires dans les plus brefs délais.
Nous vous remercions pour votre compréhension et votre réactivité.";

        // Envoyer l'email
        $mail->send();
        echo "<script>alert('Email envoyé avec succès à $email'); window.history.back();</script>";
    } catch (Exception $e) {
        $error_message = addslashes($mail->ErrorInfo); // Sécuriser le message pour JavaScript
        echo "<script>alert('Erreur lors de l\\'envoi de l\\'email: $error_message'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Client introuvable.'); window.history.back();</script>";
}

$conn->close();
?>