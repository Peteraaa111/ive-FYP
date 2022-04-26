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
  <title>資訊地圖 | 本地遊</title>

  <!-- Link the default css and js library -->
  <?php require_once('/xampp/htdocs/travelHK.com/library.php'); ?>

  <link href="/css/map_view.css" rel="stylesheet">

  <script src="/js/map_view.js"></script>
</head>

<body>

  <!-- Header -->
  <?php require_once('/xampp/htdocs/travelhk.com/zh-hk/common/header.php'); ?>

  <!-- Category -->
  <?php require_once('/xampp/htdocs/travelhk.com/zh-hk/common/category.php'); ?>

  <!-- Main Content -->
  <div class="container" id="searchHeader">
    <div class="container card">
      <div class="card-body">
        <div class="row">
          <div class="col-5">
            <select class="form-select" id="type" name="type">
              <option value="" selected disabled hidden>請選擇類別</option>
              <option value="all">全部</option>
              <option value="restaurant">餐廳</option>
              <option value="attraction">景點</option>
              <option value="guesthouse">住宿</option>
            </select>
          </div>
          <div class="col-5">
            <select class="form-select" id="district" name="district">
              <option value="" selected disabled hidden>請選擇地區</option>
              <?php
                $region_sql = "SELECT * FROM `hong_kong_region`;";
                $region_rs = mysqli_query($conn, $region_sql);

                while ($region = mysqli_fetch_assoc($region_rs)) {
                  echo "<optgroup label=\"" . $region['zh-hk'] . "\">";
                  $district_sql = "SELECT * FROM `hong_kong_district` WHERE region_id = " . $region['region_id'] . ";";
                  $district_rs = mysqli_query($conn, $district_sql);
                  while ($district = mysqli_fetch_assoc($district_rs)) {
                    echo "<option value=\"" . $district['district_id'] . "\">" . $district['zh-hk'] . "</option>";
                  }

                  echo "</optgroup>";
                }
              ?>
            </select>
          </div>
          <div class="col-2">
            <button type="button" class="btn btn-primary" onclick="searchMap()">搜尋</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <?php
      // initialize restaurant data div  // need to change table name
      $restaurant_sql = "SELECT restaurant_id AS 'ID', restaurant_chinese_name AS 'Chinese_Name',
                                restaurant_english_name AS 'English_Name', district, chinese_address, 
                                english_address, latitude, longitude, phone_number, 
                                number_of_seats, weekday_business_hours, weekend_business_hours, 
                                holiday_business_hours, create_datetime, status, partner_id
                          FROM restaurant WHERE status != 0";

      $restaurant_rs = mysqli_query($conn, $restaurant_sql);
      $restaurant_json_array = array();
          
      while ($restaurant_row = mysqli_fetch_assoc($restaurant_rs)) {
        $restaurant_json_array[] = $restaurant_row;
      }          

      echo '<div id="restaurant_allData">' . json_encode($restaurant_json_array) . '</div>';

      // initialize attraction data div
      $attraction_sql = "SELECT attraction_id AS 'ID', attraction_chinese_name AS 'Chinese_Name',
                                attraction_english_name AS 'English_Name', district, chinese_address, 
                                english_address, latitude, longitude, phone_number, email, 
                                weekday_business_hours, weekend_business_hours, 
                                holiday_business_hours, create_datetime, status 
                          FROM attraction WHERE status = 1";

      $attraction_rs = mysqli_query($conn, $attraction_sql);
      $attraction_json_array = array();
        
      while ($attraction_row = mysqli_fetch_assoc($attraction_rs)) {
        $attraction_json_array[] = $attraction_row;
      }

      echo '<div id="attraction_allData">' . json_encode($attraction_json_array) . '</div>';

      // initialize guesthouse data div
      $guesthouse_sql = "SELECT guesthouse_id AS 'ID', guesthouse_chinese_name AS 'Chinese_Name',
                                guesthouse_english_name AS 'English_Name', district, chinese_address, 
                                english_address, latitude, longitude, phone_number,
                                number_of_rooms, weekday_business_hours, weekend_business_hours, 
                                holiday_business_hours, create_datetime, Status, partner_id
                          FROM guesthouse WHERE status = 1";

      $guesthouse_rs = mysqli_query($conn, $guesthouse_sql);
      $guesthouse_json_array = array();
        
      while ($guesthouse_row = mysqli_fetch_assoc($guesthouse_rs)) {
        $guesthouse_json_array[] = $guesthouse_row;
      }

      echo '<div id="guesthouse_allData">' . json_encode($guesthouse_json_array) . '</div>';
        
      // initialize district data div
      $district_sql = "SELECT * FROM hong_kong_district";
      $district_rs = mysqli_query($conn, $district_sql);
      $district_json_array = array();
      while ($district_row = mysqli_fetch_assoc($district_rs)) {
        $district_json_array[] = $district_row;
      }

      echo '<div id="district_allData">' . json_encode($district_json_array) . '</div>';
    ?>

    <div class="showMap">
      <!-- Map frame -->
      <div id="map">
      </div>
    </div>
  </div>

  <!-- Google api must under the map div -->
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBqEKP2Vz-JuEGigdCS97dpdszcDn1KOM&callback=loadMap"></script>

  <!-- Footer -->
  <?php require_once('/xampp/htdocs/travelhk.com/zh-hk/common/footer.php'); ?>

</body>
</html>