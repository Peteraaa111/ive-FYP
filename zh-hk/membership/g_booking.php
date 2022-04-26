<?php
// Start the SESSION
session_start();

include_once('/xampp/htdocs/travelHK.com/dbConnect.php');
global $conn;

// Get the booking id
$booking = $_GET['id'];

// Get the guesthouse details
$details_sql = "SELECT * FROM `guesthouse_booking` WHERE `booking_id` = $booking;";
$details_rs = mysqli_query($conn, $details_sql);
$details = mysqli_fetch_assoc($details_rs);

// Get the guesthouse details
$guesthouse_sql = "SELECT * FROM `guesthouse` WHERE `guesthouse_id` = {$details['guesthouse_id']};";
$guesthouse_rs = mysqli_query($conn, $guesthouse_sql);
$guesthouse = mysqli_fetch_assoc($guesthouse_rs);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>預約細節 - 香港本地旅遊平台 | 本地遊</title>

  <!-- Link the default css and js library -->
  <?php include_once('/xampp/htdocs/travelHK.com/library.php'); ?>

  <link href="/css/collab_form.css" rel="stylesheet">
  <link href="/css/r_details.css" rel="stylesheet">

  <script src="/js/r_booking.js"></script>
</head>

<body>

  <!-- Header -->
  <?php include_once('../common/header.php'); ?>

  <!-- Category -->
  <?php include_once('../common/category.php'); ?>

  <!-- Main Content -->
  <!-- Main Content -->
  <section id="banner" class="padding-4rem mb-4">
    <div id="banner-background" class="bg-dark rounded-3" style="background-image: url(/data/site/guesthouse/<?php echo $guesthouse['guesthouse_id']; ?>/banner.jpg);"></div>
    <div id="banner-info" class="container py-5">
      <div class="row">
        <div class="col-md-12 text-center">
          <h1 class="fw-bold">
            <?php echo $guesthouse['guesthouse_chinese_name']; ?> 
          </h1>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 text-center">
          <h2>
            <?php echo $guesthouse['guesthouse_english_name']; ?>
          </h2>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 text-center">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star-half-alt"></i>
          <i class="far fa-star"></i>
        </div>
      </div>
    </div>
  </section>

  <form id="update-guesthouse-booking-form" enctype="multipart/form-data" method="POST">
    <!-- Guesthouse id for js process -->
    <input type="hidden" id="booking-id" name="booking-id" value="<?php echo $details['booking_id']; ?>" />
    <div class="container card">
      <div class="card-body">
        <div class="row card">
          <div class="card-body">
            <div class="col">
              <h4 class="card-title fw-bold">民宿預約</h4>
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
                日期
              </div>
              <div class="col">
                <div class="input-group">
                  <input type="date" class="form-control" id="start-date" name="start-date" value="<?php echo $details['checkin_date']; ?>" disabled>
                  <span class="input-group-text">至</span>
                  <input type="date" class="form-control" id="end-date" name="end-date" value="<?php echo $details['checkout_date']; ?>" disabled>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-2">
                房間數目
              </div>
              <div class="col">
                <div class="input-group">
                  <input type="number" class="form-control" id="rooms" name="rooms" value="<?php echo $details['room']; ?>" disabled>
                  <span class="input-group-text">間</span>
                </div>
              </div>
            </div>

            <!-- Office hours -->
            <div class="row">
              <div class="col-2">
                顧客人數
              </div>
              <div class="col-1">
                成人
                </div>
              <div class="col">
                <input class="form-control half" type="number" id="adult-number" name="adult-number" maxlength="130" value="<?php echo $details['adult']; ?>" disabled>
              </div>
              <div class="col-1">
                小童
              </div>
              <div class="col">
                <input class="form-control half" type="number" id="child-number" name="child-number" maxlength="130" value="<?php echo $details['children']; ?>" disabled>
              </div>
            </div>

            <div class="row">
              <div class="col-2">
                特殊需求
              </div>
              <div class="col">
                <input type="text" class="form-control" id="description" name="description" value="<?php echo $details['description']; ?>" disabled>
              </div>
            </div>
          </div>
        </div>
        <div class="row card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title">聯絡人資料</h5>
              </div>
            </div>
            <div class="row">
              <div class="col-2">
                顧客名稱
              </div>
              <div class="col">
                <input type="text" class="form-control" id="contact-name" name="contact-name" value="<?php echo $details['contact_name']; ?>" disabled>
              </div>
            </div>
            <div class="row">
              <div class="col-2">
                電話號碼
              </div>
              <div class="col">
                <input type="tel" class="form-control" id="contact-number" name="contact-number" minlength="8" maxlength="8" value="<?php echo $details['contact_phone']; ?>" disabled>
              </div>
            </div>
            <div class="row">
              <div class="col-2">
                電郵地址
              </div>
              <div class="col">
                <input type="text" class="form-control" id="contact-email" name="contact-email" value="<?php echo $details['contact_email']; ?>" disabled>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col text-end">
            <button type="button" class="btn btn-danger" onclick="g_cancelBooking()">取消預約</button>
          </div>
        </div>
      </div>
    </div> <!-- Container -->
  </form>

  <!-- Footer -->
  <?php include_once('../common/footer.php'); ?>

</body>

</html>