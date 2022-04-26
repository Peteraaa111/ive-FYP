var directionsService, directionsRenderer;
var mapPointIds = new Array();       // map points' id
var mapPointNames = new Array();       // map points' name
var mapPointAddresses = new Array();   // map points' address
var latitudes = new Array();           // map points' latitude
var longitudes = new Array();          // map points' longitude
var startTimes = new Array();          // map points' start time
var endTimes = new Array();            // map points' end time
var map;

$(document).ready(function () {
  // set all input fields are disabled
  $("#update-itinerary-request-form input").prop('disabled', true);
  $("#update-itinerary-request-form button").prop('disabled', true);

  // edit button event
  $("#update-btn").click(function() {
    $(this).prop('disabled', true);
    $("#update-itinerary-request-form input").prop('disabled', false);
    $("#update-itinerary-request-form button").prop('disabled', false);
    $("html, body").animate({ scrollTop: 880 }, 0);
  });

  // cancel button event
  $("#cancel-btn").click(function() {
    if (confirm("所有已更改的資料會被取消，確定繼續？") == true) {
      location.reload();
    } else {
      return;
    }
  });

  // submit button event
  $("#submit-btn").click(function() {
    updateItinerary();
  });

  // booking button function
  $("#booking-btn").click(function() {
    
  });
});

function loadMap() {
  directionsService = new google.maps.DirectionsService();
  directionsRenderer = new google.maps.DirectionsRenderer();

  // initialize all data div
  var scheduleData = JSON.parse(document.getElementById("schedule-data").innerHTML);
  var attractionData = JSON.parse(document.getElementById("attraction-data").innerHTML);

  //for getting data to generate route
  for (var i = 0; i < scheduleData.length; i++) {
    Array.prototype.forEach.call(attractionData, function (data) {
      if (scheduleData[i].attraction_id == data.attraction_id) {
        mapPointIds.push(data.attraction_id);
        mapPointNames.push(data.attraction_chinese_name);
        mapPointAddresses.push(data.chinese_address);
        latitudes.push(data.latitude);
        longitudes.push(data.longitude);
        startTimes.push(scheduleData[i].start_time);
        endTimes.push(scheduleData[i].end_time);
      }
    });
  }

  // route details table
  const timeDetailsTable = document.querySelector("#attraction-details");

  for (var i = 0; i < mapPointNames.length; i++) {
    timeDetailsTable.innerHTML += "<tr id=" + mapPointIds[i] + "><td>" + mapPointNames[i] + "</td>"
                                  + "<td><input type='hidden' name='attraction[]' value='" + mapPointIds[i] + "' />"
                                  + "<input type='time' class='form-control' name='startTime[]' value='" + startTimes[i] + "' /></td>"
                                  + "<td><input type='time' class='form-control' name='endTime[]' value='" + endTimes[i] + "' /></td>"
                                  + "<td><button type='button' class='btn btn-outline-primary' name='remove-btn' onclick='removeAttraction(" + mapPointIds[i] + ")'>移除</button></td></tr>";
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
      drawRoute(Points[mapPointNames.length - 2], Points[Points.length - 1], _waypoints);  
  } else {  
      //Call a drawRoute() function only for one point as start and end locations.  
      drawRoute(Points[mapPointNames.length - 1], Points[Points.length - 1], _waypoints);  
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

        // route details table
        const detailsTable = document.querySelector("#detailsTable");
        var markerCount = { 0 : "A → B", 1 : "B → C", 2 : "C → D", 3 : "D → E", 4 : "E → F", 5 : "F → H"};
        
        // looping for route details table
        for (var i = 0; i < _response.routes[0].legs.length; i++) {
          detailsTable.innerHTML += "<tr><td>" + markerCount[i] + "</td>"
                                  + "<td>" + mapPointNames[i] + "</td>"
                                  + "<td>" + mapPointNames[i+1] + "</td>"
                                  + "<td>" + _response.routes[0].legs[i].distance.text + "</td>" 
                                  + "<td>" + _response.routes[0].legs[i].duration.text + "</td></tr>";
        }
      }  
  });  
}

// remove attraction row on the attraction details table
function removeAttraction(id) {
  var attravtion_table = document.getElementById("attraction-details").rows.length - 1;

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

  // checking for table must include two rows
  if (attravtion_table <= 2) {
    Toast.fire({
      title: '行程必須由至少兩個景點組成。'
    });
    return;
    
  } else {
    document.getElementById(id).remove();
  }
}

function updateItinerary() {
  // initialize itinerary data
  var itineraryId = document.getElementById("itinerary-id").value;
  var chineseName = document.getElementById("chi-itinerary-name");
  var englishName = document.getElementById("eng-itinerary-name");

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
  if (chineseName.value == "" && englishName.value == "") {
    Toast.fire({
      title: '請輸入行程的中文名稱或英文名稱以更新行程。'
    });
    return;
  }

  // check for each destination starting time
  var startTime = document.querySelectorAll("#update-itinerary-request-form input[name='startTime[]']");
  for (var i = 0; i < startTime.length; i ++) {
    if (startTime[i].value == "") {
      Toast.fire({
        title: '請輸入每個地點的開始時間以更新行程。'
      });
      return;
    }
  }

  // check for each destination ending time
  var endTime = document.querySelectorAll("#update-itinerary-request-form input[name='endTime[]']");
  for (var i = 0; i < endTime.length; i ++) {
    if (endTime[i].value == "") {
      Toast.fire({
        title: '請輸入每個地點的結束時間以更新行程。'
      });
      return;
    }
  }

  // You need to use standard javascript object here
  var form = $("#update-itinerary-request-form")[0];
  var formData = new FormData(form);

  $.ajax({
    url: "/itinerary_function.php?op=tourGuideUpdateItinerary&id=" + itineraryId,
    method: "POST",
    dataType: "json",
    data: formData,
    processData: false,
    contentType: false,
    success: function (res) {
      if (res.success === true) {
        Swal.fire({
          icon: 'success',
          title: '成功更新'
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

function tourgroupRequest() {
  var itinerary_id = document.getElementById("itinerary-id").value;
  document.location.href = "http://localhost/create_tourgroup.php?id=" + itinerary_id;
}