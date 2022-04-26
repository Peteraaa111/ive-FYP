<?php
// Start the SESSION
session_start();

include_once('/xampp/htdocs/travelHK.com/dbConnect.php');
include_once('../checklogin.php');
$restaurant_id = $_GET['id'];

global $conn;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>食評 - 香港本地旅遊平台 | 本地遊</title>

  <!-- Link the default css and js library -->
  <?php include_once('/xampp/htdocs/travelHK.com/library.php'); ?>
  
  <script src="/lib/ckeditor_4.17.2/ckeditor.js"></script>
  <script src="/js/rating.js"></script>
  <link rel="stylesheet" href="/css/starrr.css">
  <link href="/css/collab_form.css" rel="stylesheet">
  <script src="/js/starrr.js"></script>
  <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css">
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
  
</head>
<body>


  <!-- Header -->
  <?php include_once('common/header.php'); ?>

  <!-- Category -->
  <?php include_once('common/category.php'); ?>

  <!-- Main Content -->
  <form id="restaurant_review">
    <div class="container card">
      <div class="card-body">
        <div class="row card">
          <div class="card-body">
            <div class="col">
              <h4 class="card-title fw-bold">寫食評</h4>
              <span class="text-danger fw-bold">*</span>
              <span class="fw-bold">必需填寫</span>
            </div>
          </div>
        </div>
        <div class="row card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title">食評内容</h5>
              </div>
            </div>
            <div class="row">
              <div class="col-2">
                食評標題
                <span class="text-danger">*</span>
              </div>
              <div class="col-5">
                <input type="text" class="form-control" id="reviewtitle" name="reviewtitle">
              </div>
            </div>
            <div class="row">
              <div class="col-2">
                用餐日期
                <span class="text-danger">*<span>
              </div>
              <div class="col">
                <div class="input-group date" id="datepicker">
                  <input type="text" class="form-control" id="mealstime" name="mealstime" readonly>
                    <span class="input-group-append">
                      <span class="input-group-text bg-white">
                        <i class="fa fa-calendar"></i>
                      </span>
                    </span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-2">
                 用餐途徑
                <span class="text-danger">*<span>
              </div>
              <div class="col">
                <input type="radio" class="btn-check" name="type_of_meal" id="type1" autocomplete="off" value="堂食">
                <label class="btn btn-outline-primary" for="type1">堂食</label>

                <input type="radio" class="btn-check" name="type_of_meal" id="type2" autocomplete="off" value="外賣自取">
                <label class="btn btn-outline-primary" for="type2">外賣自取</label>

                <input type="radio" class="btn-check" name="type_of_meal" id="type3" autocomplete="off" value="外賣送餐">
                <label class="btn btn-outline-primary" for="type3">外賣送餐</label>
                
              </div>
            </div>
            <div class="row">
              <div class="col-2">
                內容
                <span class="text-danger">*<span>
              </div>
              <div class="col">
                <textarea id="chatbox" name="chatbox">

                </textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="row card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title">評分</h5>
              </div>
            </div>
            <div class="row">
              <div class="col-2">
              細項評分
              <span class="text-danger fw-bold">*</span>
              </div>
            </div>
            <div class="row">
              <div class="col-2">
                味道
              </div>
              <div class="col">
                <div class='starrr' id='star1'></div>
              </div>
              <div>&nbsp;
                <span class='your-choice-was1' style='display: none;'>
                  <input type ="text" class="choice1" id="choice1" name="chocie1">
                </span>
              </div>
            </div>
            <div class="row">
              <div class="col-2">
                環境
              </div>
              <div class="col">
                <div class='starrr' id='star2'></div>
              </div>
              <div>&nbsp;
                <span class='your-choice-was2' style='display: none;'>
                <input type ="text" class="choice2" id="choice2" name="chocie2">
                </span>
              </div>
            </div>
            <div class="row">
              <div class="col-2">
                服務
              </div>
              <div class="col">
                <div class='starrr' id='star3'></div>
              </div>
              <div>&nbsp;
                <span class='your-choice-was3' style='display: none;'>
                  <input type ="text" class="choice3" id="choice3" name="chocie3">
                </span>
              </div>
            </div>
            <div class="row">
              <div class="col-2">
                衛生
              </div>
              <div class="col">
                <div class='starrr' id='star4'></div>
              </div>
              <div>&nbsp;
                <span class='your-choice-was4' style='display: none;'>
                 <input type ="text" class="choice4" id="choice4" name="chocie4">
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col text-end">
            <button type="button" class="btn btn-primary" onclick="submitrestaurantrating('<?php echo $restaurant_id ?>');">提交</button>
          </div>
        </div>
      </div>
    </div> <!-- Container -->
  </form>
</div>
  <!-- Footer -->
  <?php include_once('common/footer.php'); ?>
  <script type="text/javascript">
        $(function() {
            $('#datepicker').datepicker();
        });
      CKEDITOR.replace('chatbox',{
      filebrowserImageUploadUrl : '/lib/ckeditor_4.17.2/ck_upload.php',
      filebrowserUploadMethod: 'form',
      
    });
    
  </script>
  <script>
    $('#star1').starrr({
      change: function(e, value){
        if (value) {
          $('.choice1').val(value);
          
        } else {

        }
      }
    });

    $('#star2').starrr({
      change: function(e, value){
        if (value) {
          $('.choice2').val(value);
        } else {
        }
      }
    });
    $('#star3').starrr({
      change: function(e, value){
        if (value) {
          $('.choice3').val(value);
        } else {
        }
      }
    });
    $('#star4').starrr({
      change: function(e, value){
        if (value) {
          $('.choice4').val(value);
        } else {
        }
      }
    });
  </script>
</body>

</html>