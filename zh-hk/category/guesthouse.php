<?php
// Start the SESSION
session_start();

// Get database connection variable
include_once('/xampp/htdocs/travelHK.com/dbConnect.php');
global $conn;

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>香港本地旅遊平台 | 本地遊</title>

  <!-- Link the default css and js library -->
  <?php include_once('/xampp/htdocs/travelHK.com/library.php'); ?>

  <script src="/js/category.js"></script>
  <link rel="stylesheet" href="/css/category.css">
</head>

<body>

  <!-- Header -->
  <?php include_once('/xampp/htdocs/travelHK.com/zh-hk/common/header.php'); ?>

  <!-- Category -->
  <?php include_once('/xampp/htdocs/travelHK.com/zh-hk/common/category.php'); ?>

  <!-- Main Content -->
  <div class="container mt-3">

    <div class="row">

      <div class="col-md-3">
        
        <div class="card">
          <div class="card-body">

            <!-- Selected label / Searched key word -->
            <div id="selected-label" class="hidden">
              <ul class="selected-badge">
                <h6 class="text-secondary">已選標籤</h6>
                <?php
                if (isset($_GET['what']) || isset($_GET['district'])) {
                  echo "<script> $('#selected-label').show(); </script>";
                }
                if (isset($_GET['what'])) {
                  echo '
                  <span id="search-label" class="badge bg-secondary" data="'.$_GET['what'].'">'.$_GET['what'].'
                  <button type="button" class="btn-close btn-close-white" aria-label="Close"></button>
                  </span>
                  ';
                }
                if (isset($_GET['district'])) {
                  $length = count($_GET['district']);
                  for ($i=0; $i<$length; $i++) {
                    $sql = "SELECT * FROM `hong_kong_district` WHERE `district_id` = ".$_GET['district'][$i];
                    $rs = mysqli_query($conn, $sql);
                    $rc = mysqli_fetch_assoc($rs);
                    echo '
                    <span id="'.$rc['district_id'].'" class="badge bg-info text-black district-label" data="'.$rc['district_id'].'">'.$rc['zh-hk'].'
                    <button type="button" class="btn-close btn-close-white" aria-label="Close"></button>
                    </span>
                    ';
                  }
                }
                ?>
              </ul>
              <hr style="border:1px dashed #000; height:1px">
            </div>

            <!-- input selector -->
            <section id="input-selector">
              <h6 class="text-secondary">搜尋民宿名字</h6>
              <div class="input-group">
                <input type="text" class="form-control" id="search-input" name="search" value="<?php if(isset($_GET['what'])){echo $_GET['what'];} ?>" placeholder="輸入關鍵字">
                <button id="search-btn" type="button" class="btn btn-outline-secondary"><i class="fas fa-search"></i></button>
              </div>
            </section>
            <hr style="border:1px dashed #000; height:1px">

            <!-- District selector -->
            <section id="district-selector">
              <h6 class="text-secondary">地區</h6>
              <ul>
                <?php
                $districtsql = "SELECT `district`, hkd.`zh-hk` as `name`, Count(`district`) as `total`
                          FROM `guesthouse` r
                          INNER JOIN `hong_kong_district` hkd ON r.`district` = hkd.`district_id`
                          WHERE r.`status` = 1
                          GROUP BY `district`
                          ORDER BY `total` DESC LIMIT 5;";
                $district_rs = mysqli_query($conn, $districtsql);
                while($district_rc = mysqli_fetch_assoc($district_rs)){
                  echo "<li style=\"list-style-type: none;\">";

                  echo "<a class=\"district-item\" href=\"#\">";

                  echo "<span class=\"district-name\" value=\"".$district_rc['district']."\">".$district_rc['name']."</span>";
                  echo "<span class=\"district-total\">(".$district_rc['total'].")</span>";

                  echo "</a>";

                  echo "</li>";
                }
                ?>
              </ul>
            </section>
          </div>
        </div> <!-- End of Card -->

      </div> <!-- End of col-md-3 -->

      <div class="col-md-6">
        <ul id="result" onload="search();">
          <?php
          $num_per_page = 6;

          if (isset($_GET['page'])) {
            $page = $_GET['page'];
          } else {
            $page = 1;
          }
          
          $start_from = ($page - 1) * 6;
          // Default sql
          $sql = "SELECT DISTINCT `guesthouse_id` AS `id`, `guesthouse_chinese_name` AS `chi-name`, `chinese_address` AS `chi-address`
                    FROM `guesthouse`
                    WHERE `status` = 1
                    GROUP BY `id`
                    LIMIT $start_from, $num_per_page";
          $page_sql = "SELECT DISTINCT `guesthouse_id` AS `id`, `guesthouse_chinese_name` AS `chi-name`, `chinese_address` AS `chi-address`
                    FROM `guesthouse`
                    WHERE `status` = 1
                    GROUP BY `id`";
          
          $hasWhat = isset($_GET['what']);
          $hasDistrict = isset($_GET['district']);
          // Check if has search request
          if ($hasWhat || $hasDistrict) {
            
            // Initial the sql for WHERE clause
            $sql = "SELECT DISTINCT
                      `guesthouse_id` AS `id`,
                      `guesthouse_chinese_name` AS `chi-name`,
                      `chinese_address` AS `chi-address`
                    FROM `guesthouse` g
                    INNER JOIN `hong_kong_district` hkd ON g.`district` = hkd.`district_id`
                    WHERE `status` = 1 AND ";
            if ($hasWhat) {
              $sql .= "g.`guesthouse_chinese_name` LIKE '%".$_GET['what']."%'";
              if ($hasDistrict) {
                $sql .= " AND ";
              }
            }
            if ($hasDistrict) {
              $length = count($_GET['district']);
              for ($i=0; $i<$length; $i++) {
                $sql .= "g.`district` = '".$_GET['district'][$i]."'";
                if (isset($_GET['district'][$i+1])) {
                  $sql .= " OR ";
                }
              }
            }
            $sql .= " GROUP BY `id`";
            $page_sql = $sql;
            $sql .= " LIMIT $start_from, $num_per_page";
          }

          $rs = mysqli_query($conn, $sql);
          while ($rc = mysqli_fetch_assoc($rs)) {
            echo '
            <li style="list-style-type: none";>
              <a href="/'.$_COOKIE['lang'].'/g_details.php?id='.$rc['id'].'">
                <div class="card" style="margin-bottom: 10px;">

                      <div class="row g-0">
                        <div class="col-md-4" style="height: 160px;">
                          <img src="/data/site/guesthouse/'.$rc['id'].'/banner.jpg" class="img-fluid rounded-start" style="height: 100%;"></img>
                        </div>

                        <div class="col-md-8">
                          <div class="card-body">
                            <h5 class="card-title fw-bold">'.$rc['chi-name'].'</h5>
                            <div class="address">
                              <i class="fas fa-map-marker-alt"></i>
                              <span class="ms-1">'.$rc['chi-address'].'</span>
                            </div>
                          </div>
                          
                        </div>
                      </div>

                </div> <!-- End of card -->
              </a>
            </li>
            '; // End of echo
          }
          ?>
        </ul>
      </div>

    </div>
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
  </div>

  <!-- Footer -->
  <?php include_once('/xampp/htdocs/travelHK.com/zh-hk/common/footer.php'); ?>
</body>

</html>