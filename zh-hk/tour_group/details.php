<?php
// Start the SESSION
session_start();
include_once('/xampp/htdocs/travelHK.com/dbConnect.php');
global $conn;

// Get the tour group id
$tourgroup_id = $_GET['id'];

// Get the tour group details
$sql = "SELECT * FROM `tourguide_tourgroup` WHERE `tourgroup_id` = $tourgroup_id;";
$rs = mysqli_query($conn, $sql);
$tourgroup = mysqli_fetch_assoc($rs);

// Get the tourist guide fullname
$sql = "SELECT CONCAT(`lastname`, ' ', `firstname`) AS `name`
          FROM `account`
          WHERE `account_id` = {$tourgroup['account_id']}";
$rs = mysqli_query($conn, $sql);
$tourist_guide = mysqli_fetch_assoc($rs);

// Get the itinerary details
$sql = "SELECT * FROM `itinerary` WHERE `itinerary_id` = {$tourgroup['itinerary_id']};";
$rs = mysqli_query($conn, $sql);
$itinerary = mysqli_fetch_assoc($rs);

// Get the itinerary schedule
$sql = "SELECT * FROM `itinerary_schedule`
          WHERE `itinerary_id` = {$tourgroup['itinerary_id']}
          ORDER BY start_time ASC;";
$rs = mysqli_query($conn, $sql);
$schedule_count = mysqli_num_rows($rs);
$schedule = array();

// Get the attraction details from itinerary schedule
$sql = "SELECT `attraction_id`, `attraction_chinese_name`, `attraction_english_name`,`chinese_address`, `english_address`, `latitude`, `longitude`
          FROM `attraction` WHERE ";
while ($row = mysqli_fetch_assoc($rs)) {
  $schedule[] = $row;
  $sql .= "`attraction_id` = ".$row['attraction_id'];
  $schedule_count--;
  if ($schedule_count > 0) {
    $sql .= " OR ";
  }
}

// Get attraction data which are we wanted
$rs = mysqli_query($conn, $sql);
$attraction = array();

while ($row = mysqli_fetch_assoc($rs)) {
  $attraction[] = $row;
}
?>

<!DOCTYPE html>
<html lang="zh-HK">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>香港本地旅遊平台 | 本地遊</title>

  <!-- Link the default css and js library -->
  <?php include_once('/xampp/htdocs/travelHK.com/library.php'); ?>

  <link href="/css/itinerary_details.css" rel="stylesheet">
  <script src="/js/general_itinerary_details.js"></script>
  <script src="/js/general_join_tour_group.js"></script>
</head>

<body>

  <!-- Header -->
  <?php include_once('/xampp/htdocs/travelHK.com/zh-hk/common/header.php'); ?>

  <!-- Category -->
  <?php include_once('/xampp/htdocs/travelHK.com/zh-hk/common/category.php'); ?>

  <?php
    echo '<div id="schedule-data" style="display:none">'.json_encode($schedule).'</div>';
    echo '<div id="attraction-data" style="display:none">'.json_encode($attraction).'</div>';
  ?>
  <div class="container">
    <!-- Page title -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <h3 class="card-title">旅行團詳細資料</h3>
          </div>
        </div>
      </div>
    </div>
    <!-- Map frame -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="showMap">
              <div id="map"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Route details -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">路線規劃</h5>
            <br>
            <table class="table table-borderless" id="attraction-details">
              <tr><th>景點名稱</th><th>開始時間</th><th>結束時間</th></tr>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!-- Details of tour group -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <!-- Title -->
            <div class="row">
              <div class="col-md-12">
                <h5 class="card-title">旅行團資料</h5>
              </div>
            </div>
            <!-- Tour group name -->
            <div class="row mt-3">
              <div class="col-md-2">
                旅行團名稱
              </div>
              <div class="col-md-10">
                <input type="text" class="form-control" value="<?php echo $tourgroup['subject']; ?>" disabled>
              </div>
            </div>
            <!-- Tour group description -->
            <div class="row mt-3">
              <div class="col-md-2">
                行程內容
              </div>
              <div class="col-md-10">
                <div class="form-floating">
                  <textarea class="form-control" style="height: 100px" disabled><?php echo $tourgroup['description']; ?></textarea>
                  <label for="tourgroup-description">內容</label>
                </div>
              </div>
            </div>
            <!-- Name of tourist guide -->
            <div class="row mt-3">
              <div class="col-md-2">
                姓名
              </div>
              <div class="col-md-10">
                <input type="text" class="form-control" value="<?php echo $tourist_guide['name']; ?>" disabled>
              </div>
            </div>
            <!-- Tour group fee -->
            <div class="row mt-3">
              <div class="col-md-2">
                行程收費
              </div>
              <div class="col-md-10">
                <div class="input-group mb-3">
                  <span class="input-group-text">$</span>
                  <input type="number" class="form-control" value="<?php echo $tourgroup['fee']; ?>" disabled>
                </div>
              </div>
            </div>
            <!-- Departure date -->
            <div class="row mt-3">
              <div class="col-md-2">
                出發日期
              </div>
              <div class="col-md-10">
                <input type="date" class="form-control" value="<?php echo $tourgroup['start_date']; ?>" disabled>
              </div>
            </div>
            <!-- Departure time -->
            <div class="row mt-3">
              <div class="col-md-2">
                出發時間
              </div>
              <div class="col-md-10">
                <input class="form-control" type="time" value="<?php echo $tourgroup['start_time']; ?>" disabled>
              </div>
            </div>
            <!-- Maximum number of people -->
            <div class="row mt-3">
              <div class="col-md-2">
                上限人數
              </div>
              <div class="col-md-10">
                <div class="input-group">
                  <input type="number" class="form-control" value="<?php echo $tourgroup['max_people']; ?>" disabled>
                  <span class="input-group-text">人</span>
                </div>
              </div>
            </div>
            <!-- Number of remaining places -->
            <div class="row mt-3">
              <div class="col-md-2">
                剩餘名額
              </div>
              <div class="col-md-10">
                <div class="input-group">
                  <input type="number" class="form-control" value="<?php echo $tourgroup['max_people'] - $tourgroup['joined_people']; ?>" disabled>
                  <span class="input-group-text">人</span>
                </div>
              </div>
            </div>
            <!-- Gathering place -->
            <div class="row mt-3">
              <div class="col-md-2">
                集合地點
              </div>
              <div class="col-md-10">
                <input class="form-control" type="text" value="<?php echo $tourgroup['start_address']; ?>" disabled>
              </div>
            </div>
            <!-- Dismissing Place -->
            <div class="row mt-3">
              <div class="col-md-2">
                解散地點
              </div>
              <div class="col-md-10">
                <input class="form-control" type="text" value="<?php echo $tourgroup['end_address']; ?>" disabled>
              </div>
            </div>
            <!-- Cutoff date -->
            <div class="row mt-3">
              <div class="col-md-2">
                截止日期
              </div>
              <div class="col-md-10">
                <input class="form-control" type="date" value="<?php echo $tourgroup['cutoff_date']; ?>" disabled>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Tour group registration -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <!-- Title -->
            <div class="row">
              <div class="col-md-12">
                <h5 class="card-title">報名參加</h5>
              </div>
            </div>
            <?php
            if (isset($_SESSION['user_id'])) {
            ?>
            <!-- User can see this if logged in -->
            <!-- Contact number -->
            <div class="row mt-3">
              <div class="col-md-2">
                聯絡電話
                <span class="text-danger">*</span>
              </div>
              <div class="col-md-10">
                <input type="tel" class="form-control" name="contact-number" id="contact-number" minlength="8" maxlength="8" oninput="value=value.replace(/[^\d]/g,'')">
              </div>
            </div>
            <!-- Number of people -->
            <div class="row mt-3">
              <div class="col-md-2">
                參加人數
                <span class="text-danger">*</span>
              </div>
              <div class="col-md-10">
                <input type="text" class="form-control" name="number-of-people" id="number-of-people">
              </div>
            </div>
            <!-- Hidden value for tour group registration -->
            <input type="hidden" name="applicant-id" id="applicant-id" value="<?php echo $_SESSION['user_id']; ?>">
            <input type="hidden" name="tourgroup-id" id="tourgroup-id" value="<?php echo $tourgroup['tourgroup_id']; ?>">
            <!-- Submit button -->
            <div class="row mt-3">
              <div class="col-md-12 text-end">
                <button type="button" class="btn btn-primary" onclick="submitTourGroupRegistration()">提交</button>
              </div>
            </div>
            <?php
            } else {
            ?>
            <!-- User can see this if not logged in -->
            <div class="row mt-3">
              <div class="col-md-12 d-flex justify-content-center">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#login-modal">登入後才可報名</button>
              </div>
            </div>
            <?php
            } // End if
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php include_once('/xampp/htdocs/travelHK.com/zh-hk/common/footer.php'); ?>

  <!-- Google api must under the map div -->
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBqEKP2Vz-JuEGigdCS97dpdszcDn1KOM&callback=loadMap"></script>

</body>

</html>