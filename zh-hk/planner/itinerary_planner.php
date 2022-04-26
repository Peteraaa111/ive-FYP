<?php
// Start the SESSION
session_start();

require_once('/xampp/htdocs/travelHK.com/dbConnect.php');
global $conn;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>行程計劃 | 本地遊</title>

  <!-- Link the default css and js library -->
  <?php require_once('/xampp/htdocs/travelHK.com/library.php'); ?>

  <link href="/css/planner.css" rel="stylesheet">

  <script src="/js/itinerary_planner.js"></script>
</head>

<body>

  <!-- Header -->
  <?php require_once('/xampp/htdocs/travelhk.com/zh-hk/common/header.php'); ?>

  <!-- Category -->
  <?php require_once('/xampp/htdocs/travelhk.com/zh-hk/common/category.php'); ?>

  <!-- Main Content -->
  <?php
  
    // initialize attraction data div  // need to change table name
    $attraction_sql = "SELECT attraction_id AS 'ID', attraction_chinese_name AS 'Chinese_Name',
                              attraction_english_name AS 'English_Name', district, chinese_address, 
                              english_address, latitude, longitude, phone_number, email, 
                              weekday_business_hours, weekend_business_hours, 
                              holiday_business_hours, create_datetime, status
                        FROM attraction WHERE status = 1";

    $attraction_rs = mysqli_query($conn, $attraction_sql);
    $restaurant_json_array = array();

    while ($attraction_row = mysqli_fetch_assoc($attraction_rs)) {
    $attraction_json_array[] = $attraction_row;
    }
    echo '<div id="attraction_allData">' . json_encode($attraction_json_array) . '</div>';

  ?>
  <div class="showMap" id="showMap">
    <div id="map">
    </div>
  </div>

  <div class="d-flex flex-column align-items-stretch flex-shrink-0 bg-white" style="width: 330px;" id="plannerHeader">
    <a href="#" class="d-flex align-items-center flex-shrink-0 p-3 link-dark text-decoration-none border-bottom">
      <span class="fs-5 fw-semibold">行程計劃</span>
    </a>
  </div>

  <!-- Planner -->
  <form id="scheduleForm" method="POST">
    <div class="d-flex flex-column align-items-stretch flex-shrink-0 bg-white" style="width: 330px;" id="planner">
      <!-- Planner schedule-->
      <div id="schedule">
      </div>
    </div>
    <div id="createDiv">
      <button type="button" class="btn btn-primary" onclick="createPlan()" id="createButton">創建行程</button>
    </div>
  </form>

  <!-- around div header -->
  <div id="aroundHeader" class="d-flex flex-column align-items-stretch flex-shrink-0 bg-white" style="width: 330px;">
    <a href="#" class="d-flex align-items-center flex-shrink-0 p-3 link-dark text-decoration-none border-bottom">
      <span class="fs-5 fw-semibold">附近景點</span>
    </a>
  </div>

  <!-- all restaurant or attactions around the last atttraction in planner -->
  <div id="aroundBody" class="d-flex flex-column align-items-stretch flex-shrink-0 bg-white" style="width: 330px;">

  </div>

  <!-- Google api must under the map div -->
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBqEKP2Vz-JuEGigdCS97dpdszcDn1KOM&callback=loadMap"></script>

  <!-- Footer -->
  <?php require_once('/xampp/htdocs/travelhk.com/zh-hk/common/footer.php'); ?>

</body>

</html>