// create the restaurant form if all information is input CORRECTLY
function createRestaurant(id) {
  var chi_restaurantName        = $("#chi-name").val();
  var eng_restaurantName        = $("#eng-name").val();
  var district                  = $("#district").val();
  var chi_address               = $("#chi-address").val();
  var eng_address               = $("#eng-address").val();
  var restaurant_phoneNumber    = $("#phoneNo").val();
  var restaurant_email          = $("#email").val();
  var seats                     = $("#seats").val();
  var start_weekday             = $("#start-weekday").val();
  var end_weekday               = $("#end-weekday").val();
  var start_weekend             = $("#start-weekend").val();
  var end_weekend               = $("#end-weekend").val();
  var start_holiday             = $("#start-holiday").val();
  var end_holiday               = $("#end-holiday").val();

  var cuisine_selected          = [];
  $("#cuisine-checkboxes input:checked").each(function () {
    cuisine_selected.push($(this).attr("value"));
  });
  var type_selected             = [];
  $("#type-checkboxes input:checked").each(function () {
    type_selected.push($(this).attr("value"));
  });
  var payment_selected          = [];
  $("#payment-checkboxes input:checked").each(function () {
    payment_selected.push($(this).attr("value"));
  });
  var equipment_selected = [];
  $("#equipment-checkboxes input:checked").each(function () {
    equipment_selected.push($(this).attr("value"));
  });

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
  if (!restaurantName_emptyChecking(chi_restaurantName, eng_restaurantName)) {
    Toast.fire({
      title: '餐廳名稱不能為空白。'
    });
  } else if (!district_emptyChecking(district)) {
    Toast.fire({
      title: '請選擇地區。'
    });
  } else if (!chi_address_emptyChecking(chi_address)) {
    Toast.fire({
      title: '中文地址不能為空白。'
    });
  } else if (!eng_address_emptyChecking(eng_address)) {
    Toast.fire({
      title: '英文地址不能為空白。'
    });
  } else if (!phoneNumber_emptyChecking(restaurant_phoneNumber)) {
    Toast.fire({
      title: '餐廳電話不能為空白。'
    });
  } else if (!phoneNumber_validationChecking(restaurant_phoneNumber)) {
    Toast.fire({
      title: '餐廳電話格式不正確。'
    });
  } else if (!cuisine_emptyChecking(cuisine_selected)) {
    Toast.fire({
      title: '請選擇菜式。'
    });
  } else if (!type_emptyChecking(type_selected)) {
    Toast.fire({
      title: '請選擇食品 / 餐廳類型。'
    });
  } else if (!seats_emptyChecking(seats)) {
    Toast.fire({
      title: '座位數目不能為空白。'
    });
  } else if (!weekdayBusiness_emptyChecking(start_weekday, end_weekday)) {
    Toast.fire({
      title: '請輸入星期一至五的營業時間。'
    });
  } else if (!weekendBusiness_emptyChecking(start_weekend, end_weekend)) {
    Toast.fire({
      title: '請輸入星期六至日的營業時間。'
    });
  } else if (!holidayBusiness_emptyChecking(start_holiday, end_holiday)) {
    Toast.fire({
      title: '請輸入公眾假期的營業時間。'
    });
  } else if (!paymentMethod_emptyChecking(payment_selected)) {
    Toast.fire({
      title: '請選擇付款方式。'
    });
  } // End of validation checking
  // Pass form data to function.php
  else {
    $.ajax({
      url: "/function.php?op=createRestaurant&id=" + id,
      method: "POST",
      dataType: "json",
      enctype: "multipart/form-data",
      data: $("#restaurant-creation").serialize(),
      success: function (res) {
        if(res.success) {
          Swal.fire({
            icon: 'success',
            title: '成功新增',
            text: '餐廳新增成功，將會跳轉到編輯頁面。'
          }).then(function () {
            window.location.replace("restaurant_editor.php?id=" + res.id);
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: '發生錯誤！',
            text: res.reason
          });
        }
      },
      error: function (res) {
        Swal.fire({
          icon: 'error',
          title: '發生錯誤！',
          text: res.responseText
        });
      },
    });
  } // end-if
}

$(document).ready(function () {
  $("#weekday-closed").change(function () {
    if ($("#weekday-closed").is(":checked") == true) {
      $("#start-weekday").val("23:59").prop("readonly", true);
      $("#end-weekday").val("23:59").prop("readonly", true);
    } else {
      $("#start-weekday").val("").prop("readonly", false);
      $("#end-weekday").val("").prop("readonly", false);
    }
  });
  $("#weekend-closed").change(function () {
    if ($("#weekend-closed").is(":checked") == true) {
      $("#start-weekend").val("23:59").prop("readonly", true);
      $("#end-weekend").val("23:59").prop("readonly", true);
    } else {
      $("#start-weekend").val("").prop("readonly", false);
      $("#end-weekend").val("").prop("readonly", false);
    }
  });
  $("#holiday-closed").change(function () {
    if ($("#holiday-closed").is(":checked") == true) {
      $("#start-holiday").val("23:59").prop("readonly", true);
      $("#end-holiday").val("23:59").prop("readonly", true);
    } else {
      $("#start-holiday").val("").prop("readonly", false);
      $("#end-holiday").val("").prop("readonly", false);
    }
  });
});

function restaurantName_emptyChecking(chiRestaurantName, eng_restaurantName) {
  if (chiRestaurantName == "" && eng_restaurantName == "") {
    return false;
  } else {
    return true;
  }
}

function district_emptyChecking(district) {
  if (district == null) {
    return false;
  } else {
    return true;
  }
}

function chi_address_emptyChecking(chi_address) {
  if (chi_address == "") {
    return false;
  } else {
    return true;
  }
}

function eng_address_emptyChecking(eng_address) {
  if (eng_address == "") {
    return false;
  } else {
    return true;
  }
}

function phoneNumber_emptyChecking(phoneNumber) {
  if (phoneNumber == "") {
    return false;
  } else {
    return true;
  }
}

function phoneNumber_validationChecking(phoneNumber) {
  if (phoneNumber == "" || phoneNumber.length < 8) {
    return false;
  } else {
    return true;
  }
}

function cuisine_emptyChecking(cuisine_selected) {
  if (cuisine_selected.length == 0) {
    return false;
  } else {
    return true;
  }
}

function type_emptyChecking(type_selected) {
  if (type_selected.length == 0) {
    return false;
  } else {
    return true;
  }
}

function seats_emptyChecking(seats) {
  if (seats == "") {
    return false;
  } else {
    return true;
  }
}

function weekdayBusiness_emptyChecking(start_weekday, end_weekday) {
  if($("#weekday-closed").is(':checked')){
    return true;
  }
  if (start_weekday == "" || end_weekday == "") {
    return false;
  } else {
    return true;
  }
}

function weekendBusiness_emptyChecking(start_weekend, end_weekend) {
  if($("#weekend-closed").is(':checked')){
    return true;
  }
  if (start_weekend == "" || end_weekend == "") {
    return false;
  } else {
    return true;
  }
}

function holidayBusiness_emptyChecking(start_holiday, end_holiday) {
  if($("#holiday-closed").is(':checked')){
    return true;
  }
  if (start_holiday == "" || end_holiday == "") {
    return false;
  } else {
    return true;
  }
}

function paymentMethod_emptyChecking(payment_selected) {
  if (payment_selected.length == 0) {
    return false;
  } else {
    return true;
  }
}