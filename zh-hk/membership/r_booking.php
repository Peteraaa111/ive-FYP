<?php
// This is view History
// Start the SESSION
session_start();

include_once('/xampp/htdocs/travelHK.com/dbConnect.php');
global $conn;

// Get the booking id
$booking = $_GET['id'];

// Get the restaurant booking details
$details_sql = "SELECT * FROM `restaurant_booking` WHERE `booking_id` = $booking;";
$details_rs = mysqli_query($conn, $details_sql);
$details = mysqli_fetch_assoc($details_rs);

// Get the restaurant details
$restaurant_sql = "SELECT * FROM `restaurant` WHERE `restaurant_id` = {$details['restaurant_id']};";
$restaurant_rs = mysqli_query($conn, $restaurant_sql);
$restaurant = mysqli_fetch_assoc($restaurant_rs);

// ================ Get Table Layout Json ================
$restaurant_id = $details['restaurant_id'];

$json = "";

$findExistingQuery = "SELECT * FROM restaurant_layout WHERE `restaurant_id` = '$restaurant_id';";
$rs  = mysqli_query($conn, $findExistingQuery);

if (mysqli_num_rows($rs) == 1) {
  $row = mysqli_fetch_row($rs);
  $json = $row[2];
} else {
  $json = -1;
}

// ================ Get Occupation Status ================

$sql399 = "SELECT `table` FROM `restaurant_booking` WHERE `booking_id` = $booking;";

$rs399 = mysqli_query($conn, $sql399);

if (mysqli_num_rows($rs399) == 1) {
  $row399 = mysqli_fetch_row($rs399);
  $occupation = $row399[0];
} else {
  $occupation = -1;
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>餐廳預約 - 香港本地旅遊平台 | 本地遊</title>

  <!-- Link the default css and js library -->
  <?php include_once('/xampp/htdocs/travelHK.com/library.php'); ?>

  <link href="/css/collab_form.css" rel="stylesheet">
  <link href="/css/r_details.css" rel="stylesheet">

  <script src="/js/r_booking.js"></script>

  <!-- ************ Below my code ************ -->

  <link rel="stylesheet" href="../../js/jqueryui/jquery-ui.css">
  <script src="../../js/jqueryui/jquery-ui.min.js"></script>

  <!-- ************ Above my code ************ -->
  <style>
    .draggable {
      text-align: center;
      position: initial;
      width: 70px;
      height: 70px;
      float: left;
      position: absolute;
    }

    #containment-wrapper {
      margin-bottom: 30px;
      height: 500px;
      border: 2px solid #ccc;
      padding: 10px;
      overflow: auto;
      position: relative;
    }

    #booking {
      margin-right: 50px;
    }

    .bigbox {
      overflow: visible;
      margin-bottom: 30px;
      height: 300px;
      border: 2px solid #ccc;
      padding: 10px;
      overflow: auto;
      position: relative;
    }

    .draggableFake {
      text-align: center;
      position: initial;
      width: 70px;
      height: 70px;
      float: left;
      border: 2px solid #ccc;
      position: absolute;
    }
  </style>


  <script>
    var json = <?php echo $json; ?>;
    $(document).ready(function() {
      if (json === -1) {
        console.log("test");
        $("#tableLayout").hide();
      }



      // ================ Get Occupation Status ================
      var occupiedTable = '<?= $occupation ?>';
    
      if (occupiedTable == -1) {
        console.log("no data");
      } else {
        occupiedTable = occupiedTable.split(",");

        for (let n = 0; n < occupiedTable.length; n++) {
          $("#" + occupiedTable[n]).css("color", "red");
          $("#" + occupiedTable[n]).css("border-color", "red");
        }
      }
    });
  </script>


</head>

<body>

  <!-- Header -->
  <?php include_once('../common/header.php'); ?>

  <!-- Category -->
  <?php include_once('../common/category.php'); ?>

  <!-- Main Content -->
  <!-- Main Content -->
  <section id="banner" class="padding-4rem mb-4">
    <div id="banner-background" class="bg-dark rounded-3" style="background-image: url(/data/site/restaurant/<?php echo $details['restaurant_id']; ?>/banner.jpg);"></div>
    <div id="banner-info" class="container py-5">
      <div class="row">
        <div class="col-md-12 text-center">
          <h1 class="fw-bold" style="text-shadow: 1px 1px grey;">
            <?php echo $restaurant['restaurant_chinese_name']; ?>
          </h1>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 text-center" style="text-shadow: 1px 1px grey;">
          <h2>
            <?php echo $restaurant['restaurant_english_name']; ?>
          </h2>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 text-center" style="text-shadow: 1px 1px grey;">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star-half-alt"></i>
          <i class="far fa-star"></i>
        </div>
      </div>
    </div>
  </section>

  <form id="update-restaurant-booking-form" enctype="multipart/form-data" method="POST">
    <!-- Restaurant id for js process -->
    <input type="hidden" id="booking-id" name="booking-id" value="<?php echo $details['booking_id']; ?>" />
    <div class="container card">
      <div class="card-body">
        <div class="row card">
          <div class="card-body">
            <div class="col">
              <h4 class="card-title fw-bold">餐廳預約</h4>
            </div>
          </div>
        </div>
        <div class="row card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title">預約資料</h5>
              </div>
            </div>
            <div class="row">
              <div class="col-2">
                日期時間
                <span class="text-danger">*</span>
              </div>
              <div class="col-5">
                <input type="date" class="form-control" id="booking-date" name="booking-date" value="<?php echo $details['booking_date']; ?>" disabled>
              </div>
              <div class="col-5">
                <input type="time" class="form-control" id="booking-time" name="booking-time" value="<?php echo $details['booking_time']; ?>" disabled>
              </div>
            </div>
            <div class="row">
              <div class="col-2">
                顧客人數
                <span class="text-danger">*<span>
              </div>
              <div class="col">
                <div class="input-group">
                  <input type="number" class="form-control" id="people" name="people" value="<?php echo $details['people']; ?>" disabled>
                  <span class="input-group-text">人</span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-2">
                聚餐主題
              </div>
              <div class="col">
                <input type="text" class="form-control" id="booking-subject" name="booking-subject" value="<?php echo $details['booking_subject']; ?>" disabled>
              </div>
            </div>
            <div class="row">
              <div class="col-2">
                食物敏感備註
              </div>
              <div class="col">
                <input type="text" class="form-control" id="booking-description" name="booking-description" value="<?php echo $details['description']; ?>" disabled>
              </div>
            </div>
          </div>
        </div>

        <div class="row card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title">訂座人資料</h5>
              </div>
            </div>
            <div class="row">
              <div class="col-2">
                顧客名稱
                <span class="text-danger">*<span>
              </div>
              <div class="col">
                <input type="text" class="form-control" id="contact-name" name="contact-name" value="<?php echo $details['contact_name']; ?>" disabled>
              </div>
            </div>
            <div class="row">
              <div class="col-2">
                電話號碼
                <span class="text-danger">*<span>
              </div>
              <div class="col">
                <input type="tel" class="form-control" id="contact-number" name="contact-number" minlength="8" maxlength="8" value="<?php echo $details['contact_phone']; ?>" disabled>
              </div>
            </div>
            <div class="row">
              <div class="col-2">
                電郵地址
                <span class="text-danger">*<span>
              </div>
              <div class="col">
                <input type="text" class="form-control" id="contact-email" name="contact-email" value="<?php echo $details['contact_email']; ?>" disabled>
              </div>
            </div>
          </div>
        </div>


        <!-- show table layout if found result -->
        <div class="row card" id="tableLayout">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title">你預約的餐枱</h5>
              </div>
            </div>

            <div class="col">

              <div id="containment-wrapper">
                <script>
                  str = '<?= $json ?>';

                  if (str !== "") {
                    const obj = JSON.parse((str));
                    for (let i = 0; i < obj.length; i++) {
                      var table = document.createElement('div');
                      table.innerHTML = '<div class="draggable clickable ui-widget-content butNotHere" id="' + (i + 1) + '" style="left:' + obj[i].left + 'px; top:' + obj[i].top + 'px"' + 'data-ppl=' + obj[i].ppl + '>餐桌 ' + (i + 1) + "<br/>" + obj[i].ppl + "人" + '</div>';
                      $("#containment-wrapper").append(table);
                    }
                  } else {
                    console.log("no data");
                  }
                </script>
              </div>
            </div>

          </div>
        </div>









        <div class="row">
          <div class="col text-end">
            <button type="button" class="btn btn-danger" onclick="r_cancelBooking()">取消預約</button>
          </div>
        </div>
      </div>
    </div> <!-- Container -->
  </form>

  <!-- Footer -->
  <?php include_once('../common/footer.php'); ?>

</body>

</html>