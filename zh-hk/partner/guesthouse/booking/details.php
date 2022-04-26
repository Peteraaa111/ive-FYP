<?php
// Start the SESSION
session_start();

include_once('/xampp/htdocs/travelhk.com/dbConnect.php');
global $conn;

$sql = "SELECT * FROM `guesthouse_booking` WHERE `booking_id` = {$_GET['id']}";
$rs = mysqli_query($conn, $sql);
$rc = mysqli_fetch_assoc($rs);

$sql = "SELECT * FROM `guesthouse` WHERE `guesthouse_id` = {$rc['guesthouse_id']}";
$rs = mysqli_query($conn, $sql);
$guesthouse = mysqli_fetch_assoc($rs);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>管理頁面</title>

  <!-- Link the default css and js library -->
  <?php include_once('/xampp/htdocs/travelhk.com/library.php'); ?>

  <link rel="stylesheet" href="/css/admin_sidebar.css">
  <script src="/js/partner/guesthouse.js"></script>
</head>

<body>

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php require_once("../sidebar.php"); ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <div id="content">

        <!-- Topbar -->
        <?php require_once("../topbar.php"); ?>
        <!-- End of Topbar -->

        <div class="container card">
          <div class="card-body">
            <div class="row card">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-10">
                  <h4 class="card-title fw-bold">餐廳預約</h4>
                  </div>
                  <div class="col-md-2 text-end">
                    <?php
                    switch ($rc['status']) {
                      case 0:
                        echo '<span class="badge bg-primary fw-bold fs-5">待處理</span>';
                        break;
                      case 1:
                        echo '<span class="badge bg-info text-dark fw-bold fs-5">處理中</span>';
                        break;
                      case 2:
                        echo '<span class="badge bg-success fw-bold fs-5">已完成</span>';
                        break;
                      case 3:
                        echo '<span class="badge bg-danger fw-bold fs-5">已取消</span>';
                        break;
                    }
                    ?>
                  </div>
                </div>
              </div>
            </div>




            <div class="row mt-3 card">
              <div class="card-body">
                <div class="row">
                  <h5 class="card-title">民宿資料</h5>
                </div>
                <div class="row mt-3">
                  <div class="col-md-2">民宿名稱</div>
                  <div class="col-md-10">
                    <input type="text" class="form-control" value="<?php echo $guesthouse['guesthouse_chinese_name']; ?>" disabled>
                  </div>
                </div>
              </div>
            </div>
            <div class="row mt-3 card">
              <div class="card-body">
                <div class="row">
                  <div class="col">
                    <h5 class="card-title">預約資料</h5>
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-2">
                    日期
                    <span class="text-danger">*<span>
                  </div>
                  <div class="col">
                    <div class="input-group">
                      <input type="date" class="form-control" id="start-date" name="start-date" value="<?php echo $rc['checkin_date']; ?>" disabled>
                      <span class="input-group-text">至</span>
                      <input type="date" class="form-control" id="end-date" name="end-date" value="<?php echo $rc['checkout_date']; ?>" disabled>
                    </div>
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-2">
                    房間數目
                    <span class="text-danger">*<span>
                  </div>
                  <div class="col">
                    <div class="input-group">
                      <input type="number" class="form-control" id="rooms" name="rooms" value="<?php echo $rc['room']; ?>" disabled>
                      <span class="input-group-text">間</span>
                    </div>
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-2">
                    顧客人數
                    <span class="text-danger">*<span>
                  </div>
                  <div class="col-1">
                    成人
                    </div>
                  <div class="col">
                    <input class="form-control half" type="number" id="adult-number" name="adult-number" maxlength="130" value="<?php echo $rc['adult']; ?>" disabled>
                  </div>
                  <div class="col-1">
                    小童
                  </div>
                  <div class="col">
                    <input class="form-control half" type="number" id="child-number" name="child-number" maxlength="130" value="<?php echo $rc['children']; ?>" disabled>
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-2">
                    特殊需求
                  </div>
                  <div class="col">
                    <input type="text" class="form-control" id="description" name="description" placeholder="(可選) 酒店未必能配合所有要求，敬請留意。" value="<?php echo $rc['description']; ?>" disabled>
                  </div>
                </div>
              </div>
            </div>
            <div class="row mt-3 card">
              <div class="card-body">
                <div class="row">
                  <div class="col">
                    <h5 class="card-title">聯絡人資料</h5>
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-2">
                    顧客名稱
                    <span class="text-danger">*<span>
                  </div>
                  <div class="col">
                    <input type="text" class="form-control" id="contact-name" name="contact-name" value="<?php echo $rc['contact_name']; ?>" disabled>
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-2">
                    電話號碼
                    <span class="text-danger">*<span>
                  </div>
                  <div class="col">
                    <input type="tel" class="form-control" id="contact-number" name="contact-number" minlength="8" maxlength="8" oninput="value=value.replace(/[^\d]/g,'')" value="<?php echo $rc['contact_phone']; ?>" disabled>
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-2">
                    電郵地址
                    <span class="text-danger">*<span>
                  </div>
                  <div class="col">
                    <input type="text" class="form-control" id="contact-email" name="contact-email" value="<?php echo $rc['contact_email']; ?>" disabled>
                  </div>
                </div>
              </div>
            </div>
            <?php
            if ($rc['status'] == 0 || $rc['status'] == 1) {
              echo '
              <div class="row mt-3">
                <div class="col-md-12 text-end">
                  <button type="button" class="btn btn-primary me-2" onclick="finishBooking(' . $_GET['id'] . ')">完成預約</button>
                  <button type="button" class="btn btn-danger" onclick="cancelBooking(' . $_GET['id'] . ')">取消預約</button>
                </div>
              </div>
              ';
            }
            ?>
          </div>
        </div> <!-- Container -->

      </div>

    </div>
    <!-- End of Content Wrapper -->

  </div>



</body>

</html>