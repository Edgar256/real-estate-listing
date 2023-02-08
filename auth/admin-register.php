<?php
// import Config File
require('../config/config.php');

// set FALSE to AUTH_ACTIVE SESSION VARIABLE
if (isset($_SESSION)) {
    session_start();
    $_SESSION['auth_active'] = FALSE;
} else {
    session_start();
    $_SESSION['auth_active'] = FALSE;
}

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

// require admin_register.php
require('../utils/admin_register.php');

?>

<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- CSS LINKS -->
    <link rel="stylesheet" href="../css/style.css" />

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

        <!-- start register body -->
        <div class="position-relative">
            <div class="container d-flex">
                <div class="col-6 col-xl-6 col-sm-12 mx-auto py-2">
                    <div class="d-flex justify-content-center align-items-center py-3">
                        <a class="navbar-brand" href="../index.php">
                            <img src="../images/logo-tagline.svg" height="150" width="200" alt="" />
                        </a>
                    </div>
                    <h1 class="text-center display-4">ADMIN REGISTRATION</h1>

                    <!-- Display error if fail to save user -->
                    <?php if (!empty($saving_user_err)) {
                        echo "<div class='alert alert-danger'>" . json_encode($saving_user_err) . "</div>";
                    } ?>

                    <?php echo $success_msg ?>

                    <!-- Login form  -->
                    <form class="row g-3" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>' method="POST"
                        onsubmit="return validateForm()">
                        <div class="col-md-6">
                            <label for="firstname" class="form-label">First Name <span
                                    class="text-danger pl-2">*</span></label>
                            <input type="text" class="form-control <?php if (!empty($firstname_err))
                                echo "border-danger"; ?>" name="firstname" id="firstname" required />
                        </div>
                        <div class="col-md-6">
                            <label for="lastname" class="form-label">Last Name<span
                                    class="text-danger pl-2">*</span></label>
                            <input type="text" class="form-control <?php if (!empty($lastname_err))
                                echo "border-danger"; ?>" name="lastname" id="lastname" required />
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email<span class="text-danger pl-2">*</span></label>
                            <input type="email" class="form-control <?php if (!empty($email_err))
                                echo "border-danger"; ?>" name="email" id="email" required />
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone<span class="text-danger pl-2">*</span></label>
                            <input type="tel" class="form-control <?php if (!empty($phone_err))
                                echo "border-danger"; ?>" name="phone" id="phone" required />
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password<span
                                    class="text-danger pl-2">*</span></label>
                            <input type="password" class="form-control <?php if (!empty($password_err))
                                echo "border-danger"; ?>" name="password" id="password" required />
                        </div>
                        <div class="col-md-6">
                            <label for="confirm_password" class="form-label">Confirm Password<span
                                    class="text-danger pl-2">*</span></label>
                            <input type="password" class="form-control <?php if (!empty($confirm_password_err))
                                echo "border-danger"; ?>" name="confirm_password" id="confirmPassword" required />
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
        include './footer.php';
        ?>

    </div>

    <script>
        // Function to validate form input
        function validateForm() {
            // Get input values
            var firstname = document.getElementById("firstnamename").value;
            console.log(firstname);
            var lastname = document.getElementById("lastnamename").value;
            var email = document.getElementById("email").value;
            var phone = document.getElementById("phone").value;
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirmPassword").value;

            // Check if input values are not empty
            if (firstname == "" || lastname == "" || email == "" || phone == "" || password == "" || confirmPassword == "") {
                alert("All fields are required!");
                return false;
            }

            // Check if email is a valid email address
            if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
                alert("Invalid email address!");
                return false;
            }

            // Check if phone number is valid
            if (!/^\d{10}$/.test(phone)) {
                alert("Invalid phone number!");
                return false;
            }

            if (password.length < 6) {
                alert("Password must be at least 6 characters long!");
                return false;
            }

            if (password != confirmPassword) {
                alert("Passwords do not match!");
                return false;
            }

            // If all validation checks pass, return true
            return true;
        }
    </script>
</body>

</html>