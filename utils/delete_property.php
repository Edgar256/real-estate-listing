<?php
require('../config/config.php');

if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM properties WHERE id =" . $id;
    $result = $conn->query($sql);
    if ($result) {
        header("Location: ../listing-admin.php");
    } else {
        echo "<p>Error deleting entry.</p>";
    }
    exit();
}

//  close the connection
$conn->close();
?>