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
  <title>民宿合作夥伴申請資料庫 - 管理頁面</title>

  <?php
  require_once('/xampp/htdocs/travelHK.com/library.php');
  ?>

  <link rel="stylesheet" href="/css/admin_sidebar.css">

  <!-- Datatable -->
  <link rel="stylesheet" type="text/css" href="/lib/datatables/datatables.min.css" />
  <script type="text/javascript" src="/lib/datatables/datatables.min.js"></script>

  <script src="/js/admin.js"></script>
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
              <h3 class="text-secondary">民宿合作夥伴申請資料庫</h3>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-10 offset-1">
              <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                  <button class="nav-link active" id="nav-submitted-tab" data-bs-toggle="tab" data-bs-target="#nav-submitted" type="button" role="tab" aria-controls="nav-submitted" aria-selected="true">已提交</button>
                  <button class="nav-link" id="nav-review-tab" data-bs-toggle="tab" data-bs-target="#nav-review" type="button" role="tab" aria-controls="nav-review" aria-selected="false">審核中</button>
                  <button class="nav-link" id="nav-approved-tab" data-bs-toggle="tab" data-bs-target="#nav-approved" type="button" role="tab" aria-controls="nav-approved" aria-selected="false">審核通過</button>
                  <button class="nav-link" id="nav-completed-tab" data-bs-toggle="tab" data-bs-target="#nav-completed" type="button" role="tab" aria-controls="nav-completed" aria-selected="false">已完成</button>
                  <button class="nav-link" id="nav-rejected-tab" data-bs-toggle="tab" data-bs-target="#nav-rejected" type="button" role="tab" aria-controls="nav-rejected" aria-selected="false">拒絕</button>
                </div>
              </nav>
              <div class="tab-content" id="nav-tabContent">
                <!-- The collab requests status is "Submitted" -->
                <div class="tab-pane fade show active" id="nav-submitted" role="tabpanel" aria-labelledby="nav-submitted-tab">
                  <table id="collab-submitted" class="table table-hover">
                    <thead>
                      <tr>
                        <th>申請編號</th>
                        <th>民宿中文名稱</th>
                        <th>民宿英文名稱</th>
                        <th>申請時間</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sql = "SELECT `request_id`, `guesthouse_chinese_name`, `guesthouse_english_name`, `submit_datetime`
                                FROM `guesthouse_partner_request`
                                WHERE `status` = 1;";
                      $rs = mysqli_query($conn, $sql);

                      while ($rc = mysqli_fetch_assoc($rs)) {
                        echo '<tr onclick="under_review(' . $rc['request_id'] . ')"><td>' . $rc['request_id'] . "</td>";
                        echo "<td>" . $rc['guesthouse_chinese_name'] . "</td>";
                        echo "<td>" . $rc['guesthouse_english_name'] . "</td>";
                        echo "<td>" . $rc['submit_datetime'] . "</td></tr>";
                      }
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>申請編號</th>
                        <th>民宿中文名稱</th>
                        <th>民宿英文名稱</th>
                        <th>申請時間</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- The collab requests status is "Under Review" -->
                <div class="tab-pane fade" id="nav-review" role="tabpanel" aria-labelledby="nav-review-tab">
                  <table id="collab-review" class="table table-hover">
                    <thead>
                      <tr>
                        <th>申請編號</th>
                        <th>民宿中文名稱</th>
                        <th>民宿英文名稱</th>
                        <th>申請時間</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sql = "SELECT `request_id`, `guesthouse_chinese_name`, `guesthouse_english_name`, `submit_datetime`
                                FROM `guesthouse_partner_request`
                                WHERE `status` = 2;";
                      $rs = mysqli_query($conn, $sql);

                      while ($rc = mysqli_fetch_assoc($rs)) {
                      echo '<tr onclick="window.location=\'details.php?id=' . $rc['request_id'] . '\'"><td>' . $rc['request_id'] . "</td>";
                      echo "<td>" . $rc['guesthouse_chinese_name'] . "</td>";
                      echo "<td>" . $rc['guesthouse_english_name'] . "</td>";
                      echo "<td>" . $rc['submit_datetime'] . "</td></tr>";
                      }
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>申請編號</th>
                        <th>民宿中文名稱</th>
                        <th>民宿英文名稱</th>
                        <th>申請時間</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- The collab requests status is "Approved" -->
                <div class="tab-pane fade" id="nav-approved" role="tabpanel" aria-labelledby="nav-approved-tab">
                  <table id="collab-approved" class="table table-hover">
                    <thead>
                      <tr>
                        <th>申請編號</th>
                        <th>民宿中文名稱</th>
                        <th>民宿英文名稱</th>
                        <th>申請時間</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sql = "SELECT `request_id`, `guesthouse_chinese_name`, `guesthouse_english_name`, `submit_datetime`
                                FROM `guesthouse_partner_request`
                                WHERE `status` = 3;";
                      $rs = mysqli_query($conn, $sql);

                      while ($rc = mysqli_fetch_assoc($rs)) {
                      echo '<tr onclick="window.location=\'details.php?id=' . $rc['request_id'] . '\'"><td>' . $rc['request_id'] . "</td>";
                      echo "<td>" . $rc['guesthouse_chinese_name'] . "</td>";
                      echo "<td>" . $rc['guesthouse_english_name'] . "</td>";
                      echo "<td>" . $rc['submit_datetime'] . "</td></tr>";
                      }
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>申請編號</th>
                        <th>民宿中文名稱</th>
                        <th>民宿英文名稱</th>
                        <th>申請時間</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- The collab requests status is "Completed" -->
                <div class="tab-pane fade" id="nav-completed" role="tabpanel" aria-labelledby="nav-completed-tab">
                  <table id="collab-completed" class="table table-hover">
                    <thead>
                      <tr>
                        <th>申請編號</th>
                        <th>民宿中文名稱</th>
                        <th>民宿英文名稱</th>
                        <th>申請時間</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sql = "SELECT `request_id`, `guesthouse_chinese_name`, `guesthouse_english_name`, `submit_datetime`
                                FROM `guesthouse_partner_request`
                                WHERE `status` = 4;";
                      $rs = mysqli_query($conn, $sql);

                      while ($rc = mysqli_fetch_assoc($rs)) {
                      echo '<tr onclick="window.location=\'details.php?id=' . $rc['request_id'] . '\'"><td>' . $rc['request_id'] . "</td>";
                      echo "<td>" . $rc['guesthouse_chinese_name'] . "</td>";
                      echo "<td>" . $rc['guesthouse_english_name'] . "</td>";
                      echo "<td>" . $rc['submit_datetime'] . "</td></tr>";
                      }
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>申請編號</th>
                        <th>民宿中文名稱</th>
                        <th>民宿英文名稱</th>
                        <th>申請時間</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- The collab requests status is "Rejected" -->
                <div class="tab-pane fade" id="nav-rejected" role="tabpanel" aria-labelledby="nav-rejected-tab">
                  <table id="collab-rejected" class="table table-hover">
                    <thead>
                      <tr>
                        <th>申請編號</th>
                        <th>民宿中文名稱</th>
                        <th>民宿英文名稱</th>
                        <th>申請時間</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sql = "SELECT `request_id`, `guesthouse_chinese_name`, `guesthouse_english_name`, `submit_datetime`
                                FROM `guesthouse_partner_request`
                                WHERE `status` = 4;";
                      $rs = mysqli_query($conn, $sql);

                      while ($rc = mysqli_fetch_assoc($rs)) {
                      echo '<tr onclick="window.location=\'details.php?id=' . $rc['request_id'] . '\'"><td>'.$rc['request_id'].'</td>';
                      echo "<td>" . $rc['guesthouse_chinese_name'] . "</td>";
                      echo "<td>" . $rc['guesthouse_english_name'] . "</td>";
                      echo "<td>" . $rc['submit_datetime'] . "</td></tr>";
                      }
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>申請編號</th>
                        <th>民宿中文名稱</th>
                        <th>民宿英文名稱</th>
                        <th>申請時間</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>
    <!-- End of Content Wrapper -->

    <script>
      $(document).ready(function() {
        $('#collab-submitted').DataTable();
        $('#collab-review').DataTable();
        $('#collab-approved').DataTable();
        $('#collab-completed').DataTable();
        $('#collab-rejected').DataTable();
      });
    </script>

  </div>

</body>

</html>