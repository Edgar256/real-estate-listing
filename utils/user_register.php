<?php

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate firstname
    if (empty(trim($_POST["firstname"]))) {
        $firstname_err = '<div class="text-danger">
            First name is required.
        </div>';
    } elseif (strlen(trim($_POST["firstname"])) < 2) {
        $firstname_err = '<div class="alert alert-danger">
            Firstname must have atleast 2 characters.</div>';
    } else {
        $firstname = trim($_POST["firstname"]);
    }

    // Validate lastname
    if (empty(trim($_POST["lastname"]))) {
        // $lastname_err = "Please enter a lastname.";
        $lastname_err = '<div class="alert alert-danger">
            Last name is required.
        </div>';
    } elseif (strlen(trim($_POST["lastname"])) < 2) {
        $lastname_err = '<div class="alert alert-danger">
            Lastname must have atleast 2 characters.</div>';
    } else {
        $lastname = trim($_POST["lastname"]);
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = '<div class="alert alert-danger">
            Email is required.
        </div>';
    } else {

        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_err = '<div class="alert alert-danger">
            Invalid email format.</div>';
        }

        // verify if email exists
        $emailCheck = $conn->query("SELECT * FROM users WHERE email = '{$email}' ");
        if ($emailCheck->num_rows > 0) {
            // Email exists
            $email_err = '<div class="alert alert-danger">
                Email already taken.</div>';
        } else {
            // Email does not exist
            $email = trim($_POST["email"]);
        }
    }

    // Validate phone
    if (empty(trim($_POST["phone"]))) {
        // $phone_err = "Please enter a phone.";
        $phone_err = '<div class="alert alert-danger">
            Last name is required.
        </div>';
    } elseif (strlen(trim($_POST["phone"])) < 2) {
        $phone_err = "phone must have atleast 2 characters.";
    } else {
        $phone = trim($_POST["phone"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        // $password_err = "Please enter a password.";
        $password_err = '<div class="alert alert-danger">
            Password is required.
        </div>';
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have atleast 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = '<div class="alert alert-danger">
            Confirm Password is required.
        </div>';
    } else {
        $confirm_password = trim($_POST["confirm_password"]);

        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before inserting in database
    if (empty($firstname_err) && empty($password_err) && empty($confirm_password_err)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare an insert statement
        $sql = "INSERT INTO users (firstname, lastname, email, phone, password) VALUES ('$firstname', '$lastname', '$email', '$phone', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {

            $success_msg = '<div class="alert alert-success text-center">
            Your account was successfully created.</div>';

            echo '<script>setTimeout(function(){
                    window.location.href = "user-login.php";
                }, 1500);</script>';
        } else {
            $saving_user_err = '<div class="alert alert-danger">' . 'Failed to Create Account' . '</div>';
        }
    }


    // Close connection
    // $mysqli->close();
}

?>