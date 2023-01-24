<?php
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Define variables and initialize with empty values
$property_type = $property_type_name = $location = $location_name = $title = $description = $price = "";
$property_type_err = $property_type_name_err = $location_name = $location_name_err = $title_err = $description_err = $price_err = "";
$saving_property_err = $saving_location_err = $saving_type_err = "";
$property_success_msg = $location_success_msg = $type_success_msg = "";

// Validate location
if (empty(trim($_POST["location_name"]))) {
    $location_name_err = '<div class="text-danger">
            Location name is required.
        </div>';
} elseif (strlen(trim($_POST["location_name"])) < 2) {
    $location_name_err = "Location must have atleast 2 characters.";
} else {
    // verify if location exists
    $location_name[0] = strtolower($location_name[0]);
    $location_name = trim($_POST["location_name"]);
    $locationCheck = $conn->query("SELECT * FROM locations WHERE  name= '{$location_name}' ");
    if (!empty($locationCheck) > 0) {
        // Location exists
        $location_name_err = "Location already exists";
    } else {
        // Save New Location
        // Prepare an insert statement
        $sql = "INSERT INTO locations (name) VALUES ('$location_name')";

        if ($conn->query($sql) === TRUE) {
            $location_success_msg = '<div class="alert alert-success text-center">
                    New Location Added.</div>';

        } else {
            $saving_location_err = $conn->error;
        }
    }

}


?>