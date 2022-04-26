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

  <?php
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
    echo "<form id='schedule' enctype='multipart/form-data' method='POST'>";
    // get parameters value on url

    for ($i = 0; $i < count($id); $i++) {
      echo "<input type='hidden' name='attraction[]' value='".$id[$i]."' />";
      echo "<input type='hidden' name='startTime[]' value='".$start_time[$i]."' />";
      echo "<input type='hidden' name='endTime[]' value='".$end_time[$i]."' />";
    }
  ?>

  <div id="wrapper">
    <!-- Sidebar -->
    <?php require_once("/xampp/htdocs/travelHK.com/zh-hk/worker/tourist_guide/sidebar.php"); ?>
    <!-- End of Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">

        <!-- Topbar -->
        <?php require_once("/xampp/htdocs/travelHK.com/zh-hk/worker/tourist_guide/topbar.php"); ?>
        <!-- End of Topbar -->

        <!-- Main Content -->
        <div class="container-fluid">
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
                    <div class="col">
                      <input type="text" class="form-control" id="chi-itinerary-name" name="chi-itinerary-name" placeholder="中文">
                    </div>
                  </div>
                </div>
              </div><br>

              <h5 class="card-title">創建旅行團</h5>
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
                      <input class="form-check-input" type="checkbox" name="create-tourgroup-service" id="create-tourgroup-service">
                      <label class="form-check-label" for="create-tourgroup-service">
                        是的, 我需要創建旅行團
                      </label>
                    </div>
                  </div>
                </div>
              </div><br>

              <div id="create-tourgroup">
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
                        <input type="text" class="form-control" id="tourgroup-subject" name="tourgroup-subject" placeholder="中文">
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
                          <textarea class="form-control" placeholder="Leave a comment here" id="tourgroup-description" style="height: 100px"></textarea>
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
                        <input class="form-control half" type="number" id="tourgroup-fee" name="tourgroup-fee" maxlength="130">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-2">
                        出發日期
                        <span class="text-danger">*<span>
                      </div>
                      <div class="col">
                        <input class="form-control half" type="date" id="tourgroup-date" name="tourgroup-date">
                      </div>
                      <div class="col-1">
                        出發時間
                        <span class="text-danger">*<span>
                      </div>
                      <div class="col">
                        <input class="form-control half" type="time" id="tourgroup-time" name="tourgroup-time">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-2">
                        上限人數
                        <span class="text-danger">*<span>
                      </div>
                      <div class="col">
                        <div class="input-group">
                          <input type="number" class="form-control" id="max-people" name="max-people">
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
                        <input class="form-control half" type="text" id="start-address" name="start-address" maxlength="130">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-2">
                        解散地點
                        <span class="text-danger">*<span>
                      </div>
                      <div class="col">
                        <input class="form-control half" type="text" id="end-address" name="end-address" maxlength="130">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-2">
                        截止日期
                        <span class="text-danger">*<span>
                      </div>
                      <div class="col">
                        <input class="form-control half" type="date" id="cut-off-date" name="cut-off-date">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-2">
                        狀態
                        <span class="text-danger">*<span>
                      </div>
                      <div class="col-1">
                        <div class="mb-3 form-check">
                          <input class="form-check-input" type="radio" name="tourgroup-status" id="status-public" value="4" />
                          <label class="form-check-label" for="tourgroup-status">公開</label>
                        </div>
                      </div>
                      <div class="col">
                        <div class="mb-3 form-check">
                          <input class="form-check-input" type="radio" name="tourgroup-status" id="status-hidden" value="5" />
                          <label class="form-check-label" for="tourgroup-status">隱藏</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div><br>
              
              <?php echo "</form>"; ?>

              <div class="row">
                <div class="col text-end">
                  <button type="button" class="btn btn-primary submit" id="tourguide-plan-route">提交</button>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>



  <!-- Google api must under the map div -->
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBqEKP2Vz-JuEGigdCS97dpdszcDn1KOM&callback=loadMap"></script>

</body>

</html>