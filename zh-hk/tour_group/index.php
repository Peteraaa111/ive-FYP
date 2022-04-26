<?php
// Start the SESSION
session_start();
include_once('/xampp/htdocs/travelHK.com/dbConnect.php');
global $conn;
?>

<!DOCTYPE html>
<html lang="zh-HK">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>香港本地旅遊平台 | 本地遊</title>

  <!-- Link the default css and js library -->
  <?php include_once('/xampp/htdocs/travelHK.com/library.php'); ?>
  <link rel="stylesheet" href="/css/itinerary_planner_list.css">
</head>

<body>

  <!-- Header -->
  <?php include_once('/xampp/htdocs/travelHK.com/zh-hk/common/header.php'); ?>

  <!-- Category -->
  <?php include_once('/xampp/htdocs/travelHK.com/zh-hk/common/category.php'); ?>

  <!-- Main Content -->
  <div class="container mt-3">
    <section id="planner_list">
      <?php
      $num_per_page = 6;

      if (isset($_GET['page'])) {
        $page = $_GET['page'];
      } else {
        $page = 1;
      }

      $start_from = ($page - 1) * 6;
      // Get the details of `tourguide_tourgroup`
      $sql = "SELECT *
                FROM `tourguide_tourgroup`
                WHERE `status` = 4
                ORDER BY `cutoff_date` ASC
                LIMIT $start_from, $num_per_page";
      $page_sql = "SELECT *
                FROM `tourguide_tourgroup`
                WHERE `status` = 4
                ORDER BY `cutoff_date` ASC";
      $rs = mysqli_query($conn, $sql);
      while ($rc = mysqli_fetch_assoc($rs)) {
        // Get the details of `itinerary`
        $sql = "SELECT *
                  FROM `itinerary`
                  WHERE `itinerary_id` = {$rc['itinerary_id']}";
        $itinerary_rs = mysqli_query($conn, $sql);
        $itinerary_rc = mysqli_fetch_assoc($itinerary_rs);
        // Get the details of `itinerary_schedule`
        $sql = "SELECT *
                  FROM `itinerary_schedule`
                  WHERE `itinerary_id` = {$itinerary_rc['itinerary_id']}";
        $rs2 = mysqli_query($conn, $sql);
        for ($i=1; $i<=mysqli_num_rows($rs2); $i++) {
          $rc2 = mysqli_fetch_assoc($rs2);
          if ($i == 1) {
            // Get the details of `attraction` - Starting point
            $sql = "SELECT *
                      FROM `attraction`
                      WHERE `attraction_id` = {$rc2['attraction_id']}";
            $rs3 = mysqli_query($conn, $sql);
            $rc3 = mysqli_fetch_assoc($rs3);
            $start = $rc3['attraction_chinese_name'];
          }
          if ($i == mysqli_num_rows($rs2)) {
            // Get the details of `attraction` - Ending point
            $sql = "SELECT *
                      FROM `attraction`
                      WHERE `attraction_id` = {$rc2['attraction_id']}";
            $rs3 = mysqli_query($conn, $sql);
            $rc3 = mysqli_fetch_assoc($rs3);
            $end = $rc3['attraction_chinese_name'];
          }
        }
        // Output the itinerary planner simple information
        echo '
          <div class="row mb-4">
            <div class="col-md-12">
              <a class="card" href="details.php?id='.$rc['tourgroup_id'].'">
                <div class="card-body">
                  <h3 class="card-title">'.$rc['subject'].'</h3>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12">
                        起點: '.$start.'
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        終點: '.$end.'
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 text-end text-muted">
                        截止日期: '.$rc['cutoff_date'].'
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
        ';
      }
      ?>
    </section>
    <section id="pagination">
      <div class="row">
        <div class="col-md-12 d-flex justify-content-center">
          <div id="pagination">
            <?php
            $rs_result = mysqli_query($conn, $page_sql);
            $total_records = mysqli_num_rows($rs_result);
            $total_pages = ceil($total_records / $num_per_page);
            echo '<nav aria-label="Page navigation">
                    <ul class="pagination pagination pagination-lg">';
            
            $pages = $total_pages;
            if ($pages < 6) {
              $start = 2;
            } else if ($page <= 3) {
              $start = 2;
            } else if ($page > $pages - 3) {
              $start = $pages - 3;
            } else {
              $start = $page - 2;
            }
            $output = 1;
            if ($page == 1) {
              echo '<li class="page-item active"><button type="button" class="page-link">' . $output . '</button></li>';
            } else {
              echo '<li class="page-item"><button type="button" class="page-link">' . $output . '</button></li>';
            }
            if ($start > 2) {
              echo '
              <li class="page-item">
                <button type="button" class="page-link" disabled>...</button>
              </li>';
            };
            for ($i = $start; $i < $total_pages; $i++) {
              $output .= $i;
              if ($page == $i) {
                echo '<li class="page-item active"><button type="button" class="page-link">' . $i . '</button></li>';
              } else {
                echo '<li class="page-item"><button type="button" class="page-link">' . $i . '</button></li>';
              }
              if ($i > ($start + 3)) break;
            }
            if ($start < $pages - 3) {
              echo '
              <li class="page-item">
                <button type="button" class="page-link" disabled>...</button>
              </li>';
            };
            if ($page == $total_pages) {
              echo '<li class="page-item active"><button type="button" class="page-link">'.$total_pages.'</button></li>';
            } else {
              echo '<li class="page-item"><button type="button" class="page-link">'.$total_pages.'</button></li>';
            }
            echo '</ul></nav>';
            ?>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- Footer -->
  <?php include_once('/xampp/htdocs/travelHK.com/zh-hk/common/footer.php'); ?>

</body>

<script type="text/javascript">
  $(document).ready(function() {
    $('.slider').slick({
      dots: true,
      infinite: true,
      slidesToShow: 5,
      slidesToScroll: 3,
      prevArrow: '<button class="btn btn-outline-info rounded-pill left-arrow"><i class="fas fa-angle-left"></i></button>',
      nextArrow: '<button class="btn btn-outline-info rounded-pill right-arrow"><i class="fas fa-angle-right"></i></button>'
    });
  });
</script>

</html>