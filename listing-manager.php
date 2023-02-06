<?php
// import Config File
require_once('./config/config.php');

if (!isset($_SESSION)) {
    session_start();
}

$table = "properties";
$property_type_name = "";
$sql = "SELECT properties.*, locations.id AS location_id, locations.name AS location_name,  types.name AS property_type_name FROM properties JOIN locations ON properties.property_location = locations.id JOIN types ON properties.property_type = types.id WHERE manager =" . $_SESSION['id'] . " ORDER BY reg_date DESC";
$check_properties_list = $conn->query($sql);

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

    <!-- JQUERY LINK -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).ready(function () {
            $("#search-form").submit(function (e) {
                e.preventDefault();
                var property_name = $("#property_name").val();
                var location_id = $('#location_id').val();

                console.log({ property_name, location_id });

                $.ajax({
                    url: "./utils/search_property_manager.php",
                    type: "post",
                    data: $('#search-form').serialize(),
                    // data: { property_name, location_id },
                    success: function (response) {
                        console.log(response);
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
    <div class="position-relative">

        <!-- import the header section-->
        <?php include './components/header.php'; ?>

        <div class="position-relative">

            <!-- start seacrh section -->
            <div class="container pt-5">
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
            <!-- end search section -->

            <!-- start listing section -->
            <div class="container d-flex flex-wrap pb-5 mb-5" id="results">
                <div class='w-100 py-2 h3'>Displaying all properties attached to you as a Property Manager</div>
                <?php
                // redirect to manager login if session is expired
                if (!$_SESSION['auth_active']) {
                    echo '<script>alert("Your Session has expired please login")</script>';
                    echo '<script>setTimeout(function(){
                        window.location.href = "./auth/manager-login.php";
                    }, 1000);</script>';
                }

                if ($_SESSION['role'] == "MANAGER") {

                    if ($check_properties_list->num_rows > 0) {
                        while ($row = $check_properties_list->fetch_assoc()) {
                            $title = mb_convert_case($row["title"], MB_CASE_TITLE, "UTF-8");
                            $id = $row["id"];
                            // description should not be more than 120 characters
                            if (strlen($row["property_description"]) > 110) {
                                $description = substr($row["property_description"], 0, 110);
                                $description = $description . "...";
                            } else {
                                $description = $row["property_description"];
                            }
                            $price = $row["price"];
                            $location = $row["location_name"];
                            $imageData = $row['property_image'];
                            $imageData = base64_encode($imageData);
                            $datePosted = $row["reg_date"];
                            $property_type_name = $row["property_type_name"];

                            echo '<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 p-1">
                                <div class="card">
                                    <span style="background-image: url(data:image/jpeg;base64,' . $imageData . ');
                                        background-size: cover;
                                        background-repeat: no-repeat;
                                        background-position: center center;
                                        width: 100%;
                                        border-radius: 3px 3px 0px 0px;
                                        min-height: 200px;">
                                    </span>
                                    <div class="card-body">
                                        <p class="text_muted"><small><i>Posted :' . date("F j, Y, g:i a", strtotime($datePosted)) . '</i></small></p>
                                        <h5 class="card-title">' . $title . '</h5>
                                        <h6>Location: ' . $location . '</h6>
                                        <h6>Property Type : ' . $property_type_name . '</h6>
                                        <h6>Price: USD ' . number_format($price) . '</h6>
                                        <p class="card-text">
                                            ' . $description . '
                                        </p>
                                        <a href="./property-profile.php?id=' . $id . '" class="btn btn-primary w-100">View More</a>
                                    </div>
                                </div>
                            </div>';
                        }
                    } else {
                        echo "<div class='w-100 text-center py-5 display-1'>No Results found</div>";
                    }
                } else {
                    header("location:javascript://history.go(-1)");
                }

                ?>

            </div>
            <!-- end lisitng section -->

            <!-- import the footer section-->
            <?php
            include './components/footer.php';
            ?>

        </div>
    </div>
</body>

</html>