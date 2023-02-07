<?php
// import Config File
require('./config/config.php');

if (!isset($_SESSION)) {
    session_start();
}

$_SESSION['page'] = 'scheduled-visits';

// redirect to user login if session is expired
if (!$_SESSION['auth_active']) {
    echo '<script>alert("Your Session has expired please login")</script>';
    echo '<script>setTimeout(function(){
        window.location.href = "./auth/manager-login.php";
    }, 1000);</script>';
}
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Define variables and initialize with empty values
$users = $list = "";

$property_name = $location_id = $entries_err = $result = $search_query = $property_type_name = $user = $saving_location_err = $location_success_msg = $location_name_err = "";
$check_properties_list = array();

$status = "pending";

$user = $_SESSION['id'];

$sql = "SELECT visits.*, properties.title AS title, properties.property_description AS property_description, properties.price AS price, properties.property_image AS property_image, managers.firstname AS firstname , managers.lastname AS lastname  FROM visits JOIN properties ON visits.property = properties.id JOIN managers ON visits.manager = managers.id WHERE status='" . $status . "' ORDER BY visits.reg_date DESC";
$list = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors" />
    <meta name="generator" content="Hugo 0.101.0" />
    <title>Real Estate</title>

    <!-- BOOTSTRAP CSS LINKS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

    <!-- Custom styles for this template -->
    <link href="./css/dashboard.css" rel="stylesheet" />

    <!-- CSS LINKS -->
    <link rel="stylesheet" href="./css/style.css" />

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
                    <h1 class="h2">Scheduled Visits Listing</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary">
                                Share
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">
                                Export
                            </button>
                        </div>
                    </div>
                </div>

                <!-- start seacrh section -->
                <div class="container pt-5">

                    <div class="d-flex">
                        <?php echo $entries_err; ?>
                    </div>
                    <form class="row gx-3 gy-2 align-items-center" method="post" id="search-form">
                        <div class="col-sm-5">
                            <div class="container display-4">Scheduled Visits</div>
                        </div>
                        <div class="col-sm-5">
                            <!-- <label for="specificSizeInputName">Search by Location</label> -->
                            <select name="status" id="status" class="form-control">
                                <option value="pending">Pending</option>
                                <option value="rejected">Rejected</option>
                                <option value="cancelled">Cancelled</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                        <input type="text" id="user" value="<?php echo $_SESSION['id'] ?>" class="d-none">
                        <div class="col-sm-2">
                            <input type="submit" class="btn btn-primary w-100" name="submit" value="Submit" />
                        </div>
                    </form>
                </div>
                <!-- end search section -->

                <div class="d-flex flex-wrap pb-5 mb-5" id="results">

                    <?php

                    // Displaying default property list              
                    if ($list->num_rows > 0) {
                        while ($row = $list->fetch_assoc()) {
                            $title = mb_convert_case($row["title"], MB_CASE_TITLE, "UTF-8"); // Change title to title case
                            $id = $row["id"];
                            // description should not be more than 120 characters
                            if (strlen($row["property_description"]) > 110) {
                                $description = substr($row["property_description"], 0, 110);
                                $description = $description . "...";
                            } else {
                                $description = $row["property_description"];
                            }
                            $price = $row["price"];
                            $imageData = $row['property_image'];
                            $imageData = base64_encode($imageData);
                            $datePosted = $row["reg_date"];
                            $visit_date = $row["visit_date"];
                            $visit_time = $row["visit_time"];
                            $visit_status = $row["status"];
                            if (strlen($row["note"]) > 100) {
                                $note = substr($row["note"], 0, 100);
                                $note = $note . "...";
                            } else {
                                $note = $row["note"];
                            }

                            echo '<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 p-1">
                            <div class="card">
                                <span style="background-image: url(data:image/jpeg;base64,' . $imageData . ');
                                    background-size: cover;
                                    background-repeat: no-repeat;
                                    background-position: center center;
                                    width: 100%;
                                    border-radius: 3px 3px 0px 0px;
                                    min-height: 200px;">           
                                </span>';
                            if ($visit_status === "pending") {
                                echo '<div class="right-0 position-absolute p-1"><span class="badge bg-primary">Pending</span></div>';
                            } else if ($visit_status === "rejected") {
                                echo '<div class="right-0 position-absolute p-1"><span class="badge bg-danger">Rejected</span></div>';
                            } else if ($visit_status === "cancelled") {
                                echo '<div class="right-0 position-absolute p-1"><span class="badge bg-warning">Cancelled</span></div>';
                            } else if ($visit_status === "completed") {
                                echo '<div class="right-0 position-absolute p-1"><span class="badge bg-success">Completed</span></div>';
                            }
                            ;
                            echo '<div class="card-body">
                                    <p class="text_muted"><small><i>Posted : ' . date("F j, Y, g:i a", strtotime($datePosted)) . '</i></small></p>
                                    <h5 class="card-title">' . $title . '</h5>
                                    <h6>Price: USD ' . number_format($price) . '</h6>
                                    <p class="card-text">
                                        ' . $description . '
                                    </p><hr />
                                    <h6>Scheduled Date : ' . date("F jS, Y", strtotime($visit_date)) . '</h6><h6>Scheduled Time : ' . date("h:i a", strtotime($visit_time)) . '</h6><p class="card-text"> ' . $note . '</p>';
                            if ($visit_status === "pending") {
                                echo '<button class="btn btn-danger w-100 rejectButton" value="' . $row["id"] . '" data-currentStatus="' . $status . '" data-manager="' . $_SESSION['id'] . '" >Reject Visit</button>';
                                echo '<button class="btn btn-success w-100 completeButton mt-2" value="' . $row["id"] . '" data-currentStatus="' . $status . '" data-manager="' . $_SESSION['id'] . '" >Mark As Completed</button>';
                            }
                            echo '</div> </div> </div>';
                        }
                    } else {
                        echo '<div class="col-12">
                        <div class="alert alert-warning" role="alert">
                            No scheduled visits found
                        </div>
                    </div>';
                    }

                    ?>

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

    <!-- JQUERY LINK -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script defer>
        $(document).ready(function () {

            // AJAX CALL FOR FILTER BUTTON
            $("#search-form").submit(function (e) {
                e.preventDefault();
                var status = $('#status').val();

                $.ajax({
                    url: "./utils/search_visits_admin.php",
                    type: "post",
                    data: $('#search-form').serialize(),
                    data: { status },
                    success: function (response) {
                        $("#results").html(response);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // handle error
                        console.log({ jqXHR, textStatus, errorThrown });
                    }

                })
            });

            // AJAX CALL FOR CANCEL BUTTON
            $(document).on("click", ".rejectButton", function () {
                var id = $(this).attr('value');
                var status = $(this).attr('data-currentStatus');

                $.ajax({
                    url: './utils/reject_visit_admin.php',
                    type: 'post',
                    data: { id, status },
                    success: function (response) {
                        $("#results").html(response);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // handle error
                        console.log({ jqXHR, textStatus, errorThrown });
                    }
                });
            });

            // AJAX CALL FOR COMPLETE BUTTON
            $(document).on("click", ".completeButton", function () {
                var id = $(this).attr('value');
                var status = $(this).attr('data-currentStatus');

                $.ajax({
                    url: './utils/complete_visit_admin.php',
                    type: 'post',
                    data: { id, status },
                    success: function (response) {
                        $("#results").html(response);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // handle error
                        console.log({ jqXHR, textStatus, errorThrown });
                    }
                });
            });

        });
    </script>
</body>

</html>