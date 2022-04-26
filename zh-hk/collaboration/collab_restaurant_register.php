<?php
// Start the SESSION
session_start();

// Get database connection variable
include_once('/xampp/htdocs/travelHK.com/dbConnect.php');
global $conn;

// Get the request id
$request_id = $_GET['id'];

// Get the request details
$details_sql = "SELECT * FROM `restaurant_partner_request` WHERE `request_id` = $request_id;";
$details_rs = mysqli_query($conn, $details_sql);
$details = mysqli_fetch_assoc($details_rs);

// Check the request status, if status is 1, change it to 2
// Then, show the toast message
// Toast message code at the bottom of thin file
if($details['status'] == 1){
    $update_status_sql = "UPDATE `restaurant_partner_request`
                            SET `status` = 2
                            WHERE `request_id` = '".$details['request_id']."';";
    if(mysqli_query($conn, $update_status_sql)){
      // Reget the request details
      $details_sql = "SELECT * FROM `restaurant_partner_request` WHERE `request_id` = $request_id;";
      $details_rs = mysqli_query($conn, $details_sql);
      $details = mysqli_fetch_assoc($details_rs);
    } else{
    }
}

// Get the cuisines
$cuisines_sql = "SELECT * FROM `restaurant_partner_request_cuisine` WHERE `request_id` = $request_id;";
$cuisines_rs = mysqli_query($conn, $cuisines_sql);
$cuisines = array();
while ($cuisine = mysqli_fetch_assoc($cuisines_rs)) {
  $cuisines[] = $cuisine['cuisine_id'];
}

// Get the types
$types_sql = "SELECT * FROM `restaurant_partner_request_type` WHERE `request_id` = $request_id;";
$types_rs = mysqli_query($conn, $types_sql);
$types = array();
while ($type = mysqli_fetch_assoc($types_rs)) {
  $types[] = $type['type_id'];
}

// Get the payment methods
$methods_sql = "SELECT * FROM `restaurant_partner_request_payment_method` WHERE `request_id` = $request_id;";
$methods_rs = mysqli_query($conn, $methods_sql);
$methods = array();
while ($method = mysqli_fetch_assoc($methods_rs)) {
  $methods[] = $method['method_id'];
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
  <title>餐廳合作夥伴帳戶註冊 - 香港本地旅遊平台 | 本地遊</title>

  <!-- Link the default css and js library -->
  <?php include_once('/xampp/htdocs/travelHK.com/library.php'); ?>
  <script src="/js/collaboration/restaurant/collab_register.js"></script>
  <link rel="stylesheet" href="/css/collab_register.css">
</head>

<body>

  <!-- Header -->
  <?php include_once('../common/header.php'); ?>

  <!-- Main Content -->
  <div class="container">
    <!-- Progress Bar -->
    <div class="row">
      <div class="col-md-10 offset-1">
        <div class="progress">
          <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
        </div>
      </div>
    </div>
    <!-- Form -->
    <div class="row">
      <div class="col-md-12">

        <!-- Step 1 - Collab request details -->
        <section id="step-1">
          <div class="row">
            <div class="col-md-10 offset-1">
              <!-- Title -->
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-8">
                      <h3 class="text-secondary">餐廳合作夥伴申請表 (ID: <?php echo $details['request_id']; ?>)</h3>
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
                          echo '<span class="badge bg-danger fs-5">'.$status['zh-hk'].'</span>';
                          break;
                      }
                      ?>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Restaurant Information -->
              <div class="card">
                <div class="card-body">
                  <h3 class="text-secondary">餐廳資料</h3>
                  <!-- Attraction name -->
                  <div class="row">
                    <div class="col-md-2">
                      <label>餐廳名稱</label>
                      <span class="text-danger">*</span>
                    </div>
                    <div class="col-md-5">
                      <input class="form-control" type="text" placeholder="中文" value=<?php echo '"' . $details['restaurant_chinese_name'] . '"'; ?> readonly>
                    </div>
                    <div class="col-md-5">
                      <input class="form-control" type="text" placeholder="英文" value=<?php echo '"' . $details['restaurant_english_name'] . '"'; ?> readonly>
                    </div>
                  </div>
                  <!-- District -->
                  <div class="row">
                    <div class="col-md-2">
                      <label>地區</label>
                      <span class="text-danger">*</span>
                    </div>
                    <div class="col-md-10">
                      <select class="form-select" disabled="true">
                        <option value="" selected disabled hidden>請選擇地區</option>
                        <?php
                        $region_sql = "SELECT * FROM `hong_kong_region`;";
                        $region_rs = mysqli_query($conn, $region_sql);

                        while ($region = mysqli_fetch_assoc($region_rs)) {
                          echo "<optgroup label=\"" . $region['zh-hk'] . "\">";

                          $district_sql = "SELECT * FROM `hong_kong_district` WHERE region_id = " . $region['region_id'] . ";";
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
                      <input class="form-control" type="text" placeholder="中文" value=<?php echo '"' . $details['chinese_address'] . '"'; ?> readonly>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-10 offset-2">
                      <input class="form-control" type="text" placeholder="英文" value=<?php echo '"' . $details['english_address'] . '"'; ?> readonly>
                    </div>
                  </div>
                  <!-- Restaurant Contact Information -->
                  <div class="row">
                    <div class="col-md-2">
                      <label>餐廳聯絡資料</label>
                      <span class="text-danger">*<span>
                    </div>
                    <div class="col-md-5">
                      <input class="form-control" type="tel" placeholder="聯絡電話" minlength="8" maxlength="8" oninput="value=value.replace(/[^\d]/g,'')" value=<?php echo '"' . $details['restaurant_phone_number'] . '"'; ?> readonly>
                    </div>
                  </div>
                  <!-- Cuisine -->
                  <div class="row">
                    <div class="col-md-2">
                      <label>菜式</label>
                      <span class="text-danger">*<span>
                    </div>
                    <div class="col-md-10">
                      <?php
                      $cuisine_sql = "SELECT * FROM `Cuisine_List`;";
                      $cuisine_rs = mysqli_query($conn, $cuisine_sql);

                      while ($cuisine = mysqli_fetch_assoc($cuisine_rs)) {
                        // echo "<option value=\"".$type['Cuisine_ID']."\">".$type['zh-hk']."</option>";
                        if ($cuisine['cuisine_id'] == '0') {
                          // empty
                        } else {
                          echo '<div class="form-check form-check-inline">';
                          echo '<input class="form-check-input" type="checkbox" value="' . $cuisine['cuisine_id'] . '"' . (in_array($cuisine['cuisine_id'], $cuisines) ? 'checked="checked"' : '') . 'disabled="true">';
                          echo '<label class="form-check-label">' . $cuisine['zh-hk'] . '</label>';
                          echo '</div>';
                        }
                      }
                      ?>
                    </div>
                  </div>
                  <!-- Restaurant Types -->
                  <div class="row">
                    <div class="col-md-2">
                      <label>食品 / 餐廳類型</label>
                      <span class="text-danger">*</span>
                    </div>
                    <div class="col-md-10" id="type-checkboxes">
                      <?php
                      $sql = "SELECT * FROM `Restaurant_Type_List`;";
                      $rs = mysqli_query($conn, $sql);

                      while ($type = mysqli_fetch_assoc($rs)) {
                        if ($type['type_id'] == '0') {
                          // empty
                        } else {
                          echo '<div class="form-check form-check-inline">';
                          echo '<input class="form-check-input" type="checkbox" value="' . $type['type_id'] . '"' . (in_array($type['type_id'], $types) ? 'checked="checked"' : '') . 'disabled="true">';
                          echo '<label class="form-check-label">' . $type['zh-hk'] . '</label>';
                          echo '</div>';
                        }
                      }
                      ?>
                    </div>
                  </div>
                  <!-- Storefront -->
                  <div class="row">
                    <div class="col-md-2">
                      <label>門面相片</label>
                      <span class="text-danger">*<span>
                    </div>
                    <div class="col-md-10">
                      <a class="btn btn-primary" href=<?php echo "\"/travelhk.com/data/collab_request/restaurant/" . $details['request_id'] . "/storefront.jpg\""; ?> target="_blank">查看相片</a>
                    </div>
                  </div>
                  <!-- Number of Seats -->
                  <div class="row">
                    <div class="col-md-2">
                      座位數目
                      <span class="text-danger">*<span>
                    </div>
                    <div class="col-md-10">
                      <div class="input-group">
                        <input type="number" class="form-control" value=<?php echo '"' . $details['number_of_seats'] . '"'; ?> readonly>
                        <span class="input-group-text">位</span>
                      </div>
                    </div>
                  </div>
                  <!-- Opening Hours -->
                  <div class="row">
                    <div class="col-md-2">
                      <label>開放時間</label>
                      <span class="text-danger">*<span>
                    </div>
                    <div class="col-md-2">星期一至五</div>
                    <div class="col-md-8">
                        <?php
                            if ($details['weekday_business_hours'] == "closed") {
                              echo '
                              <input type="time" class="form-control business-hours" name="start-weekday" id="start-weekday" value="23:59" readonly>
                              <span> - </span>
                              <input type="time" class="form-control business-hours" name="end-weekday" id="end-weekday" value="23:59" readonly>
                              <div class="form-check form-check-inline ms-2">
                                <input type="checkbox" class="form-check-input" name="weekday-closed" id="weekday-closed" checked disabled>
                                <label for="weekday-closed">休息</label>
                              </div>
                              ';
                            } else {
                              $weekday = explode(" - ",  $details['weekday_business_hours']);
                              echo '
                              <input type="time" class="form-control business-hours" name="start-weekday" id="start-weekday" value="'.$weekday[0].'" readonly>
                              <span> - </span>
                              <input type="time" class="form-control business-hours" name="end-weekday" id="end-weekday" value="'.$weekday[1].'" readonly>
                              <div class="form-check form-check-inline ms-2">
                                <input type="checkbox" class="form-check-input" name="weekday-closed" id="weekday-closed" disabled>
                                <label for="weekday-closed">休息</label>
                              </div>
                              ';
                            }
                        ?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-2 offset-2">星期六至日</div>
                    <div class="col-md-8">
                    <?php
                            if ($details['weekend_business_hours'] == "closed") {
                              echo '
                              <input type="time" class="form-control business-hours" name="start-weekend" id="start-weekend" value="23:59" readonly>
                              <span> - </span>
                              <input type="time" class="form-control business-hours" name="end-weekend" id="end-weekend" value="23:59" readonly>
                              <div class="form-check form-check-inline ms-2">
                                <input type="checkbox" class="form-check-input" name="weekend-closed" id="weekend-closed" checked disabled>
                                <label for="weekend-closed">休息</label>
                              </div>
                              ';
                            } else {
                              $weekend = explode(" - ",  $details['weekend_business_hours']);
                              echo '
                              <input type="time" class="form-control business-hours" name="start-weekend" id="start-weekend" value="'.$weekend[0].'" readonly>
                              <span> - </span>
                              <input type="time" class="form-control business-hours" name="end-weekend" id="end-weekend" value="'.$weekend[1].'" readonly>
                              <div class="form-check form-check-inline ms-2">
                                <input type="checkbox" class="form-check-input" name="weekend-closed" id="weekend-closed" disabled>
                                <label for="weekend-closed">休息</label>
                              </div>
                              ';
                            }
                    ?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-2 offset-2">公眾假期</div>
                    <div class="col-md-8">
                    <?php
                            if ($details['holiday_business_hours'] == "closed") {
                              echo '
                              <input type="time" class="form-control business-hours" name="start-holiday" id="start-holiday" value="23:59" readonly>
                              <span> - </span>
                              <input type="time" class="form-control business-hours" name="end-holiday" id="end-holiday" value="23:59" readonly>
                              <div class="form-check form-check-inline ms-2">
                                <input type="checkbox" class="form-check-input" name="holiday-closed" id="holiday-closed" checked disabled>
                                <label for="holiday-closed">休息</label>
                              </div>
                              ';
                            } else {
                              $holiday = explode(" - ",  $details['holiday']);
                              echo '
                              <input type="time" class="form-control business-hours" name="start-holiday" id="start-holiday" value="'.$holiday[0].'" readonly>
                              <span> - </span>
                              <input type="time" class="form-control business-hours" name="end-holiday" id="end-holiday" value="'.$holiday[1].'" readonly>
                              <div class="form-check form-check-inline ms-2">
                                <input type="checkbox" class="form-check-input" name="holiday-closed" id="holiday-closed" disabled>
                                <label for="holiday-closed">休息</label>
                              </div>
                              ';
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
                      $sql = "SELECT * FROM `Payment_Method_List`;";
                      $rs = mysqli_query($conn, $sql);

                      while ($method = mysqli_fetch_assoc($rs)) {
                        if ($method['method_id'] == '0') {
                          // empty
                        } else {
                          echo '<div class="form-check form-check-inline">';
                          echo '<input class="form-check-input" type="checkbox" value="' . $method['method_id'] . '"' . (in_array($method['method_id'], $methods) ? 'checked="checked"' : '') . 'disabled="true">';
                          echo '<label class="form-check-label">' . $method['zh-hk'] . '</label>';
                          echo '</div>';
                        }
                      }
                      ?>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Information of the person in charge of the restaurant -->
              <div class="card">
                <div class="card-body">
                  <h3 class="text-secondary">餐廳負責人資料</h3>
                  <div class="row">
                    <div class="col-md-2">
                      您的資料
                    </div>
                    <div class="col-md-5">
                      <input class="form-control" type="text" placeholder="餐廳負責人姓名" value=<?php echo '"' . $details['contact_name'] . '"'; ?> readonly>
                    </div>
                    <div class="col-md-5">
                      <input class="form-control" type="email" placeholder="電郵" value=<?php echo '"' . $details['contact_email'] . '"'; ?> readonly>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Action Buttons -->
              <div class="card next">
                <div class="card-body text-end">
                  <button id="next-to-register" class="btn btn-primary next-btn">下一步</button>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Step 2 - Register form -->
        <section id="step-2">
          <div class="row">
            <div class="col-md-10 offset-1">
              <!-- Title -->
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-8">
                      <h3 class="text-secondary">帳號註冊</h3>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Account Information -->
              <form id="collab-register">

                <!-- Account Information -->
                <div class="card">
                  <div class="card-body">
                    <!-- Email Address -->
                    <div class="row">
                      <div class="col-md-2">
                        <label>電郵地址</label>
                        <span class="text-danger">*</span>
                      </div>
                      <div class="col-md-10">
                        <input type="email" class="form-control" name="collab-email" id="collab-email">
                      </div>
                    </div>
                    <!-- Password -->
                    <div class="row">
                      <div class="col-md-2">
                        <label>密碼</label>
                        <span class="text-danger">*</span>
                      </div>
                      <div class="col-md-10">
                        <input type="password" class="form-control" name="collab-psw" id="collab-psw">
                      </div>
                    </div>
                    <!-- Confirm Password -->
                    <div class="row">
                      <div class="col-md-2">
                        <label>確認密碼</label>
                        <span class="text-danger">*</span>
                      </div>
                      <div class="col-md-10">
                        <input type="password" class="form-control" name="collab-confPsw" id="collab-confPsw">
                      </div>
                    </div>
                  </div>
                </div>
                <!-- User Information -->
                <div class="card">
                  <div class="card-body">
                    <!-- First Name -->
                    <div class="row">
                      <div class="col-md-2">
                        <label>名字</label>
                        <span class="text-danger">*</span>
                      </div>
                      <div class="col-md-10">
                        <input type="text" class="form-control" name="collab-firstname" id="collab-firstname">
                      </div>
                    </div>
                    <!-- Last Name -->
                    <div class="row">
                      <div class="col-md-2">
                        <label>姓氏</label>
                        <span class="text-danger">*</span>
                      </div>
                      <div class="col-md-10">
                        <input type="text" class="form-control" name="collab-lastname" id="collab-lastname">
                      </div>
                    </div>
                    <!-- Phone Number -->
                    <div class="row">
                      <div class="col-md-2">
                        <label>電話號碼</label>
                        <span class="text-danger">*</span>
                      </div>
                      <div class="col-md-10">
                        <input type="text" class="form-control" name="collab-phoneNo" id="collab-phoneNo" maxlength="8" oninput="value=value.replace(/[^\d]/g,'')">
                      </div>
                    </div>
                    <!-- Gender -->
                    <div class="row">
                      <div class="col-md-2">
                        <label>性別</label>
                        <span class="text-danger">*</span>
                      </div>
                      <div class="col-md-10">
                        <select id="collab-gender" name="collab-gender" class="form-select input">
                          <option value="" selected="selected" hidden="hidden">性別</option>
                          <option value="m">男</option>
                          <option value="f">女</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </form>

              <!-- Button -->
              <div class="card next">
                <div class="card-body text-end">
                  <button id="next-to-restaurant" class="btn btn-primary next-btn">下一步</button>
                </div>
              </div>
              
            </div>
          </div>
        </section>

        <!-- Step 3 - Restaurant Information -->
        <section id="step-3">

          <div class="row">
            <div class="col-md-10 offset-1">
              <!-- Title -->
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-8">
                      <h3 class="text-secondary">即將創建的餐廳資訊</h3>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Restaurant Information (Display only) -->
              <div class="card">
                <div class="card-body">
                  <h3 class="text-secondary">餐廳資料</h3>
                  <!-- Attraction name -->
                  <div class="row">
                    <div class="col-md-2">
                      <label>餐廳名稱</label>
                      <span class="text-danger">*</span>
                    </div>
                    <div class="col-md-5">
                      <input class="form-control" type="text" placeholder="中文" value=<?php echo '"' . $details['restaurant_chinese_name'] . '"'; ?> readonly>
                    </div>
                    <div class="col-md-5">
                      <input class="form-control" type="text" placeholder="英文" value=<?php echo '"' . $details['restaurant_english_name'] . '"'; ?> readonly>
                    </div>
                  </div>
                  <!-- District -->
                  <div class="row">
                    <div class="col-md-2">
                      <label>地區</label>
                      <span class="text-danger">*</span>
                    </div>
                    <div class="col-md-10">
                      <select class="form-select" disabled>
                        <option value="" selected hidden>請選擇地區</option>
                        <?php
                        $region_sql = "SELECT * FROM `hong_kong_region`;";
                        $region_rs = mysqli_query($conn, $region_sql);

                        while ($region = mysqli_fetch_assoc($region_rs)) {
                          echo "<optgroup label=\"" . $region['zh-hk'] . "\">";

                          $district_sql = "SELECT * FROM `hong_kong_district` WHERE region_id = " . $region['region_id'] . ";";
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
                      <input class="form-control" type="text" placeholder="中文" value=<?php echo '"' . $details['chinese_address'] . '"'; ?> readonly>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-10 offset-2">
                      <input class="form-control" type="text" placeholder="英文" value=<?php echo '"' . $details['english_address'] . '"'; ?> readonly>
                    </div>
                  </div>
                  <!-- Restaurant Contact Information -->
                  <div class="row">
                    <div class="col-md-2">
                      <label>餐廳聯絡資料</label>
                      <span class="text-danger">*<span>
                    </div>
                    <div class="col-md-5">
                      <input class="form-control" type="tel" placeholder="聯絡電話" minlength="8" maxlength="8" oninput="value=value.replace(/[^\d]/g,'')" value=<?php echo '"' . $details['restaurant_phone_number'] . '"'; ?> readonly>
                    </div>
                  </div>
                  <!-- Cuisine -->
                  <div class="row">
                    <div class="col-md-2">
                      <label>菜式</label>
                      <span class="text-danger">*<span>
                    </div>
                    <div class="col-md-10">
                      <?php
                      $cuisine_sql = "SELECT * FROM `cuisine_list`;";
                      $cuisine_rs = mysqli_query($conn, $cuisine_sql);

                      while ($cuisine = mysqli_fetch_assoc($cuisine_rs)) {
                        // echo "<option value=\"".$type['Cuisine_ID']."\">".$type['zh-hk']."</option>";
                        if ($cuisine['cuisine_id'] == '0') {
                          // empty
                        } else {
                          echo '<div class="form-check form-check-inline">';
                          echo '<input class="form-check-input" type="checkbox" value="' . $cuisine['cuisine_id'] . '" name="cuisine[]"' . (in_array($cuisine['cuisine_id'], $cuisines) ? 'checked="checked"' : '') . 'disabled="true">';
                          echo '<label class="form-check-label">' . $cuisine['zh-hk'] . '</label>';
                          echo '</div>';
                        }
                      }
                      ?>
                    </div>
                  </div>
                  <!-- Restaurant Types -->
                  <div class="row">
                    <div class="col-md-2">
                      <label>食品 / 餐廳類型</label>
                      <span class="text-danger">*</span>
                    </div>
                    <div class="col-md-10" id="type-checkboxes">
                      <?php
                      $sql = "SELECT * FROM `restaurant_type_list`;";
                      $rs = mysqli_query($conn, $sql);

                      while ($type = mysqli_fetch_assoc($rs)) {
                        if ($type['type_id'] == '0') {
                          // empty
                        } else {
                          echo '<div class="form-check form-check-inline">';
                          echo '<input class="form-check-input" type="checkbox" value="' . $type['type_id'] . '" name="type[]"' . (in_array($type['type_id'], $types) ? 'checked="checked"' : '')
                            . 'disabled="true">';
                          echo '<label class="form-check-label">' . $type['zh-hk'] . '</label>';
                          echo '</div>';
                        }
                      }
                      ?>
                    </div>
                  </div>
                  <!-- Storefront -->
                  <div class="row">
                    <div class="col-md-2">
                      <label>門面相片</label>
                      <span class="text-danger">*<span>
                    </div>
                    <div class="col-md-10">
                      <a class="btn btn-primary" href=<?php echo "\"/travelhk.com/data/collab_request/restaurant/" . $details['request_id'] . "/storefront.jpg\""; ?> target="_blank">查看相片</a>
                    </div>
                  </div>
                  <!-- Number of Seats -->
                  <div class="row">
                    <div class="col-md-2">
                      座位數目
                      <span class="text-danger">*<span>
                    </div>
                    <div class="col-md-10">
                      <div class="input-group">
                        <input type="number" class="form-control" value=<?php echo '"' . $details['number_of_seats'] . '"'; ?> readonly>
                        <span class="input-group-text">位</span>
                      </div>
                    </div>
                  </div>
                  <!-- Opening Hours -->
                  <div class="row">
                    <div class="col-md-2">
                      <label>開放時間</label>
                      <span class="text-danger">*<span>
                    </div>
                    <div class="col-md-2">星期一至五</div>
                    <div class="col-md-8">
                      <?php
                      if ($details['weekday_business_hours'] == "closed") {
                        echo '
                        <input type="time" class="form-control business-hours" name="start-weekday" id="start-weekday" value="23:59" readonly>
                        <span> - </span>
                        <input type="time" class="form-control business-hours" name="end-weekday" id="end-weekday" value="23:59" readonly>
                        <div class="form-check form-check-inline ms-2">
                          <input type="checkbox" class="form-check-input" name="weekday-closed" id="weekday-closed" checked disabled>
                          <label for="weekday-closed">休息</label>
                        </div>
                        ';
                      } else {
                        $weekday = explode(" - ",  $details['weekday_business_hours']);
                        echo '
                        <input type="time" class="form-control business-hours" name="start-weekday" id="start-weekday" value="'.$weekday[0].'" readonly>
                        <span> - </span>
                        <input type="time" class="form-control business-hours" name="end-weekday" id="end-weekday" value="'.$weekday[1].'" readonly>
                        <div class="form-check form-check-inline ms-2">
                          <input type="checkbox" class="form-check-input" name="weekday-closed" id="weekday-closed" disabled>
                          <label for="weekday-closed">休息</label>
                        </div>
                        ';
                      }
                      ?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-2 offset-2">星期六至日</div>
                    <div class="col-md-8">
                      <?php
                      if ($details['weekend_business_hours'] == "closed") {
                        echo '
                        <input type="time" class="form-control business-hours" name="start-weekend" id="start-weekend" value="23:59" readonly>
                        <span> - </span>
                        <input type="time" class="form-control business-hours" name="end-weekend" id="end-weekend" value="23:59" readonly>
                        <div class="form-check form-check-inline ms-2">
                          <input type="checkbox" class="form-check-input" name="weekend-closed" id="weekend-closed" checked disabled>
                          <label for="weekend-closed">休息</label>
                        </div>
                        ';
                      } else {
                        $weekend = explode(" - ",  $details['weekend_business_hours']);
                        echo '
                        <input type="time" class="form-control business-hours" name="start-weekend" id="start-weekend" value="'.$weekend[0].'" readonly>
                        <span> - </span>
                        <input type="time" class="form-control business-hours" name="end-weekend" id="end-weekend" value="'.$weekend[1].'" readonly>
                        <div class="form-check form-check-inline ms-2">
                          <input type="checkbox" class="form-check-input" name="weekend-closed" id="weekend-closed" disabled>
                          <label for="weekend-closed">休息</label>
                        </div>
                        ';
                      }
                      ?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-2 offset-2">公眾假期</div>
                    <div class="col-md-8">
                      <?php
                      if ($details['holiday_business_hours'] == "closed") {
                        echo '
                        <input type="time" class="form-control business-hours" name="start-holiday" id="start-holiday" value="23:59" readonly>
                        <span> - </span>
                        <input type="time" class="form-control business-hours" name="end-holiday" id="end-holiday" value="23:59" readonly>
                        <div class="form-check form-check-inline ms-2">
                          <input type="checkbox" class="form-check-input" name="holiday-closed" id="holiday-closed" checked disabled>
                          <label for="holiday-closed">休息</label>
                        </div>
                        ';
                      } else {
                        $holiday = explode(" - ",  $details['holiday']);
                        echo '
                        <input type="time" class="form-control business-hours" name="start-holiday" id="start-holiday" value="'.$holiday[0].'" readonly>
                        <span> - </span>
                        <input type="time" class="form-control business-hours" name="end-holiday" id="end-holiday" value="'.$holiday[1].'" readonly>
                        <div class="form-check form-check-inline ms-2">
                          <input type="checkbox" class="form-check-input" name="holiday-closed" id="holiday-closed" disabled>
                          <label for="holiday-closed">休息</label>
                        </div>
                        ';
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
                      $sql = "SELECT * FROM `Payment_Method_List`;";
                      $rs = mysqli_query($conn, $sql);

                      while ($method = mysqli_fetch_assoc($rs)) {
                        if ($method['method_id'] == '0') {
                          // empty
                        } else {
                          echo '<div class="form-check form-check-inline">';
                          echo '<input class="form-check-input" type="checkbox" value="' . $method['method_id'] . '" name="payment[]"' . (in_array($method['method_id'], $methods) ? 'checked="checked"' : '') . 'disabled="true">';
                          echo '<label class="form-check-label">' . $method['zh-hk'] . '</label>';
                          echo '</div>';
                        }
                      }
                      ?>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Restaurant Information (Form) -->
              <form id="collab-restaurant" class="hidden">
                <!-- Restaurant name -->
                  <input class="form-control" type="text" name="chi-name" id="chi-name" placeholder="中文" value=<?php echo '"' . $details['restaurant_chinese_name'] . '"'; ?> readonly>
                  <input class="form-control" type="text" name="eng-name" id="eng-name" placeholder="英文" value=<?php echo '"' . $details['restaurant_english_name'] . '"'; ?> readonly>
                <!-- District -->
                  <select class="form-select" id="district" name="district">
                    <option value="" selected hidden>請選擇地區</option>
                    <?php
                    $region_sql = "SELECT * FROM `hong_kong_region`;";
                    $region_rs = mysqli_query($conn, $region_sql);

                    while ($region = mysqli_fetch_assoc($region_rs)) {
                      echo "<optgroup label=\"" . $region['zh-hk'] . "\">";

                      $district_sql = "SELECT * FROM `hong_kong_district` WHERE region_id = " . $region['region_id'] . ";";
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
                <!-- Physical Address -->
                  <input class="form-control" type="text" name="chi-address" id="chi-address" placeholder="中文" value=<?php echo '"' . $details['chinese_address'] . '"'; ?> readonly>
                  <input class="form-control" type="text" name="eng-address" id="eng-address" placeholder="英文" value=<?php echo '"' . $details['english_address'] . '"'; ?> readonly>
                <!-- Restaurant Contact Information -->
                  <input class="form-control" type="tel" name="restaurant-phoneNo" id="restaurant-phoneNo" placeholder="聯絡電話" minlength="8" maxlength="8" oninput="value=value.replace(/[^\d]/g,'')" value=<?php echo '"' . $details['restaurant_phone_number'] . '"'; ?> readonly>
                  <input class="form-control" type="email" name="email" id="email" placeholder="電郵" readonly disabled>
                <!-- Cuisine -->
                  <?php
                  $cuisine_sql = "SELECT * FROM `Cuisine_List`;";
                  $cuisine_rs = mysqli_query($conn, $cuisine_sql);

                  while ($cuisine = mysqli_fetch_assoc($cuisine_rs)) {
                    if ($cuisine['cuisine_id'] == '0') {
                      // empty
                    } else {
                      echo '<input class="form-check-input cuisine" type="checkbox" id="' . str_replace(' ', '', $cuisine['en']) . '" value="' . $cuisine['cuisine_id'] . '" name="cuisine[]"' .
                        (in_array($cuisine['cuisine_id'], $cuisines) ? 'checked="checked"' : '') . '>';
                    }
                  }
                  ?>
                <!-- Restaurant Types -->
                  <?php
                  $sql = "SELECT * FROM `restaurant_type_list`;";
                  $rs = mysqli_query($conn, $sql);

                  while ($type = mysqli_fetch_assoc($rs)) {
                    if ($type['type_id'] == '0') {
                      // empty
                    } else {
                      echo '<input class="form-check-input type" type="checkbox" id="' . str_replace(' ', '', $type['en']) . '" value="' . $type['type_id'] . '" name="type[]"' .
                        (in_array($type['type_id'], $types) ? 'checked="checked"' : '') . '>';
                    }
                  }
                  ?>
                <!-- Storefront -->
                  <a class="btn btn-primary" href=<?php echo "\"/travelhk.com/data/collab_request/restaurant/" . $details['request_id'] . "/storefront.jpg\""; ?> target="_blank">查看相片</a>
                <!-- Number of Seats -->
                  <input type="number" class="form-control" id="seats" name="seats" value=<?php echo '"' . $details['number_of_seats'] . '"'; ?> readonly>
                <!-- Opening Hours -->
                <?php
                            if ($details['weekday_business_hours'] == "closed") {
                              echo '
                              <input type="time" class="form-control business-hours" name="start-weekday" id="start-weekday" value="23:59" readonly>
                              <span> - </span>
                              <input type="time" class="form-control business-hours" name="end-weekday" id="end-weekday" value="23:59" readonly>
                              <div class="form-check form-check-inline ms-2">
                                <input type="checkbox" class="form-check-input" name="weekday-closed" id="weekday-closed" checked>
                                <label for="weekday-closed">休息</label>
                              </div>
                              ';
                            } else {
                              $weekday = explode(" - ",  $details['weekday_business_hours']);
                              echo '
                              <input type="time" class="form-control business-hours" name="start-weekday" id="start-weekday" value="'.$weekday[0].'">
                              <span> - </span>
                              <input type="time" class="form-control business-hours" name="end-weekday" id="end-weekday" value="'.$weekday[1].'">
                              <div class="form-check form-check-inline ms-2">
                                <input type="checkbox" class="form-check-input" name="weekday-closed" id="weekday-closed">
                                <label for="weekday-closed">休息</label>
                              </div>
                              ';
                            }
                        ?>
                  <?php
                            if ($details['weekend_business_hours'] == "closed") {
                              echo '
                              <input type="time" class="form-control business-hours" name="start-weekend" id="start-weekend" value="23:59" readonly>
                              <span> - </span>
                              <input type="time" class="form-control business-hours" name="end-weekend" id="end-weekend" value="23:59" readonly>
                              <div class="form-check form-check-inline ms-2">
                                <input type="checkbox" class="form-check-input" name="weekend-closed" id="weekend-closed" checked>
                                <label for="weekend-closed">休息</label>
                              </div>
                              ';
                            } else {
                              $weekend = explode(" - ",  $details['weekend_business_hours']);
                              echo '
                              <input type="time" class="form-control business-hours" name="start-weekend" id="start-weekend" value="'.$weekend[0].'">
                              <span> - </span>
                              <input type="time" class="form-control business-hours" name="end-weekend" id="end-weekend" value="'.$weekend[1].'">
                              <div class="form-check form-check-inline ms-2">
                                <input type="checkbox" class="form-check-input" name="weekend-closed" id="weekend-closed">
                                <label for="weekend-closed">休息</label>
                              </div>
                              ';
                            }
                    ?>
                  <?php
                            if ($details['holiday_business_hours'] == "closed") {
                              echo '
                              <input type="time" class="form-control business-hours" name="start-holiday" id="start-holiday" value="23:59" readonly>
                              <span> - </span>
                              <input type="time" class="form-control business-hours" name="end-holiday" id="end-holiday" value="23:59" readonly>
                              <div class="form-check form-check-inline ms-2">
                                <input type="checkbox" class="form-check-input" name="holiday-closed" id="holiday-closed" checked>
                                <label for="holiday-closed">休息</label>
                              </div>
                              ';
                            } else {
                              $holiday = explode(" - ",  $details['holiday']);
                              echo '
                              <input type="time" class="form-control business-hours" name="start-holiday" id="start-holiday" value="'.$holiday[0].'">
                              <span> - </span>
                              <input type="time" class="form-control business-hours" name="end-holiday" id="end-holiday" value="'.$holiday[1].'">
                              <div class="form-check form-check-inline ms-2">
                                <input type="checkbox" class="form-check-input" name="holiday-closed" id="holiday-closed">
                                <label for="holiday-closed">休息</label>
                              </div>
                              ';
                            }
                        ?>
                  <?php
                  $sql = "SELECT * FROM `payment_method_list`;";
                  $rs = mysqli_query($conn, $sql);

                  while ($method = mysqli_fetch_assoc($rs)) {
                    if ($method['method_id'] == '0') {
                      // empty
                    } else {
                      echo '<input class="form-check-input payment-method" type="checkbox" id="' . str_replace(' ', '', $method['en']) . '" value="' . $method['method_id'] . '" name="payment[]"' .
                        (in_array($method['method_id'], $methods) ? 'checked="checked"' : '') . '>';
                    }
                  }
                  ?>
              </form>
                
              <!-- Button -->
              <div class="card next">
                <div class="card-body text-end">
                  <button id="next-to-finish" class="btn btn-primary next-btn">完成</button>
                </div>
              </div>
            </div>
          </div>
        </section>
        
        <!-- Finish -->
        <section id="finish">
          <div class="row">
            <div class="col-md-10 offset-1 text-center">
              <div class="card">
                <div class="card-body">
                  <p>你的帳號及餐廳創建成功！</p>
                  <p>請到合作夥伴管理頁面登入。</p>
                  <p>
                    <a href="/<?php echo $_COOKIE['lang']; ?>/partner" class="btn btn-primary">前往</a>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Finished -->
        <section id="finished"></section>

      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php include_once('../common/footer.php'); ?>

</body>

</html>