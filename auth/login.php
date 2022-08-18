<?php
session_start();
 
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    if($_SESSION["isAdmin"]){
        header("location: ../views/adminPage.php");
        exit;
    }else{
        header("location: ../views/welcome.php");
        exit;
    } 
}
 
require_once "../configration/config.php";


$username = $password = "";
$username_err = $password_err = $login_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    if(empty($username_err) && empty($password_err)){
        $sql = "SELECT id, username, password , isAdmin , status , email FROM users WHERE username = :username";
        $stmt=$pdo->prepare($sql);
        if($stmt){
            $stmt->execute(array(
                ':username' => $_POST['username']
                ));

            if($stmt){
				$data = $stmt->fetch(PDO::FETCH_ASSOC);
                if($data){                    
                    $hashed_password=$data['password'];
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            
                            session_start();
                            
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $data['id'];
                            $_SESSION["username"] = $data['username'];

                            $_SESSION['email'] = $data['email'];
                            $_SESSION['isAdmin'] = $data['isAdmin'];
                            $_SESSION['status'] = $data['status'];
                            if($data['isAdmin']){
                                header("location: ../views/adminPage.php");
                                exit;
                            }else{
                                header("location: ../views/welcome.php");
                                exit;
                            }              
                                                        
                        } else{
                            $login_err = "Invalid username or password.";
                        }

                } else{

                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
    }
    
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <input type="hidden" name="role" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>
</body>
</html>

