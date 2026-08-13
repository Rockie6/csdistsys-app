<?php
// database connection settings
$host = getenv("DB_HOST") ? getenv("DB_HOST") : "localhost";
$user = getenv("DB_USER") ? getenv("DB_USER") : "root";
$pass = getenv("DB_PASS") ? getenv("DB_PASS") : "";
$db   = getenv("DB_NAME") ? getenv("DB_NAME") : "csdistsys";

// connect to mysql server
$conn = mysqli_connect($host, $user, $pass, $db);

// check if connection works
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// create the users table if it does not exist
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    fname VARCHAR(50) NOT NULL,
    lname VARCHAR(50) NOT NULL,
    contactno VARCHAR(10) NOT NULL,
    email VARCHAR(100) NOT NULL,
    address TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");
?>
