var map;
var geocoder;
var schedule = new Array();

// initial map markers
function loadMap() {
  var pune = { lat: 22.388967, lng: 114.1095893 };
  map = new google.maps.Map(document.getElementById("map"), {
    zoom: 11,
    center: pune,
  });

  var attraction_allData = JSON.parse(
    document.getElementById("attraction_allData").innerHTML
  );
  
  var infoWind = new google.maps.InfoWindow();

  initailMapMarkers(infoWind, attraction_allData);
}

// initialize all type of markers
function initailMapMarkers(infoWind, allData) {

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
    if (data.phone_number != "null") {
      contact.textContent = "聯絡電話 : " + data.phone_number;
      infowincontent.appendChild(contact);
      infowincontent.appendChild(document.createElement("br"));
    }

    // item status
    var type = document.createElement("label"); // tag text
    type.textContent = "營業時間 : " + data.weekday_business_hours;
    infowincontent.appendChild(type);
    infowincontent.appendChild(document.createElement("br"));

    // add button flex
    var buttonDiv = document.createElement("div");
    buttonDiv.className += "d-flex justify-content-end";

    // add button
    var addButton = document.createElement("button");
    addButton.className = "btn btn-outline-primary";
    addButton.append("新增");
    addButton.style.fontSize = "12px";
    addButton.setAttribute("onclick", "addToPlanner(" + data.ID + ")");
    buttonDiv.appendChild(addButton);
    infowincontent.appendChild(buttonDiv);
    infowincontent.appendChild(document.createElement("br"));

    // item photo
    var img = document.createElement("img");
    img.src = "/data/site/attraction/" + data.ID + "/banner.jpg"; // tag photo
    img.style.height = "150px"; // photo size
    img.style.width = "300px"; // photo size
    infowincontent.appendChild(img);

    var marker = new google.maps.Marker({
      position: new google.maps.LatLng(data.latitude, data.longitude),
      map: map
    });

    // on click marker function
    marker.addListener("click", function () {
      infoWind.setContent(infowincontent);
      infoWind.open(map, marker);
    });
  });
}

function addToPlanner(id) {

  var attraction_allData = JSON.parse(
    document.getElementById("attraction_allData").innerHTML
  );

  Array.prototype.forEach.call(attraction_allData, function (data) {
    if (id == data.ID) {

      findAttraction(id);

      var planner = document.getElementById("schedule");

      var contentBox = document.createElement("div");
      contentBox.id = id;
      planner.appendChild(contentBox);

      // mouse hover effect
      var hyperHover = document.createElement("a");
      hyperHover.className = "list-group-item list-group-item-action py-3 lh-tight";
      contentBox.appendChild(hyperHover);

      // main content of attraction
      var dataSubject = document.createElement("div");
      dataSubject.className = "d-flex w-100 align-items-center justify-content-between";
      hyperHover.appendChild(dataSubject);

      // Item subject
      var name = document.createElement("strong");
      name.className = "mb-1";
      name.textContent = data.Chinese_Name;
      dataSubject.appendChild(name);

      // item button div
      var buttonDiv = document.createElement("small");
      buttonDiv.className = "text-muted";
      dataSubject.appendChild(buttonDiv);

      // "remove" button
      var removeButton = document.createElement("button");
      removeButton.className = "btn btn-outline-primary";
      removeButton.textContent = "移除";
      removeButton.style.fontSize = "13px";
      removeButton.setAttribute("onclick", "removeSchedule(" + id + ")");
      buttonDiv.appendChild(removeButton);

      // item address
      var data_address = document.createElement("div");
      data_address.className = "col-10 mb-1 small";
      data_address.innerHTML = data.chinese_address;
      hyperHover.append(data_address);
      hyperHover.append(document.createElement("br"));

      // time inputs
      var inputDiv = document.createElement("div");
      inputDiv.className = "input-group mb-3";

      // attraction id input
      var attraction_id = document.createElement("input");
      attraction_id.name = "attraction[]";
      attraction_id.value = id;
      attraction_id.setAttribute("type", "hidden");

      // start time input
      var startTime = document.createElement("input");
      startTime.name = "startTime[]";
      startTime.className = "form-control";
      startTime.setAttribute("type", "time");

      // middle span
      var middleSpan = document.createElement("span");
      middleSpan.className = "input-group-text";
      middleSpan.textContent = "至";

      // end time input
      var endTime = document.createElement("input");
      endTime.name = "endTime[]";
      endTime.className = "form-control";
      endTime.setAttribute("type", "time");

      inputDiv.appendChild(attraction_id);
      inputDiv.appendChild(startTime);
      inputDiv.appendChild(middleSpan);
      inputDiv.appendChild(endTime);
      hyperHover.append(inputDiv);
    }
  });
}

// find out all attraction around the last attraction in the planner
function findAttraction(id){

  var district;
  var aroundBody = document.getElementById("aroundBody");
  aroundBody.innerHTML = "";

  var attraction_allData = JSON.parse(
    document.getElementById("attraction_allData").innerHTML
  );

  Array.prototype.forEach.call(attraction_allData, function (data) {
    if (data.ID == id) {
      district = data.district;
    }
  });

  Array.prototype.forEach.call(attraction_allData, function (data) {
    if (district == data.district && data.ID != id) {

      var contentBox = document.createElement("div");
      contentBox.id = data.ID;
      aroundBody.appendChild(contentBox);

      // mouse hover effect
      var hyperHover = document.createElement("a");
      hyperHover.className = "list-group-item list-group-item-action py-3 lh-tight";
      contentBox.appendChild(hyperHover);

      // main content of restaurant
      var dataSubject = document.createElement("div");
      dataSubject.className = "d-flex w-100 align-items-center justify-content-between";
      hyperHover.appendChild(dataSubject);

      // attraction subject
      var name = document.createElement("strong");
      name.className = "mb-1";
      name.textContent = data.Chinese_Name;
      dataSubject.appendChild(name);

      // attraction button div
      var buttonDiv = document.createElement("small");
      buttonDiv.className = "text-muted";
      dataSubject.appendChild(buttonDiv);

      // "add" button
      var addButton = document.createElement("button");
      addButton.className = "btn btn-outline-primary";
      addButton.textContent = "新增";
      addButton.style.fontSize = "13px";
      addButton.setAttribute("onclick", "addToPlanner(" + data.ID + ")");
      buttonDiv.appendChild(addButton);

      // details div
      var detailsDiv = document.createElement("div");
      detailsDiv.className = "d-flex justify-content-start";
      contentBox.appendChild(detailsDiv);

      // image div & info div
      var imgDiv = document.createElement("div");

      // attraction image
      var img = document.createElement("img");
      img.src = "/data/site/attraction/" + data.ID + "/banner.jpg"; // tag photo
      img.style.height = "90px"; // photo size
      img.style.width = "130px"; // photo size
      imgDiv.appendChild(img);

      // attraction details
      var details = document.createElement("div");
      details.style.fontSize = "12px";
      details.style.marginLeft = "10px";

      // attraction address
      var address = document.createElement("label"); // tag text
      address.style.marginTop = "15px";
      address.textContent = "地址 : " + data.chinese_address;
      details.appendChild(address);
      details.appendChild(document.createElement("br"));
  
      // attraction contact
      var contact = document.createElement("label"); // tag text
      contact.textContent = "聯絡電話 : " + data.phone_number;
      details.appendChild(contact);
      details.appendChild(document.createElement("br"));
  
      // attraction status
      var type = document.createElement("label"); // tag text
      type.textContent = "營業時間 : " + data.weekday_business_hours;
      details.appendChild(type);

      detailsDiv.appendChild(imgDiv);
      detailsDiv.appendChild(details);
    }
  });
}

function removeSchedule(id) {
  document.getElementById(id).remove();
}

function createPlan(){
  var scheduleForm = document.getElementById("schedule");

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

  if (scheduleForm.children.length <= 0) {
    Toast.fire({
      title: '請加入景點以創建行程。'
    });
  } else if (scheduleForm.children.length == 1){
    Toast.fire({
      title: '請加入至少兩個景點以創建行程。'
    });
  } else {

    var parameters = "";
    var attraction_id = document.querySelectorAll("#scheduleForm input[name='attraction[]']");
    var startTimes = document.querySelectorAll("#scheduleForm input[name='startTime[]']");
    var endTimes = document.querySelectorAll("#scheduleForm input[name='endTime[]']");
    
    for (var i = 0; i < scheduleForm.children.length; i++) {

      if (startTimes[i].value == "" || endTimes[i].value == "") {
        Toast.fire({
          title: '請輸入時間以創建行程。'
        });
        return;
      }
      
      parameters += "id[]=" + attraction_id[i].value + "&";
      parameters += "startTime[]=" + startTimes[i].value + "&";
      parameters += "endTime[]=" + endTimes[i].value;

      if (i != scheduleForm.children.length - 1) {
        parameters += "&";
      }
    }
    window.location.href="plan_route.php?" + parameters;
  }
}

// tourguide create itinerary for users
function createSchedule() {
  var scheduleForm = document.getElementById("schedule");

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

  if (scheduleForm.children.length <= 0) {
    Toast.fire({
      title: '請加入景點以創建行程。'
    });
  } else if (scheduleForm.children.length == 1){
    Toast.fire({
      title: '請加入至少兩個景點以創建行程。'
    });
  } else {

    var parameters = "";
    var attraction_id = document.querySelectorAll("#scheduleForm input[name='attraction[]']");
    var startTimes = document.querySelectorAll("#scheduleForm input[name='startTime[]']");
    var endTimes = document.querySelectorAll("#scheduleForm input[name='endTime[]']");
    
    for (var i = 0; i < scheduleForm.children.length; i++) {

      if (startTimes[i].value == "" || endTimes[i].value == "") {
        Toast.fire({
          title: '請輸入時間以創建行程。'
        });
        return;
      }
      
      parameters += "id[]=" + attraction_id[i].value + "&";
      parameters += "startTime[]=" + startTimes[i].value + "&";
      parameters += "endTime[]=" + endTimes[i].value;

      if (i != scheduleForm.children.length - 1) {
        parameters += "&";
      }
    }
    window.location.href="route.php?" + parameters;
  }
}