var directionsService, directionsRenderer;
var mapPointNames = new Array();       // map points' name
var mapPointAddresses = new Array();   // map points' address
var startTimes = new Array();          // map points' start time
var endTimes = new Array();            // map points' end time
var map;

$(document).ready(function () {
  // set all input fields are disabled
  $("#driver-booking-form input").prop('disabled', true);
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
        mapPointNames.push(data.attraction_chinese_name);
        mapPointAddresses.push(data.chinese_address);
        startTimes.push(scheduleData[i].start_time);
        endTimes.push(scheduleData[i].end_time);
      }
    });
  }

  // route details table
  const timeDetailsTable = document.querySelector("#attraction-details");

  for (var i = 0; i < mapPointNames.length; i++) {
    timeDetailsTable.innerHTML += "<tr>"
                                  + "<td>" + mapPointNames[i] + "</td>"
                                  + "<td>" + startTimes[i] + "</td>"
                                  + "<td>" + endTimes[i] + "</td>"
                                  + "</tr>";
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

function acceptDriverBooking() {
  // initialize itinerary data
  var booking_id = document.getElementById("booking-id").value;
  var t_service = document.getElementById("tourguide-service").value;
  var t_id = document.getElementById("tourguide-id").value;

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

  // You need to use standard javascript object here
  var form = $("#driver-booking-form")[0];
  var formData = new FormData(form);

  $.ajax({
    url: "/itinerary_function.php?op=acceptDriverBooking&id=" + booking_id + "&service=" + t_service + "&tid=" + t_id,
    method: "POST",
    dataType: "json",
    data: formData,
    processData: false,
    contentType: false,
    success: function (res) {
      if (res.success === true) {
        Swal.fire({
          icon: 'success',
          title: '成功接受'
        }).then(function () {
          window.location.reload();
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

function finishDriverBooking() {
  var booking_id = document.getElementById("booking-id").value;

  Swal.fire({
    icon: 'warning',
    title: '操作確認',
    text: '是否確定完成工作？',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: '完成工作',
    cancelButtonText: '關閉'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        url: "/itinerary_function.php?op=finishDriverBooking",
        data: {id: booking_id},
        dataType: "json",
        success: function (res) {
          if (res.success === true) {
            Swal.fire({
              icon: 'success',
              title: '操作完成',
              text: '工作已完成。'
            }).then(function () {
              window.location.reload();
            })
          } else {
            Swal.fire({
              icon: 'success',
              title: 'Error',
              text: res.reason
            });
          }
        }
      });
    }
  })
}

function cancelBooking() {
  var booking_id = document.getElementById("booking-id").value;

  Swal.fire({
    icon: 'warning',
    title: '操作確認',
    text: '是否確定取消工作？',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: '取消工作',
    cancelButtonText: '關閉'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        url: "/itinerary_function.php?op=cancelBooking&id=" + booking_id,
        data: {id: booking_id},
        dataType: "json",
        success: function (res) {
          if (res.success === true) {
            Swal.fire({
              icon: 'success',
              title: '操作完成',
              text: '工作已取消。'
            }).then(function () {
              window.location.reload();
            })
          } else {
            Swal.fire({
              icon: 'success',
              title: 'Error',
              text: res.reason
            });
          }
        }
      });
    }
  })
}