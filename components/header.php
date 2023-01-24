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
        echo '<div class="dropdown">' .
          '<button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"> ' . 'Hey ' . ' ' . $firstname . ' ' . $lastname . '</button>' .
          '<ul class="dropdown-menu w-100 text-center"><li><a class="dropdown-item" href="listing.php">Listing</a></li><li><a class="dropdown-item" href="./auth/logout.php">Logout</a></li></ul>' .
          '</div>';
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