<?php
// Start the SESSION
session_start();
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
      <div class="col">
        <button type="button" class="btn btn-primary" id="liveToastBtn">Show live toast</button>
      </div>
    </div>
  </div>

  <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header">
        <strong class="me-auto">Collab Request Updated</strong>
        <small>Now</small>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body">
        This collab request updated!
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function(){
      var toast = new bootstrap.Toast($('#liveToast'));
      toast.show();
    })
  </script>

  <!-- Footer -->
  <?php include_once('default_page/footer.php'); ?>

</body>

</html>