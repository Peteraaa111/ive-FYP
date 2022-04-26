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
  <script src="/lib/chart.js/chart.min.js"></script>
  <link rel="stylesheet" href="/css/callout.css">
</head>

<body>

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php require_once("/xampp/htdocs/travelHK.com/zh-hk/worker/driver/sidebar.php"); ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <div id="content">

        <!-- Topbar -->
        <?php require_once("/xampp/htdocs/travelHK.com/zh-hk/worker/driver/topbar.php"); ?>
        <!-- End of Topbar -->

        <div class="container-fluid" style="padding: 0 1.5rem;">
          <div class="row">
            <div class="col-md-12">
              <h3 class="text-secondary">主頁</h3>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="card shadow-sm bd-callout bd-callout-success">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="text-primary">一個月內完成預約次數</div>
                      <div class="text-secondary">404次</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card shadow-sm bd-callout bd-callout-danger">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="text-primary">一個月內取消預約次數</div>
                      <div class="text-secondary">404次</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="card">
                <div class="card-body">
                  <div>
                    <canvas id="halfYearCompleteBookingChart"></canvas>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">
                <div class="card-body">
                  <div>
                    <canvas id="halfYearCancelBookingChart"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>
    <!-- End of Content Wrapper -->

  </div>

</body>

<script>
  const labels = [
    '一月',
    '二月',
    '三月',
    '四月',
    '五月',
    '六月',
  ];

  const halfYearCompleteBooking_data = {
    labels: labels,
    datasets: [{
      label: '完成預約次數',
      backgroundColor: 'rgb(25, 135, 84)',
      borderColor: 'rgb(25, 135, 84)',
      data: [0, 15, 13, 23, 21, 25],
    }]
  };
  const halfYearCancelBooking_data = {
    labels: labels,
    datasets: [{
      label: '留言數據新增數量',
      backgroundColor: 'rgb(220, 53, 69)',
      borderColor: 'rgb(220, 53, 69)',
      data: [0, 3, 1, 2, 0, 5],
    }]
  };

  const halfYearCompleteBooking_config = {
    type: 'line',
    data: halfYearCompleteBooking_data,
    options: {}
  };
  const halfYearCancelBooking_config = {
    type: 'line',
    data: halfYearCancelBooking_data,
    options: {}
  };

  const clickChart = new Chart(
    document.getElementById('halfYearCompleteBookingChart'),
    halfYearCompleteBooking_config
  );
  const commentChart = new Chart(
    document.getElementById('halfYearCancelBookingChart'),
    halfYearCancelBooking_config
  );
</script>


</html>