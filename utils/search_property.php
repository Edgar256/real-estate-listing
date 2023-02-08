<?php
// import Config File
require_once('../config/config.php');

// Processing form data when form is submitted                
if (isset($_POST['property_name']) || isset($_POST['location_id'])) {

    $property_name = $_POST['property_name'];
    $location_id = $_POST['location_id'];

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
        $query = "SELECT properties.*, locations.id AS location_id, locations.name AS location_name,  types.name AS property_type_name FROM properties JOIN locations ON properties.property_location = locations.id JOIN types ON properties.property_type = types.id  WHERE UPPER(title) LIKE UPPER('%$property_name%') ORDER BY reg_date DESC";
        $result = $conn->query($query);
        $check_properties_list = $conn->query($query);        

        if ($check_properties_list->num_rows > 0) {
            while ($row = $check_properties_list->fetch_assoc()) {
                $title = mb_convert_case($row["title"], MB_CASE_TITLE, "UTF-8");
                $id = $row["id"];
                // $description = $row["property_description"];
                if (strlen($row["property_description"]) > 110) {
                    $description = substr($row["property_description"], 0, 110);
                    $description = $description . "...";
                } else {
                    $description = $row["property_description"];
                }
                $price = $row["price"];
                $location = mb_convert_case($row["location_name"], MB_CASE_TITLE, "UTF-8");
                $imageData = $row['property_image'];
                $imageData = base64_encode($imageData);
                $datePosted = $row["reg_date"];
                $property_type_name = mb_convert_case($row["property_type_name"], MB_CASE_TITLE, "UTF-8");
                $property_is_taken = $row["is_taken"];

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
                echo '<div class="card-body">
                            <p class="text_muted"><small><i>Posted : ' . date("F j, Y, g:i a", strtotime($datePosted)) . '</i></small></p>
                            <h5 class="card-title">' . $title . '</h5>
                            <h6>Location : ' . $location . '</h6>
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
    }

    if (empty(trim($_POST["property_name"])) && !empty(trim($_POST["location_id"]))) {
        $location_id = trim($_POST["location_id"]);
        $query = "SELECT properties.*, locations.id AS location_id, locations.name AS location_name,  types.name AS property_type_name FROM properties JOIN locations ON properties.property_location = locations.id JOIN types ON properties.property_type = types.id  WHERE property_location='$location_id' ORDER BY reg_date DESC";
        $result = $conn->query($query);
        $check_properties_list = $conn->query($query);

        if ($check_properties_list->num_rows > 0) {
            while ($row = $check_properties_list->fetch_assoc()) {
                $title = mb_convert_case($row["title"], MB_CASE_TITLE, "UTF-8");
                $id = $row["id"];
                $description = $row["property_description"];
                $price = $row["price"];
                $location = mb_convert_case($row["location_name"], MB_CASE_TITLE, "UTF-8");
                $imageData = $row['property_image'];
                $imageData = base64_encode($imageData);
                $datePosted = $row["reg_date"];
                $property_type_name = mb_convert_case($row["property_type_name"], MB_CASE_TITLE, "UTF-8");
                $property_is_taken = $row["is_taken"];

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
                echo ' <div class="card-body">
                            <p class="text_muted"><small><i>Posted : ' . date("F j, Y, g:i a", strtotime($datePosted)) . '</i></small></p>
                            <h5 class="card-title">' . $title . '</h5>
                            <h6>Location : ' . $location . '</h6>
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
    }

    if (!empty(trim($_POST["location_id"])) && !empty(trim($_POST["property_name"]))) {
        $property_name = trim($_POST["property_name"]);
        $property_name = mb_strtolower($property_name);
        $property_name = ucwords($property_name);
        $property_name = mysqli_real_escape_string($conn, $property_name);
        $query = "SELECT properties.*, locations.id AS location_id, locations.name AS location_name,  types.name AS property_type_name FROM properties JOIN locations ON properties.property_location = locations.id JOIN types ON properties.property_type = types.id  WHERE UPPER(title) LIKE UPPER('%$property_name%') AND property_location='$location_id' ORDER BY reg_date DESC";
        $result = $conn->query($query);
        $check_properties_list = $conn->query($query);

        if ($check_properties_list->num_rows > 0) {
            while ($row = $check_properties_list->fetch_assoc()) {
                $title = mb_convert_case($row["title"], MB_CASE_TITLE, "UTF-8");
                $id = $row["id"];
                $description = $row["property_description"];
                $price = $row["price"];
                $location = mb_convert_case($row["location_name"], MB_CASE_TITLE, "UTF-8");
                $imageData = $row['property_image'];
                $imageData = base64_encode($imageData);
                $datePosted = $row["reg_date"];
                $property_type_name = mb_convert_case($row["property_type_name"], MB_CASE_TITLE, "UTF-8");
                $property_is_taken = $row["is_taken"];

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
                echo ' <div class="card-body">
                            <p class="text_muted"><small><i>Posted : ' . date("F j, Y, g:i a", strtotime($datePosted)) . '</i></small></p>
                            <h5 class="card-title">' . $title . '</h5>
                            <h6>Location : ' . $location . '</h6>
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
    }

    if (empty(trim($_POST["location_id"])) && empty(trim($_POST["property_name"]))) {
        $property_name = trim($_POST["property_name"]);
        $property_name = mb_strtolower($property_name);
        $property_name = ucwords($property_name);
        $property_name = mysqli_real_escape_string($conn, $property_name);
        $query = "SELECT properties.*, locations.id AS location_id, locations.name AS location_name,  types.name AS property_type_name FROM properties JOIN locations ON properties.property_location = locations.id JOIN types ON properties.property_type = types.id ORDER BY reg_date DESC";
        $result = $conn->query($query);
        $check_properties_list = $conn->query($query);
        $property_is_taken = $row["is_taken"];

        if ($check_properties_list->num_rows > 0) {
            while ($row = $check_properties_list->fetch_assoc()) {
                $title = mb_convert_case($row["title"], MB_CASE_TITLE, "UTF-8");
                $id = $row["id"];
                $description = $row["property_description"];
                $price = $row["price"];
                $location = mb_convert_case($row["location_name"], MB_CASE_TITLE, "UTF-8");
                $imageData = $row['property_image'];
                $imageData = base64_encode($imageData);
                $datePosted = $row["reg_date"];
                $property_type_name = mb_convert_case($row["property_type_name"], MB_CASE_TITLE, "UTF-8");

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
                echo ' <div class="card-body">
                            <p class="text_muted"><small><i>Posted : ' . date("F j, Y, g:i a", strtotime($datePosted)) . '</i></small></p>
                            <h5 class="card-title">' . $title . '</h5>
                            <h6>Location : ' . $location . '</h6>
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
    }




}
?>