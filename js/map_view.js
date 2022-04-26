var map;
var geocoder;

function loadMap() {

  var pune = { lat: 22.388967, lng: 114.1095893 };
  map = new google.maps.Map(document.getElementById("map"), {
    zoom: 11,
    center: pune,
  });

  var infoWind = new google.maps.InfoWindow();

  // get all data of restaurant div form map_view page
  var restaurant_allData = JSON.parse(
    document.getElementById("restaurant_allData").innerHTML
  );

  // get all data of attraction div form map_view page
  var attraction_allData = JSON.parse(
    document.getElementById("attraction_allData").innerHTML
  );

  // get all data of guesthouse div form map_view page
  var guesthouse_allData = JSON.parse(
    document.getElementById("guesthouse_allData").innerHTML
  );

  // initialize all markers
  initailMapMarkers(infoWind, restaurant_allData, "R");
  initailMapMarkers(infoWind, attraction_allData, "A");
  initailMapMarkers(infoWind, guesthouse_allData, "G");
}

// initialize all type of markers
function initailMapMarkers(infoWind, allData, markerLabel) {

  Array.prototype.forEach.call(allData, function (data) {

    // create maker div
    var infowincontent = document.createElement("div");
    infowincontent.style.width = "280px";

    // item subject
    var header = document.createElement("strong"); // tag text
    header.textContent = "名稱 : " + data.Chinese_Name;
    infowincontent.appendChild(header);
    infowincontent.appendChild(document.createElement("br"));
    infowincontent.appendChild(document.createElement("br"));

    // item details
    var address = document.createElement("label"); // tag text
    address.textContent = "地址 : " + data.chinese_address;
    infowincontent.appendChild(address);
    infowincontent.appendChild(document.createElement("br"));

    // item contact
    var contact = document.createElement("label"); // tag text
    contact.textContent = "聯絡電話 : " + data.phone_number;
    infowincontent.appendChild(contact);
    infowincontent.appendChild(document.createElement("br"));

    // item status
    var type = document.createElement("label"); // tag text
    type.textContent = "營業時間 : " + data.weekday_business_hours;
    infowincontent.appendChild(type);
    infowincontent.appendChild(document.createElement("br"));
    infowincontent.appendChild(document.createElement("br"));

    // item photo
    var img = document.createElement("img");
    img.src = "testing.jpg"; // tag photo
    img.style.height = "150px"; // photo size
    img.style.width = "300px"; // photo size
    infowincontent.appendChild(img);

    // create marker
    var marker = new google.maps.Marker({
      position: new google.maps.LatLng(data.latitude, data.longitude),
      map: map,
      label: markerLabel // marker label
    });

    // mouse over marker function
    marker.addListener("mouseover", function () {
      infoWind.setContent(infowincontent);
      infoWind.open(map, marker);
    });
  });
}

// searching function
function searchMap() {

  // get the condition search data
  var type = document.getElementById("type").value;
  var district = document.getElementById("district").value;

  if (type == "" && district == "") {
    alert("請選擇適當的類別或地區");

  } else {

    if (type == "restaurant" && district == "") {
      searchTypeWithNoDistrict(
        JSON.parse(document.getElementById("restaurant_allData").innerHTML), "R"
      );

    } else if (type == "attraction" && district == "") {
      searchTypeWithNoDistrict(
        JSON.parse(document.getElementById("attraction_allData").innerHTML), "A"
      );

    } else if (type == "guesthouse" && district == "") {
      searchTypeWithNoDistrict(
        JSON.parse(document.getElementById("guesthouse_allData").innerHTML), "G"
      );

    } else if (type == "all" && district == "") {
      loadMap();

    } else if (type == "restaurant" && district != "") {
      searchTypeWithDistrict(
        JSON.parse(document.getElementById("restaurant_allData").innerHTML), "R", district
      );

    } else if (type == "attraction" && district != "") {
      searchTypeWithDistrict(
        JSON.parse(document.getElementById("attraction_allData").innerHTML), "A", district
      );

    } else if (type == "guesthouse" && district != "") {
      searchTypeWithDistrict(
        JSON.parse(document.getElementById("guesthouse_allData").innerHTML), "G", district
      );

    } else if (type == "" && district != "" || type == "all" && district != "") {

      // get all data from div
      var restaurant_AllData = JSON.parse(document.getElementById("restaurant_allData").innerHTML);
      var attraction_AllData = JSON.parse(document.getElementById("attraction_allData").innerHTML);
      var guesthouse_AllData = JSON.parse(document.getElementById("guesthouse_allData").innerHTML);
      var district_AllData = JSON.parse(document.getElementById("district_allData").innerHTML);

      var target_latitude, target_longitude;

      // looping for suitable latitude and longitude
      Array.prototype.forEach.call(district_AllData, function (data) {
        if (data.district_id  == district) {
          target_latitude = parseFloat(data.latitude);
          target_longitude = parseFloat(data.longitude);
        }
      });

      // identify the map specification 
      var pune = { lat: target_latitude, lng: target_longitude };
      map = new google.maps.Map(document.getElementById("map"), {
        zoom: 14,
        center: pune,
      });

      var infoWind = new google.maps.InfoWindow();
      
      // invoke searching function
      searchAllType(infoWind, restaurant_AllData, "R", district);
      searchAllType(infoWind, attraction_AllData, "A", district);
      searchAllType(infoWind, guesthouse_AllData, "G", district);
    }
  }
}


// initial marker with specific type with no district condition
function searchTypeWithNoDistrict(allData, markerLabel) {

  // identify the map specification 
  var pune = { lat: 22.388967, lng: 114.1095893 };
  map = new google.maps.Map(document.getElementById("map"), {
    zoom: 11,
    center: pune,
  });

  var infoWind = new google.maps.InfoWindow();

  // invoke searching function
  initailMapMarkers(infoWind, allData, markerLabel);
}


// search for all type of markers with specific district
function searchAllType(infoWind, allData, markerLabel, district) {

  Array.prototype.forEach.call(allData, function (data) {

    // create maker div
    var infowincontent = document.createElement("div");
    infowincontent.style.width = "280px";

    // data subject
    var header = document.createElement("strong"); // tag text
    header.textContent = "名稱 : " + data.Chinese_Name;
    infowincontent.appendChild(header);
    infowincontent.appendChild(document.createElement("br"));
    infowincontent.appendChild(document.createElement("br"));

    // item details
    var address = document.createElement("label"); // tag text
    address.textContent = "地址 : " + data.chinese_address;
    infowincontent.appendChild(address);
    infowincontent.appendChild(document.createElement("br"));

    // item contact
    var contact = document.createElement("label"); // tag text
    contact.textContent = "聯絡電話 : " + data.phone_number;
    infowincontent.appendChild(contact);
    infowincontent.appendChild(document.createElement("br"));

    // item status
    var type = document.createElement("label"); // tag text
    type.textContent = "營業時間 : " + data.weekday_business_hours;
    infowincontent.appendChild(type);
    infowincontent.appendChild(document.createElement("br"));
    infowincontent.appendChild(document.createElement("br"));

    // item photo
    var img = document.createElement("img");
    img.src = "testing.jpg"; // tag photo
    img.style.height = "150px"; // photo size
    img.style.width = "300px"; // photo size
    infowincontent.appendChild(img);

    // district checking
    if (district == data.district) {
      var marker = new google.maps.Marker({
        position: new google.maps.LatLng(data.latitude, data.longitude),
        map: map,
        label: markerLabel // marker label
      });

      // mouse over marker function
      marker.addListener("mouseover", function () {
        infoWind.setContent(infowincontent);
        infoWind.open(map, marker);
      });
    }
  });
}


// search for specific type with district
function searchTypeWithDistrict(allData, markerLabel, district) {

  // get all district data
  var district_AllData = JSON.parse(document.getElementById("district_allData").innerHTML);
  var target_latitude, target_longitude;

  // looping for suitable latitude and longitude
  Array.prototype.forEach.call(district_AllData, function (data) {
    if (data.district_id == district) {
      target_latitude = parseFloat(data.latitude);
      target_longitude = parseFloat(data.longitude);
    }
  });

  // identify the map specification 
  var pune = { lat: target_latitude, lng: target_longitude };
  map = new google.maps.Map(document.getElementById("map"), {
    zoom: 14,
    center: pune,
  });

  var infoWind = new google.maps.InfoWindow();

  // loop for each marker
  Array.prototype.forEach.call(allData, function (data) {

    // create maker div
    var infowincontent = document.createElement("div");
    infowincontent.style.width = "280px";

    // data subject
    var header = document.createElement("strong"); // tag text
    header.textContent = "名稱 : " + data.Chinese_Name;
    infowincontent.appendChild(header);
    infowincontent.appendChild(document.createElement("br"));
    infowincontent.appendChild(document.createElement("br"));

    // item details
    var address = document.createElement("label"); // tag text
    address.textContent = "地址 : " + data.chinese_address;
    infowincontent.appendChild(address);
    infowincontent.appendChild(document.createElement("br"));

    // item contact
    var contact = document.createElement("label"); // tag text
    contact.textContent = "聯絡電話 : " + data.phone_number;
    infowincontent.appendChild(contact);
    infowincontent.appendChild(document.createElement("br"));

    // item status
    var type = document.createElement("label"); // tag text
    type.textContent = "營業時間 : " + data.weekday_business_hours;
    infowincontent.appendChild(type);
    infowincontent.appendChild(document.createElement("br"));
    infowincontent.appendChild(document.createElement("br"));

    // item photo
    var img = document.createElement("img");
    img.src = "testing.jpg"; // tag photo
    img.style.height = "150px"; // photo size
    img.style.width = "300px"; // photo size
    infowincontent.appendChild(img);

    // district checking
    if (district == data.district) {
      var marker = new google.maps.Marker({
        position: new google.maps.LatLng(data.latitude, data.longitude),
        map: map,
        label: markerLabel // marker label
      });
  
      // mouse over marker function
      marker.addListener("mouseover", function () {
        infoWind.setContent(infowincontent);
        infoWind.open(map, marker);
      });
    }
  });
}