const GuesthouseCheck = {
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
  phoneNumberCheck: function (phoneNumber) {
    if (phoneNumber == "") {
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
  emailCheck: function (email) {
    if (email == "") {
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
  roomsCheck: function (rooms) {
    if (rooms == "") {
      return false;
    } else {
      return true;
    }
  },
  weekdayCheck: function (start_weekday, end_weekday) {
    if($("#weekday-closed").is(':checked') || $("#weekday-24hours").is(':checked')){
      return true;
    }
    if (start_weekday == "" || end_weekday == "") {
      return false;
    } else {
      return true;
    }
  },
  weekendCheck: function (start_weekend, end_weekend) {
    if($("#weekend-closed").is(':checked') || $("#weekend-24hours").is(':checked')){
      return true;
    }
    if (start_weekend == "" || end_weekend == "") {
      return false;
    } else {
      return true;
    }
  },
  holidayCheck: function (start_holiday, end_holiday) {
    if($("#holiday-closed").is(':checked') || $("#holiday-24hours").is(':checked')){
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
  storefrontCheck: function (storefront) {
    if (storefront == "") {
      return false;
    } else {
      return true;
    }
  },
  bannerCheck: function (banner) {
    if (banner == "") {
      return false;
    } else {
      return true;
    }
  },
  roomCheck: function (room) {
    if (room == "") {
      return false;
    } else {
      return true;
    }
  }
}

$(document).ready(function () {
  $("#weekday-closed").change(function () {
    if ($("#weekday-closed").is(":checked") == true) {
      $("#start-weekday").val("23:59").prop("readonly", true);
      $("#end-weekday").val("23:59").prop("readonly", true);
      $('#weekday-24hours').prop("disabled", true);
    } else {
      $("#start-weekday").val("").prop("readonly", false);
      $("#end-weekday").val("").prop("readonly", false);
      $('#weekday-24hours').prop("disabled", false);
    }
  });
  $("#weekday-24hours").change(function () {
    if ($("#weekday-24hours").is(":checked") == true) {
      $("#start-weekday").val("00:00").prop("readonly", true);
      $("#end-weekday").val("00:00").prop("readonly", true);
      $('#weekday-closed').prop("disabled", true);
    } else {
      $("#start-weekday").val("").prop("readonly", false);
      $("#end-weekday").val("").prop("readonly", false);
      $('#weekday-closed').prop("disabled", false);
    }
  });
  $("#weekend-closed").change(function () {
    if ($("#weekend-closed").is(":checked") == true) {
      $("#start-weekend").val("23:59").prop("readonly", true);
      $("#end-weekend").val("23:59").prop("readonly", true);
      $('#weekend-24hours').prop("disabled", true);
    } else {
      $("#start-weekend").val("").prop("readonly", false);
      $("#end-weekend").val("").prop("readonly", false);
      $('#weekend-24hours').prop("disabled", false);
    }
  });
  $("#weekend-24hours").change(function () {
    if ($("#weekend-24hours").is(":checked") == true) {
      $("#start-weekend").val("00:00").prop("readonly", true);
      $("#end-weekend").val("00:00").prop("readonly", true);
      $('#weekend-closed').prop("disabled", true);
    } else {
      $("#start-weekend").val("").prop("readonly", false);
      $("#end-weekend").val("").prop("readonly", false);
      $('#weekend-closed').prop("disabled", false);
    }
  });
  $("#holiday-closed").change(function () {
    if ($("#holiday-closed").is(":checked") == true) {
      $("#start-holiday").val("23:59").prop("readonly", true);
      $("#end-holiday").val("23:59").prop("readonly", true);
      $('#holiday-24hours').prop("disabled", true);
    } else {
      $("#start-holiday").val("").prop("readonly", false);
      $("#end-holiday").val("").prop("readonly", false);
      $('#holiday-24hours').prop("disabled", false);
    }
  });
  $("#holiday-24hours").change(function () {
    if ($("#holiday-24hours").is(":checked") == true) {
      $("#start-holiday").val("00:00").prop("readonly", true);
      $("#end-holiday").val("00:00").prop("readonly", true);
      $('#holiday-closed').prop("disabled", true);
    } else {
      $("#start-holiday").val("").prop("readonly", false);
      $("#end-holiday").val("").prop("readonly", false);
      $('#holiday-closed').prop("disabled", false);
    }
  });
})

function createGuesthouse(id) {
  var chi_name = $("#chi-name").val();
  var eng_name = $("#eng-name").val();
  var district = $("#district").val();
  var chi_address = $("#chi-address").val();
  var eng_address = $("#eng-address").val();
  var email = $("#email").val();
  var phoneNumber = $("#phoneNumber").val();
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
  if (!GuesthouseCheck.nameCheck(chi_name, eng_name)) {
    Toast.fire({
      title: "民宿名稱不能為空白。"
    });
  } else if (!GuesthouseCheck.districtCheck(district)) {
    Toast.fire({
      title: "請選擇地區。"
    });
  } else if (!GuesthouseCheck.chineseAddressCheck(chi_address)) {
    Toast.fire({
      title: "中文地址不能為空白。"
    });
  } else if (!GuesthouseCheck.englishAddressCheck(eng_address)) {
    Toast.fire({
      title: "英文地址不能為空白。"
    });
  } else if (!GuesthouseCheck.emailCheck(email)) {
    Toast.fire({
      title: "電郵不能為空白。"
    });
  } else if (!GuesthouseCheck.emailValidate(email)) {
    Toast.fire({
      title: "電郵格式不正確。"
    });
  } else if (!GuesthouseCheck.phoneNumberCheck(phoneNumber)) {
    Toast.fire({
      title: "電話不能為空白。"
    });
  } else if (!GuesthouseCheck.phoneNumberValidate(phoneNumber)) {
    Toast.fire({
      title: "電話格式不正確。"
    });
  } else if (!GuesthouseCheck.roomsCheck(rooms)) {
    Toast.fire({
      title: "房間數目不能為空白。"
    });
  } else if (!GuesthouseCheck.weekdayCheck(start_weekday, end_weekday)) {
    Toast.fire({
      title: "請輸入星期一至五的辦公時間。"
    });
  } else if (!GuesthouseCheck.weekendCheck(start_weekend, end_weekend)) {
    Toast.fire({
      title: "請輸入星期六至日的辦公時間。"
    });
  } else if (!GuesthouseCheck.holidayCheck(start_holiday, end_holiday)) {
    Toast.fire({
      title: "請輸入公眾假期的辦公時間。"
    });
  } else if (!GuesthouseCheck.paymentCheck(payment_selected)) {
    Toast.fire({
      title: "請選擇付款方式"
    });
  } // End of validation checking
  // Pass form data to function.php
  else {
    $.ajax({
      type: "POST",
      url: "/function.php?op=createGuesthouse&id="+id,
      dataType: "json",
      data: $("#guesthouse-creation").serialize(),
      success: function (res) {
        if (res.success === true) {
          Swal.fire({
            icon: 'success',
            title: '成功新增民宿',
            text: '民宿已成功新增，公開設定預設為「隱藏」，請檢查內容是否正確後才「公開」。',
            showConfirmButton: true,
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: '前往編輯',
            denyButtonText: '前往民宿列表',
            cancelButtonText: '繼續新增'
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.replace("details.php?id=" + res.id);
            } else if (result.isDenied) {
              window.location.replace("list.php");
            } else if (result.isDismissed) {
              // empty
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
  } // end-if
}

function updateInfo(id) {
  var chi_name = $("#chi-name").val();
  var eng_name = $("#eng-name").val();
  var district = $("#district").val();
  var chi_address = $("#chi-address").val();
  var eng_address = $("#eng-address").val();
  var email = $("#email").val();
  var phoneNumber = $("#phoneNumber").val();
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
  if (!GuesthouseCheck.nameCheck(chi_name, eng_name)) {
    Toast.fire({
      title: "餐廳名稱不能為空白。"
    });
  } else if (!GuesthouseCheck.districtCheck(district)) {
    Toast.fire({
      title: "請選擇地區。"
    });
  } else if (!GuesthouseCheck.chineseAddressCheck(chi_address)) {
    Toast.fire({
      title: "中文地址不能為空白。"
    });
  } else if (!GuesthouseCheck.englishAddressCheck(eng_address)) {
    Toast.fire({
      title: "英文地址不能為空白。"
    });
  } else if (!GuesthouseCheck.emailValidate(email)) {
    Toast.fire({
      title: "電郵格式不正確。"
    });
  } else if (!GuesthouseCheck.phoneNumberCheck(phoneNumber)) {
    Toast.fire({
      title: "電話不能為空白。"
    });
  } else if (!GuesthouseCheck.phoneNumberValidate(phoneNumber)) {
    Toast.fire({
      title: "電話格式不正確。"
    });
  } else if (!GuesthouseCheck.roomsCheck(rooms)) {
    Toast.fire({
      title: "座位數目不能為空白。"
    });
  } else if (!GuesthouseCheck.weekdayCheck(start_weekday, end_weekday)) {
    Toast.fire({
      title: "請輸入星期一至五的營業時間。"
    });
  } else if (!GuesthouseCheck.weekendCheck(start_weekend, end_weekend)) {
    Toast.fire({
      title: "請輸入星期六至日的營業時間。"
    });
  } else if (!GuesthouseCheck.holidayCheck(start_holiday, end_holiday)) {
    Toast.fire({
      title: "請輸入公眾假期的營業時間。"
    });
  } else if (!GuesthouseCheck.paymentCheck(payment_selected)) {
    Toast.fire({
      title: "請選擇付款方式"
    });
  } // End of validation checking
  // Pass form data to function.php
  else {
    $.ajax({
      type: "POST",
      url: "/function.php?op=adminUpdateGuesthouseInfo&id=" + id,
      dataType: "json",
      data: $("#basic-info").serialize(),
      success: function (res) {
        if (res.success === true) {
          Swal.fire({
            icon: 'success',
            title: '民宿資料成功更新',
            text: '民宿資料已成功更新。'
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
  } // end-if
}

function updateStatus(id) {
  $.ajax({
    type: "POST",
    url: "/function.php?op=adminUpdateGuesthouseStatus&id=" + id,
    data: $("#setting").serialize(),
    dataType: "JSON",
    success: function (res) {
      if (res.success) {
        Swal.fire({
          icon: 'success',
          title: '公開設定成功更新',
          text: '公開設定已設定為「'+ res.newStatus + '」。'
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
      })
    }
  });
}

function updateStorefront(id) {
  var storefront = $("#storefront").val();

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

  if (!GuesthouseCheck.storefrontCheck(storefront)) {
    Toast.fire({
      title: '請上傳門面照片。'
    });
  } else {
    var form = $("#image-management")[0];
    var formData = new FormData(form);
    $.ajax({
      type: "POST",
      url: "/function.php?op=adminUpdateGuesthouseStorefront&id="+id,
      enctype: "multipart/form-data",
      data: formData,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (res) {
        if (res.success) {
          Swal.fire({
            icon: 'success',
            title: '成功更新',
            text: '門面照片已成功更新。'
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
      }
    });
  }
}

function updateBanner(id) {
  var banner = $("#banner").val();

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

  if (!GuesthouseCheck.bannerCheck(banner)) {
    Toast.fire({
      title: '請上傳海報照片。'
    });
  } else {
    var form = $("#image-management")[0];
    var formData = new FormData(form);
    $.ajax({
      type: "POST",
      url: "/function.php?op=adminUpdateGuesthouseBanner&id="+id,
      enctype: "multipart/form-data",
      data: formData,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (res) {
        if (res.success) {
          Swal.fire({
            icon: 'success',
            title: '成功更新',
            text: '海報照片已成功更新。'
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
      }
    });
  }
}

function finishBooking(id) {
  Swal.fire({
    icon: 'warning',
    title: '操作確認',
    text: '是否完成預約？',
    showCancelButton: true,
    confirmButtonText: '是',
    cancelButtonText: '否'
  }).then( (result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        url: "/function.php?op=guesthouseFinishBooking",
        data: {id: id},
        dataType: "json",
        success: function (res) {
          if (res.success === true) {
            Swal.fire({
              icon: 'success',
              title: '預約已完成'
            }).then( function () {
              window.location = "list.php";
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: res.reason
            });
          }
        },
        error: function (res) {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: res.responseText
          });
        }
      });
    }
  })
}

function cancelBooking(id) {
  Swal.fire({
    icon: 'warning',
    title: '操作確認',
    text: '是否取消預約？',
    showCancelButton: true,
    confirmButtonText: '是',
    cancelButtonText: '否'
  }).then( (result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        url: "/function.php?op=guesthouseCancelBooking",
        data: {id: id},
        dataType: "json",
        success: function (res) {
          if (res.success === true) {
            Swal.fire({
              icon: 'success',
              title: '預約已取消'
            }).then( function () {
              window.location = "list.php";
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: res.reason
            });
          }
        },
        error: function (res) {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: res.responseText
          });
        }
      });
    }
  })
}