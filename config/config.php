<?php

// Require database credentials
require('credentials.php');

// Connect to MySQL server (without selecting a specific database yet)
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the database exists using a SQL query
$db_check_query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '" . DB_NAME . "'";
$db_exists = $conn->query($db_check_query);

if ($db_exists->num_rows == 0) {
    // Database does not exist, so create it
    $sql_create_database = "CREATE DATABASE " . DB_NAME;
    if ($conn->query($sql_create_database) === TRUE) {
        // echo "Database created successfully.<br>";
    } else {
        die("Error creating database: " . $conn->error);
    }
} else {
    // echo "Database already exists. Proceeding with table creation.<br>";
}

// Now, select the database
if (!$conn->select_db(DB_NAME)) {
    die("Error selecting database: " . $conn->error);
}

// SQL to create tables
$table_queries = [
    "CREATE TABLE IF NOT EXISTS Users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        firstname VARCHAR(255) NOT NULL,
        lastname VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        phone VARCHAR(255) NOT NULL,
        role VARCHAR(255) NOT NULL DEFAULT 'USER',
        password VARCHAR(255) NOT NULL,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",

    "CREATE TABLE IF NOT EXISTS Managers (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        firstname VARCHAR(255) NOT NULL,
        lastname VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        phone VARCHAR(255) NOT NULL,
        role VARCHAR(255) NOT NULL DEFAULT 'MANAGER',
        password VARCHAR(255) NOT NULL,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )",

    "CREATE TABLE IF NOT EXISTS Admins (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        firstname VARCHAR(255) NOT NULL,
        lastname VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        phone VARCHAR(255) NOT NULL,
        role VARCHAR(255) NOT NULL DEFAULT 'ADMIN',
        password VARCHAR(255) NOT NULL,    
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",

    "CREATE TABLE IF NOT EXISTS Locations (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL
    )",

    "CREATE TABLE IF NOT EXISTS Types (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL
    )",

    "CREATE TABLE IF NOT EXISTS Properties (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        property_description VARCHAR(255) NOT NULL,
        price VARCHAR(255) NOT NULL,
        property_image LONGBLOB NOT NULL,  
        is_taken TINYINT(1) NOT NULL DEFAULT 0,
        
        property_location INT(6) UNSIGNED,
        FOREIGN KEY (property_location) REFERENCES Locations(id),
        
        property_type INT(6) UNSIGNED,
        FOREIGN KEY (property_type) REFERENCES Types(id),
        
        manager INT(6) UNSIGNED,
        FOREIGN KEY (manager) REFERENCES Managers(id),
        
        buyer INT(6) UNSIGNED,
        FOREIGN KEY (buyer) REFERENCES Users(id),
        
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",

    "CREATE TABLE IF NOT EXISTS Visits (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        note VARCHAR(255) NOT NULL,
        visit_date DATE NOT NULL,
        visit_time TIME NOT NULL,
        
        property INT(6) UNSIGNED,
        FOREIGN KEY (property) REFERENCES Properties(id),
        
        user INT(6) UNSIGNED,
        FOREIGN KEY (user) REFERENCES Users(id),
        
        manager INT(6) UNSIGNED,
        FOREIGN KEY (manager) REFERENCES Managers(id),
        
        status ENUM('pending', 'rejected', 'cancelled', 'completed') NOT NULL DEFAULT 'pending',
        
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )"
];

// Loop through each table creation query and execute it
foreach ($table_queries as $query) {
    if ($conn->query($query) !== TRUE) {
        echo "Error creating table: " . $conn->error . "<br>";
    }
}

// Close the connection
// $conn->close();
?>
