<?php
// Start the SESSION
session_start();

require_once('/xampp/htdocs/travelHK.com/dbConnect.php');
global $conn;

// Get the itinerary id
$booking_id = $_GET['id'];

// Get the itinerary details
$details_sql = "SELECT * FROM `itinerary_booking` WHERE `booking_id` = $booking_id;";
$details_rs = mysqli_query($conn, $details_sql);
$details = mysqli_fetch_assoc($details_rs);

// get itinerary details
$itinerary_sql = "SELECT * FROM `itinerary` WHERE `itinerary_id` = {$details['itinerary_id']};";
$itinerary_rs = mysqli_query($conn, $itinerary_sql);
$itinerary = mysqli_fetch_assoc($itinerary_rs);

// Get the schedule
$schedule_sql = "SELECT * FROM `itinerary_schedule` WHERE `itinerary_id` = {$details['itinerary_id']} ORDER BY start_time ASC;";
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
  <title>行節細節 | 本地遊</title>

  <!-- Link the default css and js library -->
  <?php require_once('/xampp/htdocs/travelHK.com/library.php'); ?>

  <link href="/css/itinerary_details.css" rel="stylesheet">

  <script src="/js/update_itinerary_booking.js"></script>
</head>

<body>

  <!-- Header -->
  <?php require_once('/xampp/htdocs/travelhk.com/zh-hk/common/header.php'); ?>

  <!-- Category -->
  <?php require_once('/xampp/htdocs/travelhk.com/zh-hk/common/category.php'); ?>

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
              <div class="col">
                <h4 class="card-title fw-bold">路線規劃</h4>
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
        
        <form id="update-itinerary-booking-form" enctype="multipart/form-data" method="POST">
          <!-- hidden input of itinerary id and status -->
          <?php  
          echo "<input type='hidden' name='booking-id' id='booking-id' value='".$booking_id."' />";
          echo "<input type='hidden' name='booking-status' id='booking-status' value='".$details['status']."' />";
          echo "<input type='hidden' name='driver-id' id='driver-id' value='".$details['driver_id']."' />";
          echo "<input type='hidden' name='tourguide-id' id='tourguide-id' value='".$details['tourguide_id']."' />";
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
                  <tr><th>景點名稱</th><th>開始時間</th><th>結束時間</th></tr>
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
                </div>
                <div class="col">
                  <input type="text" class="form-control" id="chi-itinerary-name" name="chi-itinerary-name" value="<?php echo $itinerary['itinerary_chinese_name']; ?>" disabled />
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
                  <input type="hidden" name="driver-service" id="driver-service" value="" />
                  <input class="form-check-input" type="checkbox" name="driverService" id="driverService" value="1" 
                  <?php if ($details['drive_service'] == "1") { echo "checked"; } ?> disabled/>
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
                  <input type="hidden" name="tourguide-service" id="tourguide-service" value="" />
                  <input class="form-check-input" type="checkbox" name="tourguideService" id="tourguideService" value="1" 
                  <?php if ($details['tourguide_service'] == "1") { echo "checked"; } ?> disabled/>
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
                      如用戶沒有輸入集合或解散地點，請輸入集合地點為行程起點，而解散地點為行程終點。
                    </div>
                  </div>
                </div><br>
                <div class="row">
                  <div class="col-1">
                    出發日期
                  </div>
                  <div class="col">
                    <input class="form-control half" type="date" id="booking-date" name="booking-date" maxlength="130"  value="<?php echo $details['start_date']; ?>" disabled/>
                  </div>
                  <div class="col-1">
                    出發時間
                  </div>
                  <div class="col">
                    <input class="form-control half" type="time" id="booking-time" name="booking-time" maxlength="130"  value="<?php echo $details['start_time']; ?>" disabled/>
                  </div>
                </div>
                <div class="row">
                  <div class="col-1">
                    遊客人數
                  </div>
                  <div class="col">
                    <div class="input-group">
                      <input type="number" class="form-control" id="people-num" name="people-num"  value="<?php echo $details['people_num']; ?>" disabled/>
                      <span class="input-group-text">人</span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-1">
                    集合地點
                  </div>
                  <div class="col">
                    <input class="form-control half" type="text" id="pick-address" name="pick-address" maxlength="130" value="<?php echo $details['start_address']; ?>" disabled/>
                  </div>
                </div>
                <div class="row">
                  <div class="col-1">
                    解散地點
                  </div>
                  <div class="col">
                    <input class="form-control half" type="text" id="drop-address" name="drop-address" maxlength="130"  value="<?php echo $details['end_address']; ?>" disabled/>
                  </div>
                </div>
              </div>
            </div>
          </div><br>
          <div class="row">
            <div class="col text-end">
              <button type="button" class="btn btn-danger" onclick="cancelItineraryBooking()">取消預約</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Google api must under the map div -->
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBqEKP2Vz-JuEGigdCS97dpdszcDn1KOM&callback=loadMap"></script>

  <!-- Footer -->
  <?php require_once('/xampp/htdocs/travelhk.com/zh-hk/common/footer.php'); ?>

</body>

</html>