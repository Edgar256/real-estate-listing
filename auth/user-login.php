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
$email = $password = "";
$email_err = $password_err = "";
$login_err = $success_msg = "";

// require user-login.php
require('../utils/user_login.php');

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

        <!-- start login body -->
        <div class="position-relative">
            <div class="container d-flex">

                <div class="col-6 col-xl-6 col-sm-12 mx-auto py-5">
                    <h1 class="text-center display-4">USER LOGIN</h1>
                    <div>
                        <?php echo $login_err; ?>
                        <?php echo $success_msg; ?>
                    </div>
                    <!-- Login form  -->
                    <form class="py-5" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>' method="post"
                        action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" onsubmit="return validateForm()">
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Email<span
                                    class="text-danger pl-2">*</span></label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control <?php if (!empty($email_err))
                                    echo "border-danger"; ?>" name="email" id="email" required/>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control <?php if (!empty($password_err))
                                    echo "border-danger"; ?>" name="password" id="password" required/>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary w-100" value="Login" />
                        <div class="d-flex py-4">
                            <a href="user-register.php" class="text-decoration-none text-center w-100">Do not have
                                Account? Register</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end login body -->

        <!-- import the footer section-->
        <?php
        include './footer.php';
        ?>

    </div>

    <script>
        // Function to validate form input
        function validateForm() {
            // Get input values
            var email = document.getElementById("email").value;
            var password = document.getElementById("password").value;

            // Check if input values are not empty
            if (email == "" || password == "" ) {
                alert("All fields are required!");
                return false;
            }

            // Check if email is a valid email address
            if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
                alert("Invalid email address!");
                return false;
            }

            // If all validation checks pass, return true
            return true;
        }
    </script>
</body>

</html>