<?php
// import Config File
require('config.php');
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Define variables and initialize with empty values
$firstname = $lastname = $email = $phone = $password = $confirm_password = "";
$firstname_err = $lastname_err = $email_err = $phone_err = $password_err = $confirm_password_err = "";
$saving_user_err = "";
$success_msg = "";


// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate firstname
    if (empty(trim($_POST["firstname"]))) {
        $firstname_err = '<div class="text-danger">
            First name is required.
        </div>';
    } elseif (strlen(trim($_POST["firstname"])) < 2) {
        $firstname_err = "firstname must have atleast 2 characters.";
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
        $lastname_err = "lastname must have atleast 2 characters.";
    } else {
        $lastname = trim($_POST["lastname"]);
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        // $email_err = "Please enter a email.";
        $email_err = '<div class="alert alert-danger">
            Email is required.
        </div>';
    } else {

        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Invalid email format";
        }

        // verify if email exists
        $emailCheck = $conn->query("SELECT * FROM admins WHERE email = '{$email}' ");
        if (!empty($emailCheck) > 0) {
            // Email exists
            $email_err = "Email already taken format";
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
        $sql = "INSERT INTO admins (firstname, lastname, email, phone, password) VALUES ('$firstname', '$lastname', '$email', '$phone', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
            $success_msg = '<div class="alert alert-success text-center">
            Your account was successfully created.</div>';

            // once user is logged in , redirect to listing page after 2 seconds
            // sleep(10);
            header("Location: login-admin.php");
        } else {
            $saving_user_err = $conn->error;
        }
    }


    // Close connection
    // $mysqli->close();
}

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
</head>

<body>
    <div class="position-relative">

        <!-- import the header section-->
        <?php include './components/header.php'; ?>

        <!-- start register body -->
        <div class="position-relative">
            <div class="container d-flex">
                <div class="col-6 col-xl-6 col-sm-12 mx-auto py-5">
                    <h1 class="text-center display-4">ADMIN REGISTRATION</h1>

                    <!-- Display error if fail to save user -->
                    <?php if (!empty($saving_user_err)) {
                        echo "<div class='alert alert-danger'>" . json_encode($saving_user_err) . "</div>";
                    } ?>

                    <?php echo $success_msg ?>

                    <!-- Login form  -->
                    <form class="row g-3" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>' method="POST">
                        <div class="col-md-6">
                            <label for="firstname" class="form-label">First Name <span
                                    class="text-danger pl-2">*</span></label>
                            <input type="text" class="form-control <?php if (!empty($firstname_err))
                                echo "border-danger"; ?>" name="firstname" />
                        </div>
                        <div class="col-md-6">
                            <label for="lastname" class="form-label">Last Name<span
                                    class="text-danger pl-2">*</span></label>
                            <input type="text" class="form-control <?php if (!empty($lastname_err))
                                echo "border-danger"; ?>" name="lastname" />
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email<span class="text-danger pl-2">*</span></label>
                            <input type="email" class="form-control <?php if (!empty($email_err))
                                echo "border-danger"; ?>" name="email" />
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone<span class="text-danger pl-2">*</span></label>
                            <input type="tel" class="form-control <?php if (!empty($phone_err))
                                echo "border-danger"; ?>" name="phone" />
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password<span
                                    class="text-danger pl-2">*</span></label>
                            <input type="password" class="form-control <?php if (!empty($password_err))
                                echo "border-danger"; ?>" name="password" />
                        </div>
                        <div class="col-md-6">
                            <label for="confirm_password" class="form-label">Confirm Password<span
                                    class="text-danger pl-2">*</span></label>
                            <input type="password" class="form-control <?php if (!empty($confirm_password_err))
                                echo "border-danger"; ?>" name="confirm_password" />
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary w-100">
                                Sign up
                            </button>
                        </div>
                        <div class="d-flex py-4">
                            <a href="admin-login.php" class="text-decoration-none text-center w-100">Already have
                                Account? Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end register body -->

        <!-- import the footer section-->
        <?php
        include './components/footer.php';
        ?>

    </div>
</body>

</html>