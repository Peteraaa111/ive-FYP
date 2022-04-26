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
  <link rel="stylesheet" type="text/css" href="/lib/datatables/datatables.min.css" />
  <script type="text/javascript" src="/lib/datatables/datatables.min.js"></script>
</head>

<body>

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php require_once("/xampp/htdocs/travelHK.com/admin/common/sidebar.php"); ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <div id="content">

        <!-- Topbar -->
        <?php require_once("/xampp/htdocs/travelHK.com/admin/common/topbar.php"); ?>
        <!-- End of Topbar -->

        <div class="container-fluid">
          <div class="row">
            <div class="col-md-10 offset-1">
              <h3 class="text-secondary">新民宿資訊</h3>
            </div>
          </div>
          <div class="row">
            <div class="col-md-10 offset-1">
              <table id="guesthouse-record" class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">編號</th>
                    <th scope="col">中文名稱</th>
                    <th scope="col">英文名稱</th>
                    <th scope="col">地區</th>
                    <th scope="col">提交時間</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql = "SELECT *, hkd.`zh-hk` AS `district`
                            FROM `guesthouse_discover` ad
                            INNER JOIN `hong_kong_district` hkd ON ad.`district` = hkd.`district_id`";
                  $rs = mysqli_query($conn, $sql);
                  while ($rc = mysqli_fetch_assoc($rs)) {
                  ?>
                    <tr onclick="window.location='details.php?id=<?php echo $rc['id'] ?>';">
                      <td scope="row"><?php echo $rc['id'] ?></td>
                      <td scope="row"><?php echo $rc['guesthouse_chinese_name'] ?></td>
                      <td scope="row"><?php echo $rc['guesthouse_english_name'] ?></td>
                      <td scope="row"><?php echo $rc['district'] ?></td>
                      <td scope="row"><?php echo $rc['submit_date'] ?></td>
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
                    <th scope="col">中文名稱</th>
                    <th scope="col">英文名稱</th>
                    <th scope="col">地區</th>
                    <th scope="col">提交時間</th>
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
    $(document).ready(function() {
      $('#guesthouse-record').DataTable();
    });
  </script>
</body>

</html>