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

function updateInfo(id) {
  var chi_restaurantName = $("#chi-name").val();
  var eng_restaurantName = $("#eng-name").val();
  var district = $("#district").val();
  var chi_address = $("#chi-address").val();
  var eng_address = $("#eng-address").val();
  var latitude = $("#latitude").val();
  var longitude = $("#longitude").val();
  var phoneNo = $("#phoneNo").val();
  var email = $("#email").val();
  var seats = $("#seats").val();
  var start_weekday = $("#start-weekday").val();
  var end_weekday = $("#end-weekday").val();
  var start_weekend = $("#start-weekend").val();
  var end_weekend = $("#end-weekend").val();
  var start_holiday = $("#start-holiday").val();
  var end_holiday = $("#end-holiday").val();

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

  

  if (!Check.restaurantNameCheck(chi_restaurantName, eng_restaurantName)) {
    Toast.fire({
      title: '餐廳名稱不能為空白。'
    });
  } else if (!Check.districtCheck(district)) {
    Toast.fire({
      title: '請選擇地區。'
    });
  } else if (!Check.chiAddressCheck(chi_address)) {
    Toast.fire({
      title: '中文地址不能為空白。'
    });
  } else if (!Check.engAddressCheck(eng_address)) {
    Toast.fire({
      title: '英文地址不能為空白。'
    });
  } else if (!Check.phoneNumberCheck(phoneNo)) {
    Toast.fire({
      title: '餐廳電話不能為空白。'
    });
  } else if (!Check.cuisineCheck(cuisine_selected)) {
    Toast.fire({
      title: '請選擇菜式。'
    });
  } else if (!Check.typeCheck(type_selected)) {
    Toast.fire({
      title: '請選擇食品 / 餐廳類型。'
    });
  } else if (!Check.seatsCheck(seats)) {
    Toast.fire({
      title: '座位數目不能為空白。'
    });
  } else if (!Check.weekdayBusinessCheck(start_weekday, end_weekday)) {
    Toast.fire({
      title: '請輸入星期一至五的營業時間。'
    });
  } else if (!Check.weekendBusinessCheck(start_weekend, end_weekend)) {
    Toast.fire({
      title: '請輸入星期六至日的營業時間。'
    });
  } else if (!Check.holidayBusinessCheck(start_holiday, end_holiday)) {
    Toast.fire({
      title: '請輸入公眾假期的營業時間。'
    });
  } else if (!Check.paymentMethodCheck(payment_selected)) {
    Toast.fire({
      title: '請選擇付款方式。'
    });
  } else {
    $.ajax({
      method: "POST",
      url: "/function.php?op=restaurantUpdateInfo&id=" + id,
      data: $("#basic-info").serialize(),
      dataType: "json",
      success: function (res) {
        if(res.success) {
          Swal.fire({
            icon: 'success',
            title: '餐廳資料已更新',
            text: '您的餐廳資料更新已完成。'
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
      }
    });
  }
}

function updateStatus(id) {
  $.ajax({
    method: "POST",
    url: "/function.php?op=restaurantUpdateStatus&id=" + id,
    data: $("#setting").serialize(),
    dataType: "JSON",
    success: function (res) {
      if(res.success) {
        Swal.fire({
          icon: 'success',
          title: '餐廳狀態已變更',
          text: '您的餐廳狀態變更已完成。'
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
    }
  });
}

var Check = {
  restaurantNameCheck: function restaurantName_emptyCheck(chiRestaurantName, eng_restaurantName) {
    if (chiRestaurantName == "" && eng_restaurantName == "") {
      return false;
    } else {
      return true;
    }
  },
  districtCheck: function district_emptyCheck(district) {
    if (district == null) {
      return false;
    } else {
      return true;
    }
  },
  chiAddressCheck: function chi_address_emptyCheck(chi_address) {
    if (chi_address == "") {
      return false;
    } else {
      return true;
    }
  },
  engAddressCheck: function eng_address_emptyCheck(eng_address) {
    if (eng_address == "") {
      return false;
    } else {
      return true;
    }
  },
  phoneNumberCheck: function phoneNumber_emptyCheck(phoneNumber) {
    if (phoneNumber == "") {
      return false;
    } else {
      return true;
    }
  },
  phoneNumberValidate: function phoneNumber_validationCheck(phoneNumber) {
    if (phoneNumber == "" || phoneNumber.length < 8) {
      return false;
    } else {
      return true;
    }
  },
  cuisineCheck: function cuisine_emptyCheck(cuisine_selected) {
    if (cuisine_selected.length == 0) {
      return false;
    } else {
      return true;
    }
  },
  typeCheck: function type_emptyCheck(type_selected) {
    if (type_selected.length == 0) {
      return false;
    } else {
      return true;
    }
  },
  seatsCheck: function seats_emptyCheck(seats) {
    if (seats == "") {
      return false;
    } else {
      return true;
    }
  },
  weekdayBusinessCheck: function weekdayBusiness_emptyCheck(start_weekday, end_weekday) {
    if($("#weekday-closed").is(':checked')){
      return true;
    }
    if (start_weekday == "" || end_weekday == "") {
      return false;
    } else {
      return true;
    }
  },
  weekendBusinessCheck: function weekendBusiness_emptyCheck(start_weekend, end_weekend) {
    if($("#weekend-closed").is(':checked')){
      return true;
    }
    if (start_weekend == "" || end_weekend == "") {
      return false;
    } else {
      return true;
    }
  },
  holidayBusinessCheck: function holidayBusiness_emptyCheck(start_holiday, end_holiday) {
    if($("#holiday-closed").is(':checked')){
      return true;
    }
    if (start_holiday == "" || end_holiday == "") {
      return false;
    } else {
      return true;
    }
  },
  paymentMethodCheck: function paymentMethod_emptyCheck(payment_selected) {
    if (payment_selected.length == 0) {
      return false;
    } else {
      return true;
    }
  }
};





