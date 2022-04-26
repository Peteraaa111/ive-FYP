<?php
session_start();

include_once('/xampp/htdocs/travelHK.com/dbConnect.php');
global $conn;

// get restaurant data
$restaurant_id = $_GET['id'];
$sql = "SELECT *, hkd.`zh-hk` AS `district`, rsl.`zh-hk` AS `status`
        FROM `restaurant` r
        INNER JOIN `hong_kong_district` hkd ON r.`district` = hkd.`district_id`
        INNER JOIN `restaurant_status` rsl ON r.`status` = rsl.`status_id`
        WHERE r.`restaurant_id` = '$restaurant_id'";
$rs = mysqli_query($conn, $sql);
$rc = mysqli_fetch_assoc($rs);

// get restaurant's custine 
$cuisineRecord_sql = "SELECT * FROM `restaurant_cuisine` 
                        WHERE restaurant_id = '$restaurant_id';";
$cuisineRecord_rs = mysqli_query($conn, $cuisineRecord_sql);
$Restaurant_cuisine = array();
while ($cuisineT = mysqli_fetch_assoc($cuisineRecord_rs)) {
  $Restaurant_cuisine[] = $cuisineT['cuisine_id'];
}

// get restaurant's type 
$type_sql = "SELECT * FROM `restaurant_type` 
                        WHERE restaurant_id = '$restaurant_id';";
$type_rs = mysqli_query($conn, $type_sql);
$Restaurant_type = array();
while ($typeT = mysqli_fetch_assoc($type_rs)) {
  $Restaurant_type[] = $typeT['type_id'];
}

// get restaurant's payment method 
$payment_sql = "SELECT * FROM `restaurant_payment_method`
                        WHERE restaurant_id = '$restaurant_id';";
$payment_rs = mysqli_query($conn, $payment_sql);
$payment_type = array();
while ($paymentT = mysqli_fetch_assoc($payment_rs)) {
  $payment_type[] = $paymentT['method_id'];
}

// get restaurant's equipment
$equipment_sql = "SELECT * FROM `restaurant_equipment`
                      WHERE `restaurant_id` = '$restaurant_id';";
$equipment_rs = mysqli_query($conn, $equipment_sql);
$equipments = array();
while ($equipmentItem = mysqli_fetch_assoc($equipment_rs)) {
  $equipments[] = $equipmentItem['equipment_id'];
}


// ================ Get Table Layout Json ================
$clientID = $_SESSION["r_id"];
$restaurant_id = $_GET['id'];
$json = "";

$findExistingQuery = "SELECT * FROM restaurant_layout WHERE `r_id` = '$clientID' AND `restaurant_id` = '$restaurant_id';";
$rs  = mysqli_query($conn, $findExistingQuery);

if (mysqli_num_rows($rs) == 1) {
  $row = mysqli_fetch_row($rs);
  $json = $row[2];
} else {
  $json = -1;
}
// ================ Get time interval ================ 
$timeInterval = "";


$getTimeInterval = "SELECT `timeInterval` FROM restaurant_layout WHERE `restaurant_id` = '$restaurant_id';";

$intervalResult  = mysqli_query($conn, $getTimeInterval);
$rc1 = mysqli_fetch_assoc($intervalResult);

if ($rc1 != null) {
  $timeInterval = $rc1['timeInterval'];
} else {
  $timeInterval = -1;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>餐廳編輯器 (ID:<?php echo $_GET['id'] ?>) - 管理頁面</title>

  <?php
  require_once('/xampp/htdocs/travelHK.com/library.php');
  ?>
  <link rel="stylesheet" href="/css/admin_form.css">
  <script src="/js/partner/restaurant_editor.js"></script>



  <!-- ************ Below my code ************ -->

  <link rel="stylesheet" href="../../../js/jqueryui/jquery-ui.css">
  <script src="../../../js/jqueryui/jquery-ui.min.js"></script>

  <!-- ************ Above my code ************ -->
  <script>
    var selected = [];
    var tableid = [];

    $(document).on("click", "#save", function() {
      var jsonStr = "[";

      $(".draggable").each(function() {
        var elem = $(this),
          id = elem.attr('id'),
          pos = elem.position();

        newleft = pos.left;
        newtop = pos.top;
        ppl = $(this).attr("data-ppl");


        jsonStr += "{\"id\":\"" + $(this).attr('id') + "\",\"left\":\"" + newleft + "\",\"top\":\"" + newtop + "\",\"ppl\":\"" + ppl + "\"},";


      });

      jsonStr = jsonStr.slice(0, -1);
      jsonStr += "]";

      if (jsonStr == "]") {
        jsonStr = "";
      } else {
        console.log("saving: <?= $restaurant_id ?>");
        $.ajax({
          type: 'POST',
          url: "/function.php?op=saveRestaurantLayout",
          data: {
            'r_id': <?= $clientID ?>,
            'restaurant_id': <?= $restaurant_id ?>,
            'position': jsonStr,
            'timeInterval': $("#timeInterval").val()
          },
          success: function(result) {
            $("#message").show(200);
          },
          error: function(result) {
            alert(result.responseText);
          }
        });
      }

      console.log("Saving: " + jsonStr);

      $(".control").slideToggle("slow");
      $("#edit").slideToggle("slow");
    });

    function removeNum(num) {
      num = parseInt(num);
      convertToInt();
      const index = tableid.indexOf(num);
      if (index > -1) {
        tableid.splice(index, 1);
      }

    }

    function convertToInt() {
      var result = tableid.map(function(x) {
        return parseInt(x, 10);
      });
    }

    $(document).on("click", "#delete", function() {
      let str = "";
      for (let i = 0; i < selected.length; i++) {
        str += "餐枱 " + selected[i] + " ";
      }

      var confirmAction;

      if (str != "") {
        confirmAction = confirm("是否確認刪除: " + str + "?");
      } else {
        alert("未選取任何餐枱, 請重試");
      }


      if (confirmAction) {
        for (let i = 0; i < selected.length; i++) {
          $("#" + selected[i]).remove();
          removeNum(selected[i]);
        }
      }
      selected = [];

      // clear selection text

      $(".selected").hide();
      $(".selectmsg").text("");

    });


    var isMissing = false;

    $(document).on("click", "#addObj", function() {

      console.log("tableid: " + tableid);

      let ppl = $("#numofppl").val();

      let id;

      findMissingID();

      // console.log("tableid"+ tableid);
      // console.log("isMissing"+ isMissing);

      if (isMissing == true) {
        //    console.log("missing");
        id = findMissingID();
      } else if (tableid.length == 0) {
        id = 1;
      } else {
        //   console.log("not missing");
        id = tableid[tableid.length - 1] + 1;
      }

      tableid.push(parseInt(id));
      var $element = $('<div class="draggable ui-widget-content"/>').text("餐枱 " + id + "\n" + ppl + "人")

      $element.html($element.html().replace(/\n/g, '<br/>'));

      $element.attr({
        'id': id,
        'data-ppl': ppl
      });

      $element.css({
        width: "0px",
        height: "0px"
      });


      $("#containment-wrapper").append($element);

      $element.animate({
        width: "70px",
        height: "70px"
      }, {
        specialEasing: {
          width: "swing",
          height: "swing"
        }
      });





      becomeDraggable();

      tableid.sort((a, b) => a - b);


      isMissing = false;
    }); // End of Add Object



    function findMissingID() {
      var count = tableid[tableid.length - 1];
      var missing = new Array();
      isMissing = false;

      for (var i = 1; i <= count; i++) {
        if (tableid.indexOf(i) == -1) {
          isMissing = true;
          return i;
        }
      }

    }



    function becomeDraggable() {
      $(".draggable").draggable({
        obstacle: ".butNotHere",
        preventCollision: true,
        containment: "#containment-wrapper",
        start: function(event, ui) {
          $(this).removeClass('butNotHere');
        },
        stop: function(event, ui) {
          $(this).addClass('butNotHere');
        }
      });

      // when a draggable is double clicked:
      $(".draggable").dblclick(function() {

        $(".selected").show();
        $("#clear").show();

        // $(this).slideUp();                
        // div {border-color: coral;}
        $(this).css("border-color", "blue");
        $(this).css("color", "blue");
        // Add selected div to list

        // selected = _.union(selected, $(this).attr('id'));

        selected.push(parseInt($(this).attr('id')));

        let message = "已選取: ";
        message += outputSelected();

        $(".selectmsg").text(message);
      });


      // when draggable is clicked
      $(".draggable").click(function() {

      });
    }



    function outputSelected() {

      var tableSelection = "";

      selected = selected.filter(onlyUnique);

      selected = selected.sort((a, b) => a - b);

      for (let i = 0; i < selected.length; i++) {
        tableSelection += "餐枱" + selected[i] + " ";
      }

      return tableSelection;

    }




    // clear selection
    $(document).on("click", "#clear", function() {
      clearSelection();

    });


    function clearSelection() {
      for (let i = 0; i < selected.length; i++) {
        $("#" + selected[i]).css({
          "border-color": "",
          "color": ""
        });
      }
      selected = [];
      $(".selectmsg").text("");
      $("#clear").hide();
    }

    function onlyUnique(value, index, self) {
      return self.indexOf(value) === index;
    }

    var rotation = 0;

    // define rotation
    // jQuery.fn.rotate = function(degrees) {
    //   $(this).css({
    //     'transform': 'rotate(' + degrees + 'deg)'
    //   });
    //   return $(this);
    // };

    // document on ready
    $(document).ready(function() {
      // on change event rorate
      // $("#rotation").on("change", function() {
      //   rotation = document.getElementById("rotation").value;

      //   for (let i = 0; i < selected.length; i++) {
      //     $("#" + selected[i]).rotate(rotation);
      //   }

      // });

    }); // end of load json

    // Click Edit button
    $(document).on("click", "#edit", function() {
      $("#edit").hide("slow");
      $(".control").show("slow");
    });


    $(document).ready(function() {
      $('#reviewBooking').click(function() {

        var booking_date = $('#booking_date').val();
        var ajaxurl = '/function.php?op=loadBookingResult',
          data = {
            'restaurant_id': <?= $restaurant_id ?>,
            'booking_date': $("#realdate").val(),
            'booking_time_start': $("#realTimeStart").val(),
            'booking_time_end': $("#realTimeEnd").val()
          };
        $.post(ajaxurl, data, function(response) {
          alert(response);
        });
      });


      $('#submitTimeInterval').click(function() {
        $(".layoutEditor").show();
        $("#submitTimeInterval").hide();
      });
    });
  </script>

  <style>
    .draggable {
      text-align: center;
      position: initial;
      width: 70px;
      height: 70px;
      float: left;
      cursor: move;
      position: absolute;
    }

    #containment-wrapper {
      margin-bottom: 30px;
      height: 500px;
      border: 2px solid #ccc;
      padding: 10px;
      overflow: auto;
      position: relative;
    }

    #booking {
      margin-right: 50px;
    }

    .bigbox {
      overflow: visible;
      margin-bottom: 30px;
      height: 300px;
      border: 2px solid #ccc;
      padding: 10px;
      overflow: auto;
      position: relative;
    }

    .draggableFake {
      text-align: center;
      position: initial;
      width: 70px;
      height: 70px;
      float: left;
      border: 2px solid #ccc;
      position: absolute;
    }
  </style>

</head>

<body>

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php require_once("sidebar.php"); ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <div id="content">

        <!-- Topbar -->
        <?php require_once("topbar.php"); ?>
        <!-- End of Topbar -->

        <div class="container-fluid">
          <div class="row">
            <div class="col-md-10 offset-1">
              <div class="card">
                <div class="card-body">
                  <h3 class="text-secondary">餐廳編輯器 (ID:<?php echo $_GET['id'] ?>)</h3>
                </div>
              </div>
              <!-- Basic Information -->
              <form id="basic-info">
                <div class="card">
                  <div class="card-body">
                    <h3 class="text-secondary">基本資料</h3>
                    <div class="row">
                      <div class="card-body">
                        <!-- Restaurant name -->
                        <div class="row">

                          <div class="col-md-2">
                            <label>餐廳名稱</label>
                            <span class="text-danger">*</span>
                          </div>

                          <div class="col-md-5">
                            <input type="text" class="form-control" id="chi-name" name="chi-name" placeholder="中文" value="<?php echo $rc['restaurant_chinese_name'] ?>">
                          </div>
                          <div class="col-md-5">
                            <input type="text" class="form-control" id="eng-name" name="eng-name" placeholder="英文" value="<?php echo $rc['restaurant_english_name'] ?>">
                          </div>
                        </div>
                        <!-- District -->
                        <div class="row">
                          <div class="col-md-2">
                            <label>地區</label>
                            <span class="text-danger">*<span>
                          </div>
                          <div class="col-md-10">
                            <select class="form-select" id="district" name="district">
                              <option value="" disabled hidden>請選擇地區</option>
                              <?php
                              $region_sql = "SELECT * FROM `hong_kong_region`;";
                              $region_rs = mysqli_query($conn, $region_sql);

                              while ($region = mysqli_fetch_assoc($region_rs)) {
                                echo "<optgroup label=\"" . $region['zh-hk'] . "\">";

                                $district_sql = "SELECT * FROM `hong_kong_district` WHERE `region_id` = " . $region['region_id'] . ";";
                                $district_rs = mysqli_query($conn, $district_sql);
                                while ($district = mysqli_fetch_assoc($district_rs)) {
                                  if ($district['district_id'] == $rc['district']) {
                                    echo "<option value=\"" . $district['district_id'] . "\" selected>" . $district['zh-hk'] . "</option>";
                                  } else {
                                    echo "<option value=\"" . $district['district_id'] . "\">" . $district['zh-hk'] . "</option>";
                                  }
                                }

                                echo "</optgroup>";
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                        <!-- Physical Address -->
                        <div class="row">
                          <div class="col-md-2">
                            <label>地址</label>
                            <span class="text-danger">*<span>
                          </div>
                          <div class="col-md-10">
                            <input type="text" class="form-control" id="chi-address" name="chi-address" placeholder="中文" value="<?php echo $rc['chinese_address'] ?>">
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-2"></div>
                          <div class="col-md-10">
                            <input type="text" class="form-control" id="eng-address" name="eng-address" placeholder="英文" value="<?php echo $rc['english_address'] ?>">
                          </div>
                        </div>
                        <!-- Coordinate -->
                        <div class="row">
                          <div class="col-md-2">
                            <label>座標</label>
                            <span class="text-danger">*</span>
                          </div>
                          <div class="col-md-5">
                            <input type="text" class="form-control" name="latitude" id="latitude" placeholder="緯度" readonly value=<?php echo '"' . $rc['latitude'] . '"'; ?>>
                          </div>
                          <div class="col-md-5">
                            <input type="text" class="form-control" name="longitude" id="longitude" placeholder="經度" readonly value=<?php echo '"' . $rc['longitude'] . '"'; ?>>
                          </div>
                        </div>
                        <!-- Contact Infomation -->
                        <div class="row">
                          <div class="col-md-2">
                            <label>聯絡資料</label>
                            <span class="text-danger">*<span>
                          </div>
                          <div class="col-md-5">
                            <input class="form-control" type="tel" name="phoneNo" id="phoneNo" placeholder="聯絡電話" minlength="8" maxlength="8" oninput="value=value.replace(/[^\d]/g,'')" value="<?php echo $rc['phone_number']; ?>">
                          </div>
                          <div class="col-md-5">
                            <input class="form-control" type="email" name="email" id="email" placeholder="電郵 (如需要)" value="<?php echo $rc['email']; ?>">
                          </div>
                        </div>
                        <!-- Cuisines -->
                        <div class="row">
                          <div class="col-md-2">
                            <label>菜式</label>
                            <span class="text-danger">*<span>
                          </div>
                          <div class="col-md-10" id="cuisine-checkboxes">
                            <?php
                            $cuisine_sql = "SELECT * FROM `cuisine_list`;";
                            $cuisine_rs = mysqli_query($conn, $cuisine_sql);
                            while ($cuisine = mysqli_fetch_assoc($cuisine_rs)) {
                              if ($cuisine['cuisine_id'] == '0') {
                                // empty
                              } else {
                                echo '<div class="form-check form-check-inline">';
                                echo '<input class="form-check-input cuisine" type="checkbox" id="' . str_replace(' ', '', $cuisine['en']) . '" value="' . $cuisine['cuisine_id'] . '" name="cuisine[]"' . (in_array($cuisine['cuisine_id'], $Restaurant_cuisine) ? 'checked="checked"' : '') . '>';
                                echo '<label class="form-check-label" for="' . str_replace(' ', '', $cuisine['en']) . '">' . $cuisine['zh-hk'] . '</label>';
                                echo '</div>';
                              }
                            }
                            ?>
                          </div>
                        </div>
                        <!-- Restaurant Types -->
                        <div class="row">
                          <div class="col-2">
                            <label>食品 / 餐廳類型</label>
                            <span class="text-danger">*<span>
                          </div>
                          <div class="col-md-10" id="type-checkboxes">
                            <?php
                            $type_sql = "SELECT * FROM `restaurant_type_list`;";
                            $type_rs = mysqli_query($conn, $type_sql);

                            while ($type = mysqli_fetch_assoc($type_rs)) {
                              if ($type['type_id'] == '0') {
                                // empty
                              } else {
                                echo '<div class="form-check form-check-inline">';
                                echo '<input class="form-check-input type" type="checkbox" id="' . str_replace(' ', '', $type['en']) . '" value="' . $type['type_id'] . '" name="type[]"' . (in_array($type['type_id'], $Restaurant_type) ? 'checked="checked"' : '') . '>';
                                echo '<label class="form-check-label" for="' . str_replace(' ', '', $type['en']) . '">' . $type['zh-hk'] . '</label>';
                                echo '</div>';
                              }
                            }
                            ?>
                          </div>
                        </div>
                        <!-- Number of Seats -->
                        <div class="row">
                          <div class="col-md-2">
                            <label>座位數目</label>
                            <span class="text-danger">*<span>
                          </div>
                          <div class="col-md-10">
                            <div class="input-group">
                              <input type="number" class="form-control" id="seats" name="seats" value="<?php echo $rc['number_of_seats'] ?>">
                              <span class="input-group-text">位</span>
                            </div>
                          </div>
                        </div>
                        <!-- Business Hours -->
                        <div class="row">
                          <div class="col-md-2">
                            <label>營業時間</label>
                            <span class="text-danger">*<span>
                          </div>
                          <div class="col-md-2">星期一至五</div>
                          <div class="col-md-8">
                            <?php
                            if ($rc['weekday_business_hours'] == "closed") {
                              echo '
                              <input type="time" class="form-control business-hours" name="start-weekday" id="start-weekday" value="23:59" readonly>
                              <span> - </span>
                              <input type="time" class="form-control business-hours" name="end-weekday" id="end-weekday" value="23:59" readonly>
                              <div class="form-check form-check-inline ms-2">
                                <input type="checkbox" class="form-check-input" name="weekday-closed" id="weekday-closed" checked>
                                <label for="weekday-closed">休息</label>
                              </div>
                              ';
                            } else {
                              $weekday = explode(" - ",  $rc['weekday_business_hours']);
                              echo '
                              <input type="time" class="form-control business-hours" name="start-weekday" id="start-weekday" value="' . $weekday[0] . '">
                              <span> - </span>
                              <input type="time" class="form-control business-hours" name="end-weekday" id="end-weekday" value="' . $weekday[1] . '">
                              <div class="form-check form-check-inline ms-2">
                                <input type="checkbox" class="form-check-input" name="weekday-closed" id="weekday-closed">
                                <label for="weekday-closed">休息</label>
                              </div>
                              ';
                            }
                            ?>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-2 offset-2">星期六至日</div>
                          <div class="col-md-8">
                            <?php
                            if ($rc['weekend_business_hours'] == "closed") {
                              echo '
                              <input type="time" class="form-control business-hours" name="start-weekend" id="start-weekend" value="23:59" readonly>
                              <span> - </span>
                              <input type="time" class="form-control business-hours" name="end-weekend" id="end-weekend" value="23:59" readonly>
                              <div class="form-check form-check-inline ms-2">
                                <input type="checkbox" class="form-check-input" name="weekend-closed" id="weekend-closed" checked>
                                <label for="weekend-closed">休息</label>
                              </div>
                              ';
                            } else {
                              $weekend = explode(" - ",  $rc['weekend_business_hours']);
                              echo '
                              <input type="time" class="form-control business-hours" name="start-weekend" id="start-weekend" value="' . $weekend[0] . '">
                              <span> - </span>
                              <input type="time" class="form-control business-hours" name="end-weekend" id="end-weekend" value="' . $weekend[1] . '">
                              <div class="form-check form-check-inline ms-2">
                                <input type="checkbox" class="form-check-input" name="weekend-closed" id="weekend-closed">
                                <label for="weekend-closed">休息</label>
                              </div>
                              ';
                            }
                            ?>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-2 offset-2">公眾假期</div>
                          <div class="col-md-8">
                            <?php
                            if ($rc['holiday_business_hours'] == "closed") {
                              echo '
                              <input type="time" class="form-control business-hours" name="start-holiday" id="start-holiday" value="23:59" readonly>
                              <span> - </span>
                              <input type="time" class="form-control business-hours" name="end-holiday" id="end-holiday" value="23:59" readonly>
                              <div class="form-check form-check-inline ms-2">
                                <input type="checkbox" class="form-check-input" name="holiday-closed" id="holiday-closed" checked>
                                <label for="holiday-closed">休息</label>
                              </div>
                              ';
                            } else {
                              $holiday = explode(" - ",  $rc['holiday_business_hours']);
                              echo '
                              <input type="time" class="form-control business-hours" name="start-holiday" id="start-holiday" value="' . $holiday[0] . '">
                              <span> - </span>
                              <input type="time" class="form-control business-hours" name="end-holiday" id="end-holiday" value="' . $holiday[1] . '">
                              <div class="form-check form-check-inline ms-2">
                                <input type="checkbox" class="form-check-input" name="holiday-closed" id="holiday-closed">
                                <label for="holiday-closed">休息</label>
                              </div>
                              ';
                            }
                            ?>
                          </div>
                        </div>
                        <!-- Payment Methods -->
                        <div class="row">
                          <div class="col-md-2">
                            <label>付款方式</label>
                            <span class="text-danger">*<span>
                          </div>
                          <div class="col-md-10" id="payment-checkboxes">
                            <!-- Print the payment method with check box -->
                            <?php
                            $sql = "SELECT * FROM `payment_method_list`;";
                            $rs = mysqli_query($conn, $sql);

                            while ($method = mysqli_fetch_assoc($rs)) {
                              if ($method['method_id'] == '0') {
                                // empty    
                              } else {
                                echo '<div class="form-check form-check-inline">';
                                echo '<input class="form-check-input payment-method" type="checkbox" id="' . str_replace(' ', '', $method['en']) . '" value="' . $method['method_id'] . '" name="payment[]"' . (in_array($method['method_id'], $payment_type) ? 'checked="checked"' : '') . '>';
                                echo '<label class="form-check-label" for="' . str_replace(' ', '', $method['en']) . '">' . $method['zh-hk'] . '</label>';
                                echo '</div>';
                              }
                            }
                            ?>
                          </div>
                        </div>
                        <!-- Equipment -->
                        <div class="row">
                          <div class="col-md-2">
                            <label>公用設備</label>
                          </div>
                          <div class="col-md-10">
                            <!-- Print the equipment with check box -->
                            <?php
                            $sql = "SELECT * FROM `restaurant_equipment_list`;";
                            $rs = mysqli_query($conn, $sql);

                            while ($equipment = mysqli_fetch_assoc($rs)) {
                              if ($equipment['equipment_id'] == '0') {
                                // empty
                              } else {
                                echo '<div class="form-check form-check-inline">';
                                echo '<input class="form-check-input equipment" type="checkbox" id="' . str_replace(' ', '', $equipment['en']) . '" value="' . $equipment['equipment_id'] . '" name="equipment[]"' . (in_array($equipment['equipment_id'], $equipments) ? 'checked="checked"' : '') . '>';
                                echo '<label class="form-check-label" for="' . str_replace(' ', '', $equipment['en']) . '">' . $equipment['zh-hk'] . '</label>';
                                echo '</div>';
                              }
                            }
                            ?>
                          </div>
                        </div>
                        <!-- Update Button -->
                        <div class="row">
                          <div class="col-md-12 text-center">
                            <button type="button" id="update-btn" class="btn btn-primary" onclick="updateInfo('<?php echo $_GET['id'] ?>')">更新</button>
                          </div>
                        </div>
                      </div>
                    </div><!-- End of row -->
                  </div> <!-- End of card-body -->
                </div> <!-- End of card -->
              </form>

              <!-- Setting -->
              <form id="setting">
                <div class="card">
                  <div class="card-body">
                    <h3 class="text-secondary">設定</h3>
                    <div class="row">
                      <!-- Public Setting -->
                      <div class="col-md-2">
                        公開設定
                      </div>
                      <div class="col-md-10">
                        <?php
                        $status_list_sql = "SELECT * FROM `restaurant_status`;";
                        $status_rs = mysqli_query($conn, $status_list_sql);

                        $checked_sql = "SELECT `status` FROM `restaurant` WHERE `restaurant_id` = '" . $rc['restaurant_id'] . "';";
                        $checked_rs = mysqli_query($conn, $checked_sql);
                        $isChecked = mysqli_fetch_assoc($checked_rs);

                        while ($status = mysqli_fetch_assoc($status_rs)) {
                          if ($isChecked['status'] == $status['status_id']) {
                            echo '<div class="form-check form-check-inline">';
                            echo '<input type="radio" class="form-check-input" value="' . $status['en'] . '" name="status" id="' . $status['en'] . '" checked>';
                            echo '<label for="' . $status['en'] . '" class="form-check-label">' . $status['zh-hk'] . '</label>';
                            echo '</div>';
                          } else {
                            echo '<div class="form-check form-check-inline">';
                            echo '<input type="radio" class="form-check-input" value="' . $status['en'] . '" name="status" id="' . $status['en'] . '">';
                            echo '<label for="' . $status['en'] . '" class="form-check-label">' . $status['zh-hk'] . '</label>';
                            echo '</div>';
                          }
                        }
                        ?>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 text-center">
                        <button type="button" id="update-btn" class="btn btn-primary" onclick="updateStatus('<?php echo $_GET['id'] ?>');">更新</button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>

              <!-- Image Management -->
              <div class="card">
                <div class="card-body">
                  <h3 class="text-secondary">照片管理</h3>
                </div>
              </div>
              <!-- Comment Management -->
              <div class="card">
                <div class="card-body">
                  <h3 class="text-secondary">留言管理</h3>
                </div>
              </div>

              <!-- Manage Restaurant layout Management -->
              <div class="card">
                <div class="card-body">

                  <h3 class="text-secondary">編輯餐枱位置</h3>

                  <br>
                  <!-- MAIN Content  -->
                  <div class="row">

                    <div class="col-md-3">
                      <label> 選擇客人每段預約的時間:</label>
                      <span class="text-danger">*</span>
                    </div>

                    <div class="col-3">

                      <div class="input-group">
                        <div class="input-group mb-3">
                          <input id="timeInterval" class="form-control" type="number" min="15" max="120" step="15" value="30" />
                          <span class="input-group-text">分鐘</span>
                        </div>
                      </div>



                    </div>

                    <div class="col-3">

                      <button class="btn btn-success" id="submitTimeInterval">提交</button>

                    </div>
                  </div>













                  <div class="layoutEditor" style="display: none; margin-top:20px">
                    <!-- Content Wrapper -->
                    <div id="content-wrapper" class="d-flex flex-column">
                      <div id="content">
                        <div class="container-fluid">

                          <div class="row">
                            <div class="selected" style="display:none">

                              <span class="selectmsg"></span>

                              <button type="button" id="clear" class="btn btn-secondary float-right">清除選取</button>
                            </div>

                            <div class="row">



                            </div>



                            <div id="containment-wrapper">
                              <script>
                                str = '<?= $json ?>';

                                if (str !== "-1") {
                                  console.log("Json String is not empty");
                                  const obj = JSON.parse((str));
                                  for (let i = 0; i < obj.length; i++) {
                                    var table = document.createElement('div');
                                    table.innerHTML = '<div class="draggable ui-widget-content butNotHere" id="' + (i + 1) + '" style="left:' + obj[i].left + 'px; top:' + obj[i].top + 'px"' + 'data-ppl=' + obj[i].ppl + '>餐枱 ' + (i + 1) + "<br/>" + obj[i].ppl + "人" + '</div>';
                                    $("#containment-wrapper").append(table);
                                    tableid.push(parseInt(i));
                                    becomeDraggable();


                                  }
                                  convertToInt();
                                  console.log(obj.length);
                                  tableid.push(parseInt(obj.length));

                                  tableid.sort((a, b) => a - b);


                                  console.log("tableid: " + tableid);

                                }
                              </script>

                            </div>


                          </div>
                        </div>





                        <div class="control" style="display:none">

                          <div class="row">

                            <div class="col-7">
                              <button id="save" class="btn btn-primary">儲存餐枱位置</button>

                              <button id="addObj" class="btn btn-success">新增餐枱</button>


                              <button id="delete" class="btn btn-danger">刪除選取的餐枱</button>

                            </div>

                            <div class="col-2">

                            </div>

                            <div class="col-3">
                              <div class="input-group text-end">
                                <span class="input-group-text">容納人數 </span><input type="number" id="numofppl" class="form-control " min="1" max="12" value="1">
                              </div>


                            </div>
                          </div>

                          <div class="row">
                            <div class="col">
                              <p class="lead">
                                使用指引:
                              </p>
                              <ul class="list-group">
                                <li class="list-group-item">1. 新增餐枱, 拖拉餐枱以更改位置 </li>
                                <li class="list-group-item">2. 欲要刪除餐枱,雙擊點選餐枱, 然後點擊"刪除選取的餐枱"</li>
                                <li class="list-group-item">3. 餐枱預設容納一人, 若要增加容納人數, 先輸入容納人數, 然後點擊新增餐枱</li>
                                <li class="list-group-item">4. 編輯完成後, 點擊"儲存餐枱位置" 以儲存餐枱佈局</li>
                              </ul>
                            </div>
                          </div>
                        </div>























                        <button id="edit" class="btn btn-warning">編輯</button>

                      </div>
                    </div>
                  </div>

                </div>
              </div>
              <!-- End of restaurant management -->
            </div>
          </div>
        </div>
      </div>
      <!-- End of Content Wrapper -->
    </div>
</body>

</html>

<script>
  let str = '<?= $json ?>';
  let timeInterval = <?= $timeInterval ?>;

  if (str != -1) {
    console.log("json data found");
    $(".layoutEditor").show();
    if (timeInterval != -1) {
      $("#timeInterval").val(timeInterval);
    }
  } else {
    console.log("no json data");
  }
</script>