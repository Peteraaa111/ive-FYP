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
            <a href="booking.php" class="list-group-item list-group-item-action active" aria-current="true">預約記錄</a>
            <a href="itineray_booking.php" class="list-group-item list-group-item-action" aria-current="true">行程記錄</a>
            <a href="tourgroup_list.php" class="list-group-item list-group-item-action" aria-current="true">旅行團記錄</a>
          </div>
        </div>
      </div>
      <div class="col-md-9">
        <div id="user-profile-info" class="card">
          <div id="user-profile-info-body" class="card-body">
            <h3 class="card-title">
              預約記錄
            </h3>
            <div class="card-text">
              <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                  <button class="nav-link active" id="nav-info-tab" data-bs-toggle="tab" data-bs-target="#nav-info" type="button" role="tab" aria-controls="nav-info" aria-selected="true">
                    餐廳
                  </button>
                  <button class="nav-link" id="nav-security-tab" data-bs-toggle="tab" data-bs-target="#nav-security" type="button" role="tab" aria-controls="nav-security" aria-selected="false">
                    民宿
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
                        <th scope="col">餐廳名稱</th>
                        <th scope="col">預約日期</th>
                        <th scope="col">預約時間</th>
                        <th scope="col">建立日期</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sql = "SELECT * FROM `restaurant_booking` WHERE `account_id` = {$rd['account_id']}";
                      $rs = mysqli_query($conn, $sql);
                      while ($rc = mysqli_fetch_assoc($rs)) {
                        // Get the details of `itinerary_schedule`
                        $sql = "SELECT * FROM `restaurant` WHERE `restaurant_id` = {$rc['restaurant_id']}";
                        $rs2 = mysqli_query($conn, $sql);
                        $rc2 = mysqli_fetch_assoc($rs2);
                      ?>
                      <tr onclick="window.location='r_booking.php?id=<?php echo $rc['booking_id'] ?>';">
                        <td scope="row"><?php echo $rc['booking_id']; ?></td>
                        <td scope="row"><?php echo $rc2['restaurant_chinese_name']; ?></td>
                        <td scope="row"><?php echo $rc['booking_date']; ?></td>
                        <td scope="row"><?php echo $rc['booking_time']; ?></td>
                        <td scope="row"><?php echo $rc['create_datetime']; ?></td>
                      </tr>
                      <?php
                      };
                      mysqli_free_result($rs);
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th scope="col">編號</th>
                        <th scope="col">餐廳名稱</th>
                        <th scope="col">預約日期</th>
                        <th scope="col">預約時間</th>
                        <th scope="col">建立日期</th>
                      </tr>
                    </tfoot>
                  </table>
                </div> <!-- End Information Tab -->

                <!-- Account Security Tab -->
                <div class="tab-pane fade" id="nav-security" role="tabpanel" aria-labelledby="nav-security-tab">
                  <table id="order-list1" class="table table-hover">
                    <thead>
                      <tr>
                        <th scope="col">編號</th>
                        <th scope="col">民宿名稱</th>
                        <th scope="col">入住日期</th>
                        <th scope="col">退房日期</th>
                        <th scope="col">建立日期</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sql = "SELECT * FROM `guesthouse_booking` WHERE `account_id` = {$rd['account_id']}";
                      $rs = mysqli_query($conn, $sql);
                      while ($rc = mysqli_fetch_assoc($rs)) {
                        // Get the details of `itinerary_schedule`
                        $sql = "SELECT * FROM `guesthouse` WHERE `guesthouse_id` = {$rc['guesthouse_id']}";
                        $rs2 = mysqli_query($conn, $sql);
                        $rc2 = mysqli_fetch_assoc($rs2);
                      ?>
                      <tr onclick="window.location='g_booking.php?id=<?php echo $rc['booking_id'] ?>';">
                        <td scope="row"><?php echo $rc['booking_id']; ?></td>
                        <td scope="row"><?php echo $rc2['guesthouse_chinese_name']; ?></td>
                        <td scope="row"><?php echo $rc['checkin_date']; ?></td>
                        <td scope="row"><?php echo $rc['checkout_date']; ?></td>
                        <td scope="row"><?php echo $rc['create_datetime']; ?></td>
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
                        <th scope="col">餐廳名稱</th>
                        <th scope="col">入住日期</th>
                        <th scope="col">退房日期</th>
                        <th scope="col">建立日期</th>
                      </tr>
                    </tfoot>
                  </table>
                </div> <!-- End Security Tab -->
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