<?php
//for update_password.php and update_personal_details.php
$host = "localhost";
$dbname = "keto_diet_plan";
$username = "root";
$password = "";

$mysqli = new mysqli(hostname: $host,
                     username: $username,
                     password: $password,
                     database: $dbname);
                     
if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error);
}

?>