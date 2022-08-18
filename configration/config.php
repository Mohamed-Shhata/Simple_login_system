<?php

$host = 'localhost';
$dbname = 'login_system';
$username = 'root';
$password = '';
/* Attempt to connect to MySQL database */

try{
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // echo "Connected to $dbname at $host successfully.";

    //creating users table
    $table = "users";

    $sql = "CREATE TABLE IF NOT EXISTS $table(
        id INT( 20 ) AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR( 250 ) NOT NULL UNIQUE,
        username VARCHAR( 150 ) NOT NULL, 
        password VARCHAR( 250 ) NOT NULL,
        isAdmin INT(2) DEFAULT 0 ,
        status INT(2) DEFAULT 0
    )";
    $pdo->exec($sql);

    $count = "SELECT count(*) FROM $table";
    $smtp = $pdo->prepare($count);
    $smtp->execute();
    $number_of_records = $smtp->fetchColumn();

    if ($number_of_records == 0) {

        $admin = $pdo->prepare("INSERT INTO users(username, email , password,isAdmin,status) VALUES('Admin','admin@gmail.com',?,1,1)");
        $admin->bindParam(1, password_hash('123456', PASSWORD_DEFAULT));
        $admin->execute();

    }

}catch(PDOException $e) {
	echo $e->getMessage();
}

?>