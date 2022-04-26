<?php
// Start the SESSION
session_start();

// Get database connection variable
include_once('dbConnect.php');
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
  <?php include_once('default_page/library.php'); ?>
</head>

<body>

  <!-- Header -->
  <?php include_once('default_page/header.php'); ?>

  <!-- Category -->
  <?php include_once('default_page/category.php'); ?>

  <!-- Main Content -->
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <div class="selected-district"></div>
            <ul>
              <?php
              $sql = "SELECT District, hkd.`zh-hk` as Name, Count(District) as Total
                        FROM restaurant r
                        INNER JOIN hong_kong_district hkd ON r.District = hkd.ID
                        GROUP BY District
                        ORDER BY Total DESC LIMIT 5;";
              $rs = mysqli_query($conn, $sql);
              while($rc = mysqli_fetch_assoc($rs)){
                echo "<li style=\"list-style-type: none;\">";

                echo "<a class=\"district-item\" href=\"#\">";

                echo "<span class=\"district-name\">".$rc['Name']."</span>";
                echo "<span class=\"district-total\">(".$rc['Total'].")</span>";

                echo "</a>";

                echo "</li>";
              }
              ?>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-8">
      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php include_once('default_page/footer.php'); ?>

</body>

<script>
  $('.district-item').click(function(){
    var name = $(this).find('.district-name').text();
    if($("#" + name).length == 0){
      var item = '<span id=' + name + ' class="badge bg-primary">' + name +'</span>';
      $('.selected-district').append(item);
    }
  })
</script>

</html>