<?php
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
  <title>管理頁面</title>

  <?php
  require_once('/xampp/htdocs/travelHK.com/library.php');
  ?>

  <link rel="stylesheet" href="/css/admin_form.css">
  <script src="/js/admin.js"></script>
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

        <form id="attraction-creation" method="POST">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-10 offset-1">
                <h3 class="mb-0 text-secondary">新增景點</h3>
              </div>
            </div>
            <div class="row">
              <div class="col-md-10 offset-1 card">
                <div class="card-body">
                  <!-- Attraction name -->
                  <div class="row">
                    <div class="col-md-2">
                      <label>景點名稱</label>
                      <span class="text-danger">*</span>
                    </div>
                    <div class="col-md-5">
                      <input class="form-control" type="text" name="chi-name" id="chi-name" placeholder="中文">
                    </div>
                    <div class="col-md-5">
                      <input class="form-control" type="text" name="eng-name" id="eng-name" placeholder="英文">
                    </div>
                  </div>
                  <!-- District -->
                  <div class="row">
                    <div class="col-md-2">
                      <label>地區</label>
                      <span class="text-danger">*</span>
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
                      <span class="text-danger">*</span>
                    </div>
                    <div class="col-md-10">
                      <input class="form-control" type="text" name="chi-address" id="chi-address" placeholder="中文">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-10 offset-2">
                      <input class="form-control" type="text" name="eng-address" id="eng-address" placeholder="英文">
                    </div>
                  </div>
                  <!-- Official Information -->
                  <div class="row">
                    <div class="col-md-2">
                      <label>官方資料</label>
                    </div>
                    <div class="col-md-10">
                      <input class="form-control" type="text" name="website" id="website" placeholder="網站">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-5 offset-2">
                      <input class="form-control" type="text" name="phoneNumber" id="phoneNumber" placeholder="聯絡電話 (如需要)" minlength="8" maxlength="8" oninput="value=value.replace(/[^\d]/g,'')">
                    </div>
                    <div class="col-md-5">
                      <input class="form-control" type="email" name="email" id="email" placeholder="電郵 (如需要)">
                    </div>
                  </div>
                  <!-- Attraction Types -->
                  <div class="row">
                    <div class="col-md-2">
                      <label>景點類型</label>
                      <span class="text-danger">*</span>
                    </div>
                    <div class="col-md-10" id="type-checkboxes">
                      <?php
                      $sql = "SELECT * FROM `attraction_type_list`;";
                      $rs = mysqli_query($conn, $sql);

                      while ($type = mysqli_fetch_assoc($rs)) {
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
                  <!-- Equipments -->
                  <div class="row">
                    <div class="col-md-2">
                      <label>公用設備</label>
                    </div>
                    <div class="col-md-10" id="equipment-checkboxes">
                      <?php
                      $sql = "SELECT * FROM `attraction_equipment_list`;";
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
                  <div class="row">
                    <div class="col-md-12 text-center">
                      <button type="button" class="btn btn-primary" onclick="adminCreateAttraction();">提交</button>
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