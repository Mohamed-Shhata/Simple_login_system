<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../auth/login.php");
    exit;
}
$name = $_SESSION['name'];
$status = $_SESSION['status'];


?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
    
</head>
<body>
    
     
    <?php
    echo "<div class='flex justify-center items-center'>";
    if ($status == 0) {
        ?>
        <h1 class='my-5'>Pending request to be accepted please wait Sir, <b><?php echo htmlspecialchars($_SESSION['username']); ?></b>.</h1>
    <?php
    } elseif ($status == 1) {
    ?>
        <h1 class='my-5'>Welcome Sir,  <b><?php echo htmlspecialchars($_SESSION['username']); ?></b> .</h1>
    <?php
    } else {
        ?>
        <h1 class='my-5'>we sorry that the request has been Rejected for Sir, <b><?php echo htmlspecialchars($_SESSION['username']); ?></b>.</h1>
        <?php
    }
    echo "</div>";
    
    ?>
    <p>
        <?php if ($status<2) {
            echo '<a href="../auth/reset-password.php" class="btn btn-warning">Reset Your Password</a>';
        }?>
        <a href="../auth/logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
    </p> 
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
</body>
</html>