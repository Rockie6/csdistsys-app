<?php
// database connection settings
$db_type = getenv("DB_TYPE") ? getenv("DB_TYPE") : "mysql";
$host = getenv("DB_HOST") ? getenv("DB_HOST") : "localhost";
$user = getenv("DB_USER") ? getenv("DB_USER") : "root";
$pass = getenv("DB_PASS");
if (!$pass) { $pass = getenv("DB_PASSWORD"); }
if (!$pass) { $pass = ""; }
$db   = getenv("DB_NAME") ? getenv("DB_NAME") : "csdistsys";
$port = getenv("DB_PORT") ? getenv("DB_PORT") : ($db_type == "pgsql" ? "5432" : "3306");

// if a full database url is given (like on render), use that instead
if (getenv("DATABASE_URL")) {
    $url_parts = parse_url(getenv("DATABASE_URL"));
    $db_type = ($url_parts["scheme"] == "postgresql" || $url_parts["scheme"] == "postgres") ? "pgsql" : "mysql";
    $host = $url_parts["host"];
    $port = $url_parts["port"];
    $user = $url_parts["user"];
    $pass = $url_parts["pass"];
    $db   = ltrim($url_parts["path"], "/");
}

// connect to the database
try {
    if ($db_type == "pgsql") {
        $conn = new PDO("pgsql:host=$host;port=$port;dbname=$db;sslmode=require", $user, $pass);
    } else {
        $conn = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass);
    }
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// create the users table if it does not exist
if ($db_type == "pgsql") {
    $conn->query("CREATE TABLE IF NOT EXISTS users (
        id SERIAL PRIMARY KEY,
        fname VARCHAR(50) NOT NULL,
        lname VARCHAR(50) NOT NULL,
        contactno VARCHAR(10) NOT NULL,
        email VARCHAR(100) NOT NULL,
        address TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
} else {
    $conn->query("CREATE TABLE IF NOT EXISTS users (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        fname VARCHAR(50) NOT NULL,
        lname VARCHAR(50) NOT NULL,
        contactno VARCHAR(10) NOT NULL,
        email VARCHAR(100) NOT NULL,
        address TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
}
?>
