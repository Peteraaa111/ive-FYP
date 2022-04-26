<?php
session_start();
require_once("/xampp/htdocs/travelHK.com/dbConnect.php");
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
  <!-- <script src="../js/admin.js"></script> -->
  <link rel="stylesheet" href="/css/admin_sidebar.css">

  <!-- Datatable -->
  <link rel="stylesheet" type="text/css" href="/lib/datatables/datatables.min.css" />
  <script type="text/javascript" src="/lib/datatables/datatables.min.js"></script>
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
              <h3 class="text-secondary">現有的餐廳資料概覽</h3>
            </div>
          </div>
          <div class="row">
            <div class="col-md-10 offset-1">
              <table id="restaurant-record" class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">編號</th>
                    <th scope="col">中文名稱</th>
                    <th scope="col">英文名稱</th>
                    <th scope="col">地區</th>
                    <th scope="col">電話號碼</th>
                    <th scope="col">狀態</th>
                    <th scope="col">新增時間</th>
                    <th scope="col">管理人帳號</th>
                  </tr>
                  <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  //get the connection variable
                  global $conn;

                  $sql = "SELECT *,hkd.`zh-hk` AS `district`, rsl.`zh-hk` AS `status` 
                            FROM restaurant r
                            INNER JOIN `hong_kong_district` hkd ON r.`district` = hkd.`district_id`
                            INNER JOIN `restaurant_status` rsl ON r.`status` = rsl.`status_id`
                            ORDER BY r.`restaurant_id` ASC";
                  $rs = mysqli_query($conn, $sql);
                  while ($rc = mysqli_fetch_assoc($rs)) {
                  ?>
                    <tr onclick="window.location='restaurant_editor.php?id=<?php echo $rc['restaurant_id'] ?>';">
                      <td scope="row"><?php echo $rc['restaurant_id'] ?></td>
                      <td scope="row"><?php echo $rc['restaurant_chinese_name'] ?></td>
                      <td scope="row"><?php echo $rc['restaurant_english_name'] ?></td>
                      <td scope="row"><?php echo $rc['district'] ?></td>
                      <td scope="row"><?php echo $rc['phone_number'] ?></td>
                      <td scope="row"><?php echo $rc['status'] ?></td>
                      <td scope="row"><?php echo $rc['create_datetime'] ?></td>
                      <td scope="row"><?php echo $rc['partner_id'] ?></td>
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
                    <th scope="col">中文名稱</th>
                    <th scope="col">英文名稱</th>
                    <th scope="col">地區</th>
                    <th scope="col">電話號碼</th>
                    <th scope="col">狀態</th>
                    <th scope="col">新增時間</th>
                    <th scope="col">管理人帳號</th>
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
        var table = $('#restaurant-record').DataTable({
          orderCellsTop: true,
          "columnDefs": [
            { "width": "100px", "targets": 3}
          ],
          initComplete: function() {
            this.api().columns([5]).every(function() {
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
            this.api().columns([3]).every(function() {
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
      });
    </script>
</body>

</html>