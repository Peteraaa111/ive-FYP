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

  <!-- Datatable -->
  <link rel="stylesheet" href="/lib/datatables/datatables.min.css">
  <script src="/lib/datatables/datatables.min.js"></script>

  <link href="/css/map_view.css" rel="stylesheet">
  <script src="/js/create_tourgroup.js"></script>
  <script src="/js/worker/tourist_guide/tour_group.js"></script>
</head>

<body>
  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php require_once("/xampp/htdocs/travelHK.com/zh-hk/worker/tourist_guide/sidebar.php"); ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <div id="content">
        <!-- Topbar -->
        <?php require_once("/xampp/htdocs/travelHK.com/zh-hk/worker/tourist_guide/topbar.php"); ?>
        <!-- End of Topbar -->

        <?php
        echo '<div id="schedule-data" style="display:none">'.json_encode($schedule).'</div>';
        echo '<div id="attraction-data" style="display:none">'.json_encode($attraction).'</div>';
        ?>
        <!-- Main Content -->
        <div class="container">
          <div class="card">
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
                          <textarea class="form-control" placeholder="Leave a comment here" id="tourgroup-description" style="height: 100px"><?php echo $details['description']; ?></textarea>
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
                        參加人數
                      </div>
                      <div class="col">
                        <div class="input-group">
                          <input type="number" class="form-control" id="max-people" name="max-people" value="<?php echo $details['joined_people']; ?>" disabled>
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
                    <?php
                    if ($details['status'] == 4 || $details['status'] == 5) {
                      echo '
                      <div class="row">
                        <div class="col-2">
                          狀態
                          <span class="text-danger">*<span>
                        </div>
                        <div class="col-3">
                          <div class="mb-3 form-check">';
                      if ($details['status'] == 4) {
                        echo '
                        <input class="form-check-input" type="radio" name="tourgroup-status" id="status-public" value="4" checked="checked" />
                        <label class="form-check-label" for="status-public">公開</label>
                        ';
                      } else {
                        echo '
                        <input class="form-check-input" type="radio" name="tourgroup-status" id="status-public" value="4" />
                        <label class="form-check-label" for="status-public">公開</label>
                        ';
                      }
                      echo '
                          </div>
                        </div>
                        <div class="col-3">
                          <div class="mb-3 form-check">';
                      if ($details['status'] == 5) {
                        echo '
                        <input class="form-check-input" type="radio" name="tourgroup-status" id="status-hidden" value="5" checked="checked" />
                        <label class="form-check-label" for="status-hidden">隱藏</label>
                        ';
                      } else {
                        echo '
                        <input class="form-check-input" type="radio" name="tourgroup-status" id="status-hidden" value="5" />
                        <label class="form-check-label" for="status-hidden">隱藏</label>
                        ';
                      }
                      echo '
                          </div>
                        </div>
                      </div>
                      ';
                    }
                    ?>
                  </div>
                </div><br>
              </form>

              <div class="row">
                <div class="col text-end">
                  <button type="button" class="btn btn-primary submit" id="update-tourgroup-btn">更新</button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Joined people -->
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <h3 class="card-title">參加者</h3>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <table id="joined-people" class="table table-hover">
                        <thead>
                          <tr>
                            <th>編號</th>
                            <th>姓名</th>
                            <th>報名人數</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $sql = "SELECT ac.`account_id`, CONCAT(ac.`lastname`, ' ', ac.`firstname`) AS `name`, mem.`num_people`
                                    FROM `tourgroup_member` mem
                                    INNER JOIN `account` ac ON ac.`account_id` = mem.`account_id`
                                    WHERE mem.`tourgroup_id` = {$details['tourgroup_id']};";
                          $rs = mysqli_query($conn, $sql);
                          while ($rc = mysqli_fetch_assoc($rs)) {
                            echo '<tr>';
                            echo '<td>' . $rc['account_id'] .'</td>';
                            echo '<td>' . $rc['name'] .'</td>';
                            echo '<td>' . $rc['num_people'] .'</td>';
                            echo '</tr>';
                          }
                          ?>
                        </tbody>
                        <tfoot>
                          <tr>
                            <th>編號</th>
                            <th>姓名</th>
                            <th>報名人數</th>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Tour group control -->
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <?php
                  if ($details['status'] == 2) {
                    echo '
                    <div class="row">
                      <div class="col d-flex justify-content-center">
                        <h1 class="fw-bold text-success">旅行團已結束</h1>
                      </div>
                    </div>
                    ';
                  } else if ($details['status'] == 3) {
                    echo '
                    <div class="row">
                      <div class="col d-flex justify-content-center">
                        <h1 class="fw-bold text-danger">旅行團已取消</h1>
                      </div>
                    </div>
                    ';
                  } else if (date("Y-m-d") < $details['start_date']) {
                    echo '
                    <div class="row">
                      <div class="col d-flex justify-content-center">
                        <h1 class="fw-bold text-primary">已創建旅行團</h1>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col d-flex justify-content-center">
                        <button type="button" class="btn btn-danger fw-bold fs-4" onclick="cancelTourGroup()">取消旅行團</button>
                      </div>
                    </div>
                    ';
                  } else if (date("Y-m-d") >= $details['start_date']) {
                    echo '
                    <div class="row">
                      <div class="col d-flex justify-content-center">
                        <h1 class="fw-bold text-primary">旅行團已開始</h1>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col d-flex justify-content-center">
                        <button type="button" class="btn btn-outline-success fw-bold fs-4 me-2" onclick="finishTourGroup()">結束旅行團</button>
                        <button type="button" class="btn btn-danger fw-bold fs-4" onclick="cancelTourGroup()">取消旅行團</button>
                      </div>
                    </div>
                    ';
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>
    <!-- End of Content Wrapper -->

  </div>


  

  <!-- Google api must under the map div -->
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBqEKP2Vz-JuEGigdCS97dpdszcDn1KOM&callback=loadMap"></script>

  <script>
    $('#joined-people').DataTable();
  </script>

</body>

</html>