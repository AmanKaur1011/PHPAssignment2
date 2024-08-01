<?php
$servername = "localhost";
$username = "root";
$password = "";  // This is often the default password for MAMP and the default for XAMP in windows is an empty string 
$dbname = "entertainment";

// Create connection
$connect = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
} else {
    // Comment out or remove this line in production
    // echo "Connected successfully";
}
