<?php
session_start();

// Connect to database
require_once("/xampp/htdocs/travelHK.com/dbConnect.php");
// Get the connection variable
global $conn;

// Get the details
$id = $_GET['id'];
$sql = "SELECT * FROM `guesthouse_discover` WHERE `id` = $id";
$rs = mysqli_query($conn, $sql);
$rc = mysqli_fetch_assoc($rs);

// Get the payment method
$sql = "SELECT * FROM `guesthouse_discover_payment_method` WHERE `id` = $id";
$rs = mysqli_query($conn, $sql);
$payment = mysqli_fetch_assoc($rs);

// Get the status
$sql = "SELECT * FROM `discovery_status_list` WHERE `id` = ".$rc['status'];
$rs = mysqli_query($conn, $sql);
$status = mysqli_fetch_assoc($rs);
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>管理頁面</title>

  <?php
  require_once('/xampp/htdocs/travelHK.com/library.php');
  ?>
  <script src="/js/admin.js"></script>
  <link rel="stylesheet" href="/css/admin_sidebar.css">
  <link rel="stylesheet" href="/css/admin_form.css">
</head>

<body>

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php require_once("/xampp/htdocs/travelHK.com/admin/common/sidebar.php"); ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <div id="content">

        <!-- Topbar -->
        <?php require_once("/xampp/htdocs/travelHK.com/admin/common/topbar.php"); ?>
        <!-- End of Topbar -->

        <div class="container-fluid">
          <div class="row mb-3">
            <div class="col-md-10 offset-1">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-8">
                      <h3 class="card-title text-secondary">新民宿資訊 (ID: <?php echo $rc['id']; ?>)</h3>
                    </div>
                    <div class="col-md-4">
                      <div class="text-end">
                          <?php
                          switch($rc['status'])
                          {
                            case 1:
                              echo '<span class="badge bg-primary fs-5">'.$status['zh-hk'].'</span>';
                              break;
                            case 2:
                              echo '<span class="badge bg-success fs-5">'.$status['zh-hk'].'</span>';
                              break;
                            case 3:
                              echo '<span class="badge bg-danger fs-5">'.$status['zh-hk'].'</span>';
                              break;
                          }
                          ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- guesthouse information -->
          <div class="row">
            <div class="col-md-10 offset-1">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title text-secondary">民宿資料</h4>
                  <!-- guesthouse name -->
                  <div class="row">
                    <div class="col-md-2">
                      民宿名稱<span class="text-danger">*</span>
                    </div>
                    <div class="col-md-5">
                      <input type="text" class="form-control" value="<?php echo $rc['guesthouse_chinese_name']; ?>" readonly>
                    </div>
                    <div class="col-md-5">
                      <input type="text" class="form-control" value="<?php echo $rc['guesthouse_english_name']; ?>" readonly>
                    </div>
                  </div>
                  <!-- District -->
                  <div class="row">
                    <div class="col-md-2">
                      地區<span class="text-danger">*</span>
                    </div>
                    <div class="col-md-10">
                      <select class="form-select" id="district" name="district" disabled="true">
                        <?php
                        $region_sql = "SELECT * FROM `hong_kong_region`;";
                        $region_rs = mysqli_query($conn, $region_sql);

                        while ($region = mysqli_fetch_assoc($region_rs)) {
                          echo "<optgroup label=\"" . $region['zh-hk'] . "\">";

                          $district_sql = "SELECT * FROM `hong_kong_district` WHERE `region_id` = " . $region['region_id'] . ";";
                          $district_rs = mysqli_query($conn, $district_sql);
                          while ($district = mysqli_fetch_assoc($district_rs)) {
                            if ($rc['district'] == $district['district_id']) {
                              echo "<option value=\"" . $district['district_id'] . "\" selected>" . $district['zh-hk'] . "</option>";
                            } else {
                              echo "<option value=\"" . $district['district_id'] . "\">" . $district['zh-hk'] . "</option>";
                            }
                          }
                          echo "</optgroup>";
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <!-- Address -->
                  <div class="row">
                    <div class="col-md-2">
                      地址<span class="text-danger">*</span>
                    </div>
                    <div class="col-md-10">
                      <input type="text" class="form-control" value="<?php echo $rc['chinese_address']; ?>" readonly>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-10 offset-2">
                      <input type="text" class="form-control" value="<?php echo $rc['english_address']; ?>" readonly>
                    </div>
                  </div>
                  <!-- Number of seats -->
                  <div class="row">
                    <div class="col-md-2">
                      房間數目<span class="text-danger">*</span>
                    </div>
                    <div class="col-md-10">
                      <div class="input-group">
                        <input type="number" class="form-control" id="seats" name="seats" autocomplete="off" value="<?php echo $rc['number_of_rooms']; ?>" readonly>
                        <span class="input-group-text">位</span>
                      </div>
                    </div>
                  </div>
                  <!-- Business hours - weekday -->
                  <div class="row">
                    <div class="col-md-2">
                      營業時間<span class="text-danger">*</span>
                    </div>
                    <div class="col-md-2">星期一至五</div>
                    <div class="col-md-8">
                      <?php
                      switch ($rc['weekday_business_hours']) {
                        case 'closed':
                          echo '
                          <input type="time" class="form-control business-hours" name="start-weekday" id="start-weekday" value="23:59" readonly>
                          <span> - </span>
                          <input type="time" class="form-control business-hours" name="end-weekday" id="end-weekday" value="23:59" readonly>
                          <div class="form-check form-check-inline ms-2">
                            <input type="checkbox" class="form-check-input" name="weekday-closed" id="weekday-closed" checked disabled="true">
                            <label for="weekday-closed">休息</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="weekday-24hours" id="weekday-24hours">
                            <label for="weekday-24hours">24小時</label> 
                          </div>
                          ';
                          break;
                        case '24 Hours':
                          echo '
                          <input type="time" class="form-control business-hours" name="start-weekday" id="start-weekday" value="00:00" readonly>
                          <span> - </span>
                          <input type="time" class="form-control business-hours" name="end-weekday" id="end-weekday" value="00:00" readonly>
                          <div class="form-check form-check-inline ms-2">
                            <input type="checkbox" class="form-check-input" name="weekday-closed" id="weekday-closed" disabled="true">
                            <label for="weekday-closed">休息</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="weekday-24hours" id="weekday-24hours" checked disabled="true">
                            <label for="weekday-24hours">24小時</label> 
                          </div>
                          ';
                          break;
                        default:
                          $time = explode(" - ",  $rc['weekday_business_hours']);
                          echo '
                          <input type="time" class="form-control business-hours" name="start-weekday" id="start-weekday" value="' . $time[0] . '" readonly>
                          <span> - </span>
                          <input type="time" class="form-control business-hours" name="end-weekday" id="end-weekday" value="' . $time[1] . '" readonly>
                          <div class="form-check form-check-inline ms-2">
                            <input type="checkbox" class="form-check-input" name="weekday-closed" id="weekday-closed" disabled="true">
                            <label for="weekday-closed">休息</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="weekday-24hours" id="weekday-24hours">
                            <label for="weekday-24hours">24小時</label> 
                          </div>
                          ';
                          break;
                      }
                      ?>
                    </div>
                  </div>
                  <!-- Business hours - weekend -->
                  <div class="row">
                    <div class="col-md-2 offset-2">星期六至日</div>
                    <div class="col-md-8">
                      <?php
                      switch ($rc['weekend_business_hours']) {
                        case 'closed':
                          echo '
                          <input type="time" class="form-control business-hours" name="start-weekend" id="start-weekend" value="23:59" readonly>
                          <span> - </span>
                          <input type="time" class="form-control business-hours" name="end-weekend" id="end-weekend" value="23:59" readonly>
                          <div class="form-check form-check-inline ms-2">
                            <input type="checkbox" class="form-check-input" name="weekend-closed" id="weekend-closed" checked disabled="true">
                            <label for="weekend-closed">休息</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="weekend-24hours" id="weekend-24hours">
                            <label for="weekend-24hours">24小時</label> 
                          </div>
                          ';
                          break;
                        case '24 Hours':
                          echo '
                          <input type="time" class="form-control business-hours" name="start-weekend" id="start-weekend" value="00:00" readonly>
                          <span> - </span>
                          <input type="time" class="form-control business-hours" name="end-weekend" id="end-weekend" value="00:00" readonly>
                          <div class="form-check form-check-inline ms-2">
                            <input type="checkbox" class="form-check-input" name="weekend-closed" id="weekend-closed" disabled="true">
                            <label for="weekend-closed">休息</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="weekend-24hours" id="weekend-24hours" checked disabled="true">
                            <label for="weekend-24hours">24小時</label> 
                          </div>
                          ';
                          break;
                        default:
                          $time = explode(" - ",  $rc['weekend_business_hours']);
                          echo '
                          <input type="time" class="form-control business-hours" name="start-weekend" id="start-weekend" value="' . $time[0] . '" readonly>
                          <span> - </span>
                          <input type="time" class="form-control business-hours" name="end-weekend" id="end-weekend" value="' . $time[1] . '" readonly>
                          <div class="form-check form-check-inline ms-2">
                            <input type="checkbox" class="form-check-input" name="weekend-closed" id="weekend-closed" disabled="true">
                            <label for="weekend-closed">休息</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="weekend-24hours" id="weekend-24hours">
                            <label for="weekend-24hours">24小時</label> 
                          </div>
                          ';
                          break;
                      }
                      ?>
                    </div>
                  </div>
                  <!-- Business hours - holiday -->
                  <div class="row">
                    <div class="col-md-2 offset-2">公眾假期</div>
                    <div class="col-md-8">
                      <?php
                      switch ($rc['holiday_business_hours']) {
                        case 'closed':
                          echo '
                          <input type="time" class="form-control business-hours" name="start-holiday" id="start-holiday" value="23:59" readonly>
                          <span> - </span>
                          <input type="time" class="form-control business-hours" name="end-holiday" id="end-holiday" value="23:59" readonly>
                          <div class="form-check form-check-inline ms-2">
                            <input type="checkbox" class="form-check-input" name="holiday-closed" id="holiday-closed" checked disabled="true">
                            <label for="holiday-closed">休息</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="holiday-24hours" id="holiday-24hours">
                            <label for="holiday-24hours">24小時</label> 
                          </div>
                          ';
                          break;
                        case '24 Hours':
                          echo '
                          <input type="time" class="form-control business-hours" name="start-holiday" id="start-holiday" value="00:00" readonly>
                          <span> - </span>
                          <input type="time" class="form-control business-hours" name="end-holiday" id="end-holiday" value="00:00" readonly>
                          <div class="form-check form-check-inline ms-2">
                            <input type="checkbox" class="form-check-input" name="holiday-closed" id="holiday-closed" disabled="true">
                            <label for="holiday-closed">休息</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="holiday-24hours" id="holiday-24hours" checked disabled="true">
                            <label for="holiday-24hours">24小時</label> 
                          </div>
                          ';
                          break;
                        default:
                          $time = explode(" - ",  $rc['holiday_business_hours']);
                          echo '
                          <input type="time" class="form-control business-hours" name="start-holiday" id="start-holiday" value="' . $time[0] . '" readonly>
                          <span> - </span>
                          <input type="time" class="form-control business-hours" name="end-holiday" id="end-holiday" value="' . $time[1] . '" readonly>
                          <div class="form-check form-check-inline ms-2">
                            <input type="checkbox" class="form-check-input" name="holiday-closed" id="holiday-closed" disabled="true">
                            <label for="holiday-closed">休息</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="holiday-24hours" id="holiday-24hours">
                            <label for="holiday-24hours">24小時</label> 
                          </div>
                          ';
                          break;
                      }
                      ?>
                    </div>
                  </div>
                  <!-- Payment methods -->
                  <div class="row">
                    <div class="col-md-2">
                      付款方式<span class="text-danger">*</span>
                    </div>
                    <div class="col-md-10">
                      <?php
                      $sql = "SELECT * FROM `payment_method_list`;";
                      $rs = mysqli_query($conn, $sql);

                      while ($method = mysqli_fetch_assoc($rs)) {
                        if ($method['method_id'] == '0') {
                          // empty
                        } else {
                          echo '<div class="form-check form-check-inline">';
                          echo '<input class="form-check-input payment-method" type="checkbox" id="' . str_replace(' ', '', $method['en']) . '" value="' . $method['method_id'] . '" name="payment[]"' .
                            (in_array($method['method_id'], $payment) ? 'checked="checked"' : '') . 'disabled="true">';
                          echo '<label class="form-check-label" for="' . str_replace(' ', '', $method['en']) . '">' . $method['zh-hk'] . '</label>';
                          echo '</div>';
                        }
                      }
                      ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- guesthouse photos -->
          <div class="row">
            <div class="col-md-10 offset-1">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title text-secondary">民宿照片</h4>
                  <div class="row">
                    <div class="col-md-2">
                      照片 1<span class="text-danger">*</span>
                    </div>
                    <div class="col-md-10">
                      <?php
                      echo '<a href="/data/discovery/guesthouse/'.$id.'/photo1.jpg" class="btn btn-primary">查看相片</a>';
                      ?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-2">
                      照片 2
                    </div>
                    <div class="col-md-10">
                      <?php
                      $path = $_SERVER['DOCUMENT_ROOT']."/data/discovery/guesthouse/$id/photo2.jpg";
                      if (file_exists($path)) {
                        echo '<a href="/data/discovery/guesthouse/'.$id.'/photo2.jpg" class="btn btn-primary">查看相片</a>';
                      } else {
                        echo '<a href="#" class="btn btn-secondary" disabled>沒有相片</a>';
                      }
                      ?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-2">
                      照片 3
                    </div>
                    <div class="col-md-10">
                    <?php
                      $path = $_SERVER['DOCUMENT_ROOT']."/data/discovery/guesthouse/$id/photo3.jpg";
                      if (file_exists($path)) {
                        echo '<a href="/data/discovery/guesthouse/'.$id.'/photo3.jpg" class="btn btn-primary">查看相片</a>';
                      } else {
                        echo '<a href="#" class="btn btn-secondary" disabled>沒有相片</a>';
                      }
                      ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Official information on guesthouse -->
          <div class="row">
            <div class="col-md-10 offset-1">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title text-secondary">民宿的官方資料 (如需要)</h4>
                  <!-- Website -->
                  <div class="row">
                    <div class="col-md-2">
                      官方資料<span class="text-danger">*</span>
                    </div>
                    <div class="col-md-5">
                      <input type="tel" class="form-control" placeholder="聯絡電話" value="<?php $rc['phone_number']; ?>" readonly>
                    </div>
                    <div class="col-md-5">
                      <input type="email" class="form-control" placeholder="電郵" value="<?php $rc['email']; ?>" readonly>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Action -->
          <?php
          if ($rc['status'] == 1) {
            echo '
            <div class="row">
              <div class="col-md-10 offset-1">
                <div class="card">
                  <div class="card-body">
                    <div class="text-end">
                      <button type="button" class="btn btn-success" onclick="confirmGuesthouseDiscovery('.$rc['id'].', \'accept\')">接受</button>
                      <button class="btn btn-danger" onclick="confirmGuesthouseDiscovery('.$rc['id'].', \'reject\')">拒絕</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            ';
          }
          ?>
        </div>

      </div>

    </div>
    <!-- End of Content Wrapper -->

  </div>

</body>

</html>