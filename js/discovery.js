var AttractionCheck = {
  nameCheck: function (chi_name, eng_name) {
    if (chi_name == "" && eng_name == "") {
      return false;
    } else {
      return true;
    }
  },
  districtCheck: function (district) {
    if (district == null) {
      return false;
    } else {
      return true;
    }
  },
  chineseAddressCheck: function (chi_address) {
    if (chi_address == "") {
      return false;
    } else {
      return true;
    }
  },
  englishAddressCheck: function (eng_address) {
    if (eng_address == "") {
      return false;
    } else {
      return true;
    }
  },
  seatsCheck: function (seats) {
    if (seats == "") {
      return false;
    } else {
      return true;
    }
  },
  storefrontCheck: function (image) {
    if (image == "") {
      return false;
    } else {
      return true;
    }
  },
  phoneNumberValidate: function (phoneNumber) {
    if (phoneNumber.length > 0 && phoneNumber.length < 8) {
      return false;
    } else {
      return true;
    }
  },

  websiteValidate: function (website){
    var res = website.match(/(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g);

    if (!(res) && website.length > 0) {
      return false;
    } else {
      return true;
    }
  },

  emailValidate: function (email) {
    const regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    if (!(regex.test(email)) && email.length > 0) {
      return false;
    } else {
      return true;
    }
  },
  cuisineCheck: function (cuisine_selected) {
    if (cuisine_selected.length == 0) {
      return false;
    } else {
      return true;
    }
  },
  typeCheck: function (type_selected) {
    if (type_selected.length == 0) {
      return false;
    } else {
      return true;
    }
  },
  weekdayCheck: function (start_weekday, end_weekday) {
    if($("#weekday-closed").is(':checked') == true || $("#weekday-24hours").is(':checked') == true ){
      return true;
    }
    if (start_weekday == "" || end_weekday == "") {
      return false;
    } else {
      return true;
    }
  },
  weekendCheck: function (start_weekend, end_weekend) {
    if($("#weekend-closed").is(':checked') == true || $("#weekend-24hours").is(':checked') == true){
      return true;
    }
    if (start_weekend == "" || end_weekend == "") {
      return false;
    } else {
      return true;
    }
  },
  holidayCheck: function (start_holiday, end_holiday) {
    if($("#holiday-closed").is(':checked') == true || $("#holiday-24hours").is(':checked') == true){
      return true;
    }
    if (start_holiday == "" || end_holiday == "") {
      return false;
    } else {
      return true;
    }
  },

  paymentCheck: function (payment_selected) {
    if (payment_selected.length == 0) {
      return false;
    } else {
      return true;
    }
  },

};

$(document).ready(function () {
  $("#weekday-closed").change(function () {
    if ($("#weekday-closed").is(":checked") == true) {
      $("#start-weekday").val("23:59").prop("readonly", true);
      $("#end-weekday").val("23:59").prop("readonly", true);
      $("#weekday-24hours").attr("disabled", "disabled");
    } else {
      $("#start-weekday").val("").prop("readonly", false);
      $("#end-weekday").val("").prop("readonly", false);
      $("#weekday-24hours").removeAttr("disabled"); 
    }
  });
  $("#weekend-closed").change(function () {
    if ($("#weekend-closed").is(":checked") == true) {
      $("#start-weekend").val("23:59").prop("readonly", true);
      $("#end-weekend").val("23:59").prop("readonly", true);
      $("#weekend-24hours").attr("disabled", "disabled");
    } else {
      $("#start-weekend").val("").prop("readonly", false);
      $("#end-weekend").val("").prop("readonly", false);
      $("#weekend-24hours").removeAttr("disabled"); 
    }
  });
  $("#holiday-closed").change(function () {
    if ($("#holiday-closed").is(":checked") == true) {
      $("#start-holiday").val("23:59").prop("readonly", true);
      $("#end-holiday").val("23:59").prop("readonly", true);
      $("#holiday-24hours").attr("disabled", "disabled");
    } else {
      $("#start-holiday").val("").prop("readonly", false);
      $("#end-holiday").val("").prop("readonly", false);
      $("#holiday-24hours").removeAttr("disabled"); 
    }
  });

  $("#weekday-24hours").change(function () {
    if ($("#weekday-24hours").is(":checked") == true) {
      $("#start-weekday").val("00:00").prop("readonly", true);
      $("#end-weekday").val("00:00").prop("readonly", true);
      $("#weekday-closed").attr("disabled", "disabled");
    } else {
      $("#start-weekday").val("").prop("readonly", false);
      $("#end-weekday").val("").prop("readonly", false);
      $("#weekday-closed").removeAttr("disabled"); 
    }
  });
  $("#weekend-24hours").change(function () {
    if ($("#weekend-24hours").is(":checked") == true) {
      $("#start-weekend").val("00:00").prop("readonly", true);
      $("#end-weekend").val("00:00").prop("readonly", true);
      $("#weekend-closed").attr("disabled", "disabled");
    } else {
      $("#start-weekend").val("").prop("readonly", false);
      $("#end-weekend").val("").prop("readonly", false);
      $("#weekend-closed").removeAttr("disabled"); 
    }
  });
  $("#holiday-24hours").change(function () {
    if ($("#holiday-24hours").is(":checked") == true) {
      $("#start-holiday").val("00:00").prop("readonly", true);
      $("#end-holiday").val("00:00").prop("readonly", true);
      $("#holiday-closed").attr("disabled", "disabled");
    } else {
      $("#start-holiday").val("").prop("readonly", false);
      $("#end-holiday").val("").prop("readonly", false);
      $("#holiday-closed").removeAttr("disabled"); 
    }
  });
})




function appleNewAttraction() {
  // Get the form values
  console.log($("#discover_attraction-form").serialize());
  var chi_name = $("#chi-name").val();
  var eng_name = $("#eng-name").val();
  var district = $("#district").val();
  var chi_address = $("#chi-address").val();
  var eng_address = $("#eng-address").val();
  var image1 = $("#image1").val();
  var type_selected = [];
  $("#type-checkboxes input:checked").each(function () {
    type_selected.push($(this).attr("value"));
  });
  var start_weekday = $("#start-weekday").val();
  var end_weekday = $("#end-weekday").val();
  var start_weekend = $("#start-weekend").val();
  var end_weekend = $("#end-weekend").val();
  var start_holiday = $("#start-holiday").val();
  var end_holiday = $("#end-holiday").val();
  var payment_selected = [];
  $("#payment-checkboxes input:checked").each(function () {
    payment_selected.push($(this).attr("value"));
  });
  var website = $("#website").val();
  var phoneNumber = $("#phone_number").val();
  var email = $("#email").val();
  
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

  if (!AttractionCheck.nameCheck(chi_name, eng_name)) {
    Toast.fire({
      title: '景點名稱不能為空白。'
    });
  } else if (!AttractionCheck.districtCheck(district)) {
    Toast.fire({
      title: '請選擇地區。'
    });
  } else if (!AttractionCheck.chineseAddressCheck(chi_address)) {
    Toast.fire({
      title: '中文地址不能為空白。'
    });
  } else if (!AttractionCheck.englishAddressCheck(eng_address)) {
    Toast.fire({
      title: '英文地址不能為空白。'
    });
  }else if (!AttractionCheck.typeCheck(type_selected)) {
    Toast.fire({
      title: '請選擇景點類型。'
    });
  } else if (!AttractionCheck.weekdayCheck(start_weekday, end_weekday)) {
    Toast.fire({
      title: "請輸入星期一至五的開放時間。"
    });
  } else if (!AttractionCheck.weekendCheck(start_weekend, end_weekend)) {
    Toast.fire({
      title: "請輸入星期六至日的開放時間。"
    });
  } else if (!AttractionCheck.holidayCheck(start_holiday, end_holiday)) {
    Toast.fire({
      title: "請輸入公眾假期的開放時間。"
    });
  }else if (!AttractionCheck.paymentCheck(payment_selected)) {
    Toast.fire({
      title: "請選擇付款方式"
    });
  }else if (!AttractionCheck.storefrontCheck(image1)) {
    Toast.fire({
      title: '請上傳景點照片。'
    });
  }else if (!AttractionCheck.websiteValidate(website)) {
    Toast.fire({
      title: '網站格式不正確。'
    });
  }else if (!AttractionCheck.phoneNumberValidate(phoneNumber)) {
    Toast.fire({
      title: '聯絡電話格式不正確。'
    });
  }else if (!AttractionCheck.emailValidate(email)) {
    Toast.fire({
      title: '電郵格式不正確。'
    });
  }else {
    var form = $("#discover_attraction-form")[0];
    var formData = new FormData(form);
    $.ajax({
      type: "POST",
      url: "/function.php?op=attractiondiscoversubmit",
      dataType: "json",
      data: formData,
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      success: function (res) {
        if (res.success === true) {
          Swal.fire({
            icon: 'success',
            title: '成功提交景點資訊',
            text: '感謝你提交新的景點資訊，我們會檢查內容是否正確後才「公開」。',
            showConfirmButton: true,
            confirmButtonText: '完成'
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.replace("/");
            }
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: '錯誤！',
            text: res.reason
          });
        }
      },
      error: function (res) {
        Swal.fire({
          icon: 'error',
          title: '錯誤！',
          text: res.responseText
        });

      },
    });
  }
}

function appleNewRestaurant() {
  // Get the form values
  console.log($("#discover_restaurant-form").serialize());
  var chi_name = $("#chi-name").val();
  var eng_name = $("#eng-name").val();
  var district = $("#district").val();

  var chi_address = $("#chi-address").val();
  var eng_address = $("#eng-address").val();

  var cuisine_selected = [];
  $("#cuisine-checkboxes input:checked").each(function () {
    cuisine_selected.push($(this).attr("value"));
  });

  var type_selected = [];
  $("#type-checkboxes input:checked").each(function () {
    type_selected.push($(this).attr("value"));
  });
  var image1 = $("#image1").val();
  var seats = $("#seats").val();
  var start_weekday = $("#start-weekday").val();
  var end_weekday = $("#end-weekday").val();
  var start_weekend = $("#start-weekend").val();
  var end_weekend = $("#end-weekend").val();
  var start_holiday = $("#start-holiday").val();
  var end_holiday = $("#end-holiday").val();

  var payment_selected = [];
  $("#payment-checkboxes input:checked").each(function () {
    payment_selected.push($(this).attr("value"));
  });

  var phoneNumber = $("#phone_number").val();
  var email = $("#email").val();
  

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

  if (!AttractionCheck.nameCheck(chi_name, eng_name)) {
    Toast.fire({
      title: '餐廳名稱不能為空白。'
    });
  } else if (!AttractionCheck.districtCheck(district)) {
    Toast.fire({
      title: '請選擇地區。'
    });
  } else if (!AttractionCheck.chineseAddressCheck(chi_address)) {
    Toast.fire({
      title: '中文地址不能為空白。'
    });
  } else if (!AttractionCheck.englishAddressCheck(eng_address)) {
    Toast.fire({
      title: '英文地址不能為空白。'
    });
  } else if (!AttractionCheck.cuisineCheck(cuisine_selected)) {
    Toast.fire({
      title: "請選擇菜式。"
    });
  } else if (!AttractionCheck.typeCheck(type_selected)) {
    Toast.fire({
      title: '請選擇餐廳類型。'
    }); 
  }else if (!AttractionCheck.seatsCheck(seats)) {
    Toast.fire({
      title: "座位數目不能為空白。"
    });
  } else if (!AttractionCheck.weekdayCheck(start_weekday, end_weekday)) {
    Toast.fire({
      title: "請輸入星期一至五的開放時間。"
    });
  } else if (!AttractionCheck.weekendCheck(start_weekend, end_weekend)) {
    Toast.fire({
      title: "請輸入星期六至日的開放時間。"
    });
  } else if (!AttractionCheck.holidayCheck(start_holiday, end_holiday)) {
    Toast.fire({
      title: "請輸入公眾假期的開放時間。"
    });
  }else if (!AttractionCheck.paymentCheck(payment_selected)) {
    Toast.fire({
      title: "請選擇付款方式"
    });
  }else if (!AttractionCheck.storefrontCheck(image1)) {
    Toast.fire({
      title: '請上傳餐廳照片。'
    });
  }else if (!AttractionCheck.phoneNumberValidate(phoneNumber)) {
    Toast.fire({
      title: '聯絡電話格式不正確。'
    });
  }else if (!AttractionCheck.emailValidate(email)) {
    Toast.fire({
      title: '電郵格式不正確。'
    });
  }else {
    var form = $("#discover_restaurant-form")[0];
    var formData = new FormData(form);
    $.ajax({
      type: "POST",
      url: "/function.php?op=restaurantdiscoversubmit",
      enctype: "multipart/form-data",
      dataType: "json",
      data: formData,
      contentType: false,
      processData: false,
      success: function (res) {
        if (res.success === true) {
          Swal.fire({
            icon: 'success',
            title: '成功提交餐廳資訊',
            text: '感謝你提交新的餐廳資訊，我們會檢查內容是否正確後才「公開」。',
            showConfirmButton: true,
            confirmButtonText: '完成'
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.replace("/");
            }
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: '錯誤！',
            text: res.reason
          });
        }
      },
      error: function (res) {
        Swal.fire({
          icon: 'error',
          title: '錯誤！',
          text: res.responseText
        });

      },
    });
  }
}

function applyNewGuesthouse() {
  // Get the form values
  console.log($("#discover_guesthouse-form").serialize());
  var chi_name = $("#chi-name").val();
  var eng_name = $("#eng-name").val();
  var district = $("#district").val();
  var chi_address = $("#chi-address").val();
  var eng_address = $("#eng-address").val();
  var image1 = $("#image1").val();
  var rooms = $("#rooms").val();
  var start_weekday = $("#start-weekday").val();
  var end_weekday = $("#end-weekday").val();
  var start_weekend = $("#start-weekend").val();
  var end_weekend = $("#end-weekend").val();
  var start_holiday = $("#start-holiday").val();
  var end_holiday = $("#end-holiday").val();

  var payment_selected = [];
  $("#payment-checkboxes input:checked").each(function () {
    payment_selected.push($(this).attr("value"));
  });

  var phoneNumber = $("#phone_number").val();
  var email = $("#email").val();
  

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

  if (!AttractionCheck.nameCheck(chi_name, eng_name)) {
    Toast.fire({
      title: '民宿名稱不能為空白。'
    });
  } else if (!AttractionCheck.districtCheck(district)) {
    Toast.fire({
      title: '請選擇地區。'
    });
  } else if (!AttractionCheck.chineseAddressCheck(chi_address)) {
    Toast.fire({
      title: '中文地址不能為空白。'
    });
  } else if (!AttractionCheck.englishAddressCheck(eng_address)) {
    Toast.fire({
      title: '英文地址不能為空白。'
    });
  } else if (!AttractionCheck.seatsCheck(rooms)) {
    Toast.fire({
      title: "房間數目不能為空白。"
    });
  } else if (!AttractionCheck.weekdayCheck(start_weekday, end_weekday)) {
    Toast.fire({
      title: "請輸入星期一至五的開放時間。"
    });
  } else if (!AttractionCheck.weekendCheck(start_weekend, end_weekend)) {
    Toast.fire({
      title: "請輸入星期六至日的開放時間。"
    });
  } else if (!AttractionCheck.holidayCheck(start_holiday, end_holiday)) {
    Toast.fire({
      title: "請輸入公眾假期的開放時間。"
    });
  }else if (!AttractionCheck.paymentCheck(payment_selected)) {
    Toast.fire({
      title: "請選擇付款方式"
    });
  }else if (!AttractionCheck.storefrontCheck(image1)) {
    Toast.fire({
      title: '請上傳民宿照片。'
    });
  }else if (!AttractionCheck.phoneNumberValidate(phoneNumber)) {
    Toast.fire({
      title: '聯絡電話格式不正確。'
    });
  }else if (!AttractionCheck.emailValidate(email)) {
    Toast.fire({
      title: '電郵格式不正確。'
    });
  }else {
    var form = $("#discover_guesthouse-form")[0];
    var formData = new FormData(form);
    $.ajax({
      type: "POST",
      url: "/function.php?op=guesthousediscoversubmit",
      enctype: "multipart/form-data",
      dataType: "json",
      data: formData,
      contentType: false,
      processData: false,
      success: function (res) {
        if (res.success === true) {
          Swal.fire({
            icon: 'success',
            title: '成功提交民宿資訊',
            text: '感謝你提交新的民宿資訊，我們會檢查內容是否正確後才「公開」。',
            showConfirmButton: true,
            confirmButtonText: '完成'
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.replace("/");
            }
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: '錯誤！',
            text: res.reason
          });
        }
      },
      error: function (res) {
        Swal.fire({
          icon: 'error',
          title: '錯誤！',
          text: res.responseText
        });

      },
    });
  }
}