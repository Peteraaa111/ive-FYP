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

function guesthouseName_emptyChecking(chiGuesthouseName, eng_guesthouseName) {
  if (chiGuesthouseName == "" && eng_guesthouseName == "") {
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

function guesthouseEmail_emptyChecking(guesthouseEmail) {
  if (guesthouseEmail == "") {
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

function storefront_emptyChecking(storefront) {
  if (storefront == "") {
    return false;
  } else {
    return true;
  }
}

function rooms_emptyChecking(rooms) {
  if (rooms == "") {
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

function contactName_emptyChecking(contactName) {
  if (contactName == "") {
    return false;
  } else {
    return true;
  }
}

function contactEmail_emptyChecking(contactEmail) {
  if (contactEmail == "") {
    return false;
  } else {
    return true;
  }
}

// Submit the guesthouse collaboration request form if all information is input CORRECTLY
function submitCollabGuesthouse() {
  // Get the input values
  var chi_guesthoueName = $("#chi-guesthouse-name").val();
  var eng_guesthoueName = $("#eng-guesthouse-name").val();
  var district = $("#district").val();
  var chi_address = $("#chi-address").val();
  var eng_address = $("#eng-address").val();
  var guesthouse_phoneNumber = $("#guesthouse-phone-number").val();
  var guesthouse_email = $("#guesthouse-email").val();
  var storefront = $("#storefront").val();
  var rooms = $("#rooms").val();
  var start_weekday = $("#start-weekday").val();
  var end_weekday = $("#end-weekday").val();
  var start_weekend = $("#start-weekend").val();
  var end_weekend = $("#end-weekend").val();
  var start_holiday = $("#start-holiday").val();
  var end_holiday = $("#end-holiday").val();
  var contact_name = $("#contact-name").val();
  var contact_email = $("#contact-email").val();

  // Get the checkbox values
  var payment_selected = [];
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
  if (!guesthouseName_emptyChecking(chi_guesthoueName, eng_guesthoueName)) {
    Toast.fire({
      title: '民宿名稱不能為空白。'
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
  } else if (!phoneNumber_emptyChecking(guesthouse_phoneNumber)) {
    Toast.fire({
      title: '民宿電話不能為空白。'
    });
  } else if (!phoneNumber_validationChecking(guesthouse_phoneNumber)) {
    Toast.fire({
      title: '民宿電話格式不正確。'
    });
  } else if (!guesthouseEmail_emptyChecking(guesthouse_email)) {
    Toast.fire({
      title: '民宿電郵不能空白。'
    });
  } else if (!storefront_emptyChecking(storefront)) {
    Toast.fire({
      title: '請上傳店舖門面照片一張。'
    });
  } else if (!rooms_emptyChecking(rooms)) {
    Toast.fire({
      title: '房間數目不能為空白。'
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
  } else if (!contactName_emptyChecking(contact_name)) {
    Toast.fire({
      title: '民宿負責人姓名不能空白。'
    });
  } else if (!contactEmail_emptyChecking(contact_email)) {
    Toast.fire({
      title: '民宿負責人電郵不能空白。'
    });
  } // End of validation checking
  // Pass form data to function.php
  else {
    // Package the form data
    var form = $("#collab-guesthouse-request-form")[0];
    var formData = new FormData(form);

    $.ajax({
      method: "POST",
      url: "/function.php?op=submitGusethouseRequest",
      data: formData,
      dataType: "json",
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      success: function (res) {
        if (res.success === true) {
          Swal.fire({
            icon: 'success',
            title: '成功提交',
            text: '我們已經收到你的申請，請等待我們確認，申請結果將會以電郵形式通知。'
          }).then(function () {
            window.location.replace("/");
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
  } // end-if
}