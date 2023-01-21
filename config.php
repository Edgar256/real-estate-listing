<?php

// DATABASE CREDENTIALS
define("DB_HOST", 'localhost');
define("DB_USER", 'root');
define("DB_PASSWORD", '');

// for a predefined database
define("DB_NAME", 'Course_Work');
// $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);


$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD);

$db_connection_error;
$manager_table_creation_error;

if (!$conn) {
    // $db_connection_error = "Connection failed: " . $conn->connect_error;
    // exit();
    die("Connection failed: " . $conn->connect_error);
}

// Query to create a database
$sql_create_db = 'CREATE Database ' . DB_NAME;
if ($conn->query($sql_create_db) !== TRUE) {
    // echo "Error creating table: " . $conn->error;
}

// connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}

// sql to create users table
$sql_create_users_table = "CREATE TABLE Users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

// create Users table
if ($conn->query($sql_create_users_table) !== TRUE) {
    // echo "Error creating table: " . $conn->error;
}

// sql to create managers table
$sql_create_managers_table = "CREATE TABLE Managers (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

// create Managers table
if ($conn->query($sql_create_managers_table) !== TRUE) {
    // echo "Error creating table: " . $conn->error;
}

// sql to create managers table
$sql_create_admins_table = "CREATE TABLE Admins (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

// create Managers table
if ($conn->query($sql_create_admins_table) !== TRUE) {
    // echo "Error creating table: " . $conn->error;
}

// echo 'Connected successfully';
// mysqli_close($conn);

?>