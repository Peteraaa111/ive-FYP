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
    <?php require_once("/xampp/htdocs/travelHK.com/zh-hk/worker/tourist_guide/sidebar.php"); ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <div id="content">

        <!-- Topbar -->
        <?php require_once("/xampp/htdocs/travelHK.com/zh-hk/worker/tourist_guide/topbar.php"); ?>
        <!-- End of Topbar -->

        <div class="container-fluid">
          <div class="row">
            <div class="col-md-10 offset-1">
              <h3 class="text-secondary">旅行團記錄</h3>
            </div>
          </div>
          <div class="row">
            <div class="col-md-10 offset-1">
              <table id="order-list" class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">編號</th>
                    <th scope="col">旅行團名稱</th>
                    <th scope="col">起點</th>
                    <th scope="col">終點</th>
                    <th scope="col">報名人數</th>
                    <th scope="col">截止日期</th>
                    <th scope="col">最後更新時間</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql = "SELECT *
                            FROM `tourguide_tourgroup`
                            WHERE `account_id` = {$_SESSION['guide_id']}
                            AND `status` = 2 OR `status` = 3;";
                  $rs = mysqli_query($conn, $sql);
                  while ($rc = mysqli_fetch_assoc($rs)) {
                    // Get the details of `itinerary_schedule`
                    $sql = "SELECT *
                              FROM `itinerary_schedule`
                              WHERE `itinerary_id` = {$rc['itinerary_id']}";
                    $rs2 = mysqli_query($conn, $sql);
                    for ($i=1; $i<=mysqli_num_rows($rs2); $i++) {
                      $rc2 = mysqli_fetch_assoc($rs2);
                      if ($i == 1) {
                        // Get the details of `attraction` - Starting point
                        $sql = "SELECT *
                                  FROM `attraction`
                                  WHERE `attraction_id` = {$rc2['attraction_id']}";
                        $rs3 = mysqli_query($conn, $sql);
                        $rc3 = mysqli_fetch_assoc($rs3);
                        $start = $rc3['attraction_chinese_name'];
                      }
                      if ($i == mysqli_num_rows($rs2)) {
                        // Get the details of `attraction` - Ending point
                        $sql = "SELECT *
                                  FROM `attraction`
                                  WHERE `attraction_id` = {$rc2['attraction_id']}";
                        $rs3 = mysqli_query($conn, $sql);
                        $rc3 = mysqli_fetch_assoc($rs3);
                        $end = $rc3['attraction_chinese_name'];
                      }
                    }
                  ?>
                  <tr onclick="window.location='details.php?id=<?php echo $rc['itinerary_id'] ?>';">
                    <td scope="row"><?php echo $rc['itinerary_id']; ?></td>
                    <td scope="row"><?php echo $rc['subject']; ?></td>
                    <td scope="row"><?php echo $start; ?></td>
                    <td scope="row"><?php echo $end; ?></td>
                    <td scope="row"><?php echo $rc['joined_people']; ?></td>
                    <td scope="row"><?php echo $rc['cutoff_date']; ?></td>
                    <td scope="row"><?php echo $rc['last_update']; ?></td>
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
                    <th scope="col">旅行團名稱</th>
                    <th scope="col">起點</th>
                    <th scope="col">終點</th>
                    <th scope="col">報名人數</th>
                    <th scope="col">截止日期</th>
                    <th scope="col">最後更新時間</th>
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