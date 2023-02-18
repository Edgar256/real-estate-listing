<?php
require('../config/config.php');

if (isset($_POST['currentProperty'])) {
    $id = $_POST['currentProperty'];
    $title = $_POST['title'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // Prepare an update statement with parameter placeholders
    $sql = "UPDATE properties SET title = ?, price = ?, property_description = ? WHERE id = ?";

    // Prepare the statement and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $title, $price, $description, $id);

    // Execute the statement
    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

//  close the connection
$conn->close();
?>