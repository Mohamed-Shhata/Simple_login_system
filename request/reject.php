<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: ../auth/login.php');
}
if ($_SESSION['isAdmin'] != 1) {
    header('Location: ../views/welcome.php');
}

require "../configration/config.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $smtp = $pdo->prepare("UPDATE users SET status = 2  Where id = ?");
    $smtp->bindParam(1, $id);
    $smtp->execute();
} 
header('location:../views/adminPage.php');
exit;
?>