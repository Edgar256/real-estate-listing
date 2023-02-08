<?php
// import Config File
require_once('./config/config.php');

// Automatically logut after 30 minutes
$inactive = 1800;

// start session if session is not started
if (!isset($_SESSION)) {
  ini_set('session.gc_maxlifetime', $inactive);
  session_start();

}
if (isset($_SESSION['email']) && (time() - $_SESSION['time'] > $inactive)) {
  session_unset(); // unset $_SESSION variable for this page
  session_destroy(); // destroy session data
  header("Location: index.php");
}

$firstname = $lastname = '';

// // check if email session variable is set
if (isset($_SESSION['email']) && isset($_SESSION['firstname']) && isset($_SESSION['lastname'])) {
  $firstname = $_SESSION['firstname'];
  $lastname = $_SESSION['lastname'];
}

?>

<nav class="navbar navbar-expand-lg navbar-light 
    <?php
    if (isset($_SESSION['email'])) {
      if ($_SESSION["role"] == "ADMIN") {
        echo "bg-dark";
      } else if ($_SESSION["role"] == "MANAGER") {
        echo "bg-primary";
      } else {
        echo "bg-light";
      }
    }

    ?>">
  <div class="container">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01"
      aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
      <a class="navbar-brand" href="index.php">
        <img src="./images/logo.svg" height="60" width="150" alt="" />
      </a>
      <ul class="navbar-nav me-auto mb-2 mb-lg-0"></ul>
      <?php
      if ($_SESSION) {
        if ($_SESSION['auth_active']) {
          if ($firstname && $lastname) {
             if ($_SESSION["role"] == "MANAGER") {
              echo '<div class="dropdown">' .
                '<button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"> ' . 'Hey (' . $_SESSION["role"] . ') ' . $firstname . ' ' . $lastname . '</button>' .
                '<ul class="dropdown-menu w-100 text-center">'.
                '<li><a class="dropdown-item" href="listing-manager.php">Listing</a></li>'.
                '<li class="p-2"><a class="dropdown-item" href="scheduled-visits-manager.php">Scheduled Visits</a></li>'.
                '<li class="p-2"><a class="btn btn-danger w-100" href="./auth/logout.php">Logout</a></li>' .
                '</ul></div>';
            } else {
              echo '<div class="dropdown">' .
                '<button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"> ' . 'Hey ' . ' ' . $firstname . ' ' . $lastname . '</button>' .
                '<ul class="dropdown-menu w-100 text-center">'.
                '<li><a class="dropdown-item" href="listing.php">Property Listings</a></li>'.
                '<li class="p-2"><a class="dropdown-item" href="scheduled-visits.php">Scheduled Visits</a></li>'.
                '<li class="p-2"><a class="btn btn-danger w-100" href="./auth/logout.php">Logout</a></li>'.
                '</ul></div>';
            }
          } else {
            echo '<span class="d-flex">
              <a class="nav-link" href="./auth/user-login.php">Login</a>
              <a class="nav-link" href="./auth/user-register.php">Register</a>
            </span>';
          }
        } else {
          echo '<span class="d-flex">
              <a class="nav-link" href="./auth/user-login.php">Login</a>
              <a class="nav-link" href="./auth/user-register.php">Register</a>
            </span>';
        }
      } else {
        echo '<span class="d-flex">
              <a class="nav-link" href="./auth/user-login.php">Login</a>
              <a class="nav-link" href="./auth/user-register.php">Register</a>
            </span>';
      }



      ?>

    </div>
  </div>
</nav>