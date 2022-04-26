<?php
// Start the SESSION
session_start();

require_once('/xampp/htdocs/travelHK.com/dbConnect.php');
global $conn;

// Get the itinerary id
$itinerary_id = $_GET['id'];

// Get the itinerary details
$details_sql = "SELECT * FROM `itinerary` WHERE `itinerary_id` = $itinerary_id;";
$details_rs = mysqli_query($conn, $details_sql);
$details = mysqli_fetch_assoc($details_rs);

// Get the schedule
$schedule_sql = "SELECT * FROM `itinerary_schedule` WHERE `itinerary_id` = $itinerary_id ORDER BY start_time ASC;";
$schedule_rs = mysqli_query($conn, $schedule_sql);
$schedule_count = mysqli_num_rows($schedule_rs);
$schedule = array();

// attraction sql command
$attraction_sql = "SELECT `attraction_id`, `attraction_chinese_name`, `attraction_english_name`,
                          `chinese_address`, `english_address`, `latitude`, `longitude`
                    FROM `attraction` WHERE ";

while ($schedule_row = mysqli_fetch_assoc($schedule_rs)) {
  $schedule[] = $schedule_row;
  $attraction_sql .= "attraction_id = ".$schedule_row['attraction_id'];
  $schedule_count--;
  if ($schedule_count > 0) {
    $attraction_sql .= " OR ";
  }
}

// Get the booking
$booking_sql = "SELECT * FROM `itinerary_booking` WHERE `itinerary_id` = $itinerary_id;";
$booking_rs = mysqli_query($conn, $booking_sql);
$booking = mysqli_fetch_assoc($booking_rs);

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
  <title>
    <?php 
    echo ($details['itinerary_chinese_name'] == "" ? $details['itinerary_english_name'] : $details['itinerary_chinese_name']);
    ?> | 本地遊
  </title>

  <!-- Link the default css and js library -->
  <?php require_once('/xampp/htdocs/travelHK.com/library.php'); ?>

  <link href="/css/itinerary_details.css" rel="stylesheet">

  <script src="/js/tourguide_itinerary_details.js"></script>
</head>

<body>

  <!-- schedule and attraction data -->
  <?php
  echo '<div id="schedule-data" style="display:none">'.json_encode($schedule).'</div>';
  echo '<div id="attraction-data" style="display:none">'.json_encode($attraction).'</div>';
  ?>

  <!-- Main Content -->
  <div class="container" id="searchHeader">
    <div class="container card">
      <div class="card-body">
        <div class="row card">
          <div class="card-body">
            <div class="row">
              <div class="col-9">
                <h4 class="card-title fw-bold">路線規劃</h4>
              </div>
              <div class="col-2">
                <button type="button" class="btn btn-success" id="booking-btn" onclick="tourgroupRequest()" style="width:100%">創建旅行團</button>
              </div>
              <div class="col-1">
                <button type="button" class="btn btn-warning" id="update-btn" style="width:100%">編輯</button>
              </div>
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
        
        <form id="update-itinerary-request-form" enctype="multipart/form-data" method="POST">
          <!-- hidden input of itinerary id and status -->
          <?php  
          echo "<input type='hidden' name='itinerary-id' id='itinerary-id' value='".$itinerary_id."' />";
          echo "<input type='hidden' name='itinerary-status' id='itinerary-status' value='{$details['status']}' />";
          ?>
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

          <h5 class="card-title">路線規劃</h5>
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
                <table class="table table-borderless" id="attraction-details">
                  <tr><th>景點名稱</th><th>開始時間</th><th>結束時間</th><th></th></tr>
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
                <div class="col">
                  <input type="text" class="form-control" id="chi-itinerary-name" name="chi-itinerary-name" placeholder="中文" value="<?php echo $details['itinerary_chinese_name']; ?>" />
                </div>
              </div>
            </div>
          </div><br>

          <div class="row">
            <div class="col text-end">
              <button type="button" class="btn btn-secondary" id="cancel-btn">取消</button>
              <button type="button" class="btn btn-primary submit" id="submit-btn">提交</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Google api must under the map div -->
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBqEKP2Vz-JuEGigdCS97dpdszcDn1KOM&callback=loadMap"></script>

</body>

</html>