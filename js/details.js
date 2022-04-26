var map;
var geocoder;
// var address;

// $(document).ready(function () {

//   // set the address is chinese when the chinese's hyperlink is clicked
//   $("#chi-map-btn").click(function(){
//     address = $("#chi-map-btn").text();
//     loadMap();
//   });

//   // set the address is english when the chinese's hyperlink is clicked
//   $("#eng-map-btn").click(function(){
//     address = $("#eng-map-btn").text();
//     loadMap();
//   });
// });

function loadMap() {
  // get the longitude and latitude from the hidden inputs
  longitude = parseFloat(document.getElementById("longitude").value);
  latitude = parseFloat(document.getElementById("latitude").value);

  // initialize the marker div
  var infoWind = new google.maps.InfoWindow();
  
  // initialize the map postion
  var pune = { lat: latitude, lng: longitude };
  map = new google.maps.Map(document.getElementById("map-view"), {
    zoom: 17,
    center: pune,
  });

  // setting up the marker
  var marker = new google.maps.Marker({
    position: new google.maps.LatLng(latitude, longitude),
    map: map
  });

  // // mouse over the marker event
  // marker.addListener("mouseover", function () {
  //   infoWind.setContent(address);
  //   infoWind.open(map, marker);
  // });
}