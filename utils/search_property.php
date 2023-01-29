<?php
// Processing form data when form is submitted                
if (isset($_POST['form_search_property'])) {

    // return error if both are empty
    if (empty(trim($_POST["property_name"])) && empty(trim($_POST["location_id"]))) {
        $entries_err = '<div class="alert alert-danger text-center mx-auto">
                            Please enter a property name or location.</div>';
    }

    if (!empty(trim($_POST["property_name"])) && empty(trim($_POST["location_id"]))) {
        $property_name = trim($_POST["property_name"]);
        $property_name = mb_strtolower($property_name);
        $property_name = ucwords($property_name);
        $property_name = mysqli_real_escape_string($conn, $property_name);
        $query = "SELECT properties.*, locations.id AS location_id, locations.name AS location_name,  types.name AS property_type_name FROM properties JOIN locations ON properties.property_location = locations.id JOIN types ON properties.property_type = types.id  WHERE UPPER(title) LIKE UPPER('%$property_name%') OR UPPER(property_description) LIKE UPPER('%$property_name%') ORDER BY reg_date DESC";
        $result = $conn->query($query);
        $check_properties_list = $conn->query($query);
    }

    if (empty(trim($_POST["property_name"])) && !empty(trim($_POST["location_id"]))) {
        $location_id = trim($_POST["location_id"]);
        $query = "SELECT properties.*, locations.id AS location_id, locations.name AS location_name,  types.name AS property_type_name FROM properties JOIN locations ON properties.property_location = locations.id JOIN types ON properties.property_type = types.id  WHERE property_location='$location_id' ORDER BY reg_date DESC";
        $result = $conn->query($query);
        $check_properties_list = $conn->query($query);
    }

    if (!empty(trim($_POST["location_id"])) && !empty(trim($_POST["property_name"]))) {
        $property_name = trim($_POST["property_name"]);
        $property_name = mb_strtolower($property_name);
        $property_name = ucwords($property_name);
        $property_name = mysqli_real_escape_string($conn, $property_name);
        $query = "SELECT properties.*, locations.id AS location_id, locations.name AS location_name,  types.name AS property_type_name FROM properties JOIN locations ON properties.property_location = locations.id JOIN types ON properties.property_type = types.id  WHERE UPPER(title) LIKE UPPER('%$property_name%') OR UPPER(property_description) LIKE UPPER('%$property_name%') AND property_location='$location_id' ORDER BY reg_date DESC";
        $result = $conn->query($query);
        $check_properties_list = $conn->query($query);
    }
}
?>