<?php
// Start the SESSION
session_start();

include_once('/xampp/htdocs/travelHK.com/dbConnect.php');
global $conn;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>民宿合作夥伴申請 - 香港本地旅遊平台 | 本地遊</title>

  <!-- Link the default css and js library -->
  <?php include_once('/xampp/htdocs/travelHK.com/library.php'); ?>

  <link href="/css/collab_form.css" rel="stylesheet">

  <script src="/js/collaboration/guesthouse/collab_request.js"></script>
</head>

<body>

  <!-- Header -->
  <?php include_once('../common/header.php'); ?>

  <!-- Category -->
  <?php include_once('../common/category.php'); ?>

  <!-- Main Content -->
  <form id="collab-guesthouse-request-form" enctype="multipart/form-data" method="POST">
    <div class="container card">
      <div class="card-body">
        <div class="row card">
          <div class="card-body">
            <div class="col">
              <h4 class="card-title fw-bold">成為民宿合作夥伴</h4>
              <span class="text-danger fw-bold">*</span>
              <span class="fw-bold">必需填寫</span>
            </div>
          </div>
        </div>
        <div class="row card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title">民宿資料</h5>
              </div>
            </div>
            <!-- Guesthouse name -->
            <div class="row">
              <div class="col-2">
                民宿名稱
                <span class="text-danger">*</span>
              </div>
              <div class="col-5">
                <input type="text" class="form-control" id="chi-guesthouse-name" name="chi-guesthouse-name" placeholder="中文">
              </div>
              <div class="col-5">
                <input type="text" class="form-control" id="eng-guesthouse-name" name="eng-guesthouse-name" placeholder="英文">
              </div>
            </div>
            <!-- District -->
            <div class="row">
              <div class="col-2">
                地區
                <span class="text-danger">*<span>
              </div>
              <div class="col">
                <select class="form-select" id="district" name="district">
                  <option value="" selected disabled hidden>請選擇地區</option>
                  <?php
                  $region_sql = "SELECT * FROM `hong_kong_region`;";
                  $region_rs = mysqli_query($conn, $region_sql);

                  while ($region = mysqli_fetch_assoc($region_rs)) {
                    echo "<optgroup label=\"" . $region['zh-hk'] . "\">";

                    $district_sql = "SELECT * FROM `hong_kong_district` WHERE `region_id` = " . $region['region_id'] . ";";
                    $district_rs = mysqli_query($conn, $district_sql);
                    while ($district = mysqli_fetch_assoc($district_rs)) {
                      echo "<option value=\"" . $district['district_id'] . "\">" . $district['zh-hk'] . "</option>";
                    }

                    echo "</optgroup>";
                  }
                  ?>
                </select>
              </div>
            </div>
            <!-- Address -->
            <div class="row">
              <div class="col-2">
                地址
                <span class="text-danger">*<span>
              </div>
              <div class="col">
                <input type="text" class="form-control" id="chi-address" name="chi-address" placeholder="中文">
              </div>
            </div>
            <div class="row">
              <div class="col-2"></div>
              <div class="col">
                <input type="text" class="form-control" id="eng-address" name="eng-address" placeholder="英文">
              </div>
            </div>
            <!-- Guesthouse phone number -->
            <div class="row">
              <div class="col-2">
                民宿電話
                <span class="text-danger">*<span>
              </div>
              <div class="col">
                <input type="tel" class="form-control" id="guesthouse-phone-number" name="guesthouse-phone-number" minlength="8" maxlength="8" oninput="value=value.replace(/[^\d]/g,'')">
              </div>
            </div>
            <!-- Guesthouse email -->
            <div class="row">
              <div class="col-2">
                民宿電郵
                <span class="text-danger">*<span>
              </div>
              <div class="col">
              <input type="text" class="form-control" id="guesthouse-email" name="guesthouse-email">
              </div>
            </div>
            <!-- Storefront image -->
            <div class="row">
              <div class="col-2">
                民宿相片
                <span class="text-danger">*<span>
              </div>
              <div class="col">
                <input type="file" class="form-control" id="storefront" name="storefront" accept="image/*">
              </div>
            </div>
            <!-- Room image -->
            <div class="row">
              <div class="col-2">
                房間相片
                <span class="text-danger">*<span>
              </div>
              <div class="col">
                <input type="file" class="form-control" id="room" name="room" accept="image/*">
              </div>
            </div>
            <!-- Number of rooms -->
            <div class="row">
              <div class="col-2">
                房間數目
                <span class="text-danger">*<span>
              </div>
              <div class="col">
                <div class="input-group">
                  <input type="number" class="form-control" id="rooms" name="rooms">
                  <span class="input-group-text">間</span>
                </div>
              </div>
            </div>
            <!-- Office hours -->
            <div class="row">
              <div class="col-md-2">
                <label>辦公時間</label>
                <span class="text-danger">*<span>
              </div>
              <div class="col-md-2">星期一至五</div>
              <div class="col-md-8">
                <input type="time" class="form-control business-hours" name="start-weekday" id="start-weekday">
                <span> - </span>
                <input type="time" class="form-control business-hours" name="end-weekday" id="end-weekday">
                <div class="form-check form-check-inline ms-2">
                  <input type="checkbox" class="form-check-input" name="weekday-closed" id="weekday-closed">
                  <label for="weekday-closed">休息</label>
                </div>
                <div class="form-check form-check-inline">
                  <input type="checkbox" class="form-check-input" name="weekday-24hours" id="weekday-24hours">
                  <label for="weekday-24hours">24小時</label> 
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-2 offset-2">星期六至日</div>
              <div class="col-md-8">
                <input type="time" class="form-control business-hours" name="start-weekend" id="start-weekend">
                <span> - </span>
                <input type="time" class="form-control business-hours" name="end-weekend" id="end-weekend">
                <div class="form-check form-check-inline ms-2">
                  <input type="checkbox" class="form-check-input" name="weekend-closed" id="weekend-closed">
                  <label for="weekend-closed">休息</label>
                </div>
                <div class="form-check form-check-inline">
                  <input type="checkbox" class="form-check-input" name="weekend-24hours" id="weekend-24hours">
                  <label for="weekend-24hours">24小時</label> 
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-2 offset-2">公眾假期</div>
              <div class="col-md-8">
                <input type="time" class="form-control business-hours" name="start-holiday" id="start-holiday">
                <span> - </span>
                <input type="time" class="form-control business-hours" name="end-holiday" id="end-holiday">
                <div class="form-check form-check-inline ms-2">
                  <input type="checkbox" class="form-check-input" name="holiday-closed" id="holiday-closed">
                  <label for="holiday-closed">休息</label>
                </div>
                <div class="form-check form-check-inline">
                  <input type="checkbox" class="form-check-input" name="holiday-24hours" id="holiday-24hours">
                  <label for="holiday-24hours">24小時</label> 
                </div>
              </div>
            </div>
            <!-- Payment method -->
            <div class="row">
              <div class="col-2">
                付款方式
                <span class="text-danger">*<span>
              </div>
              <div class="col" id="payment-checkboxes">
                <!-- Print the payment method with check box -->
                <?php
                $sql = "SELECT * FROM `payment_method_list`;";
                $rs = mysqli_query($conn, $sql);

                while ($method = mysqli_fetch_assoc($rs)) {
                  if ($method['method_id'] == '0') {
                    // empty
                  } else {
                    echo '<div class="form-check form-check-inline">';
                    echo '<input class="form-check-input payment-method" type="checkbox" id="' . str_replace(' ', '', $method['en']) . '" value="' . $method['method_id'] . '" name="payment[]">';
                    echo '<label class="form-check-label" for="' . str_replace(' ', '', $method['en']) . '">' . $method['zh-hk'] . '</label>';
                    echo '</div>';
                  }
                }
                ?>
              </div>
            </div>
            <!-- Equipment -->
            <div class="row">
              <div class="col-2">
                公用設備
              </div>
              <div class="col" id="equipment-checkboxes">
                <!-- Print the equipment with check box -->
                <?php
                $sql = "SELECT * FROM `guesthouse_equipment_list`;";
                $rs = mysqli_query($conn, $sql);

                while ($method = mysqli_fetch_assoc($rs)) {
                  if ($method['equipment_id'] == '0') {
                    // empty
                  } else {
                    echo '<div class="form-check form-check-inline">';
                    echo '<input class="form-check-input equipment" type="checkbox" id="' . str_replace(' ', '', $method['en']) . '" value="' . $method['equipment_id'] . '" name="equipment[]">';
                    echo '<label class="form-check-label" for="' . str_replace(' ', '', $method['en']) . '">' . $method['zh-hk'] . '</label>';
                    echo '</div>';
                  }
                }
                ?>
              </div>
            </div>
          </div>
        </div>
        <!-- Information of the person in charge of the guesthouse -->
        <div class="row card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title">民宿負責人資料</h5>
              </div>
            </div>
            <div class="row">
              <div class="col-2">
                您的資料
                <span class="text-danger">*<span>
              </div>
              <div class="col-5">
                <input type="text" class="form-control" id="contact-name" name="contact-name" placeholder="您的姓名">
              </div>
              <div class="col-5">
                <input type="text" class="form-control" id="contact-email" name="contact-email" placeholder="您的電郵">
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col text-end">
            <button type="button" class="btn btn-primary" onclick="submitCollabGuesthouse()">提交</button>
          </div>
        </div>
      </div>
    </div> <!-- Container -->
  </form>

  <!-- Footer -->
  <?php include_once('../common/footer.php'); ?>

</body>

</html>