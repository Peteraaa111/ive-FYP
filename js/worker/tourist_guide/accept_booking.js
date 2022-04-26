var directionsService, directionsRenderer;
var mapPointNames = new Array();       // map points' name
var mapPointAddresses = new Array();   // map points' address
var map;

$(document).ready(function () {
  // set all input fields are disabled
  $("#update-booking-request-form input").prop('disabled', true);
  $("#pickUpAddress").hide();

  // set the check boxes are checked or not depending on the data
  if ($('#driverService').is(':checked') || $('#tourguideService').is(':checked')) {
    $("#pickUpAddress").show();
  }

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
        mapPointAddresses.push(data.attraction_chinese_name); 
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
  var id = $('#booking-id').val();
  Swal.fire({
    icon: 'info',
    title: '確認操作',
    text: '是否確定接受這預約？',
    showCancelButton: true,
    confirmButtonText: '接受',
    cancelButtonText: '關閉'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "GET",
        url: "/function.php?op=touristGuideAcceptBooking",
        data: {id: id},
        dataType: "json",
        success: function (res) {
          if (res.success === true) {
            Swal.fire({
              icon: 'success',
              title: '接受預約',
              text: '已接受這預約。'
            }).then(function () {
              location.reload();
            });
          }
        }
      });
    }
  })
}

function cancelBooking() {
  alert('Cancel Booking Function');
}