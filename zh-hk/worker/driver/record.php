<?php
session_start();
require_once('/xampp/htdocs/travelhk.com/dbConnect.php');
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>管理頁面</title>

  <?php
  require_once('/xampp/htdocs/travelhk.com/library.php');
  ?>

  <!-- Datatable -->
  <link rel="stylesheet" href="/lib/datatables/datatables.min.css">
  <script src="/lib/datatables/datatables.min.js"></script>
</head>

<body>

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php require_once("sidebar.php"); ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <div id="content">

        <!-- Topbar -->
        <?php require_once("topbar.php"); ?>
        <!-- End of Topbar -->

        <div class="container-fluid">
          <div class="row">
            <div class="col-md-10 offset-1">
              <h3 class="text-secondary">訂單記錄</h3>
            </div>
          </div>
          <div class="row">
            <div class="col-md-10 offset-1">
              <table id="order-list" class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">編號</th>
                    <th scope="col">集合地點</th>
                    <th scope="col">地點數目</th>
                    <th scope="col">起程日期</th>
                    <th scope="col">起程時間</th>
                    <th scope="col">開單時間</th>
                    <th scope="col">狀態</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql = "SELECT booking.`booking_id`, booking.`itinerary_id`, booking.`start_address`, booking.`start_date`, booking.`start_time`, booking.`create_datetime`, bs.`zh-hk` AS `status`
                            FROM `itinerary_booking` booking
                            INNER JOIN `booking_status` bs ON booking.`status` = bs.`status_id`
                            WHERE `driver_id` = {$_SESSION['driver_id']}
                            ORDER BY booking.`status` ASC;";
                  $rs = mysqli_query($conn, $sql);
                  while ($rc = mysqli_fetch_assoc($rs)) {
                    $sql = "SELECT COUNT(`itinerary_id`) AS `qty` FROM `itinerary_schedule` WHERE `itinerary_id` = {$rc['itinerary_id']}";
                    $site_num_rs = mysqli_query($conn, $sql);
                    $site_num_rc = mysqli_fetch_assoc($site_num_rs);
                  ?>
                  <tr onclick="window.location='order.php?id=<?php echo $rc['booking_id'] ?>';">
                    <td scope="row"><?php echo $rc['booking_id']; ?></td>
                    <td scope="row"><?php echo $rc['start_address']; ?></td>
                    <td scope="row"><?php echo $site_num_rc['qty']; ?></td>
                    <td scope="row"><?php echo $rc['start_date']; ?></td>
                    <td scope="row"><?php echo $rc['start_time']; ?></td>
                    <td scope="row"><?php echo $rc['create_datetime']; ?></td>
                    <td scope="row"><?php echo $rc['status']; ?></td>
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
                    <th scope="col">集合地點</th>
                    <th scope="col">地點數目</th>
                    <th scope="col">起程日期</th>
                    <th scope="col">起程時間</th>
                    <th scope="col">開單時間</th>
                    <th scope="col">狀態</th>
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
      $('#order-list').DataTable();
    });
  </script>

</body>

</html>