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
    <?php require_once("/xampp/htdocs/travelHK.com/zh-hk/worker/tourist_guide/sidebar.php"); ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <div id="content">

        <!-- Topbar -->
        <?php require_once("/xampp/htdocs/travelHK.com/zh-hk/worker/tourist_guide/topbar.php"); ?>
        <!-- End of Topbar -->

        <div class="container-fluid" style="padding: 0 1.5rem;">
          <div class="row">
            <div class="col-md-12">
              <h3 class="text-secondary">主頁</h3>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="card shadow-sm bd-callout bd-callout-success">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="text-primary">點擊次數</div>
                      <div class="text-secondary">404次</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card shadow-sm bd-callout bd-callout-danger">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="text-primary">留言數量</div>
                      <div class="text-secondary">404則</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card shadow-sm bd-callout bd-callout-info">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="text-primary">旅行團參加人數</div>
                      <div class="text-secondary">404人</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="card">
                <div class="card-body">
                  <div>
                    <canvas id="clickChart"></canvas>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card">
                <div class="card-body">
                  <div>
                    <canvas id="commentChart"></canvas>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card">
                <div class="card-body">
                  <div>
                    <canvas id="tourGroupParticipantChart"></canvas>
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
    '星期一',
    '星期二',
    '星期三',
    '星期四',
    '星期五',
    '星期六',
    '星期日',
  ];

  const click_data = {
    labels: labels,
    datasets: [{
      label: '點擊數據新增數量',
      backgroundColor: 'rgb(25, 135, 84)',
      borderColor: 'rgb(25, 135, 84)',
      data: [0, 5, 10, 20, 3, 7, 25],
    }]
  };
  const comment_data = {
    labels: labels,
    datasets: [{
      label: '留言數據新增數量',
      backgroundColor: 'rgb(220, 53, 69)',
      borderColor: 'rgb(220, 53, 69)',
      data: [10, 32, 25, 50, 64, 25, 42],
    }]
  };
  const tourGroupParticipant_data = {
    labels: labels,
    datasets: [{
      label: '旅行團參加人數數據新增數量',
      backgroundColor: 'rgb(13, 202, 240)',
      borderColor: 'rgb(13, 202, 240)',
      data: [47, 65, 60, 50, 39, 58, 70],
    }]
  };

  const click_config = {
    type: 'line',
    data: click_data,
    options: {}
  };
  const comment_config = {
    type: 'line',
    data: comment_data,
    options: {}
  };
  const tourGroupParticipant_config = {
    type: 'line',
    data: tourGroupParticipant_data,
    options: {}
  };

  const clickChart = new Chart(
    document.getElementById('clickChart'),
    click_config
  );
  const commentChart = new Chart(
    document.getElementById('commentChart'),
    comment_config
  );
  const tourGroupParticipantChartChart = new Chart(
    document.getElementById('tourGroupParticipantChart'),
    tourGroupParticipant_config
  );
</script>


</html>