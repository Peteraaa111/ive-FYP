<?php
session_start();
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
              <h3 class="text-secondary">現有景點資料概覽</h3>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-10 offset-1">
              <table id="myTable" class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">編號</th>
                    <th scope="col">中文名稱</th>
                    <th scope="col">英文名稱</th>
                    <th scope="col">地區</th>
                    <th scope="col">景點類型</th>
                    <th scope="col">狀態</th>
                    <th scope="col">新增時間</th>
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
                  // Connect to database
                  require_once("/xampp/htdocs/travelHK.com/dbConnect.php");

                  // Get the connection variable
                  global $conn;

                  $sql = "SELECT a.`attraction_id`, a.`attraction_chinese_name`, a.`attraction_english_name`, hkd.`zh-hk` AS `district`, s.`zh-hk` AS `status`, a.`create_datetime`
                                                FROM `attraction` a
                                                INNER JOIN `hong_kong_district` hkd ON a.`district` = hkd.`district_id`
                                                INNER JOIN `attraction_status` s ON a.`status` = s.`status_id`;";
                  $rs = mysqli_query($conn, $sql);

                  while ($rc = mysqli_fetch_assoc($rs)) {
                    echo '<tr onclick="window.location=\'attraction_editor.php?id=' . $rc['attraction_id'] . '\'">';
                    echo '<td>' . $rc['attraction_id'] . "</td>";
                    echo '<td>' . $rc['attraction_chinese_name'] . "</td>";
                    echo '<td>' . $rc['attraction_english_name'] . '</td>';
                    echo '<td>' . $rc['district'] . '</td>';
                    // Get the attraction type
                    $typeSql = "SELECT att.`attraction_id`, tlist.`zh-hk`
                                  FROM `attraction_type` att
                                  INNER JOIN `attraction_type_list` tlist ON att.`type_id` = tlist.`type_id`
                                  WHERE att.`attraction_id` = " . $rc['attraction_id'] . ";";
                    $tRs = mysqli_query($conn, $typeSql);
                    $type = "";
                    while ($tRc = mysqli_fetch_assoc($tRs)) {
                      if ($type != "") {
                        $type = $type . ", " . $tRc['zh-hk'];
                      } else {
                        $type = $tRc['zh-hk'];
                      }
                    }
                    echo "<td>" . $type . "</td>";
                    echo "<td>" . $rc['status'] . "</td>";
                    echo "<td>" . $rc['create_datetime'] . "</td></tr>";
                  }
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
                    <th scope="col">景點類型</th>
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

    <script>
      $(document).ready(function() {
        $('#myTable').DataTable({
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

  </div>

</body>

</html>