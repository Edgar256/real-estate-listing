<?php
// import Config File
require_once('./config/config.php');



?>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" href="./images/logo.png">

    <!-- BOOTSTRAP CSS LINKS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

    <!-- BOOTSTRAP JS LINKS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

    <!-- CSS LINKS -->
    <link rel="stylesheet" href="./css/style.css" />

    <!-- JQUERY LINK -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <title>Equitable Property Group</title>

    <script defer>
        $(document).ready(function () {

            // AJAX CALL FOR FILTER BUTTON
            $("#search-form").submit(function (e) {
                e.preventDefault();
                var status = $('#status').val();
                var user = $('#user').val();

                $.ajax({
                    url: "./utils/search_visits.php",
                    type: "post",
                    data: $('#search-form').serialize(),
                    data: { status, user },
                    success: function (response) {
                        $("#results").html(response);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // handle error
                        console.log({ jqXHR, textStatus, errorThrown });
                    }

                })
            });        // AJAX CALL FOR CANCEL BUTTON
            $(document).on("click", ".cancelButton", function () {
                var id = $(this).attr('value');
                var status = $(this).attr('data-currentStatus');
                var user = $(this).attr('data-user');

                $.ajax({
                    url: './utils/cancel_visit.php',
                    type: 'post',
                    data: { id, status, user },
                    success: function (response) {
                        $("#results").html(response);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // handle error
                        console.log({ jqXHR, textStatus, errorThrown });
                    }
                });
            });

        });
    </script>

</head>

<body>
    <div class="position-relative">

        <!-- import the header section-->
        <?php include './components/header.php'; ?>

        <?php
        $property_name = $location_id = $entries_err = $result = $search_query = $property_type_name = $user = "";
        $check_properties_list = array();

        $status = "pending";

        $user = $_SESSION['id'];

        $sql = "SELECT visits.*, properties.title AS title, properties.property_description AS property_description, properties.price AS price, properties.property_image AS property_image  FROM visits JOIN properties ON visits.property = properties.id WHERE status='" . $status . "' AND user='" . $user . "' ORDER BY visits.reg_date DESC";
        $check_properties_list = $conn->query($sql);
        ?>

        <div class="position-relative">

            <!-- start seacrh section -->
            <div class="container pt-5">

                <div class="d-flex">
                    <?php echo $entries_err; ?>
                </div>
                <form class="row gx-3 gy-2 align-items-center" method="post" id="search-form">
                    <div class="col-sm-5">
                        <div class="container display-4">Scheduled Visits</div>
                    </div>
                    <div class="col-sm-5">
                        <!-- <label for="specificSizeInputName">Search by Location</label> -->
                        <select name="status" id="status" class="form-control">
                            <option value="pending">Pending</option>
                            <option value="rejected">Rejected</option>
                            <option value="cancelled">Cancelled</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                    <input type="text" id="user" value="<?php echo $_SESSION['id'] ?>" class="d-none">
                    <div class="col-sm-2">
                        <input type="submit" class="btn btn-primary w-100" name="submit" value="Submit" />
                    </div>
                </form>
            </div>
            <!-- end search section -->

            <!-- start listing section -->
            <div class="container d-flex flex-wrap pb-5 mb-5" id="results">
                <?php
                // redirect to user login if session is expired
                if (!$_SESSION['auth_active']) {
                    echo '<script>alert("Your Session has expired please login")</script>';
                    echo '<script>setTimeout(function(){
                        window.location.href = "./auth/user-login.php";
                    }, 1000);</script>';
                }

                // Displaying default property list              
                if ($check_properties_list->num_rows > 0) {
                    while ($row = $check_properties_list->fetch_assoc()) {
                        $title = mb_convert_case($row["title"], MB_CASE_TITLE, "UTF-8"); // Change title to title case
                        $id = $row["id"];
                        // description should not be more than 120 characters
                        if (strlen($row["property_description"]) > 110) {
                            $description = substr($row["property_description"], 0, 110);
                            $description = $description . "...";
                        } else {
                            $description = $row["property_description"];
                        }
                        $price = $row["price"];
                        $imageData = $row['property_image'];
                        $imageData = base64_encode($imageData);
                        $datePosted = $row["reg_date"];
                        $visit_date = $row["visit_date"];
                        $visit_time = $row["visit_time"];
                        $visit_status = $row["status"];
                        if (strlen($row["note"]) > 100) {
                            $note = substr($row["note"], 0, 100);
                            $note = $note . "...";
                        } else {
                            $note= $row["note"];
                        }

                        echo '<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 p-1">
                            <div class="card">
                                <span style="background-image: url(data:image/jpeg;base64,' . $imageData . ');
                                    background-size: cover;
                                    background-repeat: no-repeat;
                                    background-position: center center;
                                    width: 100%;
                                    border-radius: 3px 3px 0px 0px;
                                    min-height: 200px;">           
                                </span>';
                        if ($visit_status === "pending") {
                            echo '<div class="right-0 position-absolute p-1"><span class="badge bg-primary">Pending</span></div>';
                        } else if ($visit_status === "rejected") {
                            echo '<div class="right-0 position-absolute p-1"><span class="badge bg-danger">Rejected</span></div>';
                        } else if ($visit_status === "cancelled") {
                            echo '<div class="right-0 position-absolute p-1"><span class="badge bg-warning">Cancelled</span></div>';
                        } else if ($visit_status === "completed") {
                            echo '<div class="right-0 position-absolute p-1"><span class="badge bg-success">Completed</span></div>';
                        }
                        ;
                        echo '<div class="card-body">
                                    <p class="text_muted"><small><i>Posted : ' . date("F j, Y, g:i a", strtotime($datePosted)) . '</i></small></p>
                                    <h5 class="card-title">' . $title . '</h5>
                                    <h6>Price: USD ' . number_format($price) . '</h6>
                                    <p class="card-text">
                                        ' . $description . '
                                    </p><hr />
                                    <h6>Scheduled Date : ' . date("F jS, Y", strtotime($visit_date)) . '</h6><h6>Scheduled Time : ' . date("h:i a", strtotime($visit_time)) . '</h6><p class="card-text"> ' . $note . '</p>';
                        if ($visit_status === "pending") {
                            echo '<button class="btn btn-danger w-100 cancelButton" value="' . $row["id"] . '" data-currentStatus="' . $status . '" data-user="' . $_SESSION['id'] . '" >Cancel Visit</button>';
                        }
                        echo '</div> </div> </div>';
                    }
                } else {
                    echo '<div class="col-12">
                        <div class="alert alert-warning" role="alert">
                            No scheduled visits found
                        </div>
                    </div>';
                }

                ?>
            </div>
            <!-- end lisitng section -->

            <!-- import the footer section-->
            <?php
            include './components/footer.php';
            ?>

        </div>
    </div>

</body>

</html>