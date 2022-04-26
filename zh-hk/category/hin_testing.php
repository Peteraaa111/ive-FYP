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
  <script src="/js/log.js"></script>
  <link rel="stylesheet" href="/css/category.css">
</head>

<body>

  <!-- Header -->
  <?php include_once('../common/header.php'); ?>

  <!-- Category -->
  <?php include_once('../common/category.php'); ?>

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
                if (isset($_GET['what']) || isset($_GET['district']) || isset($_GET['cuisine']) || isset($_GET['type'])) {
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
                if (isset($_GET['cuisine'])) {
                  $length = count($_GET['cuisine']);
                  for ($i=0; $i<$length; $i++) {
                    $sql = "SELECT * FROM `cuisine_list` WHERE `cuisine_id` = ".$_GET['cuisine'][$i];
                    $rs = mysqli_query($conn, $sql);
                    $rc = mysqli_fetch_assoc($rs);
                    echo '
                    <span id="'.$rc['cuisine_id'].'" class="badge bg-warning text-black district-label" data="'.$rc['cuisine_id'].'">'.$rc['zh-hk'].'
                    <button type="button" class="btn-close btn-close-white" aria-label="Close"></button>
                    </span>
                    ';
                  }
                }
                if (isset($_GET['type'])) {
                  $length = count($_GET['type']);
                  for ($i=0; $i<$length; $i++) {
                    $sql = "SELECT * FROM `restaurant_type_list` WHERE `type_id` = ".$_GET['type'][$i];
                    $rs = mysqli_query($conn, $sql);
                    $rc = mysqli_fetch_assoc($rs);
                    echo '
                    <span id="'.$rc['type_id'].'" class="badge bg-success district-label" data="'.$rc['type_id'].'">'.$rc['zh-hk'].'
                    <button type="button" class="btn-close btn-close-white" aria-label="Close"></button>
                    </span>
                    ';
                  }
                }
                ?>
              </ul>
              <hr style="border:1px dashed #000; height:1px">
            </div>

            <!-- Test Button -->
            <!-- <section id="test">
              <h6 class="text-secondary">For testing function</h6>
              <button id="clearAll" class="btn btn-danger">Clear all result</button>
              <button id="reload" class="btn btn-danger">Reload</button>
              <button id="changeURL" class="btn btn-danger">Change URL</button>
            </section> -->

            <!-- input selector -->
            <section id="input-selector">
              <h6 class="text-secondary">搜尋餐廳名字</h6>
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
                          FROM `restaurant` r
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
            <hr style="border:1px dashed #000; height:1px">

            <!-- cuisine selector -->
            <section id="cuisine-selector">
              <h6 class="text-secondary">菜式</h6>
              <ul>
                <?php
                $cuisinesql = "SELECT rc.`cuisine_id`, COUNT(rc.`cuisine_id`) as `total`, cl.`zh-hk` AS `chi-name`, cl.`en` AS `en-name`
                        FROM `restaurant_cuisine` rc
                        INNER JOIN `cuisine_list` cl ON rc.`cuisine_id` = cl.`cuisine_id`
                        INNER JOIN `restaurant` r ON rc.`restaurant_id` = r.`restaurant_id`
                        WHERE r.`status` = 1
                        GROUP BY `cuisine_id`
                        ORDER BY `total` DESC LIMIT 5;";
                $cuisine_rs = mysqli_query($conn, $cuisinesql);
                while($cuisine_rc = mysqli_fetch_assoc($cuisine_rs)){
                  echo "<li style=\"list-style-type: none;\">";

                  echo "<a class=\"cuisine-item\" href=\"#\">";

                  echo "<span class=\"cuisine-name\" value=\"".$cuisine_rc['cuisine_id']."\" title=\"".$cuisine_rc['en-name']."\">".$cuisine_rc['chi-name']."</span>";
                  echo "<span class=\"cuisine-total\">(".$cuisine_rc['total'].")</span>";

                  echo "</a>";

                  echo "</li>";
                }
                ?>
              </ul>
            </section>
            <hr style="border:1px dashed #000; height:1px">

            <!-- type selector -->
            <section id="type-selector">
              <h6 class="text-secondary">類別</h6>
              <ul>
                <?php
                $typesql = "SELECT rt.`type_id`, COUNT(rt.`type_id`) as `total`, rtl.`zh-hk` AS `chi-name`, rtl.`en` AS `en-name`
                              FROM `restaurant_type` rt
                              INNER JOIN `restaurant_type_list` rtl ON rt.`type_id` = rtl.`type_id`
                              INNER JOIN `restaurant` r ON rt.`restaurant_id` = r.`restaurant_id`
                              WHERE r.`status` = 1
                              GROUP BY `type_id`
                              ORDER BY `total` DESC LIMIT 5;";
                $type_rs = mysqli_query($conn, $typesql);
                while($type_rc = mysqli_fetch_assoc($type_rs)){
                  echo "<li style=\"list-style-type: none;\">";
                    echo "<a class=\"type-item\" href=\"#\">";
                      echo "<span class=\"type-name\" value=\"".$type_rc['type_id']."\" title=\"".$type_rc['en-name']."\">".$type_rc['chi-name']."</span>";
                      echo "<span class=\"type-total\">(".$type_rc['total'].")</span>";
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
            // Default sql
            $sql = "SELECT DISTINCT r.`restaurant_id` AS `id`, r.`restaurant_chinese_name` AS `chi-name`, r.`chinese_address` AS `chi-address`, rtl.`zh-hk` AS `typeName`, cl.`zh-hk` AS `cuisineName`
                        FROM `restaurant` r
                        INNER JOIN `restaurant_type` rt ON r.`restaurant_id` = rt.`restaurant_id`
                        INNER JOIN `restaurant_cuisine` rc ON r.`restaurant_id` = rc.`restaurant_id`
                        INNER JOIN `restaurant_type_list` rtl ON rt.`type_id` = rtl.`type_id`
                        INNER JOIN `cuisine_list` cl ON rc.`cuisine_id` = cl.`cuisine_id`
                        WHERE `status` = 1
                        GROUP BY `id`";
            
            $hasWhat = isset($_GET['what']);
            $hasDistrict = isset($_GET['district']);
            $hasCuisine = isset($_GET['cuisine']);
            $hasType = isset($_GET['type']);
            // Check if has search request
            if ($hasWhat || $hasDistrict || $hasCuisine || $hasType) {
              
              // Initial the sql for WHERE clause
              $sql = "SELECT
                        r.`restaurant_id` AS `id`,
                        r.`restaurant_chinese_name` AS `chi-name`,
                        r.`chinese_address` AS `chi-address`,
                        hkd.`zh-hk` AS `district`,
                        rtl.`zh-hk` AS `typeName`,
                        cl.`zh-hk` AS `cuisineName`
                      FROM `restaurant` r
                      INNER JOIN `hong_kong_district` hkd ON r.`district` = hkd.`district_id`
                      INNER JOIN `restaurant_type` rt ON r.`restaurant_id` = rt.`restaurant_id`
                      INNER JOIN `restaurant_cuisine` rc ON r.`restaurant_id` = rc.`restaurant_id`
                      INNER JOIN `restaurant_type_list` rtl ON rt.`type_id` = rtl.`type_id`
                      INNER JOIN `cuisine_list` cl ON rc.`cuisine_id` = cl.`cuisine_id`
                      WHERE `status` = 1 AND ";
              if ($hasWhat) {
                $sql .= "r.restaurant_chinese_name LIKE '%".$_GET['what']."%'";
                if ($hasDistrict || $hasCuisine || $hasType) {
                  $sql .= " AND ";
                }
              }
              if ($hasDistrict) {
                $length = count($_GET['district']);
                for ($i=0; $i<$length; $i++) {
                  $sql .= "r.`district` = '".$_GET['district'][$i]."'";
                  if (isset($_GET['district'][$i+1])) {
                    $sql .= " OR ";
                  }
                }
                if ($hasCuisine || $hasType) {
                  $sql .= " AND ";
                }
              }
              if ($hasCuisine) {
                $length = count($_GET['cuisine']);
                for ($i=0; $i<$length; $i++) {
                  $sql .= "rc.`cuisine_id` = '".$_GET['cuisine'][$i]."'";
                  if (isset($_GET['cuisine'][$i+1])) {
                    $sql .= " OR ";
                  }
                }
                if ($hasType) {
                  $sql .= " AND ";
                }
              }
              if ($hasType) {
                $length = count($_GET['type']);
                for ($i=0; $i<$length; $i++) {
                  $sql .= "rtl.`type_id` = '".$_GET['type'][$i]."'";
                  if (isset($_GET['type'][$i+1])) {
                    $sql .= " OR ";
                  }
                }
              }
              $sql .= " GROUP BY `id`";
            }

            $rs = mysqli_query($conn, $sql);
            while ($rc = mysqli_fetch_assoc($rs)) {
              $cuisines = '';
              $cSql = "SELECT list.`zh-hk`, list.`en`
                          FROM `restaurant_cuisine` cuisine
                          INNER JOIN `cuisine_list` list ON list.`cuisine_id` = cuisine.`cuisine_id`
                          WHERE cuisine.`restaurant_id` = ".$rc['id'];
              $crs = mysqli_query($conn, $cSql);
              while ($crc = mysqli_fetch_assoc($crs)) {
                $cuisines .= $crc['zh-hk']." / ";
              }
              $cuisines = trim($cuisines, " / ");

              $types = '';
              $tSql = "SELECT list.`zh-hk`, list.`en`
                          FROM `restaurant_type` type
                          INNER JOIN `restaurant_type_list` list ON list.`type_id` = type.`type_id`
                          WHERE type.`restaurant_id` = ".$rc['id'];
              $trs = mysqli_query($conn, $tSql);
              while ($trc = mysqli_fetch_assoc($trs)) {
                $types .= $trc['zh-hk']." / ";
              }
              $types = trim($types, " / ");

              // if the user has logged in, add the log function
              $onclick = "";
              if (isset($_SESSION['user_id'])) {
                $onclick = 'log('.$_SESSION['user_id'].', '.$rc['id'].', \'CLICK\', \'\', \'restaurant\')';
              }
              echo '
              <li style="list-style-type: none";>
                <a href="/'.$_COOKIE['lang'].'/r_details.php?id='.$rc['id'].'" onclick="'.$onclick.'">
                  <div class="card" style="margin-bottom: 10px;">

                        <div class="row g-0">
                          <div class="col-md-4" style="height: 160px;">
                            <img src="/data/site/restaurant/'.$rc['id'].'/storefront.jpg" class="img-fluid rounded-start" style="height: 100%;"></img>
                          </div>

                          <div class="col-md-8">
                            <div class="card-body">
                              <h5 class="card-title fw-bold">'.$rc['chi-name'].'</h5>
                              <div class="address">
                                <i class="fas fa-map-marker-alt"></i>
                                <span class="ms-1">'.$rc['chi-address'].'</span>
                              </div>
                              <div class="cuisines">
                                <i class="fas fa-utensils"></i>
                                <span class="ms-1">'.$cuisines.'</span>
                              </div>
                              <div class="types">
                                <i class="fas fa-bookmark"></i>
                                <span class="ms-1">'.$types.'</span>
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
      </div><br>
      <ul class="pagination justify-content-center">
        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item"><a class="page-link" href="#">Next</a></li>
      </ul>

    </div>
  </div>

  <!-- Footer -->
  <?php include_once('../common/footer.php'); ?>
</body>

</html>