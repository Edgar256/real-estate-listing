<?php
// import Config File
require('config.php');
require('./auth/clear_sessions.php');

// check if email session variable is set
// if (isset($_SESSION['email'])) {
//     header("Location: index.php");
// }

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

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $login_err = "";
    $success_msg = "";

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
        $email = trim($_POST["email"]);

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

    // Check input errors before inserting in database
    if (empty($email_err) && empty($password_err)) {

        // Prepare and execute the query
        $stmt = $conn->prepare("SELECT * FROM admins WHERE email = ?");
        // $stmt->bind_param("s", $email);
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $stmt->bind_param("s", $email);
        }
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        // Check if the query returned any rows
        if ($result->num_rows > 0) {
            // Fetch the user data
            $user = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $user['password'])) {

                $success_msg = '<div class="alert alert-success text-center">
                Login was successful.</div>';

                session_start();

                // set session variables
                $_SESSION['email'] = $user['email'];
                $_SESSION['firstname'] = $user['firstname'];
                $_SESSION['lastname'] = $user['lastname'];
                $_SESSION['phone'] = $user['phone'];

                // echo json_encode($_SESSION);
                // sleep(5);

                // once user is logged in , redirect to listing page
                header("Location: property-dashboard.php");


            } else {
                $login_err = '<div class="alert alert-danger">
                Invalid Password.</div>';
            }

        } else {
            // Show an error message if email not found
            $login_err = '<div class="alert alert-danger">
                Email not found.</div>';
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

        <!-- start login body -->
        <div class="position-relative">
            <div class="container d-flex">

                <div class="col-6 col-xl-6 col-sm-12 mx-auto py-5">
                    <h1 class="text-center display-4">ADMIN LOGIN</h1>
                    <div>
                        <?php echo $login_err; ?>
                        <?php echo $success_msg; ?>
                    </div>
                    <!-- Login form  -->
                    <form class="py-5" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>' method="post"
                        action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Email<span
                                    class="text-danger pl-2">*</span></label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control <?php if (!empty($email_err))
                                    echo "border-danger"; ?>" name="email" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control <?php if (!empty($password_err))
                                    echo "border-danger"; ?>" name="password" />
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary w-100">Sign in</input>
                        <div class="d-flex py-4">
                            <a href="register-admin.php" class="text-decoration-none">Do not have Account? Register</a>
                            <a href="forgot-password.php" class="text-decoration-none ms-auto">Forgot Password</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end login body -->

        <!-- import the footer section-->
        <?php
        include './components/footer.php';
        ?>

    </div>
</body>

</html>