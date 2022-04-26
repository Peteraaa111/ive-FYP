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
              <h3 class="text-secondary">現有的餐廳</h3>
            </div>
          </div>
          <div class="row">
            <div class="col-md-10 offset-1">
              <table id="myTable" class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">中文名稱</th>
                    <th scope="col">英文名稱</th>
                    <th scope="col">地區</th>
                    <th scope="col">電話號碼</th>
                    <th scope="col">狀態</th>
                    <th scope="col">新增時間</th>
                  </tr>
                  <tr>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql = "SELECT *, hkd.`zh-hk` AS `district`, rsl.`zh-hk` AS `status` 
                            FROM `restaurant` r
                            INNER JOIN `hong_kong_district` hkd ON r.`district` = hkd.`district_id`
                            INNER JOIN `restaurant_status` rsl ON r.`status` = rsl.`status_id`
                            WHERE `partner_id` = " . $_SESSION['r_id'] . ";";
                  $rs = mysqli_query($conn, $sql);
                  while ($rc = mysqli_fetch_assoc($rs)) {
                  ?>
                  <tr onclick="window.location='restaurant_editor.php?id=<?php echo $rc['restaurant_id'] ?>';">
                    <td scope="row"><?php echo $rc['restaurant_chinese_name'] ?></td>
                    <td scope="row"><?php echo $rc['restaurant_english_name'] ?></td>
                    <td scope="row"><?php echo $rc['district'] ?></td>
                    <td scope="row"><?php echo $rc['phone_number'] ?></td>
                    <td scope="row"><?php echo $rc['status'] ?></td>
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
                    <th scope="col">中文名稱</th>
                    <th scope="col">英文名稱</th>
                    <th scope="col">地區</th>
                    <th scope="col">電話號碼</th>
                    <th scope="col">狀態</th>
                    <th scope="col">新增時間</th>
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
      $('#myTable').DataTable({
        orderCellsTop: true,
        initComplete: function() {
          this.api().columns([4]).every(function() {
            var column = this;
            console.log(this.index())
            var select = $('<select class="form-select"><option value=""></option></select>')
              .appendTo($('thead tr:eq(1) th:eq(' + this.index() + ')'))
              .on('change', function() {
                var val = $.fn.dataTable.util.escapeRegex(
                  $(this).val()
                );
                column
                  .search(val ? '^' + val + '$' : '', true, false)
                  .draw();
              });

            column.data().unique().sort().each(function(d, j) {
              select.append('<option value="' + d + '">' + d + '</option>')
            });
          });
          this.api().columns([2]).every(function() {
            var column = this;
            console.log(this.index())
            var select = $('<select class="form-select"><option value=""></option></select>')
              .appendTo($('thead tr:eq(1) th:eq(' + this.index() + ')'))
              .on('change', function() {
                var val = $.fn.dataTable.util.escapeRegex(
                  $(this).val()
                );
                column
                  .search(val ? '^' + val + '$' : '', true, false)
                  .draw();
              });

            column.data().unique().sort().each(function(d, j) {
              select.append('<option value="' + d + '">' + d + '</option>')
            });
          });
        }
      });
    })
  </script>
</body>

</html>