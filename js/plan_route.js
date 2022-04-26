var directionsService;
var directionsRenderer = '';
var mapPoints = new Array();
var mapPointAddresses = new Array();
var map;

$(document).ready(function () {
  $("#pickUpAddress").hide();
  $("#create-tourgroup").hide();
  $("option").prop("disabled", true);

  var today = new Date().toISOString().split('T')[0];
  $("#tourgroup-date").attr("min", today);
  $("#cut-off-date").attr("min", today);

  // show the pick up and drop off form to the user
  $("#driverService").change(function(){
    if ($('#driverService').is(':checked') || $('#tourguideService').is(':checked')) {
      $("#pickUpAddress").show("slow");
    } else {
      $("#pickUpAddress").hide("slow");
    }
  });

  // show the pick up and drop off form to the user
  $("#tourguideService").change(function(){
    if ($('#tourguideService').is(':checked') || $('#driverService').is(':checked')) {
      $("#pickUpAddress").show("slow");
    } else {
      $("#pickUpAddress").hide("slow");
    }
  });

  // show the create tourgroup form
  $("#create-tourgroup-service").change(function() {
    if ($('#create-tourgroup-service').is(':checked')) {
      $("#create-tourgroup").show("slow");
    } else {
      $("#create-tourgroup").hide("slow");
    }
  });

  $("#tourguide-plan-route").click(function() {
    if ($('#create-tourgroup-service').is(':checked')) {
      createTourGroup();
    } else {
      tourguide_createItinerary();
    }
  });
});

function loadMap() {
  directionsService = new google.maps.DirectionsService();
  directionsRenderer = new google.maps.DirectionsRenderer();

  // get attraction data
  var attraction_allData = JSON.parse(
    document.getElementById("attraction_allData").innerHTML
  );

  // need to modify
  var attraction_id = new Array();
  var attraction_records = document.querySelectorAll("#schedule input[name='attraction[]']");

  for (var i = 0; i < attraction_records.length; i++) {
    attraction_id.push(attraction_records[i].value);
  }

  // for getting data chinese address to generate route
  for (var i = 0; i < attraction_id.length; i++) {
    Array.prototype.forEach.call(attraction_allData, function (data) {
      if (attraction_id[i] == data.ID) {
        mapPoints.push(data.Chinese_Name);
        mapPointAddresses.push(data.chinese_address);
      }
    });
  }

  //Define the map.  
  var pune = { lat: 22.388967, lng: 114.1095893 };
  map = new google.maps.Map(document.getElementById("map"), {
    zoom: 11,
    center: pune,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });

  //Set the map for directionsRenderer  
  directionsRenderer.setMap(map); 

  //Set different options for DirectionsRenderer mehtods.  
    //draggable option will used to drag the route.  
    directionsRenderer.setOptions({  
      draggable: false  
  });
  
  drawRoutePointsAndWaypoints(mapPointAddresses);  
}
 
function drawRoutePointsAndWaypoints(Points) {  
  //Define a variable for waypoints.  
  var _waypoints = new Array();  
 
  if (Points.length > 2) //Waypoints will be come.  
  {  
      for (var j = 1; j < Points.length - 1; j++) {  
          var address = Points[j];  
          if (address !== "") {  
              _waypoints.push({  
                  location: address,  
                  stopover: true  //stopover is used to show marker on map for waypoints  
              });  
          }  
      }  
      //Call a drawRoute() function  
      drawRoute(Points[0], Points[Points.length - 1], _waypoints);  
  } else if (Points.length > 1) {  
      //Call a drawRoute() function only for start and end locations  
      drawRoute(Points[mapPoints.length - 2], Points[Points.length - 1], _waypoints);  
  } else {  
      //Call a drawRoute() function only for one point as start and end locations.  
      drawRoute(Points[mapPoints.length - 1], Points[Points.length - 1], _waypoints);  
  }  
} 

function drawRoute(originAddress, destinationAddress, _waypoints) {  
  //Define a request variable for route .  
  var _request = '';  
 
  //This is for more then two locatins  
  if (_waypoints.length > 0) {  
      _request = {  
          origin: originAddress,  
          destination: destinationAddress,  
          waypoints: _waypoints, //an array of waypoints  
          optimizeWaypoints: true, //set to true if you want google to determine the shortest route or false to use the order specified.  
          travelMode: google.maps.DirectionsTravelMode.DRIVING  // mode for driving route
      };  
  } else {  
      //This is for one or two locations. Here noway point is used.  
      _request = {  
          origin: originAddress,  
          destination: destinationAddress,  
          travelMode: google.maps.DirectionsTravelMode.DRIVING  // mode for driving route
      };  
  }  
 
  //This will take the request and draw the route and return response and status as output  
  directionsService.route(_request, function(_response, _status) {  
      if (_status == google.maps.DirectionsStatus.OK) {  

        // display route
        directionsRenderer.setDirections(_response);  

        const detailsTable = document.querySelector("#detailsTable");
        var markerCount = { 0 : "A → B", 1 : "B → C", 2 : "C → D", 3 : "D → E", 4 : "E → F", 5 : "F → H"};
        
        for (var i = 0; i < _response.routes[0].legs.length; i++) {
          detailsTable.innerHTML += "<tr><td>" + markerCount[i] + "</td><td>" + mapPoints[i] + "</td><td>" + mapPoints[i+1]+ "</td><td>" 
          + _response.routes[0].legs[i].distance.text + "</td><td>" + _response.routes[0].legs[i].duration.text + "</td></tr>";
        }
      }  
  });  
}

// store data process
function createItinerary() {

  // initialize itinerary's subject data
  var chineseName = document.getElementById("chi-name");
  var englishName = document.getElementById("eng-name");

  // initialize booking's service data details
  var bookingDate = document.getElementById("bookingDate");
  var bookingTime = document.getElementById("bookingTime");
  var peopleNum = document.getElementById("peopleNum");
  var pickAddress = document.getElementById("pickAddress");
  var dropAddress = document.getElementById("dropAddress");
  var driverService = 0, tourguideService = 0, itineraryStatus = 0;

  // Setting up the Toast message
  const Toast = Swal.mixin({
    toast: true,
    icon: 'error',
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })

  // check the itinerary subject is valid or not
  if (document.getElementById("chi-itinerary-name").value == "" &&
      document.getElementById("eng-itinerary-name").value == "") {
    Toast.fire({
      title: '請輸入行程的中文名稱或英文名稱以創建行程。'
    });
    return;

  } else {
    chineseName.value = document.getElementById("chi-itinerary-name").value;
    englishName.value = document.getElementById("eng-itinerary-name").value;
  }

  // check for empty values of date, time and number of people
  if (document.getElementById('driverService').checked || document.getElementById('tourguideService').checked) {
    if (document.getElementById("booking-date").value == "" || 
        document.getElementById("booking-time").value == "" || 
        document.getElementById("people-num").value == "") {
      Toast.fire({
        title: '請輸入出發日子、出發時間及遊客人數以創建行程。'
      });
      return;

    } else {

      // check for booking date is valid or not
      if (document.getElementById("booking-date").value <= new Date().toISOString().split('T')[0]) {
        Toast.fire({
          title: '請輸入有效日期以編輯行程。'
        });
        return;
      }

      // assign datas into hidden input fieldss
      bookingDate.value = document.getElementById("booking-date").value;
      bookingTime.value = document.getElementById("booking-time").value;
      peopleNum.value = document.getElementById("people-num").value;
      itineraryStatus = 1;

      // set pick address and drop address into fields
      if (document.getElementById("pick-address").value == "") {
        pickAddress.value = mapPoints[0];
      } else {
        pickAddress.value = document.getElementById("pick-address").value;
      }
      
      if (document.getElementById("drop-address").value == "") {
        dropAddress.value = mapPoints[mapPoints.length - 1];
      } else {
        dropAddress.value = document.getElementById("drop-address").value;
      }

      if (document.getElementById('driverService').checked) {
        driverService = 1;
      } else if (document.getElementById('tourguideService').checked) {
        tourguideService = 1;
      }
    }
  }

  // You need to use standard javascript object here
  var form = $("#schedule")[0];
  var formData = new FormData(form);

  $.ajax({
    url: "/itinerary_function.php?op=createItinerary&driver=" + driverService 
                                                              + "&tourGuide=" + tourguideService
                                                              + "&status=" + itineraryStatus,
    method: "POST",
    dataType: "json",
    data: formData,
    processData: false,
    contentType: false,
    success: function (res) {
      if (res.success === true) {
        Swal.fire({
          icon: 'success',
          title: '成功創建'
        }).then(function () {
          window.location.replace("/zh-hk/");
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: '錯誤',
          text: res.reason
        });
      }
    },
    error: function (res) {
      Swal.fire({
        icon: 'error',
        title: '錯誤',
        text: res.responseText
      });
    },
  });
}

// tourguide create tourgroup
function createTourGroup() {
  // get form data
  var itinerary_name = document.getElementById("chi-itinerary-name").value;
  var subject = document.getElementById("tourgroup-subject").value;
  var description = document.getElementById("tourgroup-description").value;
  var fee = document.getElementById("tourgroup-fee").value;
  var start_date = document.getElementById("tourgroup-date").value;
  var start_time = document.getElementById("tourgroup-time").value;
  var max_people = document.getElementById("max-people").value;
  var start_address = document.getElementById("start-address").value;
  var end_address = document.getElementById("end-address").value;
  var cut_date = document.getElementById("cut-off-date").value;
  var statusPublic = document.getElementById("status-public");
  var statusHidden = document.getElementById("status-hidden");

  var tourgroup_description = document.getElementById("description");

  // Setting up the Toast message
  const Toast = Swal.mixin({
    toast: true,
    icon: 'error',
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })

  // Validation checking
  if (itinerary_name == "") {
    Toast.fire({
      title: '行程名稱不能為空白。'
    });
  } else if (subject == "") {
    Toast.fire({
      title: '旅行團名稱不能為空白。'
    });
  } else if (description == "") {
    Toast.fire({
      title: '行程內容不能為空白。'
    });
  } else if (fee == "") {
    Toast.fire({
      title: '行程收費不能為空白。'
    });
  } else if (start_date == "") {
    Toast.fire({
      title: '出發日期不能為空白。'
    });
  } else if (start_time == "") {
    Toast.fire({
      title: '出發時間不能為空白。'
    });
  } else if (max_people == "") {
    Toast.fire({
      title: '上限人數不能為空白。'
    });
  } else if (start_address == "") {
    Toast.fire({
      title: '集合地點不能為空白。'
    });
  } else if (end_address == "") {
    Toast.fire({
      title: '解散地點不能為空白。'
    });
  } else if (cut_date == "") {
    Toast.fire({
      title: '截止日期不能為空白。'
    });
  }else if (fee < 0) {
    Toast.fire({
      title: '請輸入正確的行程收費。'
    });
  } else if (!statusPublic.checked && !statusHidden.checked) {
    Toast.fire({
      title: '請選擇行程狀態。'
    });
  } else {
 
    tourgroup_description.value = description;

    // Package the form data
    var form = $("#schedule")[0];
    var formData = new FormData(form);

    $.ajax({
      method: "POST",
      url: "/itinerary_function.php?op=createTourGroup",
      data: formData,
      dataType: "json",
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      success: function (res) {
        if (res.success === true) {
          Swal.fire({
            icon: 'success',
            title: '成功創建'
          }).then(function () {
            window.location.replace("http://localhost/tourguide_planner.php");
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: '錯誤',
            text: res.reason
          });
        }
      },
      error: function (res) {
        Swal.fire({
          icon: 'error',
          title: '錯誤',
          text: res.responseText
        });
      },
    });
  } // end if
}

function tourguide_createItinerary() {
  var subject = document.getElementById("chi-itinerary-name").value;

  // Setting up the Toast message
  const Toast = Swal.mixin({
    toast: true,
    icon: 'error',
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })

  if (subject == "") {
    Toast.fire({
      title: '行程名稱不能為空白。'
    });
  } else {
    // Package the form data
    var form = $("#schedule")[0];
    var formData = new FormData(form);

    $.ajax({
      method: "POST",
      url: "/itinerary_function.php?op=createItinerary_tourGuide",
      data: formData,
      dataType: "json",
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      success: function (res) {
        if (res.success === true) {
          Swal.fire({
            icon: 'success',
            title: '成功創建'
          }).then(function () {
            window.location.replace("list.php");
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: '錯誤',
            text: res.reason
          });
        }
      },
      error: function (res) {
        Swal.fire({
          icon: 'error',
          title: '錯誤',
          text: res.responseText
        });
      },
    });
  }
}