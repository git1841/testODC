<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];


    if ($username == "admin" && $password == "password") {
        $_SESSION['username'] = $username;
        header("Location: welcome.php");
        exit();
    } else {
        echo "<script>alert('Nom d'utilisateur ou mot de passe incorrect');</script>";
    }
}
?>
