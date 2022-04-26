<?php
session_start();

require_once('/xampp/htdocs/travelHK.com/dbConnect.php');
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
  <link rel="stylesheet" href="/css/itinerary_planner_list.css">
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

        <div class="container mt-3">

          <section id="create_planner">
            <div class="row mb-2">
              <div class="col-md-12 text-end">
                <a href="itinerary_planner.php" class="btn btn-success">
                  <i class="fas fa-plus-square me-2"></i>
                  <span>創建新行程規劃</span>
                </a>
              </div>
            </div>
          </section>

          <section id="planner_list">
            <?php
            $num_per_page = 6;

            if (isset($_GET['page'])) {
              $page = $_GET['page'];
            } else {
              $page = 1;
            }
            
            $start_from = ($page - 1) * 6;
            // Get the details of `itinerary`
            $sql = "SELECT *
                      FROM `itinerary`
                      WHERE `account_id` = {$_SESSION['guide_id']}
                      ORDER BY `itinerary_id` ASC
                      LIMIT $start_from, $num_per_page";
            $page_sql = "SELECT *
                          FROM `itinerary`
                          WHERE `account_id` = {$_SESSION['guide_id']}
                          ORDER BY `itinerary_id` ASC";
            $rs = mysqli_query($conn, $sql);
            while ($rc = mysqli_fetch_assoc($rs)) {
              // Get the details of `itinerary_schedule`
              $sql = "SELECT *
                        FROM `itinerary_schedule`
                        WHERE `itinerary_id` = {$rc['itinerary_id']}";
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
                      <a class="card" href="create_details.php?id='.$rc['itinerary_id'].'">
                        <div class="card-body">
                          <h3 class="card-title">'.$rc['itinerary_chinese_name'].'</h3>
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
                                最後更新日期: '.$rc['create_datetime'].'
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
                    echo '<li class="page-item active"><a class="page-link" href="create.php?page='.$output.'">' . $output . '</a></li>';
                  } else {
                    echo '<li class="page-item"><a class="page-link" href="create.php?page='.$output.'">' . $output . '</a></li>';
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
                      echo '<li class="page-item active"><a class="page-link" href="create.php?page='.$i.'">' . $i . '</a></li>';
                    } else {
                      echo '<li class="page-item"><a class="page-link" href="create.php?page='.$i.'">' . $i . '</a></li>';
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
                    echo '<li class="page-item active"><a class="page-link" href="create.php?page='.$total_pages.'">'.$total_pages.'</a></li>';
                  } else {
                    echo '<li class="page-item"><a class="page-link" href="create.php?page='.$total_pages.'">'.$total_pages.'</a></li>';
                  }
                  echo '</ul></nav>';
                  ?>
                </div>
              </div>
            </div>
          </section>

        </div>

      </div>

    </div>
    <!-- End of Content Wrapper -->

  </div>

</body>

</html>