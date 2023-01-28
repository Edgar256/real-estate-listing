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

// require user-register.php
require('./utils/user_register.php');

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

        <!-- start register body -->
        <div class="position-relative">
            <div class="container d-flex">
                <div class="col-6 col-xl-6 col-sm-12 mx-auto py-5">
                    <h1 class="text-center display-4">USER REGISTRATION</h1>
                    <!-- Display error if fail to save user -->
                    <?php if (!empty($saving_user_err)) {
                        echo $saving_user_err;
                    } ?>

                    <?php echo $email_err ?>
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
                            <a href="user-login.php" class="text-decoration-none text-center w-100">Already have
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