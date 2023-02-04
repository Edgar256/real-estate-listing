<?php

// import Config File
require_once('../config/config.php');

// Processing form data when form is submitted
if (isset($_POST['date']) || isset($_POST['note']) || isset($_POST['time'])) {

    // Validate note
    $input_note = trim($_POST["note"]);
    if (empty($input_note)) {
        $note_err = "Please enter a note.";
    } else {
        $note = $input_note;
    }

    // Validate date
    $input_date = trim($_POST["date"]);
    if (empty($input_date)) {
        $visit_date_err = "Please enter a date.";
    } else {
        $visit_date = $input_date;
    }

    // Validate time
    $input_time = trim($_POST["time"]);
    if (empty($input_time)) {
        $visit_time_err = "Please enter a time.";
    } else {
        $visit_time = $input_time;
    }

    // Validate user
    $input_user = trim($_POST["user"]);
    if (empty($input_user)) {
        $user_err = "Please enter a user.";
    } else {
        $user = $input_user;
    }

    $property = $_POST["property_id"];
    $manager = $_POST["manager_id"];

    // Check input errors before inserting in database
    if (empty($visit_time_err) && empty($visit_date_err) && empty($note_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO visits (note, visit_date, visit_time, property, user, manager)VALUES ('$note', '$visit_date', '$visit_time', '$property', '$user', '$manager')";

        if ($conn->query($sql) === TRUE) {
            $visit_success_msg = '<div class="alert alert-success text-center">
                  Visit Schedule Added.</div>';
            echo "success";
        } else {
            $visit_err = $conn->error;
            echo "failed";
        }
    }

} else {
    header("Location: ../property-profile.php?id=' . $property . '");
}
?>