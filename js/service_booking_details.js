var directionsService, directionsRenderer;
var mapPointNames = new Array();       // map points' name
var mapPointAddresses = new Array();   // map points' address
var map;

$(document).ready(function () {
  // set all input fields are disabled
  $("#update-booking-request-form input").prop('disabled', true);
  $("#update-booking-request-form button").prop('disabled', true);
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

  // edit button event
  $("#update-btn").click(function() {

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
  
    // if itinerary is cancelled, it cannot be change
    if ($("#booking-status").val() == 3) {
      Toast.fire({
        title: '很抱歉！因預約已取消，所以未能更新預約。'
      });
      return;
    } else if ($("#booking-status").val() == 2) {
      Toast.fire({
        title: '很抱歉！有關服務已完成辦理，因此未能更新行程。'
      });
      return;
    } else if ($("#booking-status").val() == 1) {
      Toast.fire({
        title: '很抱歉！有關服務正在處理，因此未能更新行程。'
      });
      return;
    } else if ($("#booking-date").val() <= new Date().toISOString().split('T')[0]) {
      Toast.fire({
        title: '很抱歉！因預約已逾時，所以未能更新預約。'
      });
      return;
    }

    $(this).prop('disabled', true);
    $("#driverService").prop('disabled', false);
    $("#tourguideService").prop('disabled', false);
    $("#booking-date").prop('disabled', false);
    $("#booking-date").prop('disabled', false);
    $("#booking-time").prop('disabled', false);
    $("#people-num").prop('disabled', false);
    $("#pick-address").prop('disabled', false);
    $("#drop-address").prop('disabled', false);
    $("#update-booking-request-form button").prop('disabled', false);
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
    if (!$('#driverService').is(':checked') && !$('#tourguideService').is(':checked')) {
      if (confirm("預約取消後將無法復原，確定繼續？") == true) {
        cancelBooking();
      } else {
        return;
      }
    } else {
      updateBooking();
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

// cancel booking record because there is not service is checked
function cancelBooking() {

  // initialize itinerary data
  var bookingId = document.getElementById("booking-id").value;

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
  var form = $("#update-booking-request-form")[0];
  var formData = new FormData(form);

  $.ajax({
    url: "/itinerary_function.php?op=cancelBooking&id=" + bookingId,
    method: "POST",
    dataType: "json",
    data: formData,
    processData: false,
    contentType: false,
    success: function (res) {
      if (res.success === true) {
        Swal.fire({
          icon: 'success',
          title: '成功取消'
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

function updateBooking() {
  // initialize itinerary data
  var bookingId = document.getElementById("booking-id").value;

  // initialize service data
  var driver_service = document.getElementById("driver-service");
  var tourguide_service = document.getElementById("tourguide-service");

  // assign services value
  if (document.getElementById("driverService").checked) {
    driver_service.value = 1;
  } else {
    driver_service.value = 0;
  }

  if (document.getElementById("tourguideService").checked) {
    tourguide_service.value = 1;
  } else {
    tourguide_service.value = 0;
  }

  // initialize booking data
  var bookingDate = document.getElementById("booking-date");
  var bookingTime = document.getElementById("booking-time");
  var peopleNum = document.getElementById("people-num");
  var pickAddress = document.getElementById("pick-address");
  var dropAddress = document.getElementById("drop-address");

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

  // check for empty values of date, time and number of people
  if (bookingDate.value == "" || bookingTime.value == "" || peopleNum.value == "") {
    Toast.fire({
      title: '請輸入出發日子、出發時間及遊客人數以更新預約。'
    });
    return;
  } else if (bookingDate.value <= new Date().toISOString().split('T')[0]) {
    Toast.fire({
      title: '請輸入有效日期以更新預約。'
    });
    return;
  } else if (pickAddress.value == "" || dropAddress.value == "") {
    Toast.fire({
      title: '請輸入集合地點及解散地點以更新預約。'
    });
    return;
  }

  // You need to use standard javascript object here
  var form = $("#update-booking-request-form")[0];
  var formData = new FormData(form);

  $.ajax({
    url: "/itinerary_function.php?op=updateBooking&id=" + bookingId,
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