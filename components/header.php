<?php
// import Config File
require_once('config.php');

session_start();

$firstname = $lastname = '';

// check if email session variable is set
if (isset($_SESSION['email'])) {
  $firstname = $_SESSION['firstname'];
  $lastname = $_SESSION['lastname'];
}

?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01"
      aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
      <a class="navbar-brand" href="index.php">
        <img src="./images/logo.png" height="50" width="100" alt="" />
      </a>
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

      </ul>
      <?php
      if ($firstname && $lastname) {
        echo '<span class="d-flex">
                  <span class="nav-link" href="login-user.php">' . 'Horray ' . ' ' . $firstname . ' ' . $lastname . '</span>
                  <a href="./auth/logout.php" class="btn btn-danger text-white">LOGOUT</a>
              </span>';
      } else {
        echo '<span class="d-flex">
                  <a class="nav-link" href="login-user.php">Login</a>
                  <a class="nav-link" href="register-user.php">Register</a>
              </span>';
      }
      ?>

    </div>
  </div>
</nav>