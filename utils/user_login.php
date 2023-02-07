<?php
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

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
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
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

                $inactive = 3600;                

                // start session if session is not started
                if (!isset($_SESSION)) {
                    ini_set('session.gc_maxlifetime', $inactive); // set the session max lifetime to 2 hours
                    session_start();                   
                }

                // set session variables
                $_SESSION['email'] = $user['email'];
                $_SESSION['firstname'] = $user['firstname'];
                $_SESSION['lastname'] = $user['lastname'];
                $_SESSION['phone'] = $user['phone'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['time'] = time();
                $_SESSION['auth_active'] = TRUE;
                $_SESSION['id'] = $user['id'];

                $success_msg = '<div class="alert alert-success text-center">
                Login was successful.</div>';

                echo '<script>setTimeout(function(){
                    window.location.href = "../listing.php";
                }, 1500);</script>';

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
    $conn->close();

}
?>