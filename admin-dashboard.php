<?php
// import Config File
require('./config/config.php');

if (!isset($_SESSION)) {
  session_start();
}

$_SESSION['page'] = 'dashboard';

// Define variables and initialize with empty values
$count_users = $count_managers = $count_admins = 0;
$users_err = "";

// $sql = "SELECT *  FROM users";
// $result = $conn->query($sql);
// $count_users = $result->fetchColumn();

// $result = $conn->query("SELECT COUNT(*) FROM users");
// $row = $result->fetch(PDO::FETCH_ASSOC);
// $size = $row['COUNT(*)'];

// echo 'here ' .$size;

// $sql = "SELECT COUNT(*) FROM users";
// $result = $conn->query($sql);

// if (!is_object($result)) {
//   echo 'No result!';
// } else {
//   $row = $result->fetch(PDO::FETCH_ASSOC);
//   $count_users = $row['COUNT(*)'];
//   echo 'here ' . $count_users;
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="" />
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors" />
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

        <div class="d-flex">
          <div class="col-4 p-2">
            <div class="alert alert-primary alert-dismissible fade show d-flex">
              <span data-feather="user" class="align-text-bottom w-25" style="height: 70px;"></span>
              <div class="w-75">
                <h3 class="">Users
                  <?php echo $count_users ?>
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
                <h3 class="">Managers</h3>
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
                <h3 class="">Admins</h3>
                <h6><a href="./admins-listing.php"
                    class="badge bg-secondary rounded-pill text-bg-warning text-decoration-none">View All Admins</a>
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