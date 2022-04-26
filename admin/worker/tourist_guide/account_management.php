<?php
session_start();

// Connect to database
require_once("/xampp/htdocs/travelHK.com/dbConnect.php");
// Get the connection variable
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
  <link rel="stylesheet" type="text/css" href="/lib/datatables/datatables.css" />
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
              <h3 class="text-secondary">導遊帳號資料概覽</h3>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-10 offset-1">
              <table id="myTable" class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">姓名</th>
                    <th scope="col">性別</th>
                    <th scope="col">聯絡電話</th>
                    <th scope="col">年齡</th>
                    <th scope="col">帳號狀態</th>
                    <th scope="col">註冊時間</th>
                  </tr>
                  <tr>
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
                  $sql = "SELECT ac.`account_id`, CONCAT(ac.`lastname`, ' ', ac.`firstname`) AS `name`, IF(ac.`gender` = 'm', '男', '女') AS `gender`, ac.`phone_number`, YEAR(NOW()) - ac.`birth_year` AS `age`, s.`zh-hk` AS `status`, ac.`registration_time`
                            FROM `account` ac
                            INNER JOIN `account_status` s ON ac.`status` = s.`status_id`
                            WHERE ac.`type_id` = 4;";
                  $rs = mysqli_query($conn, $sql);

                  while ($rc = mysqli_fetch_assoc($rs)) {
                    echo '<tr onclick="window.location=\'account.php?id=' . $rc['account_id'] . '\'">';
                    echo '<td>' . $rc['account_id'] . "</td>";
                    echo '<td>' . $rc['name'] . "</td>";
                    echo '<td>' . $rc['gender'] . '</td>';
                    echo '<td>' . $rc['phone_number'] . '</td>';
                    echo "<td>" . $rc['age'] . "</td>";
                    echo "<td>" . $rc['status'] . "</td>";
                    echo "<td>" . $rc['registration_time'] . "</td></tr>";
                  }
                  mysqli_free_result($rs);
                  mysqli_close($conn);
                  ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">姓名</th>
                    <th scope="col">性別</th>
                    <th scope="col">聯絡電話</th>
                    <th scope="col">年齡</th>
                    <th scope="col">帳號狀態</th>
                    <th scope="col">註冊時間</th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>

      </div>

    </div>
    <!-- End of Content Wrapper -->

    <script>
      $(document).ready(function() {
        $('#myTable').DataTable({
          orderCellsTop: true,
          "columnDefs": [
            { "width": "100px", "targets": 3}
          ],
          initComplete: function() {
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
      });
    </script>

  </div>

</body>

</html>