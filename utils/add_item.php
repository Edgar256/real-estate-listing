<?php
// Processing form data when form is submitted
if (isset($_POST['form_submit_location'])) {

    // Validate location
    if (empty(trim($_POST["location_name"]))) {
        $location_name_err = "Location name is required.";
    } elseif (strlen(trim($_POST["location_name"])) < 2) {
        $location_name_err = 'Location must have atleast 2 characters.';
    } else {
        // verify if location exists
        $location_name = mb_strtolower($location_name);
        $location_name = trim($_POST["location_name"]);
        $locationCheck = $conn->query("SELECT * FROM locations WHERE  name='{$location_name}' ");
        $row_cnt = $locationCheck->num_rows;
        $new_location = mb_strtolower($location_name);

        if ($row_cnt == 0) {
            $sql = "INSERT INTO locations (name) VALUES ('$new_location')";
            if ($conn->query($sql) === TRUE) {
                $location_success_msg = '<div class="alert alert-success text-center">
                    New Location Added.</div>';
                echo "<script>setTimeout(\"location.href = 'property-dashboard.php';\",1500);</script>";
            } else {
                $saving_location_err = $conn->error;
            }
        } else {
            $location_name_err = ' Location ' . mb_strtoupper($location_name) . ' already exists';
        }
    }

} elseif (isset($_POST['form_submit_property_type'])) {

    // Validate property type
    if (empty(trim($_POST["property_type_name"]))) {
        $location_name_err = "Property type name is required.";
    } elseif (strlen(trim($_POST["property_type_name"])) < 2) {
        $property_type_name_err = 'Location must have atleast 2 characters.';
    } else {
        // verify if location exists
        $property_type_name = mb_strtolower($property_type_name);
        $property_type_name = trim($_POST["property_type_name"]);
        $propertyTypeNameCheck = $conn->query("SELECT * FROM types WHERE  name='{$property_type_name}' ");
        $row_cnt = $propertyTypeNameCheck->num_rows;
        $new_property_name = mb_strtolower($property_type_name);

        if ($row_cnt == 0) {
            $sql = "INSERT INTO types (name) VALUES ('$new_property_name')";
            if ($conn->query($sql) === TRUE) {
                $type_success_msg = '<div class="alert alert-success text-center">
                    New Type Added.</div>';
                echo "<script>setTimeout(\"location.href = 'property-dashboard.php';\",1500);</script>";
            } else {
                $saving_property_type_name_err = $conn->error;
            }
        } else {
            $property_type_name_err = ' Type ' . mb_strtoupper($property_type_name) . ' already exists';
        }
    }

} elseif (isset($_POST['form_submit_property'])) {

    // Validate title
    if (empty(trim($_POST["title"]))) {
        $title_err = '<div class="text-danger">
            Title is required.
        </div>';
    } elseif (strlen(trim($_POST["title"])) < 2) {
        $title_err = "Title must have atleast 2 characters.";
    } else {
        $title = trim($_POST["title"]);
    }

    // Validate price
    if (empty(trim($_POST["price"]))) {
        $price_err = '<div class="text-danger">
            Price is required.
        </div>';
    } else {
        $price = trim($_POST["price"]);
    }

    // Validate location
    if (empty(trim($_POST["location"]))) {
        $location_err = '<div class="text-danger">
            Location is required.
        </div>';
    } else {
        $location = trim($_POST["location"]);
    }

    // Validate property type
    if (empty(trim($_POST["property_type"]))) {
        $property_type_err = '<div class="text-danger">
            Property Type is required.
        </div>';
    } else {
        $property_type = trim($_POST["property_type"]);
    }

    // Validate manager
    if (empty(trim($_POST["manager"]))) {
        $manager_err = '<div class="text-danger">
            Manager is required.
        </div>';
    } else {
        $manager = trim($_POST["manager"]);
    }

    // Validate description
    if (empty(trim($_POST["description"]))) {
        $description_err = '<div class="text-danger">
            Description is required.
        </div>';
    } else {
        $description = trim($_POST["description"]);
    }

    if ((isset($_FILES['image']) && $_FILES['image']['error'] == 0)) {
        $file = $_FILES['image'];
        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $file_ext = explode('.', $file_name);
        $file_ext = strtolower(end($file_ext));
        $allowed = array('jpg', 'jpeg', 'png', 'gif');

        if (!in_array($file_ext, $allowed)) {
            exit(2);
        }

        $data = file_get_contents($file_tmp);

        if (empty($title_err) && empty($price_err) && empty($property_type_err) && empty($manager_err) && empty($description_err)) {
            //     Prepare an insert statement
            $sql = "INSERT INTO properties (title, price, property_type, manager, property_description, property_location, property_image) VALUES (?, ?, ?, ?, ?, ?, ?)";
            if ($stmt = $conn->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("sssssss", $param_title, $param_price, $param_property_type, $param_manager, $param_description, $param_location, $param_image);

                // Set parameters
                $param_title = $title;
                $param_price = $price;
                $param_property_type = $property_type;
                $param_manager = $manager;
                $param_description = $description;
                $param_location = $location;
                $param_image = $data;

                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    // Display success message 
                    $property_success_msg = '<div class="alert alert-success text-center">
                                                Property entry was successfully created.</div>';
                    echo "<script>setTimeout(\"location.href = 'listing-admin.php';\",2000);</script>";
                } else {
                    $saving_property_err = $conn->error;
                }
                // Close statement
                $stmt->close();
            }
        }
    }
}
?>