<?php
session_start();

include_once('/xampp/htdocs/travelHK.com/dbConnect.php');
global $conn;
?>

<!DOCTYPE html>
<html lang="zh-HK">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>管理頁面</title>

  <?php
  require_once('/xampp/htdocs/travelHK.com/library.php');
  ?>

  <script src="/js/admin.js"></script>
  <link rel="stylesheet" href="/css/admin_form.css">
</head>

<body>

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php require_once('../../common/sidebar.php'); ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <div id="content">

        <!-- Topbar -->
        <?php require_once("../../common/topbar.php"); ?>
        <!-- End of Topbar -->

        <form id="restaurant-creation" method="POST">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-10 offset-1">
                <h3 class="mb-0 text-secondary">新增餐廳</h3>
              </div>
            </div>
            <div class="row">
              <div class="col-md-10 offset-1 card">
                <div class="card-body">
                  <!-- Restaurant Name -->
                  <div class="row">
                    <div class="col-md-2">
                      <label>餐廳名稱</label>
                      <span class="text-danger">*</span>
                    </div>
                    <div class="col-md-5">
                      <input type="text" class="form-control" id="chi-name" name="chi-name" placeholder="中文">
                    </div>
                    <div class="col-md-5">
                      <input type="text" class="form-control" id="eng-name" name="eng-name" placeholder="英文">
                    </div>
                  </div>
                  <!-- District -->
                  <div class="row">
                    <div class="col-md-2">
                      <label>地區</label>
                      <span class="text-danger">*<span>
                    </div>
                    <div class="col-md-10">
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
                  <!-- Physical Address -->
                  <div class="row">
                    <div class="col-md-2">
                      <label>地址</label>
                      <span class="text-danger">*<span>
                    </div>
                    <div class="col-md-10">
                      <input type="text" class="form-control" id="chi-address" name="chi-address" placeholder="中文">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-10 offset-2">
                      <input type="text" class="form-control" id="eng-address" name="eng-address" placeholder="英文">
                    </div>
                  </div>
                  <!-- Coordinate -->
                  <div class="row">
                    <div class="col-md-2">
                      <label>座標</label>
                      <span class="text-danger">*<span>
                    </div>
                    <div class="col-md-5">
                      <input type="text" class="form-control" id="latitude" name="latitude" placeholder="(自動填入)" value="0" readonly>
                    </div>
                    <div class="col-md-5">
                      <input type="text" class="form-control" id="longitude" name="longitude" placeholder="(自動填入)" value="0" readonly>
                    </div>
                  </div>
                  <!-- Contact Information -->
                  <div class="row">
                    <div class="col-md-2">
                      <label>聯絡資料</label>
                      <span class="text-danger">*<span>
                    </div>
                    <div class="col-md-5">
                      <input class="form-control" type="tel" name="phoneNumber" id="phoneNumber" placeholder="聯絡電話" minlength="8" maxlength="8" oninput="value=value.replace(/[^\d]/g,'')">
                    </div>
                    <div class="col-md-5">
                      <input class="form-control" type="email" name="email" id="email" placeholder="電郵 (如需要)">
                    </div>
                  </div>
                  <!-- Cuisine -->
                  <div class="row">
                    <div class="col-md-2">
                      <label>菜式</label>
                      <span class="text-danger">*<span>
                    </div>
                    <div class="col-md-10" id="cuisine-checkboxes">
                      <?php
                      $cuisine_sql = "SELECT * FROM `cuisine_list`;";
                      $cuisine_rs = mysqli_query($conn, $cuisine_sql);

                      while ($cuisine = mysqli_fetch_assoc($cuisine_rs)) {
                        if ($cuisine['cuisine_id'] == '0') {
                          // empty
                        } else {
                          echo '<div class="form-check form-check-inline">';
                          echo '<input class="form-check-input cuisine" type="checkbox" id="' . str_replace(' ', '', $cuisine['en']) . '" value="' . $cuisine['cuisine_id'] . '" name="cuisine[]">';
                          echo '<label class="form-check-label" for="' . str_replace(' ', '', $cuisine['en']) . '">' . $cuisine['zh-hk'] . '</label>';
                          echo '</div>';
                        }
                      }
                      ?>
                    </div>
                  </div>
                  <!-- Restaurant Type -->
                  <div class="row">
                    <div class="col-md-2">
                      <label>食品 / 餐廳類型</label>
                      <span class="text-danger">*<span>
                    </div>
                    <div class="col-md-10" id="type-checkboxes">
                      <?php
                      $type_sql = "SELECT * FROM `restaurant_type_list`;";
                      $type_rs = mysqli_query($conn, $type_sql);

                      while ($type = mysqli_fetch_assoc($type_rs)) {
                        if ($type['type_id'] == '0') {
                          // empty
                        } else {
                          echo '<div class="form-check form-check-inline">';
                          echo '<input class="form-check-input type" type="checkbox" id="' . str_replace(' ', '', $type['en']) . '" value="' . $type['type_id'] . '" name="type[]">';
                          echo '<label class="form-check-label" for="' . str_replace(' ', '', $type['en']) . '">' . $type['zh-hk'] . '</label>';
                          echo '</div>';
                        }
                      }
                      ?>
                    </div>
                  </div>
                  <!-- Number of Seats -->
                  <div class="row">
                    <div class="col-md-2">
                      <label>座位數目</label>
                      <span class="text-danger">*<span>
                    </div>
                    <div class="col-md-10">
                      <div class="input-group">
                        <input type="number" class="form-control" id="seats" name="seats">
                        <span class="input-group-text">位</span>
                      </div>
                    </div>
                  </div>
                  <!-- Business Hours -->
                  <div class="row">
                    <div class="col-md-2">
                      <label>營業時間</label>
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
                    </div>
                  </div>
                  <!-- Payment Methods -->
                  <div class="row">
                    <div class="col-md-2">
                      <label>付款方式</label>
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
                          echo '<input class="form-check-input payment-method" type="checkbox" id="' . str_replace(' ', '', $method['en']) . '" value="' . $method['method_id'] . '" name="payment[]">';
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
                      <!-- Print the payment method with check box -->
                      <?php
                      $sql = "SELECT * FROM `restaurant_equipment_list`;";
                      $rs = mysqli_query($conn, $sql);

                      while ($equipment = mysqli_fetch_assoc($rs)) {
                        if ($equipment['equipment_id'] == '0') {
                          // empty
                        } else {
                          echo '<div class="form-check form-check-inline">';
                          echo '<input class="form-check-input equipment" type="checkbox" id="' . str_replace(' ', '', $equipment['en']) . '" value="' . $equipment['equipment_id'] . '" name="equipment[]">';
                          echo '<label class="form-check-label" for="' . str_replace(' ', '', $equipment['en']) . '">' . $equipment['zh-hk'] . '</label>';
                          echo '</div>';
                        }
                      }
                      ?>
                    </div>
                  </div>
                  <!-- Submit -->
                  <div class="row">
                    <div class="col-md-12 text-end">
                      <button type="button" class="btn btn-primary" onclick="adminCreateRestaurant();">提交</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!-- End of Content Wrapper -->

  </div>

</body>

</html>