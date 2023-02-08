<?php
// import Config File
require('./config/config.php');
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

// require add_item.php
require('utils/add_item.php');

?>

<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" href="./images/logo.png">

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
            <div class="container d-xl-flex d-md-block d-sm-block">

                <!-- handle adding locations -->
                <div class="col-xl-6 col-md-12 col-sm-12 py-5 p-2">
                    <div class="border border-secondary bg-light p-5 rounded">
                        <h1 class="text-center display-4">LOCATIONS</h1>
                        <?php echo $saving_location_err ?>
                        <?php
                        if ($location_name_err) {
                            echo "<div class='alert alert-danger text-center'>" . json_encode($location_name_err) . "</div>";
                        }
                        ?>
                        <?php echo $location_success_msg ?>
                        <form action="" class="d-flex w-100" method="post">
                            <input type="text" class="form-control" name="location_name">
                            <input type="submit" name="form_submit_location" class="btn btn-success"
                                value="Add Location" name="form_submit_location" />
                        </form>
                        <div>
                            <?php
                            $table = "locations";
                            $check_locations_list = $conn->query("SELECT * FROM $table");
                            if ($check_locations_list->num_rows > 0) {
                                while ($row = $check_locations_list->fetch_assoc()) {
                                    $name = mb_convert_case($row["name"], MB_CASE_TITLE, "UTF-8");
                                    echo "<span class='btn btn-secondary m-1'>" . $name . "</span>";
                                }
                            } else {
                                echo "No Locations found";
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <!-- handle adding property types -->
                <div class="col-xl-6 col-md-12 col-sm-12 py-5 p-2">
                    <div class="border border-secondary bg-light p-5 rounded">
                        <h1 class="text-center display-4">PROPERTY TYPE</h1>
                        <?php echo $saving_property_err ?>
                        <?php
                        if ($property_type_name_err) {
                            echo "<div class='alert alert-danger text-center'>" . json_encode($property_type_name_err) . "</div>";
                        }
                        ?>
                        <?php echo $type_success_msg ?>
                        <form action="" class="d-flex w-100" method="post">
                            <input type="text" class="form-control" name="property_type_name">
                            <input type="submit" class="btn btn-success" value="Add Property Type"
                                name="form_submit_property_type" />
                        </form>
                        <div>
                            <?php
                            $table = "types";
                            $check_locations_list = $conn->query("SELECT * FROM $table");
                            if ($check_locations_list->num_rows > 0) {
                                while ($row = $check_locations_list->fetch_assoc()) {
                                    $name = mb_convert_case($row["name"], MB_CASE_TITLE, "UTF-8");
                                    echo "<span class='btn btn-secondary m-1'>" . $name . "</span>";
                                }
                            } else {
                                echo "No Prperty Types found";
                            }
                            ?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="container p-2">
                <div class="border border-secondary bg-light p-5 rounded">
                    <h1 class="text-center display-4">ADDING PROPERTY</h1>
                    <?php echo $property_success_msg ?>
                    <?php echo $saving_property_err ?>

                    <!-- handle adding a property -->
                    <form action="" class="d-xl-flex flex-wrap d-md-flex d-sm-block" method="post"
                        enctype="multipart/form-data">
                        <div class="col-xl-3 col-md-6 col-sm-12 p-3">
                            <label for="title" class="form-label">Property Title <span
                                    class="text-danger pl-2">*</span></label>
                            <input type="text" class="form-control <?php if (!empty($title_err))
                                echo "border-danger"; ?>" name="title" required />
                        </div>
                        <div class="col-xl-3 col-md-6 col-sm-12 p-3">
                            <label for="price" class="form-label">Price in Dollars($) <span
                                    class="text-danger pl-2">*</span></label>
                            <input type="number" class="form-control <?php if (!empty($price_err))
                                echo "border-danger"; ?>" name="price" required />
                        </div>
                        <div class="col-xl-3 col-md-6 col-sm-12 p-3">
                            <label for="title" class="form-label">Select Property Location <span
                                    class="text-danger pl-2">*</span></label>
                            <select name="location" id="" class="form-control <?php if (!empty($location_err))
                                echo "border-danger"; ?>">
                                <option value="">Select Property Location</option>
                                <?php
                                $table = "locations";
                                $check_locations_list = $conn->query("SELECT * FROM $table");
                                if ($check_locations_list->num_rows > 0) {
                                    while ($row = $check_locations_list->fetch_assoc()) {
                                        $name = mb_convert_case($row["name"], MB_CASE_TITLE, "UTF-8");
                                        $id = $row["id"];
                                        echo "<option value=" . $id . ">" . $name . "</option>";
                                    }
                                } else {
                                    echo "No Locations found";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-xl-3 col-md-6 col-sm-12 p-3">
                            <label for="title" class="form-label">Select Property Type <span
                                    class="text-danger pl-2">*</span></label>
                            <select name="property_type" id="" class="form-control <?php if (!empty($property_type_err))
                                echo "border-danger"; ?>">
                                <option value="">Select Property Type</option>
                                <?php
                                $table = "types";
                                $check_types_list = $conn->query("SELECT * FROM $table");
                                if ($check_types_list->num_rows > 0) {
                                    while ($row = $check_types_list->fetch_assoc()) {
                                        $name = mb_convert_case($row["name"], MB_CASE_TITLE, "UTF-8");
                                        $id = $row["id"];
                                        echo "<option value=" . $id . ">" . $name . "</option>";
                                    }
                                } else {
                                    echo "No Prperty types found";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-xl-3 col-md-6 col-sm-12 p-3">
                            <label for="manager" class="form-label">Assign to a Manager <span
                                    class="text-danger pl-2">*</span></label>
                            <select name="manager" id="" class="form-control <?php if (!empty($manager_err))
                                echo "border-danger"; ?>">
                                <option value="">Select Manager</option>
                                <?php
                                $table = "managers";
                                $check_types_list = $conn->query("SELECT * FROM $table");
                                if ($check_types_list->num_rows > 0) {
                                    while ($row = $check_types_list->fetch_assoc()) {
                                        $firstname = mb_convert_case($row["firstname"], MB_CASE_TITLE, "UTF-8");
                                        $lastname = mb_convert_case($row["lastname"], MB_CASE_TITLE, "UTF-8");
                                        $id = $row["id"];
                                        echo "<option value=" . $id . ">" . $firstname . ' ' . $lastname . "</option>";
                                    }
                                } else {
                                    echo "No Locations found";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-xl-3 col-md-6 col-sm-12 p-3">
                            <label for="title" class="form-label">Property Profile Image <span
                                    class="text-danger pl-2">*</span></label>
                            <input type="file" class="form-control <?php if (!empty($image_err))
                                echo "border-danger"; ?>" accept=" image/gif, image/jpeg,image/jpg, image/png"
                                name="image" required />
                        </div>
                        <div class="col-xl-6 col-md-6 col-sm-12 p-3">
                            <label for="title" class="form-label">Property Description <span
                                    class="text-danger pl-2">*</span></label>
                            <textarea type="text" rows="5" class="form-control <?php if (!empty($description_err))
                                echo "border-danger"; ?>" name="description"
                                placeholder="Add property description"></textarea>
                        </div>

                        <div class="w-100 d-flex">
                            <div class="col-md-4 p-5 mx-auto">
                                <input type="submit" class="btn btn-success w-100" value="Upload Property"
                                    name="form_submit_property" />
                            </div>
                        </div>

                        <div class="w-100">
                            <div class="col-md-4 p-5 mx-auto">
                                <?php echo $property_success_msg ?>
                                <?php echo $saving_property_err ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <!-- import the footer section-->
        <?php
        include './components/footer.php';
        ?>

    </div>
</body>

</html>