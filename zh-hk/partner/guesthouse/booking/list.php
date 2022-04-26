<?php
session_start();

// connect to database
require_once("/xampp/htdocs/travelHK.com/dbConnect.php");
//get the connection variable
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

  <link rel="stylesheet" href="/css/admin_sidebar.css">

  <!-- Datatable -->
  <link rel="stylesheet" href="/lib/datatables/datatables.min.css">
  <script src="/lib/datatables/datatables.min.js"></script>
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

        <div class="container-fluid">
          <div class="row">
            <div class="col-md-10 offset-1">
              <h3 class="text-secondary">現有的預約</h3>
            </div>
          </div>
          <div class="row">
            <div class="col-md-10 offset-1">
              <table id="myTable" class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">編號</th>
                    <th scope="col">入住日期</th>
                    <th scope="col">退房日期</th>
                    <th scope="col">日數</th>
                    <th scope="col">房間數目</th>
                    <th scope="col">聯絡人名稱</th>
                    <th scope="col">聯絡人電話號碼</th>
                    <th scope="col">旅館名稱</th>
                    <th scope="col">預約日期</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql = "SELECT
                            `booking`.`booking_id` AS `id`,
                            `booking`.`checkin_date` AS `checkin`,
                            `booking`.`checkout_date` AS `checkout`,
                            DATEDIFF(`booking`.`checkout_date`, `booking`.`checkin_date`) AS `days`,
                            `booking`.`room` AS `rooms`,
                            `booking`.`contact_name` AS `contact_name`,
                            `booking`.`contact_phone` AS `contact_phone`,
                            `guesthouse`.`guesthouse_chinese_name` AS `guesthouse_name`,
                            `booking`.`create_datetime` AS `create_datetime`
                          FROM `guesthouse_booking` `booking`
                          INNER JOIN `guesthouse` `guesthouse`
                            ON `guesthouse`.`partner_id` = {$_SESSION['g_id']}
                          WHERE `booking`.`status` = 0 OR `booking`.`status` = 1";
                  $rs = mysqli_query($conn, $sql);
                  while ($rc = mysqli_fetch_assoc($rs)) {
                  ?>
                  <tr onclick="window.location='details.php?id=<?php echo $rc['id'] ?>';">
                    <td scope="row"><?php echo $rc['id'] ?></td>
                    <td scope="row"><?php echo $rc['checkin'] ?></td>
                    <td scope="row"><?php echo $rc['checkout'] ?></td>
                    <td scope="row"><?php echo $rc['days'] ?></td>
                    <td scope="row"><?php echo $rc['rooms'] ?></td>
                    <td scope="row"><?php echo $rc['contact_name'] ?></td>
                    <td scope="row"><?php echo $rc['contact_phone'] ?></td>
                    <td scope="row"><?php echo $rc['guesthouse_name'] ?></td>
                    <td scope="row"><?php echo $rc['create_datetime'] ?></td>
                  </tr>
                </tbody>
                <?php
                };
                mysqli_free_result($rs);
                mysqli_close($conn);
                ?>
                <tfoot>
                  <tr>
                    <th scope="col">編號</th>
                    <th scope="col">入住日期</th>
                    <th scope="col">退房日期</th>
                    <th scope="col">日數</th>
                    <th scope="col">房間數目</th>
                    <th scope="col">聯絡人名稱</th>
                    <th scope="col">聯絡人電話號碼</th>
                    <th scope="col">旅館名稱</th>
                    <th scope="col">預約日期</th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>

      </div>

    </div>
    <!-- End of Content Wrapper -->

  </div>

  <script>
    $(document).ready(function () {
      $('#myTable').DataTable();
    })
  </script>
</body>

</html>