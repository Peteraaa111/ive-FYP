<?php
// Session Start
session_start();

// Get database connection variable
include_once('/xampp/htdocs/travelHK.com/dbConnect.php');
global $conn;

// Get the request id
$request_id = $_GET['id'];

// Get the request details
$details_sql = "SELECT * FROM `guesthouse_partner_request` WHERE `request_id` = $request_id;";
$details_rs = mysqli_query($conn, $details_sql);
$details = mysqli_fetch_assoc($details_rs);

// Check the request status, if status is 1, change it to 2
// Then, show the toast message
// Toast message code at the bottom of thin file
if($details['status'] == 1){
  $update_status_sql = "UPDATE `guesthouse_partner_request`
                          SET `status` = 2
                          WHERE `request_id` = '".$details['request_id']."';";
  if(mysqli_query($conn, $update_status_sql)){
    // Reget the request details
    $details_sql = "SELECT * FROM `guesthouse_partner_request` WHERE `request_id` = $request_id;";
    $details_rs = mysqli_query($conn, $details_sql);
    $details = mysqli_fetch_assoc($details_rs);
  }
  echo "
  <script>
    var toast = true;
    var id = ".$details['request_id']."
  </script>";
} else {
  echo "
  <script>
    var toast = false;
  </script>";
}

// Get the payment methods
$methods_sql = "SELECT * FROM `guesthouse_partner_request_payment_method` WHERE `request_id` = $request_id;";
$methods_rs = mysqli_query($conn, $methods_sql);
$methods = array();
while ($method = mysqli_fetch_assoc($methods_rs)) {
  $methods[] = $method['method_id'];
}

// Get the equipments
$equipments_sql = "SELECT * FROM `guesthouse_partner_request_equipment` WHERE `request_id` = $request_id;";
$equipments_rs = mysqli_query($conn, $equipments_sql);
$equipments = array();
while ($equipment = mysqli_fetch_assoc($equipments_rs)) {
  $equipments[] = $equipment['equipment_id'];
}

// Get the status
$status_sql = "SELECT * FROM `partner_request_status` WHERE `status_ID` = ".$details['status'].";";
$status_rs = mysqli_query($conn, $status_sql);
$status = mysqli_fetch_assoc($status_rs);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>民宿合作夥伴申請 編號: <?php echo $details['request_id']; ?> - 管理頁面</title>

  <?php
  require_once('/xampp/htdocs/travelHK.com/library.php');
  ?>
  <link rel="stylesheet" href="/css/admin_form.css">
  <script src="/js/admin.js"></script>
  <script>
    $(document).ready(function(){
      // Hidden the button if the status is not under review
      var status = <?php echo $details['status']; ?> ;
      if(!(status == 2)) {
        $('#confirmation').hide();
      }
      if (toast) {
        Swal.fire({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
          },
          icon: 'info',
          title: '民宿合作夥伴申請狀態已更新',
          text: '編號: '+id+' 的申請狀態已更新。由 已提交 至 審核中。',
        });
      }
    });
  </script>
</head>

<body>

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php require_once("../../common/sidebar.php"); ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <div id="content">

        <!-- Topbar -->
        <?php require_once("../../common/topbar.php"); ?>
        <!-- End of Topbar -->

        <div class="container-fluid">
          <div class="row">
            <div class="col-md-10 offset-1">
              <!-- Title -->
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-8">
                      <h3 class="text-secondary">民宿合作夥伴申請表 (ID: <?php echo $details['request_id']; ?>)</h3>
                    </div>
                    <div class="col-md-4 text-end">
                      <?php
                      switch($details['status'])
                      {
                        case 1:
                          echo '<span class="badge bg-primary fs-5">'.$status['zh-hk'].'</span>';
                          break;
                        case 2:
                          echo '<span class="badge bg-info text-dark fs-5">'.$status['zh-hk'].'</span>';
                          break;
                        case 3:
                          echo '<span class="badge bg-success fs-5">'.$status['zh-hk'].'</span>';
                          break;
                        case 4:
                          echo '<span class="badge bg-success fs-5">'.$status['zh-hk'].'</span>';
                          break;
                        case 5:
                          echo '<span class="badge bg-danger fs-5">'.$status['zh-hk'].'</span>';
                          break;
                      }
                      ?>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Guesthouse Information -->
              <div class="card">
                <div class="card-body">
                  <h3 class="text-secondary">民宿資料</h3>
                  <!-- Guesthouse name -->
                  <div class="row">
                    <div class="col-md-2">
                      <label>民宿名稱</label>
                      <span class="text-danger">*</span>
                    </div>
                    <div class="col-md-5">
                      <input class="form-control" type="text" name="chi-name" id="chi-name" placeholder="中文" value=<?php echo '"' . $details['guesthouse_chinese_name'] . '"'; ?> readonly>
                    </div>
                    <div class="col-md-5">
                      <input class="form-control" type="text" name="eng-name" id="eng-name" placeholder="英文" value=<?php echo '"' . $details['guesthouse_english_name'] . '"'; ?> readonly>
                    </div>
                  </div>
                  <!-- District -->
                  <div class="row">
                    <div class="col-md-2">
                      <label>地區</label>
                      <span class="text-danger">*</span>
                    </div>
                    <div class="col-md-10">
                      <select class="form-select" id="district" name="district" disabled="true">
                        <option value="" selected disabled hidden>請選擇地區</option>
                        <?php
                        $region_sql = "SELECT * FROM `hong_kong_region`;";
                        $region_rs = mysqli_query($conn, $region_sql);

                        while ($region = mysqli_fetch_assoc($region_rs)) {
                          echo "<optgroup label=\"" . $region['zh-hk'] . "\">";

                          $district_sql = "SELECT * FROM `hong_kong_district` WHERE `region_id` = " . $region['region_id'] . ";";
                          $district_rs = mysqli_query($conn, $district_sql);
                          while ($district = mysqli_fetch_assoc($district_rs)) {
                            if ($details['district'] == $district['district_id']) {
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
                  <!-- Physical Address -->
                  <div class="row">
                    <div class="col-md-2">
                      <label>地址</label>
                      <span class="text-danger">*</span>
                    </div>
                    <div class="col-md-10">
                      <input class="form-control" type="text" name="chi-address" id="chi-address" placeholder="中文" value=<?php echo '"' . $details['chinese_address'] . '"'; ?> readonly>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-10 offset-2">
                      <input class="form-control" type="text" name="eng-address" id="eng-address" placeholder="英文" value=<?php echo '"' . $details['english_address'] . '"'; ?> readonly>
                    </div>
                  </div>
                  <!-- Guesthouse phone number -->
                  <div class="row">
                    <div class="col-md-2">
                      <label>民宿電話</label>
                      <span class="text-danger">*<span>
                    </div>
                    <div class="col-md-10">
                      <input class="form-control" type="tel" name="phone-number" id="phone-number" placeholder="聯絡電話" minlength="8" maxlength="8" oninput="value=value.replace(/[^\d]/g,'')" value="<?php echo $details['guesthouse_phone_number']; ?>" readonly>
                    </div>
                  </div>
                  <!-- Guesthouse email -->
                  <div class="row">
                    <div class="col-md-2">
                      <label>民宿電郵</label>
                      <span class="text-danger">*<span>
                    </div>
                    <div class="col-md-10">
                      <input class="form-control" type="email" name="email" id="email" placeholder="電郵" value="<?php echo $details['guesthouse_email']; ?>" readonly>
                    </div>
                  </div>
                  <!-- Storefront image -->
                  <div class="row">
                    <div class="col-md-2">
                      <label>門面相片</label>
                      <span class="text-danger">*<span>
                    </div>
                    <div class="col-md-10">
                      <a class="btn btn-primary" href="<?php echo "/data/collab_request/guesthouse/" . $details['request_id'] . "/storefront.jpg"; ?>" target="_blank">查看相片</a>
                    </div>
                  </div>
                  <!-- Room image -->
                  <div class="row">
                    <div class="col-md-2">
                      <label>房間相片</label>
                      <span class="text-danger">*<span>
                    </div>
                    <div class="col-md-10">
                      <a class="btn btn-primary" href="<?php echo "/data/collab_request/guesthouse/" . $details['request_id'] . "/room.jpg"; ?>" target="_blank">查看相片</a>
                    </div>
                  </div>
                  <!-- Number of Seats -->
                  <div class="row">
                    <div class="col-md-2">
                    房間數目
                      <span class="text-danger">*<span>
                    </div>
                    <div class="col-md-10">
                      <div class="input-group">
                        <input type="number" class="form-control" id="rooms" name="rooms" value="<?php echo $details['number_of_rooms']; ?>" readonly>
                        <span class="input-group-text">間</span>
                      </div>
                    </div>
                  </div>
                  <!-- Opening Hours -->
                  <div class="row">
                    <div class="col-md-2">
                      <label>辦公時間</label>
                      <span class="text-danger">*<span>
                    </div>
                    <div class="col-md-2">星期一至五</div>
                    <div class="col-md-8">
                      <?php
                      switch ($details['weekday_business_hours']) {
                        case 'closed':
                          echo '
                          <input type="time" class="form-control business-hours" name="start-weekday" id="start-weekday" value="23:59" readonly>
                          <span> - </span>
                          <input type="time" class="form-control business-hours" name="end-weekday" id="end-weekday" value="23:59" readonly>
                          <div class="form-check form-check-inline ms-2">
                            <input type="checkbox" class="form-check-input" name="weekday-closed" id="weekday-closed" disabled="true" checked>
                            <label for="weekday-closed">休息</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="weekday-24hours" id="weekday-24hours" disabled="true">
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
                            <input type="checkbox" class="form-check-input" name="weekday-24hours" id="weekday-24hours" disabled="true" checked>
                            <label for="weekday-24hours">24小時</label> 
                          </div>
                          ';
                          break;
                        default:
                          $time = explode(" - ",  $details['weekday_business_hours']);
                          echo '
                          <input type="time" class="form-control business-hours" name="start-weekday" id="start-weekday" value="' . $time[0] . '" readonly>
                          <span> - </span>
                          <input type="time" class="form-control business-hours" name="end-weekday" id="end-weekday" value="' . $time[1] . '" readonly>
                          <div class="form-check form-check-inline ms-2">
                            <input type="checkbox" class="form-check-input" name="weekday-closed" id="weekday-closed" disabled="true">
                            <label for="weekday-closed">休息</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="weekday-24hours" id="weekday-24hours" disabled="true">
                            <label for="weekday-24hours">24小時</label> 
                          </div>
                          ';
                          break;
                      }
                      ?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-2 offset-2">星期六至日</div>
                    <div class="col-md-8">
                      <?php
                      switch ($details['weekend_business_hours']) {
                        case 'closed':
                          echo '
                          <input type="time" class="form-control business-hours" name="start-weekend" id="start-weekend" value="23:59" readonly>
                          <span> - </span>
                          <input type="time" class="form-control business-hours" name="end-weekend" id="end-weekend" value="23:59" readonly>
                          <div class="form-check form-check-inline ms-2">
                            <input type="checkbox" class="form-check-input" name="weekend-closed" id="weekend-closed" disabled="true" checked>
                            <label for="weekend-closed">休息</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="weekend-24hours" id="weekend-24hours" disabled="true">
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
                            <input type="checkbox" class="form-check-input" name="weekend-24hours" id="weekend-24hours" disabled="true" checked>
                            <label for="weekend-24hours">24小時</label> 
                          </div>
                          ';
                          break;
                        default:
                          $time = explode(" - ",  $details['weekend_business_hours']);
                          echo '
                          <input type="time" class="form-control business-hours" name="start-weekend" id="start-weekend" value="' . $time[0] . '" readonly>
                          <span> - </span>
                          <input type="time" class="form-control business-hours" name="end-weekend" id="end-weekend" value="' . $time[1] . '" readonly>
                          <div class="form-check form-check-inline ms-2">
                            <input type="checkbox" class="form-check-input" name="weekend-closed" id="weekend-closed" disabled="true">
                            <label for="weekend-closed">休息</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="weekend-24hours" id="weekend-24hours" disabled="true">
                            <label for="weekend-24hours">24小時</label> 
                          </div>
                          ';
                          break;
                      }
                      ?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-2 offset-2">公眾假期</div>
                    <div class="col-md-8">
                      <?php
                      switch ($details['holiday_business_hours']) {
                        case 'closed':
                          echo '
                          <input type="time" class="form-control business-hours" name="start-holiday" id="start-holiday" value="23:59" readonly>
                          <span> - </span>
                          <input type="time" class="form-control business-hours" name="end-holiday" id="end-holiday" value="23:59" readonly>
                          <div class="form-check form-check-inline ms-2">
                            <input type="checkbox" class="form-check-input" name="holiday-closed" id="holiday-closed" disabled="true" checked>
                            <label for="holiday-closed">休息</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="holiday-24hours" id="holiday-24hours" disabled="true">
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
                            <input type="checkbox" class="form-check-input" name="holiday-24hours" id="holiday-24hours" disabled="true" checked>
                            <label for="holiday-24hours">24小時</label> 
                          </div>
                          ';
                          break;
                        default:
                          $time = explode(" - ",  $details['holiday_business_hours']);
                          echo '
                          <input type="time" class="form-control business-hours" name="start-holiday" id="start-holiday" value="' . $time[0] . '" readonly>
                          <span> - </span>
                          <input type="time" class="form-control business-hours" name="end-holiday" id="end-holiday" value="' . $time[1] . '" readonly>
                          <div class="form-check form-check-inline ms-2">
                            <input type="checkbox" class="form-check-input" name="holiday-closed" id="holiday-closed" disabled="true">
                            <label for="holiday-closed">休息</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="holiday-24hours" id="holiday-24hours" disabled="true">
                            <label for="holiday-24hours">24小時</label> 
                          </div>
                          ';
                          break;
                      }
                      ?>
                    </div>
                  </div>
                  <!-- Payment Method -->
                  <div class="row">
                    <div class="col-md-2">
                      付款方式
                      <span class="text-danger">*<span>
                    </div>
                    <div class="col-md-10" id="payment-checkboxes">
                      <!-- Print the payment method with check box -->
                      <?php
                      $sql = "SELECT * FROM `payment_method_list`;";
                      $rs = mysqli_query($conn, $sql);

                      while ($method = mysqli_fetch_assoc($rs)) {
                        if ($method['method_id'] == '0') {
                          // empty
                        } else {
                          echo '<div class="form-check form-check-inline">';
                          echo '<input class="form-check-input payment-method" type="checkbox" id="' . str_replace(' ', '', $method['en']) . '" value="' . $method['method_id'] . '" name="payment[]"' .
                            (in_array($method['method_id'], $methods) ? 'checked="checked"' : '')
                            . 'disabled="true">';
                          echo '<label class="form-check-label" for="' . str_replace(' ', '', $method['en']) . '">' . $method['zh-hk'] . '</label>';
                          echo '</div>';
                        }
                      }
                      ?>
                    </div>
                  </div>
                  <!-- Equipments -->
                  <div class="row">
                    <div class="col-md-2">
                      <label>公用設備</label>
                    </div>
                    <div class="col-md-10" id="equipment-checkboxes">
                      <?php
                      $sql = "SELECT * FROM `guesthouse_equipment_list`;";
                      $rs = mysqli_query($conn, $sql);

                      while ($equipment = mysqli_fetch_assoc($rs)) {
                        if ($equipment['equipment_id'] == '0') {
                          // empty    
                        } else {
                          echo '<div class="form-check form-check-inline">';
                          echo '<input class="form-check-input" type="checkbox" id="' . str_replace(' ', '', $equipment['en']) . '" value="' . $equipment['equipment_id'] . '" name="equipment[]"' . (in_array($equipment['equipment_id'], $equipments) ? 'checked="checked"' : '') . ' disabled="true">';
                          echo '<label class="form-check-label" for="' . str_replace(' ', '', $equipment['en']) . '">' . $equipment['zh-hk'] . '</label>';
                          echo '</div>';
                        }
                      }
                      ?>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Information of the person in charge of the guesthouse -->
              <div class="card">
                <div class="card-body">
                  <h3 class="text-secondary">民宿負責人資料</h3>
                  <div class="row">
                    <div class="col-md-2">
                      您的資料
                    </div>
                    <div class="col-md-5">
                      <input class="form-control" type="text" name="name" id="name" placeholder="民宿負責人姓名" value="<?php echo $details['contact_name']; ?>" readonly>
                    </div>
                    <div class="col-md-5">
                      <input class="form-control" type="email" name="email" id="email" placeholder="電郵" value="<?php echo $details['contact_email']; ?>" readonly>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Action Buttons -->
              <div id="confirmation" class="card">
                <div class="card-body text-end">
                  <button type="button" id="accept-btn" class="btn btn-success" onclick="confirmCollabApplication('<?php echo $details['request_id']; ?>', 'accept', 'guesthouse', '<?php echo $details['contact_email']; ?>');">接受</button>
                  <button type="button" id="reject-btn" class="btn btn-danger" onclick="confirmCollabApplication('<?php echo $details['request_id']; ?>', 'reject', 'guesthouse', '<?php echo $details['contact_email']; ?>');">拒絕</button>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>
    <!-- End of Content Wrapper -->

  </div>

</body>

</html>