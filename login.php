<?php
// import Config File
require('config.php');
session_start();
if (isset($_SESSION['email'])) {
  header("Location: index.php");
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
          <!-- Login form  -->
          <form class="py-5" action="login.php" method="post"
            action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="row mb-3">
              <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
              <div class="col-sm-10">
                <input type="email" class="form-control" name="email" />
              </div>
            </div>
            <div class="row mb-3">
              <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" name="password" />
              </div>
            </div>
            <input type="submit" class="btn btn-primary w-100">Sign in</input>
            <div class="d-flex py-4">
              <a href="register.php" class="text-decoration-none">Do not have Account? Register</a>
              <a href="forgot-password.php" class="text-decoration-none ms-auto">Forgot Password</a>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- end login body -->

  </div>
</body>

</html>