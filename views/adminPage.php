<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../auth/login.php");
    exit;
}
if(!$_SESSION["isAdmin"]){
    header("location: welcome.php");
}
require_once "../configration/config.php";

$sql="select id,username,email,status from users where isAdmin =0 && status=0; ";
$pendingUsers = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

$sql2="select id,username,email,status from users where isAdmin =0 && status=1; ";
$acceptedUsers = $pdo->query($sql2)->fetchAll(PDO::FETCH_ASSOC);

// var_dump($pendingUsers);
// echo sizeof($pendingUsers);
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
<body style='background-color: cadetblue; color: #f8f9fa;'>
    <h1 class="my-5">Welcome Sir, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. </h1>
    <p>
        <a href="../auth/reset-password.php" class="btn btn-warning">Reset Your Password</a>
        <a href="../auth/logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
    </p>

    <br>
    <p>
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. all pending user waiting in the wait queue</h1>
    </p>

    <table class="table table-success table-striped">
        <thead>
            <tr>
            <th >ID</th>
            <th >Name</th>
            <th >Email</th>
            <!-- <th >Handle</th> -->
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($pendingUsers as $user) {
            ?>
            <tr class='my-3'>
            <th scope="row"><?php echo $user['id'] ."<br>";?></th>
            <td ><?php echo $user['username'] ."<br>";?></td>
            <td><?php echo $user['email'] ."<br>";?></td>
            <td > <a class='btn btn-success mx-3' href='../request/accept.php?id=<?php echo $user['id'];?>' >accept</a> 
            <a class='btn btn-danger mx-3' href='../request/reject.php?id=<?php echo $user['id'];?>' >reject</a> </td>

            </tr>
            <?php } ?>
        </tbody>
    </table>
    <br>
    <p>
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. all accepted users in the system.</h1>
    </p>
    <table class="table table-success table-striped">
        <thead>
            <tr>
            <th >ID</th>
            <th >Name</th>
            <th >Email</th>
            <!-- <th >Handle</th> -->
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($acceptedUsers as $user) {
            ?>
            <tr class='my-3'>
            <th scope="row"><?php echo $user['id'] ."<br>";?></th>
            <td ><?php echo $user['username'] ."<br>";?></td>
            <td><?php echo $user['email'] ."<br>";?></td>
            
            </tr>
            <?php } ?>
            
        </tbody>  
    </table>
    
</body>
</html>