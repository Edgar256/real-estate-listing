<?php
// import Config File
require_once('config.php');

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
        <?php
        include './components/header.php';
        ?>

        <!-- start landing section -->
        <div class="position-absolute landing-area">
            <div class="container d-flex">
                <div class="col-8 col-xl-8 col-sm-12">
                    <div class="p-5">
                        <div class="text-white py-5 display-1">
                            Welcome to Equitable Property Group where we help you find your
                            dream home.
                        </div>
                        <a href="./login.html" class="btn btn-success display-6">Get Started</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end landing section -->


    </div>
</body>

</html>