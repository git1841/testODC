
<?php
$codecli = $_GET['codecli'];
//$reste = $_GET['reste'];

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
}
    // Envoi de l'e-mail
echo $email;
//echo $reste;






require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'zaho@gmail.com';                     //SMTP username
    $mail->Password   = 'zaho123';                              //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
    $mail->Port       = 587;                                    //TCP port to connect to

    //Recipients
    $mail->setFrom('zaho@gmail.com', 'Mailer');
    $mail->addAddress('andefasana@gmail.com');     //Add a recipient

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}




$stmt->close();
$conn->close();
?>

