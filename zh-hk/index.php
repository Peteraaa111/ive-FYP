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
  <link rel="stylesheet" href="/css/category_slick.css">
  <link rel="stylesheet" href="/css/card.css">
</head>

<body>

  <!-- Header -->
  <?php include_once('common/header.php'); ?>

  <!-- Category -->
  <?php include_once('common/category.php'); ?>

  <!-- Main Content -->
  <div class="container mt-3">

    <!-- Search bar -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <!-- Card body -->
            <div class="row">
              <div class="col-md-10">
                <form>
                  <div class="input-group">
                    <input type="text" class="form-control" name="search-txt" id="search-txt" placeholder="搜尋...">
                    <button type="button" class="btn btn-outline-primary" id="search-btn">
                      <i class="fas fa-search"></i>
                    </button>
                  </div>
                </form>
              </div>
              <div class="col-md-1">
                <div class="d-grid gap-2">
                  <a href="#" class="btn btn-info">進階</a>
                </div>
              </div>
              <div class="col-md-1">
                <div class="d-grid gap-2">
                  <a href="map_view.php" class="btn btn-secondary">
                    <i class="fas fa-map-marked-alt"></i>
                  </a>
                </div>
              </div>
            </div>
          </div> <!-- End of card-body -->
        </div>
      </div>
    </div>

    <!-- Slide show row -->
    <div class="row mb-3">
      <div class="col-md-12">

        <!-- Slide show -->
        <div id="carouselExampleIndicators" class="carousel slide mt-3" data-bs-ride="carousel">

          <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
          </div>

          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="../assets/img/banner/banner1.png" class="d-block w-100" alt="test1">
            </div>
            <div class="carousel-item">
              <img src="../assets/img/banner/banner2.png" class="d-block w-100" alt="test2">
            </div>
            <div class="carousel-item">
              <img src="../assets/img/banner/banner3.png" class="d-block w-100" alt="test3">
            </div>
          </div>

          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>

      </div>
    </div>

    <!-- Attraction Category -->
    <div class="row mb-2">
      <div class="col-md-12">
        <h5 class="pb-2 bg-light border-bottom border-3 border-info">香港熱門景點類型</h5>
      </div>
    </div>
    <div class="row mb-2">
      <div class="col-md-12">
        <div class="slider">
          <a href="#">
            <div class="card">
              <img src="/assets/img/category/attraction/park.jpg" alt="park" class="card-img-top img-thumbnail">
              <div class="card-body">
                <h5 class="card-title">公園</h5>
              </div>
            </div>
          </a>
          <a href="#">
            <div class="card">
              <img src="/assets/img/category/attraction/hiking.jpg" alt="park" class="card-img-top img-thumbnail">
              <div class="card-body">
                <h5 class="card-title">行山</h5>
              </div>
            </div>
          </a>
          <a href="#">
            <div class="card">
              <img src="/assets/img/category/attraction/historical_landmark.jpg" alt="park" class="card-img-top img-thumbnail">
              <div class="card-body">
                <h5 class="card-title">歷史古蹟</h5>
              </div>
            </div>
          </a>
          <a href="#">
            <div class="card">
              <img src="/assets/img/category/attraction/temple.jpg" alt="park" class="card-img-top img-thumbnail">
              <div class="card-body">
                <h5 class="card-title">廟宇</h5>
              </div>
            </div>
          </a>
          <a href="#">
            <div class="card">
              <img src="/assets/img/category/attraction/theme_park.jpg" alt="park" class="card-img-top img-thumbnail">
              <div class="card-body">
                <h5 class="card-title">主題樂園</h5>
              </div>
            </div>
          </a>
          <a href="#">
            <div class="card">
              <img src="/assets/img/category/attraction/museum.jpg" alt="park" class="card-img-top img-thumbnail">
              <div class="card-body">
                <h5 class="card-title">博物館</h5>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>

    <!-- Attraction recommendation -->
    <section id="attraction_recommendation" class="recommendation mb-2">
      <?php
      if (isset($_SESSION['user_id'])) {
        include_once('/xampp/htdocs/travelHK.com/recommendationAi_attraction.php');
        $result = personalized($_SESSION['user_id'], 9);
        echo '
          <div class="row mb-2">
            <div class="col-md-12">
              <h5 class="pb-2 bg-light border-bottom border-3 border-info">你可能感興趣的景點</h5>
            </div>
          </div>
          <div class="row row-cols-1 row-cols-md-3 g-4">';

        $sql = "SELECT DISTINCT a.`attraction_id` AS `id`, a.`attraction_chinese_name` AS `chi-name`, a.`chinese_address` AS `chi-address`, list.`zh-hk` AS `typeName`
                  FROM `attraction` a
                  INNER JOIN `attraction_type` aty ON a.`attraction_id` = aty.`attraction_id`
                  INNER JOIN `attraction_type_list` list ON aty.`type_id` = list.`type_id`
                  WHERE `status` = 1 AND ";
        for ($i=0; $i<9; $i++) {
          $sql .= "a.`attraction_id` = " . $result[$i]['recommendedItemId'];
          if ($i != 8) {
            $sql .= " OR ";
          }
        }
        $rs = mysqli_query($conn, $sql);
        while ($rc = mysqli_fetch_assoc($rs)) {
          $types = '';
          $tSql = "SELECT list.`zh-hk`, list.`en`
                      FROM `attraction_type` type
                      INNER JOIN `attraction_type_list` list ON list.`type_id` = type.`type_id`
                      WHERE type.`attraction_id` = ".$rc['id'];
          $trs = mysqli_query($conn, $tSql);
          while ($trc = mysqli_fetch_assoc($trs)) {
            $types .= $trc['zh-hk']." / ";
          }
          $types = trim($types, " / ");

          echo '
          <div class="col">
            <a href="a_details.php?id='.$rc['id'].'" class="card">
              <img src="/data/site/attraction/'.$rc['id'].'/banner.jpg" class="img-fluid rounded-start"></img>
              <div class="card-body">
                <h5 class="card-title fw-bold">'.$rc['chi-name'].'</h5>
                <div class="address">
                  <i class="fas fa-map-marker-alt"></i>
                  <span class="ms-1">'.$rc['chi-address'].'</span>
                </div>
                <div class="types">
                  <i class="fas fa-bookmark"></i>
                  <span class="ms-1">'.$types.'</span>
                </div>
              </div>
            </a>
          </div>
          ';
        }
        echo '</div>';
      } else {
        echo '
          <div class="row mb-2">
            <div class="col-md-12">
              <h5 class="pb-2 bg-light border-bottom border-3 border-info">熱門景點</h5>
            </div>
          </div>
          <div class="row row-cols-1 row-cols-md-3 g-4">
        ';
        $sql = "SELECT DISTINCT a.`attraction_id` AS `id`, a.`attraction_chinese_name` AS `chi-name`, a.`chinese_address` AS `chi-address`, list.`zh-hk` AS `typeName`
                  FROM `attraction` a
                  INNER JOIN `attraction_type` aty ON a.`attraction_id` = aty.`attraction_id`
                  INNER JOIN `attraction_type_list` list ON aty.`type_id` = list.`type_id`
                  WHERE `status` = 1
                  GROUP BY `id`
                  LIMIT 9";
        $rs = mysqli_query($conn, $sql);
        while ($rc = mysqli_fetch_assoc($rs)) {
          $types = '';
          $tSql = "SELECT list.`zh-hk`, list.`en`
                      FROM `attraction_type` type
                      INNER JOIN `attraction_type_list` list ON list.`type_id` = type.`type_id`
                      WHERE type.`attraction_id` = ".$rc['id'];
          $trs = mysqli_query($conn, $tSql);
          while ($trc = mysqli_fetch_assoc($trs)) {
            $types .= $trc['zh-hk']." / ";
          }
          $types = trim($types, " / ");

          echo '
          <div class="col">
            <a href="a_details.php?id='.$rc['id'].'" class="card">
              <img src="/data/site/attraction/'.$rc['id'].'/banner.jpg" class="img-fluid rounded-start"></img>
              <div class="card-body">
                <h5 class="card-title fw-bold">'.$rc['chi-name'].'</h5>
                <div class="address">
                  <i class="fas fa-map-marker-alt"></i>
                  <span class="ms-1">'.$rc['chi-address'].'</span>
                </div>
                <div class="types">
                  <i class="fas fa-bookmark"></i>
                  <span class="ms-1">'.$types.'</span>
                </div>
              </div>
            </a>
          </div>
          ';
        }
        echo '</div>';
      }
      ?>
    </section>

    <!-- Restaurant recommendation -->
    <section id="restaurant_recommendation" class="recommendation mb-2">
      <?php
      if (isset($_SESSION['user_id'])) {
        include_once('/xampp/htdocs/travelHK.com/recommendationAi_restaurant.php');
        $result = restaurant_personalized($_SESSION['user_id'], 9);
        echo '
          <div class="row mb-2">
            <div class="col-md-12">
              <h5 class="pb-2 bg-light border-bottom border-3 border-info">你可能感興趣的餐廳</h5>
            </div>
          </div>
          <div class="row row-cols-1 row-cols-md-3 g-4">
        ';

        $sql = "SELECT DISTINCT r.`restaurant_id` AS `id`, r.`restaurant_chinese_name` AS `chi-name`, r.`chinese_address` AS `chi-address`
                  FROM restaurant r
                  WHERE `status` = 1 AND ";
        for ($i=0; $i<9; $i++) {
          $sql .= "r.`restaurant_id` = " . $result[$i]['recommendedItemId'];
          if ($i != 8) {
            $sql .= " OR ";
          }
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

          echo '
          <div class="col">
            <a href="r_details.php?id='.$rc['id'].'" class="card">
              <img src="/data/site/restaurant/'.$rc['id'].'/banner.jpg" class="img-fluid rounded-start"></img>
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
            </a>
          </div>
          ';
        }
        echo '</div>';
      } else {
        echo '
          <div class="row mb-2">
            <div class="col-md-12">
              <h5 class="pb-2 bg-light border-bottom border-3 border-info">熱門餐廳</h5>
            </div>
          </div>
          <div class="row row-cols-1 row-cols-md-3 g-4">
        ';
        $sql = "SELECT DISTINCT r.`restaurant_id` AS `id`, r.`restaurant_chinese_name` AS `chi-name`, r.`chinese_address` AS `chi-address`, rtl.`zh-hk` AS `typeName`, cl.`zh-hk` AS `cuisineName`
                    FROM restaurant r
                    INNER JOIN `restaurant_type` rt ON r.`restaurant_id` = rt.`restaurant_id`
                    INNER JOIN `restaurant_cuisine` rc ON r.`restaurant_id` = rc.`restaurant_id`
                    INNER JOIN `restaurant_type_list` rtl ON rt.`type_id` = rtl.`type_id`
                    INNER JOIN `cuisine_list` cl ON rc.`cuisine_id` = cl.`cuisine_id`
                    WHERE `status` = 1
                    GROUP BY `id`
                    LIMIT 9";
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

          echo '
          <div class="col">
            <a href="r_details.php?id='.$rc['id'].'" class="card">
              <img src="/data/site/restaurant/'.$rc['id'].'/banner.jpg" class="img-fluid rounded-start"></img>
              <div class="card-body">
                <h5 class="card-title fw-bold">'.$rc['chi-name'].'</h5>
                <div class="address">
                  <i class="fas fa-map-marker-alt"></i>
                  <span class="ms-1">'.$rc['chi-address'].'</span>
                </div>
                <div class="types">
                  <i class="fas fa-bookmark"></i>
                  <span class="ms-1">'.$types.'</span>
                </div>
              </div>
            </a>
          </div>
          ';
        }
        echo '</div>';
      }
      ?>
    </section>

  </div>

  <!-- Footer -->
  <?php include_once('common/footer.php'); ?>

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