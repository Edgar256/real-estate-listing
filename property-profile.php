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
    <?php include './components/header.php'; ?>

    <div class="position-relative">
      <div class="container">

        <!-- Property Profile -->
        <?php
        if ($_SESSION['role'] == "USER") {
          $id = $_GET['id'];
          $property_type = '';
          $query = "SELECT properties.*, locations.id AS location_id,locations.name AS location_name, types.id AS property_type_id, types.name AS property_type_name FROM properties JOIN locations ON properties.property_location = locations.id JOIN types ON properties.property_type = types.id WHERE properties.id = " . $id;
          $check_property = $conn->query($query);

          if ($check_property->num_rows > 0) {
            // output data of each row
            while ($row = $check_property->fetch_assoc()) {
              // echo "id: " . $row["id"] . " - Name: " . $row["name"] . " " . $row["email"] . "<br>";
              $imageData = $row['property_image'];
              $imageData = base64_encode($imageData);
              $property_type = $row['property_type'];
              echo '<div class="d-flex">
            <span class="col-sm-7 p-3">
              <img src="data:image/jpeg;base64,' . $imageData . '" style="font-weight:bold" class="card-img-top p-2" >
            </span>
            <span class="col-sm-5 p-3">
              <p class="text_muted"><small><i>Posted :' . date("F j, Y, g:i a", strtotime($row['reg_date'])) . '</i></small></p>
              <div class="display-6">' . $row['title'] . '</div>
              <h6>Location: ' . $row['location_name'] . '</h6>
              <h6>Property type : ' . $row['property_type_name'] . '</h6>
              <h6>USD ' . $row['price'] . '</h6>
              <p class="card-text">
              ' . $row['property_description'] . '
              </p>
              <div class="col-12">
                <button type="submit" class="btn btn-primary w-100" data-bs-toggle="modal"
                  data-bs-target="#scheduleVisitModal">
                  SCHEDULE FIELD VISIT
                </button>
              </div>
            </span>
          </div>';
            }
            ;
          } else {
            echo "0 results";
          }
        } else {
          header("location:javascript://history.go(-1)");
        }

        ?>




        <!-- Similar Houses -->
        <div class="pt-5">
          <p class="display-6 pt-5">View Similar Houses</p>
        </div>

        <div class="d-flex flex-wrap pb-5">
          <?php
          $table = "properties";

          $sql = "SELECT properties.*, locations.id AS location_id,locations.name AS location_name, types.name AS property_type_name FROM properties JOIN locations ON properties.property_location = locations.id JOIN types ON properties.property_type = types.id WHERE property_type = " . $property_type;
          $check_properties_list = $conn->query($sql);
          if ($check_properties_list->num_rows > 0) {
            while ($row = $check_properties_list->fetch_assoc()) {
              $title = mb_convert_case($row["title"], MB_CASE_TITLE, "UTF-8");
              $id = $row["id"];
              $description = $row["property_description"];
              $price = $row["price"];
              $location = $row["location_name"];
              $imageData = $row['property_image'];
              $imageData = base64_encode($imageData);
              $datePosted = $row["reg_date"];
              $property_type = $row["property_type_name"];

              echo '<div class="w-25 p-1">
                            <div class="card">
                                <img src="data:image/jpeg;base64,' . $imageData . '" style="font-weight:bold">
                                <div class="card-body">
                                    <p class="text_muted"><small><i>Posted :' . date("F j, Y, g:i a", strtotime($datePosted)) . '</i></small></p>
                                    <h5 class="card-title">' . $title . '</h5>
                                    <h6>Location: ' . $location . '</h6>
                                    <h6>Property type: ' . $property_type . '</h6>
                                    <h6>Price: USD ' . $price . '</h6>
                                    <p class="card-text">
                                        ' . $description . '
                                    </p>
                                    <a href="./property-profile.php?id=' . $id . '" class="btn btn-primary w-100">View More</a>
                                </div>
                            </div>
                        </div>';
            }
          } else {
            echo "No Results found";
          }

          $conn->close();
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
            You are scheduling a visit to this Propery.
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4">
          <div class="col-12">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" />
          </div>
          <div class="col-12">
            <label for="time" class="form-label">Time</label>
            <input type="time" class="form-control" id="time" />
          </div>
          <div class="col-12">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" />
          </div>
          <div class="col-12">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" />
          </div>
          <div class="col-12">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" id="phone" />
          </div>
          <div class="col-12">
            <label for="message" class="form-label">Message</label>
            <textarea class="form-control" id="message" rows="3"></textarea>
          </div>

          <div class="col-12 pt-2">
            <button type="submit" class="btn btn-primary w-100" data-bs-toggle="modal"
              data-bs-target="#scheduleVisitSuccessModal" data-bs-dismiss="modal">
              SCHEDULE FIELD VISIT
            </button>
          </div>
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
</body>

</html>