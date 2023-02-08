<?php
// import Config File
require('./config/config.php');

if (!isset($_SESSION)) {
  session_start();
}

$_SESSION['page'] = 'dashboard';

// Define variables and initialize with empty values
$count_users = $count_managers = $count_admins = $count_properties = $count_property_types = $count_locations = $count_visits = 0;
$users_err = "";

$sql = "SELECT COUNT(*) FROM users";
$result = $conn->query($sql);

// Check if there is a result
if ($result->num_rows > 0) {

  // Fetch the result
  $row = $result->fetch_assoc();

  // Extract the count from the result
  $count_users = $row["COUNT(*)"];

} else {
  $count_users = 0;
}

$sql = "SELECT COUNT(*) FROM managers";
$result = $conn->query($sql);

// Check if there is a result
if ($result->num_rows > 0) {

  // Fetch the result
  $row = $result->fetch_assoc();

  // Extract the count from the result
  $count_managers = $row["COUNT(*)"];

} else {
  $count_managers = 0;
}

$sql = "SELECT COUNT(*) FROM admins";
$result = $conn->query($sql);

// Check if there is a result
if ($result->num_rows > 0) {

  // Fetch the result
  $row = $result->fetch_assoc();

  // Extract the count from the result
  $count_admins = $row["COUNT(*)"];

} else {
  $count_admins = 0;
}

$sql = "SELECT COUNT(*) FROM properties";
$result = $conn->query($sql);

// Check if there is a result
if ($result->num_rows > 0) {

  // Fetch the result
  $row = $result->fetch_assoc();

  // Extract the count from the result
  $count_properties = $row["COUNT(*)"];

} else {
  $count_properties = 0;
}

$sql = "SELECT COUNT(*) FROM types";
$result = $conn->query($sql);

// Check if there is a result
if ($result->num_rows > 0) {

  // Fetch the result
  $row = $result->fetch_assoc();

  // Extract the count from the result
  $count_property_types = $row["COUNT(*)"];

} else {
  $count_property_types = 0;
}

$sql = "SELECT COUNT(*) FROM locations";
$result = $conn->query($sql);

// Check if there is a result
if ($result->num_rows > 0) {

  // Fetch the result
  $row = $result->fetch_assoc();

  // Extract the count from the result
  $count_locations = $row["COUNT(*)"];

} else {
  $count_locations = 0;
}


$sql = "SELECT COUNT(*) FROM visits";
$result = $conn->query($sql);

// Check if there is a result
if ($result->num_rows > 0) {

  // Fetch the result
  $row = $result->fetch_assoc();

  // Extract the count from the result
  $count_visits = $row["COUNT(*)"];

} else {
  $count_visits = 0;
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="" />
  <meta name="author" content="Edgar Tinkamanyire" />
  <meta name="generator" content="Hugo 0.101.0" />
  <title>Dashboard Template · Bootstrap v5.2</title>

  <!-- BOOTSTRAP CSS LINKS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

  <!-- Custom styles for this template -->
  <link href="./css/dashboard.css" rel="stylesheet" />

</head>

<body>

  <!-- Inculde admin header -->
  <?php include('./components/admin-header.php'); ?>


  <div class="container-fluid">
    <div class="row">

      <!-- include admin sidenav -->
      <?php include("./components/admin-sidenav.php"); ?>

      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div
          class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Dashboard</h1>
        </div>

        <div class="d-flex flex-wrap">
          <div class="col-4 p-2">
            <div class="alert alert-primary alert-dismissible fade show d-flex">
              <span data-feather="user" class="align-text-bottom w-25" style="height: 70px;"></span>
              <div class="w-75">
                <h3 class="">Users (
                  <?php echo $count_users; ?> )
                </h3>
                <h6><a href="./users-listing.php"
                    class="badge bg-primary rounded-pill text-bg-warning text-decoration-none">View All Users</a></h6>
              </div>
            </div>
          </div>
          <div class="col-4 p-2">
            <div class="alert alert-warning alert-dismissible fade show d-flex">
              <span data-feather="command" class="align-text-bottom w-25" style="height: 70px;"></span>
              <div class="w-75">
                <h3 class="">Managers (
                  <?php echo $count_managers; ?> )
                </h3>
                <h6><a href="./managers-listing.php"
                    class="badge bg-warning rounded-pill text-bg-warning text-decoration-none">View All Managers</a>
                </h6>
              </div>
            </div>
          </div>
          <div class="col-4 p-2">
            <div class="alert alert-secondary alert-dismissible fade show d-flex">
              <span data-feather="terminal" class="align-text-bottom w-25" style="height: 70px;"></span>
              <div class="w-75">
                <h3 class="">Admins (
                  <?php echo $count_admins; ?> )
                </h3>
                <h6><a href="./admins-listing.php"
                    class="badge bg-secondary rounded-pill text-bg-warning text-decoration-none">View All Admins</a>
                </h6>
              </div>
            </div>
          </div>
          <div class="col-8 p-2">
            <div class="alert alert-primary alert-dismissible fade show d-flex">
              <span data-feather="list" class="align-text-bottom w-25" style="height: 70px;"></span>
              <div class="w-75">
                <h3 class="">Property Listings (
                  <?php echo $count_properties; ?> )
                </h3>
                <h6><a href="./listing-admin.php"
                    class="badge bg-primary rounded-pill text-bg-warning text-decoration-none">View All Properties</a>
                </h6>
              </div>
            </div>
          </div>
          <div class="col-4 p-2">
            <div class="alert alert-warning alert-dismissible fade show d-flex">
              <span data-feather="command" class="align-text-bottom w-25" style="height: 70px;"></span>
              <div class="w-75">
                <h3 class="">Property Types (
                  <?php echo $count_property_types; ?> )
                </h3>
                <h6><a href="./property-types-listing.php"
                    class="badge bg-warning rounded-pill text-bg-warning text-decoration-none">View All Property
                    Types</a>
                </h6>
              </div>
            </div>
          </div>
          <div class="col-4 p-2">
            <div class="alert alert-danger alert-dismissible fade show d-flex">
              <span data-feather="list" class="align-text-bottom w-25" style="height: 70px;"></span>
              <div class="w-75">
                <h3 class="">Locations (
                  <?php echo $count_locations; ?> )
                </h3>
                <h6><a href="./locations-listing.php"
                    class="badge bg-primary rounded-pill text-bg-warning text-decoration-none">View All Locations</a>
                </h6>
              </div>
            </div>
          </div>
          <div class="col-8 p-2">
            <div class="alert alert-info alert-dismissible fade show d-flex">
              <span data-feather="command" class="align-text-bottom w-25" style="height: 70px;"></span>
              <div class="w-75">
                <h3 class="">Scheduled Visits (
                  <?php echo $count_visits; ?> )
                </h3>
                <h6><a href="./scheduled-visits-admin.php"
                    class="badge bg-warning rounded-pill text-bg-warning text-decoration-none">View All Scheduled
                    Visits</a>
                </h6>
              </div>
            </div>
          </div>
        </div>

      </main>
    </div>
  </div>

  <!-- <script src="../assets/dist/js/bootstrap.bundle.min.js"></script> -->
  <!-- BOOTSTRAP JS LINKS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
    integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE"
    crossorigin="anonymous"></script>
  <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"
        integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha"
        crossorigin="anonymous"></script> -->
  <script src="./js/dashboard.js"></script>
</body>

</html>