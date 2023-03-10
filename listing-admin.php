<?php
// import Config File
require('./config/config.php');

if (!isset($_SESSION)) {
    session_start();
}

$_SESSION['page'] = 'property-listing';

// Define variables and initialize with empty values
$users = $list = "";

$table = "properties";

$sql = "SELECT properties.*, 
        locations.name AS location_name, 
        locations.id AS location_id, 
        managers.firstname AS manager_firstname, 
        managers.lastname AS manager_lastname, 
        managers.phone AS manager_phone, 
        managers.email AS manager_email,
        COALESCE(users.firstname, 'N/A') AS user_firstname,
        COALESCE(users.lastname, 'N/A') AS user_lastname,
        COALESCE(users.phone, 'N/A') AS user_phone,
        COALESCE(users.email, 'N/A') AS user_email
        FROM properties 
        JOIN locations ON properties.property_location = locations.id 
        JOIN managers ON properties.manager = managers.id 
        LEFT JOIN users ON properties.buyer = users.id 
        ORDER BY properties.reg_date DESC";

$list = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="Edgar Tinkamanyire" />
    <link rel="icon" type="image/png" href="./images/logo.png">
    <meta name="generator" content="Hugo 0.101.0" />
    <title>Real Estate</title>

    <!-- BOOTSTRAP CSS LINKS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

    <!-- Custom styles for this template -->
    <link href="./css/dashboard.css" rel="stylesheet" />
    <link rel="stylesheet" href="./css/style.css">

    <!-- JQUERY LINK -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).ready(function () {
            $("#search-form").submit(function (e) {
                e.preventDefault();
                var property_name = $("property_name").val();
                var location_id = $('#location_id:selected').val()
                $.ajax({
                    url: "./utils/search_property_admin.php",
                    type: "post",
                    data: $('#search-form').serialize(),
                    success: function (response) {
                        $("#results").html(response);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // handle error
                        console.log({ jqXHR, textStatus, errorThrown });
                    }

                })
            });
        });
    </script>

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
                    <h1 class="h2">Property Listing</h1>
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
                <div class="container pt-1">
                    <form class="row gx-3 gy-2 align-items-center" method="post" id="search-form">
                        <div class="col-sm-5">
                            <!-- <label for="specificSizeInputName">Search by Name</label> -->
                            <input type="text" class="form-control" id="property_name" name="property_name"
                                placeholder="Search by Name" />
                        </div>
                        <div class="col-sm-5">
                            <!-- <label for="specificSizeInputName">Search by Location</label> -->
                            <select name="location_id" id="location_id" class="form-control <?php if (!empty($location_err))
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
                        <div class="col-sm-2">
                            <input type="submit" class="btn btn-primary w-100" name="submit" value="Submit" />
                        </div>
                    </form>
                </div>

                <!-- start listing section -->
                <div class="container d-flex flex-wrap  pb-5 mb-5" id="results">

                    <?php
                    // redirect to user login if session is expired
                    if (!$_SESSION['auth_active']) {
                        echo '<script>alert("Your Session has expired please login")</script>';
                        echo '<script>setTimeout(function(){
                        window.location.href = "./auth/admin-login.php";
                    }, 1000);</script>';
                    }

                    ?>

                    <?php

                    if ($list->num_rows > 0) {
                        while ($row = $list->fetch_assoc()) {
                            $title = mb_convert_case($row["title"], MB_CASE_TITLE, "UTF-8");
                            $id = $row["id"];
                            $description = $row["property_description"];
                            $price = $row["price"];
                            $location = $row["location_name"];
                            $imageData = $row['property_image'];
                            $imageData = base64_encode($imageData);
                            $datePosted = $row["reg_date"];

                            $manager_firstname = mb_convert_case($row["manager_firstname"], MB_CASE_TITLE, "UTF-8");
                            $manager_lastname = mb_convert_case($row["manager_lastname"], MB_CASE_TITLE, "UTF-8");
                            $manager_email = $row["manager_email"];
                            $manager_phone = $row["manager_phone"];
                            $property_is_taken = $row["is_taken"];
                            $user_firstname = mb_convert_case($row["user_firstname"], MB_CASE_TITLE, "UTF-8");
                            $user_lastname = mb_convert_case($row["user_lastname"], MB_CASE_TITLE, "UTF-8");
                            $user_email = $row["user_email"];
                            $user_phone = $row["user_phone"];

                            //retrieve image data from database
                            $imgData = base64_encode($row['property_image']);

                            //create data URI for image
                            $src = 'data:image/jpeg;base64,' . $imgData;

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

                            if ($property_is_taken === "1") {
                                echo '<img src="./images/sold.svg" alt="Sold SVG Image" class="left-0 position-absolute">';
                            }
                            echo '<button type="button" class="btn btn-info position-absolute right-0 m-1 py-1 rounded-pill" data-bs-toggle="modal"  data-bs-target="#editModal' . $id . '" >Edit<span data-feather="edit" class="align-text-bottom ml-2"></span></button>';

                            echo ' <div class="card-body">
                                    <p class="card-title"><small><i>Posted : ' . date("F j, Y, g:i a", strtotime($datePosted)) . '</i></small></p>
                                    <h5 class="card-title">' . $title . '</h5>
                                    <h6>Location: ' . $location . '</h6>
                                    <h6>Price: USD ' . number_format($price) . '</h6>
                                    <p class="card-text">
                                        ' . $description . '
                                    </p><hr>
                                    <div class="mb-2">
                                        <h6>Manager: ' . $manager_firstname . ' ' . $manager_lastname . '</h6>
                                        <p class="m-0">Email: ' . $manager_email . '</p>
                                        <p class="m-0">Phone: ' . $manager_phone . '</p>
                                    </div>';

                            if ($property_is_taken === "1") {
                                echo '<hr><div>                                
                                    <h6>Client: ' . $user_firstname . ' ' . $user_lastname . '</h6>
                                    <p class="m-0">Email: ' . $user_email . '</p>
                                    <p class="m-0">Phone: ' . $user_phone . '</p>
                                </div>';
                            }

                            echo '<form method="post" action="./utils/delete_property.php">
                                        <input type="hidden" name="id" value=' . $id . '>
                                        <input type="submit" name="delete" id="delete" value="DELETE" class="btn btn-danger w-100"/><br/>
                                    </form>

                                </div>
                            </div>
                        </div>';

                            echo '<div class="modal fade" id="editModal' . $id . '" tabindex="-1" aria-labelledby="editPropertyModalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title">Edit Property</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                            <form id="edit-form' . $id . '" class="d-xl-flex flex-wrap d-md-flex d-sm-block" method="post">';

                            echo '<img src="' . $src . '" alt="Property Image" class="img-fluid mb-3 w-100" />';


                            echo '<input type="text" class="form-control" name="id" id="currentProperty' . $id . '" value="' . $id . '" hidden />
                                                <div class="col-xl-12 col-md-12 col-sm-12 p-3">
                                                    <label for="title" class="form-label">Property Title <span class="text-danger pl-2">*</span></label>
                                                    <input type="text" class="form-control" value="' . $title . '" placeholder="' . $title . '" name="title" id="title' . $id . '" />
                                                </div>
                                                <div class="col-xl-12 col-md-12 col-sm-12 p-3">
                                                    <label for="title" class="form-label">Property Price <span class="text-danger pl-2">*</span></label>
                                                    <input type="text" class="form-control" value="' . $price . '" placeholder="' . number_format($price) . '"  name="price" id="price' . $id . '" />
                                                </div>
                                                <div class="col-xl-12 col-md-12 col-sm-12 p-3">
                                                    <label for="title" class="form-label">Property description <span class="text-danger pl-2">*</span></label>
                                                    <textarea class="form-control" name="description" value="' . $description . '" id="description' . $id . '" rows="5" maxLength="254" id="description' . $id . '">' . $description . '</textarea>
                                                </div>
                                                <div class="col-12 pt-2">                                                    
                                                    <input type="submit" name="delete" value="SAVE EDITS" class="btn btn-danger w-100"/><br/>
                                                </div>
                                            </form>                                 
                                            </div>
                                        </div>
                                        </div>
                                    </div>';

                            echo '<script> $(document).ready(function () {
                                    $("#edit-form' . $id . '").submit(function (e) {
                                        e.preventDefault();
                                        var form = $(this);
                                        var currentProperty = $("#currentProperty' . $id . '").val();
                                        var title = $("#title' . $id . '").val();
                                        var price = $("#price' . $id . '").val();
                                        var description = $("#description' . $id . '").val();

                                        if( title=="" || price=="" || description=="" ){
                                            alert("Please fill all the fields");
                                            return;
                                        }

                                        console.log({currentProperty, title, price, description});

                                        $.ajax({
                                            type: "post",
                                            url: "./utils/edit_property.php",
                                            data: { currentProperty, title, price, description},
                                            success: function (data) {
                                                // $("#___editPropertyModal").modal("show");
                                                if (data == "success") {
                                                    alert("Property updated successfully");
                                                    location.reload();
                                                } else {
                                                    console.log("Property update failed");
                                                    console.log(data);
                                                    alert("Something went wrong");
                                                }
                                            }
                                        });
                                    });
                                }); </script>';

                        }
                    } else {
                        echo "No Results found";
                    }

                    //  close the connection
                    $conn->close();
                    ?>

                </div>
                <!-- end lisitng section -->

            </main>
        </div>
    </div>


    <!-- Edit Property Modal -->
    <div class="modal fade" id="___editPropertyModal" tabindex="-1" aria-labelledby="editPropertyModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Success</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="display-6 text-center text-success">
                        Hooray! Your visit has been scheduled. One of our property
                        managers will reach out to you shortly.
                    </p>

                    <div class="col-12 pt-2">
                        <button type="submit" class="btn btn-primary w-100" data-bs-dismiss="modal">
                            DISMISS
                        </button>
                    </div>
                </div>
            </div>
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



    <script>
        $(document).ready(function () {
            $("#edit-form").submit(function (e) {
                e.preventDefault();

                console.log(this)

                var currentProperty = $('#currentProperty').val();
                var title = $('#title').val();
                var price = $('#price').val();
                var description = $('#description').val();

                console.log({ currentProperty, title, price, description });

                // if (!date || !time || !note || !user || !property_id || !manager_id) {
                //   alert('Please fill all the fields');
                //   return;
                // }

                // console.log({ property_id });

                // $.ajax({
                //   url: "./utils/schedule_visit.php",
                //   type: "post",
                //   data: { date, time, note, user, property_id, manager_id },
                //   success: function (response) {
                //     console.log({ response });
                //     if (response == 'success') {
                //       $('#scheduleVisitModal').modal('hide');
                //       $('#scheduleVisitSuccessModal').modal('show');
                //     }
                //   },
                //   error: function (jqXHR, textStatus, errorThrown) {
                //     // handle error
                //     console.log({ Failed });
                //     console.log({ jqXHR, textStatus, errorThrown });
                //   }

                // })

            });
    });
    </script>

</body>

</html>