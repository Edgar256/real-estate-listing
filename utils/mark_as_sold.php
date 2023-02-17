<?php
// import Config File
require_once('../config/config.php');

if (!isset($_SESSION)) {
    session_start();
}

// Processing form data when form is submitted                
if (isset($_POST['status'])) {

    $status = $_POST['status'];
    $id = $_POST['id'];
    $manager = $_POST['manager'];
    $propertyId = $_POST['propertyId'];
    $userId = $_POST['userId'];

    if (!empty(trim($_POST["status"]))) {

        // Set Property to SOLD
        $sell_sql = "UPDATE properties SET is_taken = true, buyer = '" . $userId . "' WHERE id = '" . $propertyId . "'";
        $sell_property = $conn->query($sell_sql);

        // Return results after updating the status
        $sql = "SELECT visits.*, 
                properties.id AS property_id, 
                properties.is_taken AS property_is_taken, 
                properties.title AS title, 
                properties.property_description AS property_description, 
                properties.price AS price, 
                properties.property_image AS property_image , 
                users.firstname AS firstname, users.lastname AS lastname  
                FROM visits 
                JOIN properties ON visits.property = properties.id 
                JOIN users ON visits.user = users.id 
                WHERE status='" . $status . "' AND visits.manager=' " . $manager . "' ORDER BY visits.reg_date DESC";

        $check_properties_list = $conn->query($sql);

        if ($check_properties_list->num_rows > 0) {
            while ($row = $check_properties_list->fetch_assoc()) {
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
                $firstname = $row["firstname"];
                $lastname = $row["lastname"];
                $visit_date = $row["visit_date"];
                $visit_time = $row["visit_time"];
                $visit_status = $row["status"];
                if (strlen($row["note"]) > 100) {
                    $note = substr($row["note"], 0, 100);
                    $note = $note . "...";
                } else {
                    $note = $row["note"];
                }
                $property_id = $row["property_id"];
                $property_is_taken = $row["property_is_taken"];

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

                if ($visit_status === "pending") {
                    echo '<div class="right-0 position-absolute p-1"><span class="badge bg-primary">Pending</span></div>';
                } else if ($visit_status == "rejected") {
                    echo '<div class="right-0 position-absolute p-1"><span class="badge bg-danger">Rejected</span></div>';
                } else if ($visit_status == "cancelled") {
                    echo '<div class="right-0 position-absolute p-1"><span class="badge bg-warning">Cancelled</span></div>';
                } else if ($visit_status == "completed") {
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
                        <h6>Client : ' . $firstname . ' ' . $lastname . '</h6>
                        <h6>Scheduled Date : ' . date("F jS, Y", strtotime($visit_date)) . '</h6>
                        <h6>Scheduled Time : ' . date("h:i a", strtotime($visit_time)) . '</h6>';

                if ($visit_status === "pending") {
                    echo '<button class="btn btn-danger w-100 cancelButton" value="' . $row["id"] . '" data-currentStatus="' . $status . '" data-user="' . $_SESSION['id'] . '" >Cancel Visit</button>';
                    echo '<button class="btn btn-success w-100 completeButton mt-2" value="' . $row["id"] . '" data-currentStatus="' . $status . '" data-manager="' . $_SESSION['id'] . '" >Mark As Completed</button>';

                }
                if ($visit_status === "completed" && $property_is_taken === "0") {
                    echo '<button class="btn btn-success w-100 sellButton" value="' . $row["id"] . '" data-currentStatus="' . $status . '" data-manager="' . $_SESSION['id'] . '"  data-property-id="' . $property_id . '" >Mark House As Sold</button>';
                }
                echo '</div> </div> </div>';
            }
        } else {
            echo "<div class='w-100 text-center py-5 display-1'>No Results found</div>";
        }

    } else {
        echo "<div class='w-100 text-center py-5 display-1'>Error in status</div>";
    }
}


?>