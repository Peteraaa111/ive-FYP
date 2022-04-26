<?php
// Start the SESSION
session_start();

require_once('/xampp/htdocs/travelHK.com/dbConnect.php');
global $conn;

$tourgroup_id = $_GET['id'];

// Get the itinerary details
$details_sql = "SELECT * FROM `tourguide_tourgroup` WHERE `tourgroup_id` = $tourgroup_id;";
$details_rs = mysqli_query($conn, $details_sql);
$details = mysqli_fetch_assoc($details_rs);

// Get the itinerary details
$itinerary_sql = "SELECT * FROM `itinerary` WHERE `itinerary_id` = '{$details['itinerary_id']}';";
$itinerary_rs = mysqli_query($conn, $itinerary_sql);
$itinerary = mysqli_fetch_assoc($itinerary_rs);

// Get the schedule
$schedule_sql = "SELECT * FROM `itinerary_schedule` WHERE `itinerary_id` = '{$details['itinerary_id']}' ORDER BY start_time ASC;";
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
  <title><?php echo $details['subject']; ?> | 本地遊</title>

  <!-- Link the default css and js library -->
  <?php require_once('/xampp/htdocs/travelHK.com/library.php'); ?>

  <link href="/css/map_view.css" rel="stylesheet">

  <script src="/js/create_tourgroup.js"></script>
</head>

<body>

  <?php
    echo '<div id="schedule-data" style="display:none">'.json_encode($schedule).'</div>';
    echo '<div id="attraction-data" style="display:none">'.json_encode($attraction).'</div>';
  ?>

  <!-- Main Content -->
  
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
              </div>
              <div class="col">
                <input type="text" class="form-control" id="chi-itinerary-name" name="chi-itinerary-name" placeholder="中文" value="<?php echo $itinerary['itinerary_chinese_name']; ?>" disabled>
              </div>
            </div>
          </div>
        </div><br>

        <form id="update-tourgroup-form" enctype="multipart/form-data" method="POST">
          <!-- empty row of div for making good padding -->
          <?php echo "<input type='hidden' name='tourgroup_id' id='tourgroup_id' value='$tourgroup_id' />" ?>
          <?php echo "<input type='hidden' name='tourgroup-people' id='tourgroup-people' value='{$details['joined_people']}' />" ?>

          <h5 class="card-title">旅行團資料</h5>
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
                  旅行團名稱
                  <span class="text-danger">*</span>
                </div>
                <div class="col">
                  <input type="text" class="form-control" id="tourgroup-subject" name="tourgroup-subject" placeholder="中文" value="<?php echo $details['subject']; ?>">
                </div>
              </div>
              <div class="row">
                <div class="col-2">
                  行程內容
                  <span class="text-danger">*<span>
                </div>
                <div class="col">
                  <div class="form-floating">
                    <input type="hidden" name="description" id="description" value="" />
                    <textarea class="form-control" placeholder="Leave a comment here" id="tourgroup-description" style="height: 100px">
                      <?php echo $details['description']; ?>
                    </textarea>
                    <label for="tourgroup-description">內容</label>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-2">
                  行程收費
                  <span class="text-danger">*<span>
                </div>
                <div class="col">
                  <input class="form-control half" type="number" id="tourgroup-fee" name="tourgroup-fee" maxlength="130" value="<?php echo $details['fee']; ?>">
                </div>
              </div>
              <div class="row">
                <div class="col-2">
                  出發日期
                  <span class="text-danger">*<span>
                </div>
                <div class="col">
                  <input class="form-control half" type="date" id="tourgroup-date" name="tourgroup-date" value="<?php echo $details['start_date']; ?>">
                </div>
                <div class="col-1">
                  出發時間
                  <span class="text-danger">*<span>
                </div>
                <div class="col">
                  <input class="form-control half" type="time" id="tourgroup-time" name="tourgroup-time" value="<?php echo $details['start_time']; ?>">
                </div>
              </div>
              <div class="row">
                <div class="col-2">
                  上限人數
                  <span class="text-danger">*<span>
                </div>
                <div class="col">
                  <div class="input-group">
                    <input type="number" class="form-control" id="max-people" name="max-people" value="<?php echo $details['max_people']; ?>">
                    <span class="input-group-text">人</span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-2">
                  集合地點
                  <span class="text-danger">*<span>
                </div>
                <div class="col">
                  <input class="form-control half" type="text" id="start-address" name="start-address" maxlength="130" value="<?php echo $details['start_address']; ?>">
                </div>
              </div>
              <div class="row">
                <div class="col-2">
                  解散地點
                  <span class="text-danger">*<span>
                </div>
                <div class="col">
                  <input class="form-control half" type="text" id="end-address" name="end-address" maxlength="130" value="<?php echo $details['end_address']; ?>">
                </div>
              </div>
              <div class="row">
                <div class="col-2">
                  截止日期
                  <span class="text-danger">*<span>
                </div>
                <div class="col">
                  <input class="form-control half" type="date" id="cut-off-date" name="cut-off-date" value="<?php echo $details['cutoff_date']; ?>">
                </div>
              </div>
              <div class="row">
                <div class="col-2">
                  狀態
                  <span class="text-danger">*<span>
                </div>
                <div class="col-1">
                  <div class="mb-3 form-check">
                    <input class="form-check-input" type="radio" name="tourgroup-status" id="status-public" value="4" <?php if ($details['status'] == 4) { echo "checked"; } ?> />
                    <label class="form-check-label" for="tourgroup-status">公開</label>
                  </div>
                </div>
                <div class="col">
                  <div class="mb-3 form-check">
                    <input class="form-check-input" type="radio" name="tourgroup-status" id="status-hidden" value="5" <?php if ($details['status'] == 5) { echo "checked"; } ?> />
                    <label class="form-check-label" for="tourgroup-status">隱藏</label>
                  </div>
                </div>
              </div>
            </div>
          </div><br>
        </form>

        <div class="row">
          <div class="col text-end">
            <button type="button" class="btn btn-primary submit" id="update-tourgroup-btn">提交</button>
          </div>
        </div>
      </div>
    </div>

  <!-- Google api must under the map div -->
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBqEKP2Vz-JuEGigdCS97dpdszcDn1KOM&callback=loadMap"></script>

</body>

</html>