<?php
// Start the SESSION
session_start();

include_once('dbConnect.php');
global $conn;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>行程計劃 | 本地遊</title>

  <!-- Link the default css and js library -->
  <?php include_once('default_page/library.php'); ?>

  <link href="css/planner.css" rel="stylesheet">

  <script type="text/javascript" src="js/itinerary_planner.js"></script>
</head>

<body>

  <!-- Header -->
  <?php include_once('default_page/header.php'); ?>

  <!-- Category -->
  <?php include_once('default_page/category.php'); ?>

  <!-- Main Content -->
  <!-- Planner -->
  <div class="d-flex flex-column align-items-stretch flex-shrink-0 bg-white" style="width: 330px;" id="planner">
    <a href="#" class="d-flex align-items-center flex-shrink-0 p-3 link-dark text-decoration-none border-bottom">
      <span class="fs-5 fw-semibold">行程計劃</span>
    </a>

    <div class="list-group list-group-flush border-bottom scrollarea">
      <div>
        <a href="#" class="list-group-item list-group-item-action py-3 lh-tight">
          <div class="d-flex w-100 align-items-center justify-content-between">
            <strong class="mb-1" id="name">List group item heading</strong>
            <small class="text-muted" id="type">Tues</small>
          </div>
          <div class="col-10 mb-1 small">
            Some placeholder content in a paragraph below the heading and date.
          </div>
        </a>
      </div>
      <div>
        <a href="#" class="list-group-item list-group-item-action py-3 lh-tight">
          <div class="d-flex w-100 align-items-center justify-content-between">
            <strong class="mb-1">List group item heading</strong>
            <small class="text-muted">Tues</small>
          </div>
          <div class="col-10 mb-1 small">
            Some placeholder content in a paragraph below the heading and date.
          </div>
        </a>
      </div>
    </div>
  </div>
  <?php
  include_once('map_function.php');
  $markerGetter = new initialMap;

  // restaurant initialize
  $allRestaurant = $markerGetter->getAllRestaurants();
  $allRestaurant = json_encode($allRestaurant, true);
  echo '<div id="restaurant_allData">' . $allRestaurant . '</div>';

  // attraction initialize                      
  $allAttraction = $markerGetter->getAllAttractions();
  $allAttraction = json_encode($allAttraction, true);
  echo '<div id="attraction_allData">' . $allAttraction . '</div>';

  ?>
  <div class="showMap" id="showMap">
    <div id="map">
    </div>
  </div>

  <!-- Google api must under the map div -->
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBqEKP2Vz-JuEGigdCS97dpdszcDn1KOM&callback=loadMap"></script>

  <!-- Footer -->
  <?php include_once('default_page/footer.php'); ?>

</body>

</html>