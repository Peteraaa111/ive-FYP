<?php
// Start the SESSION
session_start();

require_once('/xampp/htdocs/travelHK.com/dbConnect.php');
global $conn;

$id = $_GET['id'];
$start_time = $_GET['startTime'];
$end_time = $_GET['endTime'];
$schedule_count = count($id);

$attraction_sql = "SELECT attraction_id AS 'ID', attraction_chinese_name AS 'Chinese_Name',
                              attraction_english_name AS 'English_Name', district, chinese_address, 
                              english_address, latitude, longitude, phone_number, email, 
                              weekday_business_hours, weekend_business_hours, 
                              holiday_business_hours, create_datetime, status
                        FROM attraction WHERE ";

for ($i = 0; $i < $schedule_count; $i++) {
  $attraction_sql .= "attraction_id = ".$id[$i];
  if ($i < $schedule_count - 1) {
    $attraction_sql .= " OR ";
  }
}

//Get attraction data which are we wanted
$attraction_rs = mysqli_query($conn, $attraction_sql);
$attraction = array();

while ($attraction_row = mysqli_fetch_assoc($attraction_rs)) {
  $attraction[] = $attraction_row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>路線規劃 | 本地遊</title>

  <!-- Link the default css and js library -->
  <?php require_once('/xampp/htdocs/travelHK.com/library.php'); ?>

  <link href="/css/map_view.css" rel="stylesheet">

  <script src="/js/plan_route.js"></script>
</head>

<body>

  <!-- Header -->
  <?php require_once('/xampp/htdocs/travelhk.com/zh-hk/common/header.php'); ?>

  <!-- Category -->
  <?php require_once('/xampp/htdocs/travelhk.com/zh-hk/common/category.php'); ?>

  <?php
    $id = $_GET['id'];
    // initialize district data div
    $district_sql = "SELECT * FROM hong_kong_district";
    $district_rs = mysqli_query($conn, $district_sql);
    $district_json_array = array();
    while ($district_row = mysqli_fetch_assoc($district_rs)) {
      $district_json_array[] = $district_row;
    }

    echo '<div id="attraction_allData">' . json_encode($attraction) . '</div>';
    echo '<div id="district_allData">' . json_encode($district_json_array) . '</div>';
 
    // Setting up hidden type of inputs for find out the route
    echo "<form id='schedule'>";
    // get parameters value on url
    for ($i = 0; $i < count($id); $i++) {
      echo "<input type='hidden' name='attraction[]' value='".$id[$i]."' />";
      echo "<input type='hidden' name='startTime[]' value='".$start_time[$i]."' />";
      echo "<input type='hidden' name='endTime[]' value='".$end_time[$i]."' />";
    }

    // itinerary subject
    echo "<input type='hidden' name='chi-name' id='chi-name' value='' />";
    echo "<input type='hidden' name='eng-name' id='eng-name' value='' />";
    
    // booking details
    echo "<input type='hidden' name='bookingDate' id='bookingDate' value='' />";
    echo "<input type='hidden' name='bookingTime' id='bookingTime' value='' />";
    echo "<input type='hidden' name='peopleNum' id='peopleNum' value='' />";
    echo "<input type='hidden' name='pickAddress' id='pickAddress' value='' />";
    echo "<input type='hidden' name='dropAddress' id='dropAddress' value='' />";
    echo "</form>";
  ?>

  <!-- Main Content -->
  <div class="container" id="searchHeader">
    <div class="container card">
      <div class="card-body">
        <div class="row card">
          <div class="card-body">
            <div class="col">
              <h4 class="card-title fw-bold">路線規劃</h4>
            </div>
          </div>
        </div>
        <!-- Map frame -->
        <div class="row card">
          <div class="card-body">
            <div class="col">
              <div class="showMap">
                <div id="map">
                </div>
              </div>
            </div>
          </div>
        </div><br>

        <h5 class="card-title">行程細節</h5>
        <div class="row card">
          <div class="card-body">
            <!-- empty row of div for making good padding -->
            <div class="row">
              <div class="col">
                <div class="title"></div>
            </div>
            </div>
            <div class="col">
              <!-- Route details -->
              <table class="table table-borderless" id="detailsTable">
                <tr><th></th><th>起點</th><th>終點</th><th>行程距離</th><th>所需時間</th></tr>
              </table>
            </div>
          </div>
        </div><br>

        <h5 class="card-title">行程資料</h5>
        <div class="row card">
          <div class="card-body">
            <!-- empty row of div for making good padding -->
            <div class="row">
              <!-- empty row of div for making good padding -->
              <div class="row">
                <div class="col">
                  <div class="title"></div>
                </div>
              </div>
              <div class="col-2">
                行程名稱
                <span class="text-danger">*</span>
              </div>
              <div class="col-5">
                <input type="text" class="form-control" id="chi-itinerary-name" name="chi-itinerary-name" placeholder="中文">
              </div>
              <div class="col-5">
                <input type="text" class="form-control" id="eng-itinerary-name" name="eng-itinerary-name" placeholder="英文">
              </div>
            </div>
          </div>
        </div><br>

        <h5 class="card-title">接載服務</h5>
        <div class="row card">
          <div class="card-body">
            <!-- empty row of div for making good padding -->
            <div class="row">
              <div class="col">
                <div class="title"></div>
              </div>
            </div>
            <div class="col">
              <div class="mb-3 form-check">
                <input class="form-check-input" type="checkbox" name="driverService" id="driverService">
                <label class="form-check-label" for="driverService">
                  是的, 我需要司機提供接載服務
                </label>
              </div>
            </div>
            </div>
        </div><br>

        <h5 class="card-title">導遊服務</h5>
        <div class="row card">
          <div class="card-body">
            <!-- empty row of div for making good padding -->
            <div class="row">
              <div class="col">
                <div class="title"></div>
              </div>
            </div>
            <div class="col">
              <div class="mb-3 form-check">
                <input class="form-check-input" type="checkbox" name="tourguideService" id="tourguideService">
                <label class="form-check-label" for="tourguideService">
                  是的, 我需要導遊提供導遊服務
                </label>
              </div>
            </div>
          </div>
        </div><br>
        
        <div id="pickUpAddress">
          <h5 class="card-title">接送地點</h5>
          <div class="row card">
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <div class="title" style="color:grey">
                    如用戶沒有輸入集合或解散地點，系統將預設集合地點為行程起點，而解散地點為行程終點。
                  </div>
                </div>
              </div><br>
              <div class="row">
                <div class="col-1">
                  出發日期
                  <span class="text-danger">*<span>
                </div>
                <div class="col">
                  <input class="form-control half" type="date" id="booking-date" name="booking-date" maxlength="130">
                </div>
                <div class="col-1">
                  出發時間
                  <span class="text-danger">*<span>
                </div>
                <div class="col">
                  <input class="form-control half" type="time" id="booking-time" name="booking-time" maxlength="130">
                </div>
              </div>
              <div class="row">
                <div class="col-1">
                  遊客人數
                  <span class="text-danger">*<span>
                </div>
                <div class="col">
                  <div class="input-group">
                    <input type="number" class="form-control" id="people-num" name="people-num">
                    <span class="input-group-text">人</span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-1">
                  集合地點
                </div>
                <div class="col">
                  <input class="form-control half" type="text" id="pick-address" name="pick-address" maxlength="130" placeholder="Optional">
                </div>
              </div>
              <div class="row">
                <div class="col-1">
                  解散地點
                </div>
                <div class="col">
                  <input class="form-control half" type="text" id="drop-address" name="drop-address" maxlength="130" placeholder="Optional">
                </div>
              </div>
            </div>
          </div>
        </div><br>

        <div class="row">
          <div class="col text-end">
            <button type="button" class="btn btn-primary submit" onclick="createItinerary()">提交</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Google api must under the map div -->
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBqEKP2Vz-JuEGigdCS97dpdszcDn1KOM&callback=loadMap"></script>

  <!-- Footer -->
  <?php require_once('/xampp/htdocs/travelhk.com/zh-hk/common/footer.php'); ?>

</body>

</html>