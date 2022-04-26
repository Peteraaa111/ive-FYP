<?php
// Session Start
session_start();

// Get database connection variable
include_once('/xampp/htdocs/travelHK.com/dbConnect.php');
global $conn;

// Get the attraction id
$attraction_id = $_GET['id'];

// Get the attraction details
$details_sql = "SELECT * FROM `attraction` WHERE `attraction_id` = $attraction_id;";
$details_rs = mysqli_query($conn, $details_sql);
$info = mysqli_fetch_assoc($details_rs);

// Get the attraction types
$type_sql = "SELECT * FROM `attraction_type` WHERE `attraction_id` = $attraction_id;";
$type_rs = mysqli_query($conn, $type_sql);
$types = array();
while ($type = mysqli_fetch_assoc($type_rs)) {
  $types[] = $type['type_id'];
}

// Get the equipments
$equipment_sql = "SELECT * FROM `attraction_equipment` WHERE `attraction_id` = $attraction_id;";
$equipment_rs = mysqli_query($conn, $equipment_sql);
$equipments = array();
while ($equipment = mysqli_fetch_assoc($equipment_rs)) {
  $equipments[] = $equipment['equipment_id'];
}
?>

<!DOCTYPE html>
<html lang="zh-HK">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>景點編輯器 (ID: <?php echo $_GET['id']; ?>) - 管理頁面</title>

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

        <div class="container-fluid">
          <div class="row">
            <div class="col-md-10 offset-1">
              <!-- Title -->
              <div class="card">
                <div class="card-body">
                  <h3 class="text-secondary">景點編輯器 (ID: <?php echo $_GET['id']; ?>)</h3>
                </div>
              </div>

              <!-- Basic Information -->
              <form id="basic-info">
                <div class="card">
                  <div class="card-body">
                    <h3 class="text-secondary">基本資料</h3>
                    <!-- Attraction name -->
                    <div class="row">
                      <div class="col-md-2">
                        <label>景點名稱</label>
                        <span class="text-danger">*</span>
                      </div>
                      <div class="col-md-5">
                        <input class="form-control" type="text" name="chi-name" id="chi-name" placeholder="中文" value=<?php echo '"' . $info['attraction_chinese_name'] . '"'; ?>>
                      </div>
                      <div class="col-md-5">
                        <input class="form-control" type="text" name="eng-name" id="eng-name" placeholder="英文" value=<?php echo '"' . $info['attraction_english_name'] . '"'; ?>>
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
                              if ($info['district'] == $district['district_id']) {
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
                        <input class="form-control" type="text" name="chi-address" id="chi-address" placeholder="中文" value=<?php echo '"' . $info['chinese_address'] . '"'; ?>>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-10 offset-2">
                        <input class="form-control" type="text" name="eng-address" id="eng-address" placeholder="英文" value=<?php echo '"' . $info['english_address'] . '"'; ?>>
                      </div>
                    </div>
                    <!-- Coordinate -->
                    <div class="row">
                      <div class="col-md-2">
                        <label>座標</label>
                        <span class="text-danger">*</span>
                      </div>
                      <div class="col-md-5">
                        <input type="text" class="form-control" name="latitude" id="latitude" placeholder="緯度" value=<?php echo '"' . $info['latitude'] . '"'; ?> readonly>
                      </div>
                      <div class="col-md-5">
                        <input type="text" class="form-control" name="longitude" id="longitude" placeholder="經度" value=<?php echo '"' . $info['longitude'] . '"'; ?> readonly>
                      </div>
                    </div>
                    <!-- Official Information -->
                    <div class="row">
                      <div class="col-md-2">
                        <label>官方資料</label>
                      </div>
                      <div class="col-md-10">
                        <input class="form-control" type="text" name="website" id="website" placeholder="網站" value="<?php echo $info['website']; ?>">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-5 offset-2">
                        <input class="form-control" type="text" name="phoneNumber" id="phoneNumber" placeholder="聯絡電話 (如需要)" minlength="8" maxlength="8" oninput="value=value.replace(/[^\d]/g,'')" value=<?php echo '"' . $info['phone_number'] . '"'; ?>>
                      </div>
                      <div class="col-md-5">
                        <input class="form-control" type="email" name="email" id="email" placeholder="電郵 (如需要)" value=<?php echo '"' . $info['email'] . '"'; ?>>
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
                            echo '<input class="form-check-input type" type="checkbox" id="' . str_replace(' ', '', $type['en']) . '" value="' . $type['type_id'] . '" name="type[]"' .
                              (in_array($type['type_id'], $types) ? 'checked="checked"' : '')
                              . '>';
                            echo '<label class="form-check-label" for="' . str_replace(' ', '', $type['en']) . '">' . $type['zh-hk'] . '</label>';
                            echo '</div>';
                          }
                        }
                        ?>
                      </div>
                    </div>
                    <!-- Business hours - weekday -->
                    <div class="row">
                      <div class="col-md-2">
                        開放時間<span class="text-danger">*</span>
                      </div>
                      <div class="col-md-2">星期一至五</div>
                      <div class="col-md-8">
                        <?php
                        switch ($info['weekday_business_hours']) {
                          case 'closed':
                            echo '
                            <input type="time" class="form-control business-hours" name="start-weekday" id="start-weekday" value="23:59" readonly>
                            <span> - </span>
                            <input type="time" class="form-control business-hours" name="end-weekday" id="end-weekday" value="23:59" readonly>
                            <div class="form-check form-check-inline ms-2">
                              <input type="checkbox" class="form-check-input" name="weekday-closed" id="weekday-closed" checked>
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
                              <input type="checkbox" class="form-check-input" name="weekday-24hours" id="weekday-24hours" checked>
                              <label for="weekday-24hours">24小時</label> 
                            </div>
                            ';
                            break;
                          default:
                            $time = explode(" - ",  $info['weekday_business_hours']);
                            echo '
                            <input type="time" class="form-control business-hours" name="start-weekday" id="start-weekday" value="' . $time[0] . '">
                            <span> - </span>
                            <input type="time" class="form-control business-hours" name="end-weekday" id="end-weekday" value="' . $time[1] . '">
                            <div class="form-check form-check-inline ms-2">
                              <input type="checkbox" class="form-check-input" name="weekday-closed" id="weekday-closed">
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
                        switch ($info['weekend_business_hours']) {
                          case 'closed':
                            echo '
                            <input type="time" class="form-control business-hours" name="start-weekend" id="start-weekend" value="23:59" readonly>
                            <span> - </span>
                            <input type="time" class="form-control business-hours" name="end-weekend" id="end-weekend" value="23:59" readonly>
                            <div class="form-check form-check-inline ms-2">
                              <input type="checkbox" class="form-check-input" name="weekend-closed" id="weekend-closed" checked>
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
                              <input type="checkbox" class="form-check-input" name="weekend-24hours" id="weekend-24hours" checked>
                              <label for="weekend-24hours">24小時</label> 
                            </div>
                            ';
                            break;
                          default:
                            $time = explode(" - ",  $info['weekend_business_hours']);
                            echo '
                            <input type="time" class="form-control business-hours" name="start-weekend" id="start-weekend" value="' . $time[0] . '">
                            <span> - </span>
                            <input type="time" class="form-control business-hours" name="end-weekend" id="end-weekend" value="' . $time[1] . '">
                            <div class="form-check form-check-inline ms-2">
                              <input type="checkbox" class="form-check-input" name="weekend-closed" id="weekend-closed">
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
                        switch ($info['holiday_business_hours']) {
                          case 'closed':
                            echo '
                            <input type="time" class="form-control business-hours" name="start-holiday" id="start-holiday" value="23:59" readonly>
                            <span> - </span>
                            <input type="time" class="form-control business-hours" name="end-holiday" id="end-holiday" value="23:59" readonly>
                            <div class="form-check form-check-inline ms-2">
                              <input type="checkbox" class="form-check-input" name="holiday-closed" id="holiday-closed" checked>
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
                              <input type="checkbox" class="form-check-input" name="holiday-24hours" id="holiday-24hours" checked>
                              <label for="holiday-24hours">24小時</label> 
                            </div>
                            ';
                            break;
                          default:
                            $time = explode(" - ",  $info['holiday_business_hours']);
                            echo '
                            <input type="time" class="form-control business-hours" name="start-holiday" id="start-holiday" value="' . $time[0] . '">
                            <span> - </span>
                            <input type="time" class="form-control business-hours" name="end-holiday" id="end-holiday" value="' . $time[1] . '">
                            <div class="form-check form-check-inline ms-2">
                              <input type="checkbox" class="form-check-input" name="holiday-closed" id="holiday-closed">
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
                    <!-- Equipments -->
                    <div class="row">
                      <div class="col-md-2">
                        <label>公用設備</label>
                      </div>
                      <div class="col-md-10" id="equipment-checkboxes">
                        <!-- Print the payment method with check box -->
                        <?php
                        $sql = "SELECT * FROM `attraction_equipment_list`;";
                        $rs = mysqli_query($conn, $sql);

                        while ($equipment = mysqli_fetch_assoc($rs)) {
                          if ($equipment['equipment_id'] == '0') {
                            // empty    
                          } else {
                            echo '<div class="form-check form-check-inline">';
                            echo '<input class="form-check-input" type="checkbox" id="' . str_replace(' ', '', $equipment['en']) . '" value="' . $equipment['equipment_id'] . '" name="equipment[]"' . (in_array($equipment['equipment_id'], $equipments) ? 'checked="checked"' : '') . '>';
                            echo '<label class="form-check-label" for="' . str_replace(' ', '', $equipment['en']) . '">' . $equipment['zh-hk'] . '</label>';
                            echo '</div>';
                          }
                        }
                        ?>
                      </div>
                    </div>
                    <!-- Update Button -->
                    <div class="row">
                      <div class="col-md-12 text-center">
                        <button type="button" id="update-btn" class="btn btn-primary" onclick="adminUpdateAttractionInfo(<?php echo $info['attraction_id']; ?>);">更新</button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
              <!-- Setting -->
              <form id="setting">
                <div class="card">
                  <div class="card-body">
                    <h3 class="text-secondary">設定</h3>
                    <div class="row">
                      <!-- Public Setting -->
                      <div class="col-md-2">
                        公開設定
                      </div>
                      <div class="col-md-10">
                        <?php
                        $status_list_sql = "SELECT * FROM `attraction_status`;";
                        $status_rs = mysqli_query($conn, $status_list_sql);

                        $checked_sql = "SELECT `status` FROM `attraction` WHERE `attraction_id` = '" . $info['attraction_id'] . "';";
                        $checked_rs = mysqli_query($conn, $checked_sql);
                        $isChecked = mysqli_fetch_assoc($checked_rs);

                        while ($status = mysqli_fetch_assoc($status_rs)) {
                          if ($isChecked['status'] == $status['status_id']) {
                            echo '<div class="form-check form-check-inline">';
                            echo '<input type="radio" class="form-check-input" value="' . $status['en'] . '" name="status" id="' . $status['en'] . '" checked>';
                            echo '<label for="' . $status['en'] . '" class="form-check-label">' . $status['zh-hk'] . '</label>';
                            echo '</div>';
                          } else {
                            echo '<div class="form-check form-check-inline">';
                            echo '<input type="radio" class="form-check-input" value="' . $status['en'] . '" name="status" id="' . $status['en'] . '">';
                            echo '<label for="' . $status['en'] . '" class="form-check-label">' . $status['zh-hk'] . '</label>';
                            echo '</div>';
                          }
                        }
                        ?>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 text-center">
                        <button type="button" id="update-btn" class="btn btn-primary" onclick="adminUpdateAttractionStatus(<?php echo $info['attraction_id']; ?>);">更新</button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
              <!-- Image Management -->
              <!-- <div class="card">
                <div class="card-body">
                  <h3 class="text-secondary">照片管理</h3>
                </div>
              </div> -->
              <!-- Comment Management -->
              <!-- <div class="card">
                <div class="card-body">
                  <h3 class="text-secondary">留言管理</h3>
                </div>
              </div> -->
            </div>
          </div>
        </div>

      </div>

    </div>
    <!-- End of Content Wrapper -->

  </div>

</body>

</html>