<?php
// Start the SESSION
session_start();

include_once('dbConnect.php');
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
  <?php include_once('default_page/library.php'); ?>

  <link href="css/map_view.css" rel="stylesheet">

  <script type="text/javascript" src="js/map_view.js"></script>
</head>

<body>

  <!-- Header -->
  <?php include_once('default_page/header.php'); ?>

  <!-- Category -->
  <?php include_once('default_page/category.php'); ?>

  <!-- Main Content -->
  <div class="container">
    <div class="row">
      <div class="col">
        <div class="container" id="mapHeader">
          <div class="d-flex justify-content-between">
            <div>
              <h3>地圖</h3>
            </div>
            <div class="d-flex justify-content-end">
              <div>
                <select class="form-select" id="type" name="type">
                  <option value="" selected disabled hidden>請選擇類別</option>
                  <option value="all">全部</option>
                  <option value="restaurant">餐廳</option>
                  <option value="attraction">景點</option>
                  <option value="guesthouse">住宿</option>
                </select>
              </div>
              <div>
                <select class="form-select" id="district" name="district">
                  <option value="" selected disabled hidden>請選擇地區</option>
                  <?php
                  $region_sql = "SELECT * FROM `Hong_Kong_Region`;";
                  $region_rs = mysqli_query($conn, $region_sql);

                  while ($region = mysqli_fetch_assoc($region_rs)) {
                    echo "<optgroup label=\"" . $region['zh-hk'] . "\">";

                    $district_sql = "SELECT * FROM `Hong_Kong_District` WHERE Region_ID = " . $region['ID'] . ";";
                    $district_rs = mysqli_query($conn, $district_sql);
                    while ($district = mysqli_fetch_assoc($district_rs)) {
                      echo "<option value=\"" . $district['ID'] . "\">" . $district['zh-hk'] . "</option>";
                    }

                    echo "</optgroup>";
                  }
                  ?>
                </select>
              </div>
              <div>
                <button type="button" class="btn btn-primary" onclick="searchMap()">搜尋</button>
              </div>
            </div>
          </div>
        </div>
        <div class="container">
          <!-- Map frame -->
          <?php
          include_once('map_function.php');
          $markerGetter = new initialMap;

          // restaurant initialize
          $allRestaurant = $markerGetter->getAllRestaurants();
          $allRestaurant = json_encode($allRestaurant, true);
          echo '<div id="restaurant_allData">' . $allRestaurant . '</div>';

          // attraction initialize
          $allRestaurant = $markerGetter->getAllAttractions();
          $allRestaurant = json_encode($allRestaurant, true);
          echo '<div id="attraction_allData">' . $allRestaurant . '</div>';

          ?>
          <div class="showMap">
            <div id="map">

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Google api must under the map div -->
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBqEKP2Vz-JuEGigdCS97dpdszcDn1KOM&callback=loadMap"></script>

  <!-- Footer -->
  <?php include_once('default_page/footer.php'); ?>

</body>

</html>