<?php
session_start();
require_once("/xampp/htdocs/travelHK.com/dbConnect.php");
global $conn;
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>司機工作申請 - 管理頁面</title>

  <?php
  require_once('/xampp/htdocs/travelHK.com/library.php');
  ?>

  
  <!-- Datatable -->
  <link rel="stylesheet" type="text/css" href="/lib/datatables/datatables.min.css" />
  <script type="text/javascript" src="/lib/datatables/datatables.min.js"></script>

  <script src="/js/admin.js"></script>
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
              <h3 class="text-secondary">司機工作申請管理</h3>
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
                <!-- The driver job application status is "Submitted" -->
                <div class="tab-pane fade show active" id="nav-submitted" role="tabpanel" aria-labelledby="nav-submitted-tab">
                  <table id="submitted" class="table table-hover">
                    <thead>
                      <tr>
                        <th>申請編號</th>
                        <th>申請人姓名</th>
                        <th>申請時間</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sql = "SELECT `id`, `chinese_firstname`, `chinese_lastname`, `submit_datetime`
                                FROM `driver_application`
                                WHERE `status` = 1;";
                      $rs = mysqli_query($conn, $sql);

                      while ($rc = mysqli_fetch_assoc($rs)) {
                        echo '<tr onclick="wd_under_review(' . $rc['id'] . ')"><td>' . $rc['id'] . "</td>";
                        echo "<td>" . $rc['chinese_lastname'] . $rc['chinese_firstname'] . "</td>";
                        echo "<td>" . $rc['submit_datetime'] . "</td></tr>";
                      }
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>申請編號</th>
                        <th>申請人姓名</th>
                        <th>申請時間</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- The collab requests status is "Under Review" -->
                <div class="tab-pane fade" id="nav-review" role="tabpanel" aria-labelledby="nav-review-tab">
                  <table id="review" class="table table-hover">
                    <thead>
                      <tr>
                        <th>申請編號</th>
                        <th>申請人姓名</th>
                        <th>申請時間</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sql = "SELECT `id`, `chinese_firstname`, `chinese_lastname`, `submit_datetime`
                                FROM `driver_application`
                                WHERE `status` = 2;";
                      $rs = mysqli_query($conn, $sql);

                      while ($rc = mysqli_fetch_assoc($rs)) {
                        echo '<tr onclick="window.location=\'application.php?id=' . $rc['id'] . '\'"><td>' . $rc['id'] . "</td>";
                        echo "<td>" . $rc['chinese_lastname'] . $rc['chinese_firstname'] . "</td>";
                        echo "<td>" . $rc['submit_datetime'] . "</td></tr>";
                      }
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>申請編號</th>
                        <th>申請人姓名</th>
                        <th>申請時間</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- The collab requests status is "Approved" -->
                <div class="tab-pane fade" id="nav-approved" role="tabpanel" aria-labelledby="nav-approved-tab">
                  <table id="approved" class="table table-hover">
                    <thead>
                      <tr>
                        <th>申請編號</th>
                        <th>申請人姓名</th>
                        <th>申請時間</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sql = "SELECT `id`, `chinese_firstname`, `chinese_lastname`, `submit_datetime`
                                FROM `driver_application`
                                WHERE `status` = 3;";
                      $rs = mysqli_query($conn, $sql);

                      while ($rc = mysqli_fetch_assoc($rs)) {
                        echo '<tr onclick="window.location=\'application.php?id=' . $rc['id'] . '\'"><td>' . $rc['id'] . "</td>";
                        echo "<td>" . $rc['chinese_lastname'] . $rc['chinese_firstname'] . "</td>";
                        echo "<td>" . $rc['submit_datetime'] . "</td></tr>";
                      }
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>申請編號</th>
                        <th>申請人姓名</th>
                        <th>申請時間</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- The collab requests status is "Completed" -->
                <div class="tab-pane fade" id="nav-completed" role="tabpanel" aria-labelledby="nav-completed-tab">
                  <table id="completed" class="table table-hover">
                    <thead>
                      <tr>
                        <th>申請編號</th>
                        <th>申請人姓名</th>
                        <th>申請時間</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sql = "SELECT `id`, `chinese_firstname`, `chinese_lastname`, `submit_datetime`
                                FROM `driver_application`
                                WHERE `status` = 4;";
                      $rs = mysqli_query($conn, $sql);

                      while ($rc = mysqli_fetch_assoc($rs)) {
                        echo '<tr onclick="window.location=\'application.php?id=' . $rc['id'] . '\'"><td>' . $rc['id'] . "</td>";
                        echo "<td>" . $rc['chinese_lastname'] . $rc['chinese_firstname'] . "</td>";
                        echo "<td>" . $rc['submit_datetime'] . "</td></tr>";
                      }
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>申請編號</th>
                        <th>申請人姓名</th>
                        <th>申請時間</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- The collab requests status is "Rejected" -->
                <div class="tab-pane fade" id="nav-rejected" role="tabpanel" aria-labelledby="nav-rejected-tab">
                  <table id="rejected" class="table table-hover">
                    <thead>
                      <tr>
                        <th>申請編號</th>
                        <th>申請人姓名</th>
                        <th>申請時間</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sql = "SELECT `id`, `chinese_firstname`, `chinese_lastname`, `submit_datetime`
                                FROM `driver_application`
                                WHERE `status` = 4;";
                      $rs = mysqli_query($conn, $sql);

                      while ($rc = mysqli_fetch_assoc($rs)) {
                        echo '<tr onclick="window.location=\'application.php?id=' . $rc['id'] . '\'"><td>' . $rc['id'] . "</td>";
                        echo "<td>" . $rc['chinese_lastname'] . $rc['chinese_firstname'] . "</td>";
                        echo "<td>" . $rc['submit_datetime'] . "</td></tr>";
                      }
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>申請編號</th>
                        <th>申請人姓名</th>
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

  </div>

  <script>
    $(document).ready(function() {
      $('#submitted').DataTable();
      $('#review').DataTable();
      $('#approved').DataTable();
      $('#completed').DataTable();
      $('#rejected').DataTable();
    });
  </script>

</body>

</html>