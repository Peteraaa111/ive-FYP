var directionsService, directionsRenderer;
var mapPointNames = new Array();       // map points' name
var mapPointAddresses = new Array();   // map points' address
var map;
$(document).ready(function () {
  $("#update-tourgroup-btn").click(function() {
    if ($("#tourgroup-people").val() > 0) {
      alert("由於旅行團已有參加者，所以未能更改。");
      return;
    } else {
      updateTourGroup();
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

function createTourGroup() {
  // get form data
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
  if (subject == "") {
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
    var form = $("#create-tourgroup-form")[0];
    var formData = new FormData(form);

    $.ajax({
      method: "POST",
      url: "/itinerary_function.php?op=createTourGroupInList",
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
  } // end if
}

function updateTourGroup() {

  // get form data
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
  if (subject == "") {
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
    var form = $("#update-tourgroup-form")[0];
    var formData = new FormData(form);

    $.ajax({
      method: "POST",
      url: "/itinerary_function.php?op=updateTourGroup",
      data: formData,
      dataType: "json",
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      success: function (res) {
        if (res.success === true) {
          Swal.fire({
            icon: 'success',
            title: '成功更新'
          }).then(function () {
            location.reload();
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

function cancel_joinTourgroup() {
  if (confirm("確定取消報名？") == true) {
    var joined = document.getElementById("joined").value;
    // Package the form data
    var form = $("#update-tourgroup-form")[0];
    var formData = new FormData(form);

    $.ajax({
      method: "POST",
      url: "/itinerary_function.php?op=cancelJoinTourGroup&join=" + joined,
      data: formData,
      dataType: "json",
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      success: function (res) {
        if (res.success === true) {
          Swal.fire({
            icon: 'success',
            title: '成功取消'
          }).then(function () {
            window.location.replace("/zh-hk/membership/tourgroup_list.php");
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
  } else {
    return;
  }
}