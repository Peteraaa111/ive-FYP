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
    <?php require_once("common/sidebar.php"); ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <div id="content">

        <!-- Topbar -->
        <?php require_once("common/topbar.php"); ?>
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
                      <div class="text-primary">景點數量</div>
                      <div class="text-secondary">404間</div>
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
                      <div class="text-primary">餐廳數量</div>
                      <div class="text-secondary">404間</div>
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
                      <div class="text-primary">民宿數量</div>
                      <div class="text-secondary">404間</div>
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
                    <canvas id="attractionChart"></canvas>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card">
                <div class="card-body">
                  <div>
                    <canvas id="restaurantChart"></canvas>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card">
                <div class="card-body">
                  <div>
                    <canvas id="guesthouseChart"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <canvas id="totalGeneralUserChart"></canvas>
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

  const attraction_data = {
    labels: labels,
    datasets: [{
      label: '景點數據新增數量',
      backgroundColor: 'rgb(25, 135, 84)',
      borderColor: 'rgb(25, 135, 84)',
      data: [0, 5, 10, 20, 3, 7, 25],
    }]
  };
  const restaurant_data = {
    labels: labels,
    datasets: [{
      label: '餐廳數據新增數量',
      backgroundColor: 'rgb(220, 53, 69)',
      borderColor: 'rgb(220, 53, 69)',
      data: [10, 32, 25, 50, 64, 25, 42],
    }]
  };
  const guesthouse_data = {
    labels: labels,
    datasets: [{
      label: '民宿數據新增數量',
      backgroundColor: 'rgb(13, 202, 240)',
      borderColor: 'rgb(13, 202, 240)',
      data: [47, 65, 60, 50, 39, 58, 70],
    }]
  };
  const registrationGeneralUser_data = {
    labels: labels,
    datasets: [{
      label: '用戶註冊數量',
      backgroundColor: 'rgb(13, 110, 253)',
      borderColor: 'rgb(13, 110, 253)',
      data: [28, 41, 35, 78, 50, 80, 88],
    }]
  }

  const attraction_config = {
    type: 'line',
    data: attraction_data,
    options: {}
  };
  const restaurant_config = {
    type: 'line',
    data: restaurant_data,
    options: {}
  };
  const guesthouse_config = {
    type: 'line',
    data: guesthouse_data,
    options: {}
  };
  const registrationGeneralUser_config = {
    type: 'line',
    data: registrationGeneralUser_data,
    options: {}
  };

  const attractionChart = new Chart(
    document.getElementById('attractionChart'),
    attraction_config
  );
  const restaurantChart = new Chart(
    document.getElementById('restaurantChart'),
    restaurant_config
  );
  const guesthouseChart = new Chart(
    document.getElementById('guesthouseChart'),
    guesthouse_config
  );
  const totalGeneralUserChart = new Chart(
    document.getElementById('totalGeneralUserChart'),
    registrationGeneralUser_config
  );
</script>


</html>