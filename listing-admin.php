<?php
// import Config File
require('config.php');
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Define variables and initialize with empty values
$property_type_name = $location_name = "";
$property_type_name_err = $location_name_err = "";
$saving_property_type_name_err = $saving_location_err = $saving_type_err = "";
$location_success_msg = $type_success_msg = "";

$title = $price = $location = $property_type = $manager = $description = $property_success_msg = "";
$title_err = $price_err = $location_err = $property_type_err = $manager_err = $description_err = $saving_property_err = "";

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
                } else {
                    $saving_property_err = $conn->error;
                }

                // Close statement
                $stmt->close();


            }
        }
    }

    // Close connection
    // $mysqli->close();
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- CSS LINKS -->
    <link rel="stylesheet" href="./css/style.css" />

    <!-- BOOTSTRAP CSS LINKS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

    <!-- BOOTSTRAP JS LINKS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <title>Equitable Property Group</title>
</head>

<body>
    <div class="position-relative">

        <!-- import the header section-->
        <?php include './components/header.php'; ?>

        <div class="position-relative">

            <div class="pb-5 mb-5">
                <!-- start seacrh section -->
                <div class="container pt-5">
                    <form class="row gx-3 gy-2 align-items-center">
                        <div class="col-sm-5">
                            <!-- <label for="specificSizeInputName">Search by Name</label> -->
                            <input type="text" class="form-control" id="specificSizeInputName"
                                placeholder="Search by Name" />
                        </div>
                        <div class="col-sm-5">
                            <!-- <label for="specificSizeInputName">Search by Location</label> -->
                            <select class="form-select" id="specificSizeSelect">
                                <option selected>Search by Location</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <button type="submit" class="btn btn-primary w-100">Submit</button>
                        </div>
                    </form>
                </div>
                <!-- end search section -->

                <!-- start listing section -->
                <div class="container d-flex flex-wrap">
                    <?php
                    $table = "properties";
                    $query = "SELECT * FROM properties JOIN property_type ON properties.property_type = property_type.id JOIN locations ON properties.location = locations.id JOIN managers ON properties.manager = managers.id";
                    $sql = "SELECT properties.*, locations.* FROM properties JOIN locations ON properties.property_location = locations.id ORDER BY reg_date DESC";
                    $check_properties_list = $conn->query($sql);
                    if ($check_properties_list->num_rows > 0) {
                        while ($row = $check_properties_list->fetch_assoc()) {
                            $title = mb_convert_case($row["title"], MB_CASE_TITLE, "UTF-8");
                            $id = $row["id"];
                            $description = $row["property_description"];
                            $price = $row["price"];
                            $location = $row["name"];
                            $imageData = $row['property_image'];
                            $imageData = base64_encode($imageData);
                            $datePosted = $row["reg_date"];

                            echo '<div class="w-25 p-1">
                            <div class="card">
                                <img src="data:image/jpeg;base64,' . $imageData . '" style="font-weight:bold">
                                <div class="card-body">
                                    <p class="card-title"><small><i>Posted :' . date("F j, Y, g:i a", strtotime($datePosted)) . '</i></small></p>
                                    <h5 class="card-title">' . $title . '</h5>
                                    <h6>Location: ' . $location . '</h6>
                                    <h6>Price: USD ' . $price . '</h6>
                                    <p class="card-text">
                                        ' . $description . '
                                    </p>
                                    <form method="post">
                                        <input type="submit" name="delete" id="delete" value="DELETE" class="btn btn-danger w-100"/><br/>
                                    </form>
                                    function deleteProperty() {
                                            $id = $_POST['.$id.'];
                                            $sql = "DELETE FROM properties WHERE id = '.$id.'";
                                            $result = $conn->query($sql);
                                    }
                                </div>
                            </div>
                        </div>';
                        }
                    } else {
                        echo "No Locations found";
                    }

                    function deleteProperty()
                    {
                        echo "Your test function on button click is working";
                        exit();
                    }
                    if (array_key_exists('delete', $_POST)) {
                        deleteProperty();
                    }
                    //  close the connection
                    $conn->close();
                    ?>

                </div>
                <!-- end lisitng section -->
            </div>

        </div>

        <!-- import the footer section-->
        <?php
        include './components/footer.php';
        ?>

    </div>
</body>

</html>