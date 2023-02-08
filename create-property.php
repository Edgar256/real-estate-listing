<?php
// import Config File
require('./config/config.php');

if (!isset($_SESSION)) {
    session_start();
}

$_SESSION['page'] = 'create-property';

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Define variables and initialize with empty values
$users = $list = "";

$table = "types";

$sql = "SELECT *  FROM " . $table . " ORDER BY id DESC";
$list = $conn->query($sql);

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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="Edgar Tinkamanyire" />
    <meta name="generator" content="Hugo 0.101.0" />
    <title>Real Estate</title>

    <!-- BOOTSTRAP CSS LINKS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

    <!-- Custom styles for this template -->
    <link href="./css/dashboard.css" rel="stylesheet" />
</head>

<body>

    <!-- Inculde admin header -->
    <?php include('./components/admin-header.php'); ?>

    <div class="container-fluid">
        <div class="row">

            <!-- include admin sidenav -->
            <?php include("./components/admin-sidenav.php"); ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Create A New Property</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">

                    </div>
                </div>

                <div class="w-100 p-2">
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
                                <input type="submit" class="btn btn-success w-100" value="CREATE PROPERTY"
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

            </main>
        </div>
    </div>

    <!-- <script src="../assets/dist/js/bootstrap.bundle.min.js"></script> -->
    <!-- BOOTSTRAP JS LINKS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
        integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE"
        crossorigin="anonymous"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"
        integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha"
        crossorigin="anonymous"></script> -->
    <script src="./js/dashboard.js"></script>
</body>

</html>