<?php
// import Config File
require('./config/config.php');

if (!isset($_SESSION)) {
    session_start();
}

$_SESSION['page'] = 'types';

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
                    <h1 class="h2">Create Property Types Listing</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">

                    </div>
                </div>

                <div class="w-100 d-flex justify-content-center align-items-center">
                    <!-- handle adding property types -->
                    <div class="col-xl-9 col-md-12 col-sm-12 py-2 px-5">
                        <div class="border border-secondary bg-light px-5 rounded">
                            <h1 class="text-center display-4">PROPERTY TYPE</h1>
                            <?php echo $saving_property_err ?>
                            <?php
                            if ($property_type_name_err) {
                                echo "<div class='alert alert-danger text-center'>" . json_encode($property_type_name_err) . "</div>";
                            }
                            ?>
                            <?php echo $type_success_msg ?>
                            <form action="" class="w-100 px-5 py-2" method="post">
                                <input type="text" class="form-control" name="property_type_name">
                                <div class="d-flex w-100 py-1">
                                    <input type="submit" class="btn btn-success mx-auto" value="CREATE PROPERTY TYPE"
                                        name="form_submit_property_type" />
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Property Types Listing</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary">
                                Share
                            </button>z
                            <button type="button" class="btn btn-sm btn-outline-secondary">
                                Export
                            </button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th scope="col">#ID</th>
                                <th scope="col">Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($list->num_rows > 0) {
                                while ($row = $list->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . mb_convert_case($row["name"], MB_CASE_TITLE, "UTF-8") . "</td>";
                                    echo "</tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
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