<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];


    if ($username == "admin" && $password == "admin") {
        $_SESSION['username'] = $username;
        header("Location: page_acceuille.php");
        exit();
    } else {
        echo 'erreur de login';
        header("Location: erreurlog.html");
    }
}
?>
