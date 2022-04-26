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

  <link rel="stylesheet" href="../../../../js/jqueryui/jquery-ui.css">
  <script src="../../../../js/jqueryui/jquery-ui.min.js"></script>

  <!-- Datatable -->
  <link rel="stylesheet" href="/lib/datatables/datatables.min.css">
  <script src="/lib/datatables/datatables.min.js"></script>


  <style>
    .draggable {
      text-align: center;
      position: initial;
      width: 70px;
      height: 70px;
      float: left;
      cursor: pointer;
      position: absolute;
    }

    #containment-wrapper {
      height: 500px;
      border: 2px solid #ccc;
      padding: 10px;
      overflow: auto;
      position: relative;
      margin-top: 20px;
    }
  </style>


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
              <h3 class="text-secondary">過往的預約記錄</h3>
            </div>
          </div>
          <div class="row">
            <div class="col-md-10 offset-1">
              <table id="myTable" class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">編號</th>
                    <th scope="col">餐廳名稱</th>
                    <th scope="col">預訂日期</th>
                    <th scope="col">開始時間</th>
                    <th scope="col">聯絡人名稱</th>
                    <th scope="col">聯絡人電話號碼</th>
                    <th scope="col">預訂枱號</th>
                    <th scope="col">審核狀態</th>
                    <th scope="col">預覽訂座</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql = "SELECT
                  `booking`.`booking_id` AS `id`,
                  `restaurant`.`restaurant_chinese_name` AS `name`,
                  `booking`.`booking_date` AS `date`,
                  `booking`.`booking_time` AS `time`,
                  `booking`.`contact_name` AS `contact_name`,
                  `booking`.`contact_phone` AS `phone`,
                  `booking`.`people` AS `people`,
                  `booking`.`table` AS `table`,
                  `booking`.`restaurant_id` AS `resid`,
                  `booking`.`status` AS `status`
                  FROM `restaurant_booking` `booking`
                INNER JOIN `restaurant` `restaurant`
                  ON `restaurant`.`partner_id` = {$_SESSION['r_id']} AND `restaurant`.`restaurant_id` = `booking`.`restaurant_id`
                          WHERE `booking`.`status` = 2 OR `booking`.`status` = 3
                          ORDER BY `booking`.`booking_id` ASC";
                  $rs = mysqli_query($conn, $sql);
                  while ($rc = mysqli_fetch_assoc($rs)) {
                  ?>
                    <tr>
                      <td scope="row" onclick="window.location='details.php?id=<?php echo $rc['id'] ?>';"><?php echo $rc['id'] ?></td>
                      <td scope="row" onclick="window.location='details.php?id=<?php echo $rc['id'] ?>';"> <?php echo $rc['name'] ?></td>
                      <td scope="row" onclick="window.location='details.php?id=<?php echo $rc['id'] ?>';"><?php echo $rc['date'] ?></td>
                      <td scope="row" onclick="window.location='details.php?id=<?php echo $rc['id'] ?>';"><?php echo $rc['time'] ?></td>
                      <td scope="row" onclick="window.location='details.php?id=<?php echo $rc['id'] ?>';"><?php echo $rc['contact_name'] ?></td>
                      <td scope="row" onclick="window.location='details.php?id=<?php echo $rc['id'] ?>';"><?php echo $rc['phone'] ?></td>
                      <td scope="row" onclick="window.location='details.php?id=<?php echo $rc['id'] ?>';">
                        <?php if ($rc['table'] == null) {
                          echo "不適用";
                        } else {
                          echo $rc['table'];
                        } ?></td>
                      <td scope="row" onclick="window.location='details.php?id=<?php echo $rc['id'] ?>';">
                        <?php
                        switch ($rc['status']) {
                          case 0:
                            echo "待處理";
                            break;
                          case 1:
                            echo "處理中";
                            break;
                          case 2:
                            echo "已完成";
                            break;
                          case 3:
                            echo "已取消";
                            break;
                          default:
                            echo "未知";
                        }
                        ?></td>
                      <td scope="row">
                        <?php
                        if ($rc['table'] == null) {
                          echo "不適用";
                        } else {
                          echo '<button class="btn btn-secondary viewLayout" data-bs-toggle="modal" data-bs-target="#exampleModal"  data-resid="' . $rc['resid'] . '"  data-date="' . $rc['date'] . '"   data-time="' . $rc['time'] .
                            '"   data-name="' . $rc['name'] . '"  >預覽</button>';
                        }
                        ?></td>
                    </tr>
                </tbody>
              <?php
                  };
                  mysqli_free_result($rs);

              ?>
              <tfoot>
                <tr>
                  <th scope="col">編號</th>
                  <th scope="col">餐廳名稱</th>
                  <th scope="col">預訂日期</th>
                  <th scope="col">開始時間</th>
                  <th scope="col">聯絡人名稱</th>
                  <th scope="col">聯絡人電話號碼</th>
                  <th scope="col">預訂枱號</th>
                  <th scope="col">審核狀態</th>
                  <th scope="col">預覽訂座</th>
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


  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title">
            <h5 id="exampleModalLabel">預約資訊</h5>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="clearOccupation()"></button>
        </div>
        <div class="modal-body">
          <div id="containment-wrapper">

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="clearOccupation()">關閉</button>
        </div>
      </div>
    </div>
  </div>







  <script>
    $(document).ready(function() {
      $('#myTable').DataTable();
    });


    $(".viewLayout").click(function() {
      let resid = $(this).data("resid");
      let bkdate = $(this).data("date");
      let bktime = $(this).data("time");
      let name = $(this).data("name");

      exampleModalLabel

      $("#exampleModalLabel").text(name + " - " + bkdate + " (" + bktime + ") 的訂座情況");



      $.ajax({
        url: "/function.php?op=loadTablePlacement",
        type: "POST",
        data: {
          resid: resid,
        },
        success: function(data) {


          if (data === -1) {

            alert("no table layout found")

          } else {

            const obj = JSON.parse((data));
            for (let i = 0; i < obj.length; i++) {
              var table = document.createElement('div');
              table.innerHTML = '<div class="draggable clickable ui-widget-content butNotHere" id="' + (i + 1) + '" style="left:' + obj[i].left + 'px; top:' + obj[i].top + 'px"' + 'data-ppl=' + obj[i].ppl + '>餐桌 ' + (i + 1) + "<br/>" + obj[i].ppl + "人" + '</div>';
              $("#containment-wrapper").append(table);
            }

            var ajaxurl = '/function.php?op=loadBookingLayout';
            data = {
              'resid': resid,
              'bkdate': bkdate,
              'bktime': bktime
            };
            $.post(ajaxurl, data, function(response) {

              console.log(response);

              response = response.slice(0, -1).split(",");
              for (let n = 0; n < response.length; n++) {
                $("#" + response[n]).css("color", "red");
                $("#" + response[n]).css("border-color", "red");
              }
            });


          }

        }
      });
    });

    function clearOccupation() {
      $("#containment-wrapper").empty();
    }
  </script>
</body>

</html>