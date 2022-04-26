<?php
session_start();
include_once('/xampp/htdocs/travelHK.com/dbConnect.php');

if (!isset($_SESSION['user_email'])) {
  header("Location: /");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>會員中心 - 香港本地旅遊平台 | 本地遊</title>

  <!-- Link the default css and js library -->
  <?php include_once('/xampp/htdocs/travelHK.com/library.php'); ?>

  <!-- Datatable -->
  <link rel="stylesheet" href="/lib/datatables/datatables.min.css">
  <script src="/lib/datatables/datatables.min.js"></script>

  <!-- User Profile CSS -->
  <link rel="stylesheet" href="/css/user_profile.css">

  <!-- Update User Info JS -->
  <script src="/js/updateUserInfo.js"></script>
</head>

<body>

  <!-- Header -->
  <?php include_once('../common/header.php'); ?>

  <?php
  global $conn;

  // Get the account information from database
  $query = "SELECT * FROM account WHERE `email` = '{$_SESSION['user_email']}';";
  $rs = mysqli_query($conn, $query);
  $rd = mysqli_fetch_assoc($rs);
  ?>

  <!-- Main Content -->
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <!-- User profile -->
        <div id="user-profile" class="card">
          <?php
          $id = $_SESSION['user_id'];
          $user_iconPath = "/data/account/general/$id/icon.png";
          echo '<img id="user-profile-icon" src="'.$user_iconPath.'" class="card-img-top rounded-circle" alt="User Icon">';
          ?>
          <div class="card-body">
            <h5 class="card-title">
              <?php echo $rd['nickname']; ?>
            </h5>
            <p class="card-text">
              會員ID : <?php echo $rd['account_id']; ?>
            </p>
          </div>
        </div>
        <!-- User menu -->
        <div id="user-menu" class="card">
          <div class="card-body">
            <h5 class="card-title">
              選單
            </h5>
          </div>
          <div class="list-group">
            <a href="user.php" class="list-group-item list-group-item-action" aria-current="true">帳號設定</a>
            <a href="booking.php" class="list-group-item list-group-item-action" aria-current="true">預約記錄</a>
            <a href="itineray_booking.php" class="list-group-item list-group-item-action active" aria-current="true">行程記錄</a>
            <a href="tourgroup_list.php" class="list-group-item list-group-item-action" aria-current="true">旅行團記錄</a>
          </div>
        </div>
      </div>
      <div class="col-md-9">
        <div id="user-profile-info" class="card">
          <div id="user-profile-info-body" class="card-body">
            <h3 class="card-title">
              行程記錄
            </h3>
            <div class="card-text">
              <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                  <button class="nav-link active" id="nav-info-tab" data-bs-toggle="tab" data-bs-target="#nav-info" type="button" role="tab" aria-controls="nav-info" aria-selected="true">
                    行程
                  </button>
                </div>
              </nav>
              <div class="tab-content" id="nav-tabContent">
                <!-- Basic Information Tab -->
                <div class="tab-pane fade show active" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab">
                  <table id="order-list" class="table table-hover">
                    <thead>
                      <tr>
                        <th scope="col">編號</th>
                        <th scope="col">行程名稱</th>
                        <th scope="col">接送服務</th>
                        <th scope="col">導遊服務</th>
                        <th scope="col">起程日期</th>
                        <th scope="col">狀態</th>
                        <th scope="col">完成日期</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sql = "SELECT * FROM `itinerary_booking` WHERE `account_id` = {$rd['account_id']}";
                      $rs0 = mysqli_query($conn, $sql);

                      while ($rc = mysqli_fetch_assoc($rs0)) {
                        // Get the details of `tourguide_tourgroup`
                        $sql = "SELECT * FROM `itinerary` WHERE `itinerary_id` = {$rc['itinerary_id']}";
                        $rs1 = mysqli_query($conn, $sql);
                        $rc1 =  mysqli_fetch_assoc($rs1);

                        // get the itinerary subject
                        if ($rc1['itinerary_english_name'] == "") {
                          $subject = $rc1['itinerary_chinese_name'];
                        } else {
                          $subject = $rc1['itinerary_english_name'];
                        }

                        // get the driver service status
                        if ($rc['drive_service'] == 1) {
                          $driver_service = "O";
                        } else {
                          $driver_service = "X";
                        }

                        // get the tourguide service status
                        if ($rc['tourguide_service'] == 1) {
                          $tourguide_service = "O";
                        } else {
                          $tourguide_service = "X";
                        }

                        // get the booking status
                        if ($rc['status'] == 0) {
                          $status = "待處理";
                        } else if ($rc['status'] == 1) {
                          $status = "處理中";
                        } else if ($rc['status'] == 2) {
                          $status = "已完成";
                        } else if ($rc['status'] == 3) {
                          $status = "已取消";
                        }

                        ?>
                        <tr onclick="window.location='itinerary_details.php?id=<?php echo $rc['booking_id'] ?>';">
                          <td scope="row"><?php echo $rc['booking_id']; ?></td>
                          <td scope="row"><?php echo $subject; ?></td>
                          <td scope="row"><?php echo $driver_service; ?></td>
                          <td scope="row"><?php echo $tourguide_service; ?></td>
                          <td scope="row"><?php echo $rc['start_date']; ?></td>
                          <td scope="row"><?php echo $status; ?></td>
                          <td scope="row"><?php echo $rc['complete_datetime']; ?></td>
                        </tr>
                      <?php        
                      };
                      mysqli_free_result($rs);
                      mysqli_close($conn);
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th scope="col">編號</th>
                        <th scope="col">行程名稱</th>
                        <th scope="col">接送服務</th>
                        <th scope="col">導遊服務</th>
                        <th scope="col">起程日期</th>
                        <th scope="col">狀態</th>
                        <th scope="col">完成日期</th>
                      </tr>
                    </tfoot>
                  </table>
                </div> <!-- End Information Tab -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php include_once('../common/footer.php'); ?>

  <script>
    $(document).ready(function () {
      $('#order-list').DataTable();
      $('#order-list1').DataTable();
    });
  </script>


</body>

</html>