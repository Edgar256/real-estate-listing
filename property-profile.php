<?php
// import Config File
require_once('./config/config.php');

$id = $note = $visit_date = $visit_time = $user = $manager = $property = $visit_success_msg = '';
$note_err = $visit_date_err = $visit_time_err = $property_err = $user_err = $manager_err = $visit_err = '';


?>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" type="image/png" href="./images/logo.png">

  <!-- CSS LINKS -->
  <link rel="stylesheet" href="./css/style.css" />

  <!-- BOOTSTRAP CSS LINKS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

  <!-- BOOTSTRAP JS LINKS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

  <!-- JQUERY LINK -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <title>Realtors Inc.</title>

</head>

<body>
  <div class="position-relative">

    <!-- import the header section-->
    <?php include './components/header.php'; ?>

    <div class="position-relative">
      <div class="container">

        <!-- Property Profile -->
        <?php
        if ($_SESSION['role'] == "USER" || $_SESSION['role'] == "MANAGER" || $_SESSION['role'] == "ADMIN") {
          $id = $_GET['id'];
          $property_type = '';
          $user = $_SESSION['id'];
          $query = "SELECT properties.*, 
                    locations.id AS location_id,
                    locations.name AS location_name, 
                    types.id AS property_type_id, 
                    types.name AS property_type_name, 
                    managers.id AS manager_id, 
                    users.id AS buyer_id , 
                    users.firstname AS buyer_firstname, 
                    users.lastname AS buyer_lastname, 
                    users.phone AS buyer_phone, 
                    users.email AS buyer_email  
                    FROM properties 
                    JOIN locations ON properties.property_location = locations.id 
                    JOIN types ON properties.property_type = types.id 
                    JOIN managers ON properties.manager = managers.id 
                    LEFT JOIN users ON properties.buyer = users.id 
                    WHERE properties.id = " . $id;

          $check_property = $conn->query($query);

          if ($check_property->num_rows > 0) {
            // output data of each row
            while ($row = $check_property->fetch_assoc()) {
              $property = $row['id'];
              $manager = $row['manager_id'];

              $imageData = $row['property_image'];
              $imageData = base64_encode($imageData);
              $property_type = $row['property_type'];
              $property_is_taken = $row["is_taken"];
              echo '<div class="d-flex">
            <span class="col-sm-7 p-3">';
              if ($property_is_taken === "1") {
                echo '<img src="./images/sold.svg" alt="Sold SVG Image" class="left-0 position-absolute">';
              }
              echo '<img src="data:image/jpeg;base64,' . $imageData . '" style="font-weight:bold" class="card-img-top p-0" >              
              </span>
            <span class="col-sm-5 p-3">
              <input type="hidden" name="manager_id" id="manager_id" value="' . $manager . '">
              <input type="hidden" name="property_id" id="property_id" value="' . $property . '">
              <p class="text_muted"><small><i>Posted :' . date("F j, Y, g:i a", strtotime($row['reg_date'])) . '</i></small></p>
              <div class="display-6">' . mb_convert_case($row["title"], MB_CASE_TITLE, "UTF-8") . '</div>
              <h6>Location: ' . mb_convert_case($row['location_name'], MB_CASE_TITLE, "UTF-8") . '</h6>
              <h6>Property type : ' . mb_convert_case($row['property_type_name'], MB_CASE_TITLE, "UTF-8") . '</h6>
              <h6>USD ' . number_format($row['price']) . '</h6>
              <p class="card-text">
              ' . $row['property_description'] . '
              </p>';

              if ($_SESSION["role"] == "USER" && $property_is_taken === "0") {
                echo '<div class="col-12">
                <button type="submit" class="btn btn-primary w-100" data-bs-toggle="modal"
                  data-bs-target="#scheduleVisitModal">
                  SCHEDULE FIELD VISIT
                </button>
              </div>';
              }
              ;

              if ($_SESSION["role"] == "MANAGER" && $property_is_taken === "1") {
                echo '<div class="col-12 py-5">
                 <h5>Client: ' . mb_convert_case($row['buyer_firstname'], MB_CASE_TITLE, "UTF-8") . ' ' . mb_convert_case($row['buyer_lastname'], MB_CASE_TITLE, "UTF-8") . '</h5>';
                echo '<h5>Phone: ' . $row['buyer_phone'] . '</h5>';
                echo '<h5>Email: ' . $row['buyer_email'] . '</h5>';
              }
              ;

              echo '</span></div>';
            }
            ;
          } else {
            echo "0 results";
          }
        } else {
          header("location:javascript://history.go(-1)");
        }

        ?>




        <?php
        if ($_SESSION["role"] == "USER") {
          echo '
            <div class="pt-5">
              <p class="display-6 pt-5">View Similar Houses</p>
            </div>';
        }
        ?>

        <div class="d-flex flex-wrap pb-5">
          <?php
          $table = "properties";

          $sql = "SELECT properties.*, locations.id AS location_id,locations.name AS location_name, types.name AS property_type_name FROM properties JOIN locations ON properties.property_location = locations.id JOIN types ON properties.property_type = types.id WHERE property_type = " . $property_type . " AND properties.id != " . $property . " ORDER BY reg_date DESC LIMIT 4";
          $check_properties_list = $conn->query($sql);
          if ($check_properties_list->num_rows > 0) {
            while ($row = $check_properties_list->fetch_assoc()) {
              $curr_property_id = $row["id"];
              $title = mb_convert_case($row["title"], MB_CASE_TITLE, "UTF-8"); // Change title to title case
              // description should not be more than 110 characters
              if (strlen($row["property_description"]) > 110) {
                $description = substr($row["property_description"], 0, 110);
                $description = $description . "...";
              } else {
                $description = $row["property_description"];
              }
              $price = $row["price"];
              $location = $row["location_name"]; // Change location name to title case
              $imageData = $row['property_image'];
              $imageData = base64_encode($imageData);
              $datePosted = $row["reg_date"];
              $property_type = $row["property_type_name"]; // Change property name to title case
              $property_is_taken = $row["is_taken"];

              if ($_SESSION["role"] == "USER") {
                echo '<div class="w-25 p-1">
                            <div class="card">
                                <span style="background-image: url(data:image/jpeg;base64,' . $imageData . ');
                                    background-size: cover;
                                    background-repeat: no-repeat;
                                    background-position: center center;
                                    width: 100%;
                                    border-radius: 3px 3px 0px 0px;
                                    min-height: 200px;">
                                </span>';
                if ($property_is_taken === "1") {
                  echo '<img src="./images/sold.svg" alt="Sold SVG Image" class="left-0 position-absolute">';
                }
                echo '<div class="card-body">
                                    <p class="text_muted"><small><i>Posted :' . date("F j, Y, g:i a", strtotime($datePosted)) . '</i></small></p>
                                    <h5 class="card-title">' . $title . '</h5>                                    
                                    <h6>Location: ' . $location . '</h6>
                                    <h6>Property type: ' . $property_type . '</h6>
                                    <h6>Price: USD ' . number_format($price) . '</h6>
                                    <p class="card-text">
                                        ' . $description . '
                                    </p>
                                    <a href="./property-profile.php?id=' . $curr_property_id . '" class="btn btn-primary w-100">View More</a>
                                </div>
                            </div>
                        </div>';
              }

            }
          } else {
            echo "<div class='w-100 text-center py-5 display-1'>No Results found</div>";
          }

          // $conn->close();
          ?>

        </div>
      </div>
    </div>
  </div>

  <!-- Schedule Visit Modal -->
  <div class="modal fade" id="scheduleVisitModal" tabindex="-1" aria-labelledby="scheduleVisitModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            You are scheduling a visit to this Propery. Please fill in your details
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4">

          <form method="post" id="schedule-form">
            <div class="col-12">
              <label for="date" class="form-label">Date</label>
              <input type="date" class="form-control" id="date" name="date" />
            </div>
            <div class="col-12">
              <label for="time" class="form-label">Time</label>
              <input type="time" class="form-control" id="time" name="time" />
            </div>
            <div class="col-12 py-2">
              <label for="name" class="form-label h4">Name:
                <?php echo isset($_SESSION['firstname']) && isset($_SESSION['lastname']) ? $_SESSION['firstname'] . ' ' . $_SESSION['lastname'] : 'Session variables are not set'; ?>
              </label>
              <input type="text" class="d-none" value="<?php echo isset($_SESSION['id']) ? $_SESSION['id'] : ''; ?>"
                id="user">
            </div>
            <div class="col-12">
              <label for="email" class="form-label h4">Email :
                <?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>
              </label>
            </div>
            <div class="col-12">
              <label for="phone" class="form-label h4">Phone :
                <?php echo isset($_SESSION['phone']) ? $_SESSION['phone'] : ''; ?>
              </label>
            </div>
            <div class="col-12">
              <label for="note" class="form-label">Message</label>
              <textarea class="form-control" id="note" name="note" rows="3"></textarea>
            </div>

            <div class="col-12 pt-2">
              <button type="submit" class="btn btn-primary w-100">
                SCHEDULE FIELD VISIT
              </button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>

  <!-- Success Schedule Visit Modal -->
  <div class="modal fade" id="scheduleVisitSuccessModal" tabindex="-1" aria-labelledby="scheduleVisitModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Success</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4">
          <p class="display-6 text-center text-success">
            Hooray! Your visit has been scheduled. One of our property
            managers will reach out to you shortly.
          </p>

          <div class="col-12 pt-2">
            <button type="submit" class="btn btn-primary w-100" data-bs-toggle="modal"
              data-bs-target="#scheduleVisitSuccessModal" data-bs-dismiss="modal">
              DISMISS
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php



  ?>

  <!-- import the footer section-->
  <?php
  include './components/footer.php';
  ?>

  <script>
    $(document).ready(function () {
      $("#schedule-form").submit(function (e) {
        e.preventDefault();
        var date = $("#date").val();
        var time = $('#time').val();
        var note = $('#note').val();
        var user = $('#user').val();
        var property_id = $('#property_id').val();
        var manager_id = $('#manager_id').val();

        if (!date || !time || !note || !user || !property_id || !manager_id) {
          alert('Please fill all the fields');
          return;
        }

        console.log({ property_id });

        $.ajax({
          url: "./utils/schedule_visit.php",
          type: "post",
          data: { date, time, note, user, property_id, manager_id },
          success: function (response) {
            console.log({ response });
            if (response == 'success') {
              $('#scheduleVisitModal').modal('hide');
              $('#scheduleVisitSuccessModal').modal('show');
            }
          },
          error: function (jqXHR, textStatus, errorThrown) {
            // handle error
            console.log({ Failed });
            console.log({ jqXHR, textStatus, errorThrown });
          }

        })
      });
    });
  </script>

</body>

</html>