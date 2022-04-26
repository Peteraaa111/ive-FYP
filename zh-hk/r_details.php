<?php
// Start the SESSION
session_start();

// Get database connection variable
include_once('/xampp/htdocs/travelHK.com/dbConnect.php');
global $conn;

// Get the restaurant id
$restaurant_id = $_GET['id'];

// Get the restaurant details
$details_sql = "SELECT * FROM `restaurant` WHERE `restaurant_id` = $restaurant_id;";
$details_rs = mysqli_query($conn, $details_sql);
$details = mysqli_fetch_assoc($details_rs);

// Get the equipment
$equipment_sql = "SELECT * FROM `restaurant_equipment` WHERE `restaurant_id` = $restaurant_id;";
$equipment_rs = mysqli_query($conn, $equipment_sql);
$equipments = array();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $details['restaurant_chinese_name']; ?> - 香港本地旅遊平台 | 本地遊</title>



  <!-- Link the default css and js library -->
  <?php include_once('/xampp/htdocs/travelHK.com/library.php'); ?>

  <link rel="stylesheet" href="/css/r_details.css">
  <link rel="stylesheet" href="/css/card.css">
  <!-- chat box javascript  -->
  <script src="/lib/ckeditor_4.17.2/ckeditor.js"></script>
  <script src="/js/chatbox.js"></script>
  <script src="/js/details.js"></script>
</head>

<body>

  <!-- Header -->
  <?php include_once('common/header.php'); ?>

  <!-- Category -->
  <?php include_once('common/category.php'); ?>

  <!-- Main Content -->
  <section id="banner" class="padding-4rem mb-4">
    <div id="banner-background" class="bg-dark rounded-3" style="background-image: url(/data/site/restaurant/<?php echo $details['restaurant_id']; ?>/banner.jpg);"></div>
    <div id="banner-info" class="container py-5">
      <div class="row">
        <div class="col-md-12 text-center">
          <h1 class="fw-bold">
            <?php echo $details['restaurant_chinese_name']; ?> 
          </h1>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 text-center">
          <h2>
            <?php echo $details['restaurant_english_name']; ?>
          </h2>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 text-center">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star-half-alt"></i>
          <i class="far fa-star"></i>
          <a id="showtext" style="margin-left:5px" href="r_review.php?id=<?php echo $restaurant_id;?>">
            <img src="/assets/img/web_logo/review2.png" title="寫食評" alt="寫食評" width="40" height="40"> 
          </a>
        </div>
      </div>
      <?php
      if (isset($_SESSION['user_id']) && $details['partner_id'] != null) {
        echo '
        <div class="row mt-4">
          <div class="col-md-12 text-center">
            <a href="r_booking.php?id='.$details['restaurant_id'].'" class="btn btn-primary fw-bold fs-5">座位預約</a>
          </div>
        </div>
        ';
      }
      ?>
    </div>
  </section>

  <section id="information" class="mb-4">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <div id="r_info" class="card">
            <div class="card-body">
              <h5 class="card-title fw-bold">餐廳資訊</h5>
              <hr class="py-1">
              <h6 class="fw-bold">地址</h6>
              <button id="chi-map-btn" type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#map-modal" onclick="">
                <?php echo $details['chinese_address']; ?>
              </button>
              <button id="eng-map-btn" type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#map-modal" onclick="">
                <?php echo $details['english_address']; ?>
              </button>

              <!-- Get the latitude & longitude for loading map -->
              <?php echo "<input type='hidden' id='latitude' value='".$details['latitude']."' />"; ?>
              <?php echo "<input type='hidden' id='longitude' value='".$details['longitude']."' />"; ?>

              <hr>
              <h6 class="fw-bold">聯絡方法</h6>
              <p>電話: <?php echo $details['phone_number']; ?></p>
              <?php
              if ($details['email'] != '') {
                echo '
                <p>電郵: '.$details['email'].'</p>
                ';
              }
              ?>
              <hr>
              <h6 class="fw-bold">營業時間</h6>
              <div class="row">
                <div class="col-4">
                  星期一至五:
                </div>
                <div class="col">
                  <?php
                  if ($details['weekday_business_hours'] == "closed") {
                    echo "全日休息";
                  } else {
                    echo $details['weekday_business_hours'];
                  }
                  ?>
                </div>
              </div>
              <div class="row">
                <div class="col-4">
                  星期六至日:
                </div>
                <div class="col">
                  <?php
                  if ($details['weekend_business_hours'] == "closed") {
                    echo "全日休息";
                  } else {
                    echo $details['weekend_business_hours'];
                  }
                  ?>
                </div>
              </div>
              <div class="row">
                <div class="col-4">
                  公眾假期:
                </div>
                <div class="col">
                <?php
                  if ($details['holiday_business_hours'] == "closed") {
                    echo "全日休息";
                  } else {
                    echo $details['holiday_business_hours'];
                  }
                  ?>
                </div>
              </div>
              <hr>
              <h6 class="fw-bold">其他資料</h6>
              <span>未有資料</span>
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="card">
            <div id="r_photos" class="card-body">
              <h5 class="card-title fw-bold">餐廳照片</h5>
              <hr class="py-1">
              <div class="photos">
                <ul class="list">
                  <li class="item">
                    <a href="#">
                      <div class="content" style="background-image: url(/assets/img/test-only/restaurant/200x200.png);"></div>
                    </a>
                  </li>
                  <li class="item">
                    <a href="#">
                      <div class="content" style="background-image: url(/assets/img/test-only/restaurant/200x200.png);"></div>
                    </a>
                  </li>
                  <li class="item">
                    <a href="#">
                      <div class="content" style="background-image: url(/assets/img/test-only/restaurant/200x200.png);"></div>
                    </a>
                  </li>
                  <li class="item">
                    <a href="#">
                      <div class="content" style="background-image: url(/assets/img/test-only/restaurant/200x200.png);"></div>
                    </a>
                  </li>
                  <li class="item">
                    <a href="#">
                      <div class="content" style="background-image: url(/assets/img/test-only/restaurant/200x200.png);"></div>
                    </a>
                  </li>
                  <li class="item">
                    <a href="#">
                      <div class="content" style="background-image: url(/assets/img/test-only/restaurant/200x200.png);"></div>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="review" class="mb-4">  
    <div class="container">
      <div class="row">
        <div class="col-md-12">      
            <?php
            $sql = "SELECT rc.`restaurant_id`, rc.`content`, rc.`create_datetime` AS `date`, a.`nickname` AS `name`, rc.title,rc.comment_id,rc.taste_rating,rc.environment_rating,rc.service_rating,rc.hygiene_rating, rc.date_of_visit, rc.dining_method,
            rc.status
                    FROM `restaurant_comment` rc
                    INNER JOIN `account` a ON rc.`account_id` = a.`account_id`
                    WHERE rc.status = 1 AND rc.`restaurant_id` = {$details['restaurant_id']}";
            $comment_rs = mysqli_query($conn, $sql);
            while ($comment_rc = mysqli_fetch_assoc($comment_rs)) {
            ?>
            <div id="review" class="card mb-3">
              <div class="card-body">
                <div class="row review-content">
                    <div class="col-md-2 text-center">
                      <img src="/assets/img/account/default_icon.png" alt="icon" style="width: 145px; height: 145px">
                      <div> <?php echo $comment_rc["name"]; ?> </div>
                      <div> <?php echo $comment_rc['date']; ?> </div>
                    </div>
                    <div class="col-md-8">
                      <div>
                        <h2><?php echo $comment_rc['title']?></h2>
                        <?php echo $comment_rc['content']; ?>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div>
                        <div>味道 
                        <?php
                          $x=0;
                          for($x=0; $x<5;$x++){
                            if($x<$comment_rc['taste_rating']){
                              echo '<span class="fa fa-star checked"></span>';
                            }else{
                              echo '<span class="fa fa-star"></span>';
                            }
                          }
                        ?> 
                        </div>
                        <div>環境 
                        <?php
                          $x=0;
                          for($x=0; $x<5;$x++){
                            if($x<$comment_rc['environment_rating']){
                              echo '<span class="fa fa-star checked"></span>';
                            }else{
                              echo '<span class="fa fa-star"></span>';
                            }
                          }
                        ?> 
                        </div>
                        <div>服務 
                        <?php
                          $x=0;
                          for($x=0; $x<5;$x++){
                            if($x<$comment_rc['service_rating']){
                              echo '<span class="fa fa-star checked"></span>';
                            }else{
                              echo '<span class="fa fa-star"></span>';
                            }
                          }
                        ?> 
                        </div>
                        <div>衛生 
                        <?php
                          $x=0;
                          for($x=0; $x<5;$x++){
                            if($x<$comment_rc['hygiene_rating']){
                              echo '<span class="fa fa-star checked"></span>';
                            }else{
                              echo '<span class="fa fa-star"></span>';
                            }
                          }
                        ?> 
                        </div>
                      </div>
                      <div>
                        <div>用餐日期 <?php echo $comment_rc["date_of_visit"]; ?> </div>
                        <div>用餐途徑 <?php echo $comment_rc["dining_method"]; ?> </div>
                      </div>
                    </div>
                </div>
              </div>
            </div>
            <?php
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </section>


  <section id="recommended">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <?php
          include_once("/xampp/htdocs/travelHK.com/recommendationAi_restaurant.php");
          $result = restaurant_itemToItem($details['restaurant_id'], 10);
          echo '
          <div class="row mb-2">
            <div class="col-md-12">
              <h5 class="pb-2 bg-light border-bottom border-3 border-info">其他人感到興趣的餐廳</h5>
            </div>
          </div>
          <div class="row row-cols-1 row-cols-md-3 g-4">';

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
          ?>
        </div>
      </div>
    </div>
  </section>

  <!-- Map View Modal -->
  <div class="modal fade" id="map-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">詳細位置</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <!-- Map View -->
        <div class="modal-body">
          <div class="or-td-wrap clearfix">
            <div class="td1"></div>
            <div class="td2">地圖指南</div>
            <div class="td1"></div>
          </div>

          <!-- Map View Frame -->
          <div id="map-view"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Map View Modal -->

  <!-- Google api must under the map div -->
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBqEKP2Vz-JuEGigdCS97dpdszcDn1KOM&callback=loadMap"></script>
  
  <!-- Footer -->
  <?php include_once('common/footer.php'); ?>
</body>

</html>