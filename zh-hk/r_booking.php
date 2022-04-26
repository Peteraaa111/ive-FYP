<?php
// This is real.Booking
// Start the SESSION
session_start();

include_once('../dbConnect.php');
global $conn;

// Get the restaurant id
$restaurant_id = $_GET['id'];

// Get the restaurant details
$details_sql = "SELECT * FROM `restaurant` WHERE `restaurant_id` = $restaurant_id;";
$details_rs = mysqli_query($conn, $details_sql);
$details = mysqli_fetch_assoc($details_rs);



// ================ Get Table Layout Json ================
$restaurant_id = $_GET['id'];
$json = "";

$findExistingQuery = "SELECT * FROM restaurant_layout WHERE `restaurant_id` = '$restaurant_id';";
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
  <title>餐廳預約 - 香港本地旅遊平台 | 本地遊</title>

  <!-- Link the default css and js library -->
  <?php include_once('../library.php'); ?>

  <link href="/css/collab_form.css" rel="stylesheet">
  <link href="/css/r_details.css" rel="stylesheet">

  <script src="/js/r_booking.js"></script>

  <link rel="stylesheet" href="../js/jqueryui/jquery-ui.css">
  <script src="../js/jqueryui/jquery-ui.min.js"></script>

  <style>
    .draggable {
      text-align: center;
      position: initial;
      width: 70px;
      height: 70px;
      float: left;
      cursor: pointer;
      position: absolute;
    }

    #containment-wrapper {
      height: 500px;
      border: 2px solid #ccc;
      padding: 10px;
      overflow: auto;
      position: relative;
      margin-top: 20px;
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

  <script>
    var selected = [];
    var tableid = [];



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


    var isMissing = false;

    $(document).on("click", "#addObj", function() {

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

      tableid.push(id);
      var $element = $('<div class="draggable ui-widget-content"/>').text("餐桌 " + id + "\n" + ppl + "人")

      $element.html($element.html().replace(/\n/g, '<br/>'));

      $element.attr({
        'id': id,
        'data-ppl': ppl
      });
      $("#containment-wrapper").append($element);
      becomeDraggable();
      tableid.sort();
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
      // when draggable is clicked
      $(".clickable").click(function() {

        var collator = new Intl.Collator(undefined, {
          numeric: true,
          sensitivity: 'base'
        });

        $(".selected").show();

        $("#clear").show();

        // $(this).slideUp();                
        // div {border-color: coral;}
        $(this).css("border-color", "green");
        $(this).css("color", "green");
        // Add selected div to list

        // selected = _.union(selected, $(this).attr('id'));

        selected.push($(this).attr('id'));
        selected = selected.filter(onlyUnique);

        selected = selected.sort(collator.compare);

        let message = "";
        let forStoring = "";

        for (let i = 0; i < selected.length; i++) {
          message += "餐桌" + selected[i] + " ";
          forStoring += selected[i] + ",";
        }

        $("#tableSelected").val("已選取: " + message);

        forStoring = forStoring.slice(0, -1);
        $("#table").val(forStoring);

      });

      $(".clickable").dblclick(function() {

        let newSelection = "";
        var elem = $(this),
          id = elem.attr('id');

        const index = selected.indexOf(id);
        if (index > -1) {
          selected.splice(index, 1);
        }

        $(this).css("border-color", "");
        $(this).css("color", "");

        selected = selected.filter(onlyUnique);
        selected.sort();

        for (let i = 0; i < selected.length; i++) {
          newSelection += "餐桌" + selected[i] + " ";
        }

        $("#tableSelected").val("已選取: " + newSelection);
      });

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
      var json = <?= $json ?>;
      if (json == -1) {
        $("#restaurantLayout1").hide();
        $("#selectedTable").hide();
        $("#selectedTable").hide();
      }
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


</head>

<body>
  <!-- Header -->
  <?php include_once('common/header.php'); ?>

  <!-- Category -->
  <?php include_once('common/category.php'); ?>

  <!-- Main Content -->
  <!-- Main Content -->
  <section id="banner" class="padding-4rem mb-4">
    <div id="banner-background" class="bg-dark rounded-3" style="background-image: url(/data/site/restaurant/<?php echo $details['restaurant_id']; ?>/banner.jpg);"></div>
    <div id="banner-info" class="container py-5">
      <div class="row">
        <div class="col-md-12 text-center">
          <h1 class="fw-bold" style="text-shadow: 1px 1px grey;">
            <?php echo $details['restaurant_chinese_name']; ?>
          </h1>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 text-center" style="text-shadow: 1px 1px grey;">
          <h2>
            <?php echo $details['restaurant_english_name']; ?>
          </h2>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 text-center" style="text-shadow: 1px 1px grey;">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star-half-alt"></i>
          <i class="far fa-star"></i>
        </div>
      </div>
    </div>
  </section>

  <form id="restaurant-booking-form" enctype="multipart/form-data" method="POST">
    <!-- Restaurant id for js process -->
    <input type="hidden" id="restaurant-id" name="restaurant-id" value="<?php echo $details['restaurant_id']; ?>" />

    <div class="container card">
      <div class="card-body">
        <div class="row card">
          <div class="card-body">
            <div class="col">
              <h4 class="card-title fw-bold">餐廳預約</h4>
            </div>
          </div>
        </div>


        <div class="row card">
          <div class="card-body">

            <div class="row">
              <div class="col">
                <h5 class="card-title">預約資料</h5>
              </div>
            </div>

            <div class="row">

              <div class="col-2">
                日期時間
                <span class="text-danger">*</span>
              </div>

              <div class="col-5">
                <input type="date" class="form-control" id="booking-date" name="booking-date">
              </div>

              <div class="col-5">
                <input type="text" class="form-control" id="day-of-week" name="day-of-week" readonly>
              </div>

            </div>


            <div class="row" id="datalistInput" style="display: none;">
              <div class="col-2">
                選擇時間段
                <span class="text-danger">*</span>

              </div>

              <div class="col-5">


                <div class="input-group">
                  <select class="form-control" id="hourSelectorInputs" name="hourSelectorInput">
                  </select>
                  <span class="input-group-text">時</span>
                </div>



              </div>

              <div class="col-5">
                <div class="input-group" style="display: none;" id="inputGroupForMinute">
                  <select class="form-control" style="display: none;" id="minuteSelectorInput">
                  </select>
                  <span class="input-group-text">分</span>
                </div>
              </div>

            </div>

            <div class="row" id="rowBookingTime" style="display: none;">
              <div class="col-2">
                選擇的時間<span class="text-danger">*</span>
              </div>
              <div class="col-5">
                <div class="input-group">
                  <span class="input-group-text">入座</span>
                  <input type="time" class="form-control" name="booking-time" id="booking-time">
                </div>
              </div>

              <div class="col-5" id="intervalDisplay" style="display: none;">
                <div class="input-group">
                  <span class="input-group-text">每輪時間</span>
                  <input type="text" class="form-control" id="interval" value="" readonly></input>
                  <span class="input-group-text">分鐘</span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-2">
                顧客人數
                <span class="text-danger">*</span>
              </div>
              <div class="col">
                <div class="input-group">
                  <input type="number" class="form-control" id="people" name="people">
                  <span class="input-group-text">人</span>
                </div>
              </div>
            </div>



            <div class="row" id="restaurantLayout1" style="display: none;">
              <div class="col-2">
                選擇餐枱
                <span class="text-danger">*</span>
              </div>
              <div class="col">

                <div id="containment-wrapper">
                  <script>
                    str = '<?= $json ?>';

                    if (str !== "") {
                      const obj = JSON.parse((str));
                      for (let i = 0; i < obj.length; i++) {
                        var table = document.createElement('div');
                        table.innerHTML = '<div class="draggable clickable ui-widget-content butNotHere" id="' + (i + 1) + '" style="left:' + obj[i].left + 'px; top:' + obj[i].top + 'px"' + 'data-ppl=' + obj[i].ppl + '>餐桌 ' + (i + 1) + "<br/>" + obj[i].ppl + "人" + '</div>';
                        $("#containment-wrapper").append(table);
                        tableid.push(i);
                        becomeDraggable();
                      }

                      // TODO: Check if the id is missing
                      tableid.push(obj.length);
                      tableid.sort();
                    }
                  </script>
                </div>
              </div>
            </div>


            <div class="row" id="selectedTable" style="display: none;">
              <div class="col-2">
                你選擇的餐枱
                <span class="text-danger">*</span>
              </div>
              <div class="col">

                <span tabindex="0" data-bs-toggle="tooltip" title="單擊方塊選擇餐枱, 
                雙鍵點擊取消選擇">

                  <input type="text" class="form-control" id="tableSelected" name="tableSelected" placeholder="點擊上圖方塊以選擇餐枱" readonly />

                  <input type="hidden" class="form-control" id="table" name="table" readonly />

                </span>

              </div>
            </div>



            <div class="row">
              <div class="col-2">
                聚餐主題
              </div>
              <div class="col">
                <input type="text" class="form-control" id="booking-subject" name="booking-subject" placeholder="附加資訊 (可選)">
              </div>
            </div>


            <div class="row">
              <div class="col-2">
                食物敏感備註
              </div>
              <div class="col">
                <input type="text" class="form-control" id="booking-description" name="booking-description" placeholder="不多於100字">
              </div>
            </div>


          </div>
        </div>


        <div class="row card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title">訂座人資料</h5>
              </div>
            </div>
            <div class="row">
              <div class="col-2">
                顧客名稱
                <span class="text-danger">*</span>
              </div>
              <div class="col">
                <input type="text" class="form-control" id="contact-name" name="contact-name">
              </div>
            </div>
            <div class="row">
              <div class="col-2">
                電話號碼
                <span class="text-danger">*</span>
              </div>
              <div class="col">
                <input type="tel" class="form-control" id="contact-number" name="contact-number" minlength="8" maxlength="8" oninput="value=value.replace(/[^\d]/g,'')">
              </div>
            </div>
            <div class="row">
              <div class="col-2">
                電郵地址
                <span class="text-danger">*</span>
              </div>
              <div class="col">
                <input type="text" class="form-control" id="contact-email" name="contact-email">
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col text-end">
            <button type="button" class="btn btn-secondary" id="cancel-btn">取消</button>
            <button type="button" class="btn btn-primary" onclick="restaurantBooking()">提交</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Container -->
  </form>

  <!-- Footer -->
  <?php include_once('common/footer.php'); ?>

</body>

</html>

<script>
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });
</script>
<script>
  let workingHourStart;
  let workingHourEnd;
  let workingMinuteStart;
  let workingMinuteEnd;
  let occupiedTable;

  const selectElement = document.querySelector('#booking-date');

  selectElement.addEventListener('change', (event) => {
    const selectedDate = event.target.value;
    const selectedDateArray = selectedDate.split('-');
    const selectedYear = selectedDateArray[0];
    const selectedMonth = selectedDateArray[1];
    const selectedDay = selectedDateArray[2];
    const selectedDateObject = new Date(selectedYear, selectedMonth - 1, selectedDay);
    const selectedDayOfWeek = selectedDateObject.getDay();
    const selectedDayOfWeekString = ['日', '一', '二', '三', '四', '五', '六'][selectedDayOfWeek];

    $("#hourSelectorInputs").empty();
    $("#hourSelectorInputs").val("");
    $("#minuteSelectorInput").empty();



    clearOccupation();

    $("#day-of-week").val("星期" + selectedDayOfWeekString);

    $("#hourSelectorInputs").attr("placeholder", "選擇小時");
    $("#minuteSelectorInput").attr("placeholder", "選擇分鐘");

    let queryString = window.location.search;
    let restaurantID = <?= $restaurant_id ?>;

    if (queryString.includes("date")) {
      var pageUrl = "?id=" + restaurantID + "&date=" + selectedDayOfWeekString;
      window.history.pushState('', '', pageUrl);
    } else {
      var pageUrl = queryString + "&date=" + selectedDayOfWeekString;
      window.history.pushState('', '', pageUrl);
    }

    let jsonObj;


    var ajaxurl = '/function.php?op=getWorkingTime',
      data = {
        'restaurant_id': <?= $restaurant_id ?>,
        'booking_date': $("#realdate").val(),
        'booking_time_start': $("#realTimeStart").val(),
        'booking_time_end': $("#realTimeEnd").val()
      };
    $.post(ajaxurl, data, function(response) {
      if (response == -1) {
        alert("無法找到餐廳");
      } else {
        jsonObj = JSON.parse((response));

      }

      let workingtime;
      let timeInterval = <?= $timeInterval ?>;

      // No time interval found
      if (timeInterval === -1) {
        $("#rowBookingTime").slideDown();
      }
      // found time interval
      else {

        // show datalist


        if (selectedDayOfWeekString == "一" || selectedDayOfWeekString == "二" || selectedDayOfWeekString == "三" || selectedDayOfWeekString == "四" || selectedDayOfWeekString == "五") {
          workingtime = jsonObj.weekday;

          if (workingtime === "closed") {
            alert("餐廳在星期一至五關門, 請選擇其他日期");
            $("#datalistInput").hide();
            $("#booking-date").val("");
            return;
          } else {
            $("#datalistInput").slideDown();

            // Show avaliable working hours
            workingHourStart = parseInt(workingtime.split(":")[0]);

            workingHourEnd = workingtime.split("-")[1];
            workingHourEnd = parseInt((workingHourEnd.split(":")[0]).trim());


            // Calculate logic with time interval 
            workingMinuteStart = parseInt(workingtime.split(":")[1]);

            workingMinuteEnd = workingtime.split("-")[1];
            workingMinuteEnd = parseInt((workingMinuteEnd.split(":")[1]).trim());


            $("#hourSelectorInputs").empty();
            $("#minuteSelectorInput").empty();

            $("#hourSelectorInputs").append($('<option/>', {
              value: -1,
              text: "請選擇訂座小時"
            }));

            $("#minuteSelectorInput").append($('<option/>', {
              value: -1,
              text: "請選擇訂座開始分鐘"
            }));

            for (let i = workingHourStart; i <= workingHourEnd; i++) {
              $('#hourSelectorInputs').append($('<option/>', {
                value: i,
                text: i
              }));
            }
          }

        } else if (selectedDayOfWeekString == "六" || selectedDayOfWeekString == "日") {

          workingtime = jsonObj.weekend;

          if (workingtime === "closed") {
            alert("餐廳在星期六至日關門, 請選擇其他日期");
            $("#datalistInput").hide();
            $("#booking-date").val("");
            return;
          } else {

            $("#datalistInput").slideDown();

            // Show avaliable working hours
            workingHourStart = parseInt(workingtime.split(":")[0]);

            workingHourEnd = workingtime.split("-")[1];
            workingHourEnd = parseInt((workingHourEnd.split(":")[0]).trim());


            // Calculate logic with time interval 
            workingMinuteStart = parseInt(workingtime.split(":")[1]);

            workingMinuteEnd = workingtime.split("-")[1];
            workingMinuteEnd = parseInt((workingMinuteEnd.split(":")[1]).trim());


            $("#hourSelectorInputs").empty();
            $("#minuteSelectorInput").empty();

            $("#hourSelectorInputs").append($('<option/>', {
              value: -1,
              text: "請選擇訂座開始小時"
            }));

            $("#minuteSelectorInput").append($('<option/>', {
              value: -1,
              text: "請選擇訂座開始分鐘"
            }));


            for (let i = workingHourStart; i <= workingHourEnd; i++) {
              $('#hourSelectorInputs').append($('<option/>', {
                value: i,
                text: i
              }));
            }
          }
        } else {
          alert("Unknown error: Unable to get day of week");
        }
      }
    });
  });

  $(document).ready(function() {
    $("#hourSelectorInputs").change(function() {

      $("#minuteSelectorInput").empty();
      $("#booking-time").val("");

      let hourSelected = parseInt($('#hourSelectorInputs').val().trim());

      if ($('#hourSelectorInputs').val() >= workingHourStart && $('#hourSelectorInputs').val() <= workingHourEnd && !Number.isNaN(hourSelected)) {

        $("#minuteSelectorInput").show();
        $("#inputGroupForMinute").show();

        timeInterval = <?= $timeInterval ?>;

        let minute = workingMinuteStart;


        $("#minuteSelectorInput").empty();
        $("#minuteSelectorInput").append($('<option/>', {
              value: -1,
              text: "請選擇訂座開始分鐘"
            }));


        var j = workingHourStart;

        while (j < workingHourEnd + 1) {

          minute += timeInterval;

          if (j === workingHourEnd && minute > workingMinuteEnd) {
            break;
          }

          while (minute > 59) {
            minute -= 60;
            j++;
          }

          if (j == hourSelected) {
            if (j == workingHourEnd && (minute + timeInterval) > workingMinuteEnd) {
              break;
            } else {
              $('#minuteSelectorInput').append($('<option/>', {
                value: minute,
                text: minute
              }));
            }
          }

        }
        if ($('#minuteSelectorInput option').length == 1) {
          alert("您當前所選擇的小時並沒有提供可選擇的時間");
          $('#hourSelectorInputs').val(-1);
          $("#inputGroupForMinute").hide();
          $("#rowBookingTime").hide();
        }
      }
    });




    $("#minuteSelectorInput").change(function() {

      if ($("#minuteSelectorInput").val() === "" || $("#hourSelectorInputs").val() === "") {
        alert("請選擇時間段");
      } else {
        newTimeChanges();
        loadOccupation();
      }
    });
  });

  function newTimeChanges() {

    let hr = $("#hourSelectorInputs").val();
    let min = $("#minuteSelectorInput").val();

    $("#rowBookingTime").slideDown();
    $("#booking-time").prop('readonly', true);

    if (hr.length == 1) {
      hr = "0" + hr;
    }
    if (min.length == 1) {
      min = "0" + min;
    }


    $("#booking-time").val(hr + ":" + min);

    $("#restaurantLayout1").slideDown();
    $("#selectedTable").slideDown();

    $("#intervalDisplay").show();
    $("#interval").val(timeInterval);

  }

  function loadOccupation() {
    var ajaxurl = '/function.php?op=findBookingByDateAndTime',
      data = {
        'restaurant_id': <?= $restaurant_id ?>,
        'booking_date': $("#booking-date").val(),
        'booking_time': $("#booking-time").val()
      };
    $.post(ajaxurl, data, function(response) {
      console.log("response: " + response);

      occupiedTable = response;
      occupiedTable = occupiedTable.slice(1);
      occupiedTable = occupiedTable.slice(0, occupiedTable.length - 1);
      occupiedTable = occupiedTable.replace(/['"]+/g, '')
      occupiedTable = occupiedTable.split(",");

      if (response == -1) {
        console.log("no data");
        clearOccupation();
      } else {
        for (let n = 0; n < occupiedTable.length; n++) {
          $("#" + occupiedTable[n]).css("color", "red");
          $("#" + occupiedTable[n]).css("border-color", "red");

          $("#" + occupiedTable[n]).removeClass("clickable");

          $("#" + occupiedTable[n]).addClass("occupied");
          $("#" + occupiedTable[n]).unbind();


        }
        $(".occupied").click(function() {
          alert("您選擇的桌號已被預訂");
        });
      }
    });
  }

  function clearOccupation() {
    $(".draggable").each(function() {
      $(this).unbind();
      $(this).css("color", "");
      $(this).css("border-color", "");
      $(this).removeClass("occupied");
      $(this).addClass("clickable");

      $("#tableSelected").val("");

      becomeDraggable();
    });
  }

  $("#hourSelectorInputs").focus(function() {
    if ($('#booking-date').val() === "") {
      alert("請先選擇日期");
      $(this).blur();
    }
  });

  $("#minuteSelectorInput").focus(function() {
    if ($('#booking-date').val() === "") {
      alert("請先選擇日期");
      $(this).blur();
    }
  });
</script>