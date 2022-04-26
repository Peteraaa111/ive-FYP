const AttractionCheck = {
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
  phoneNumberValidate: function (phoneNumber) {
    if (phoneNumber.length > 0 && phoneNumber.length < 8) {
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
  typeCheck: function (type_selected) {
    if (type_selected.length == 0) {
      return false;
    } else {
      return true;
    }
  },
  weekdayCheck: function (start_weekday, end_weekday) {
    if($("#weekday-closed").is(':checked') == true){
      return true;
    }
    if (start_weekday == "" || end_weekday == "") {
      return false;
    } else {
      return true;
    }
  },
  weekendCheck: function (start_weekend, end_weekend) {
    if($("#weekend-closed").is(':checked') == true){
      return true;
    }
    if (start_weekend == "" || end_weekend == "") {
      return false;
    } else {
      return true;
    }
  },
  holidayCheck: function (start_holiday, end_holiday) {
    if($("#holiday-closed").is(':checked') == true){
      return true;
    }
    if (start_holiday == "" || end_holiday == "") {
      return false;
    } else {
      return true;
    }
  },
};

const RestaurantCheck = {
  nameCheck: function nameCheck(chi_name, eng_name) {
    if (chi_name == "" && eng_name == "") {
      return false;
    } else {
      return true;
    }
  },
  districtCheck: function districtCheck(district) {
    if (district == null) {
      return false;
    } else {
      return true;
    }
  },
  chineseAddressCheck: function chineseAddressCheck(chi_address) {
    if (chi_address == "") {
      return false;
    } else {
      return true;
    }
  },
  englishAddressCheck: function englishAddressCheck(eng_address) {
    if (eng_address == "") {
      return false;
    } else {
      return true;
    }
  },
  phoneNumberCheck: function phoneNumberCheck(phoneNumber) {
    if (phoneNumber == "") {
      return false;
    } else {
      return true;
    }
  },
  phoneNumberValidate: function phoneNumberValidate(phoneNumber) {
    if (phoneNumber.length > 0 && phoneNumber.length < 8) {
      return false;
    } else {
      return true;
    }
  },
  emailValidate: function emailValidate(email) {
    const regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    if (!(regex.test(email)) && email.length > 0) {
      return false;
    } else {
      return true;
    }
  },
  cuisineCheck: function cuisineCheck(cuisine_selected) {
    if (cuisine_selected.length == 0) {
      return false;
    } else {
      return true;
    }
  },
  typeCheck: function typeCheck(type_selected) {
    if (type_selected.length == 0) {
      return false;
    } else {
      return true;
    }
  },
  seatsCheck: function seatsCheck(seats) {
    if (seats == "") {
      return false;
    } else {
      return true;
    }
  },
  weekdayCheck: function weekdayCheck(start_weekday, end_weekday) {
    if($("#weekday-closed").is(':checked')){
      return true;
    }
    if (start_weekday == "" || end_weekday == "") {
      return false;
    } else {
      return true;
    }
  },
  weekendCheck: function weekendCheck(start_weekend, end_weekend) {
    if($("#weekend-closed").is(':checked') == true){
      return true;
    }
    if (start_weekend == "" || end_weekend == "") {
      return false;
    } else {
      return true;
    }
  },
  holidayCheck: function holidayCheck(start_holiday, end_holiday) {
    if($("#holiday-closed").is(':checked') == true){
      return true;
    }
    if (start_holiday == "" || end_holiday == "") {
      return false;
    } else {
      return true;
    }
  },
  paymentCheck: function paymentCheck(payment_selected) {
    if (payment_selected.length == 0) {
      return false;
    } else {
      return true;
    }
  },
  storefrontCheck: function storefrontCheck(storefront) {
    if (storefront == "") {
      return false;
    } else {
      return true;
    }
  },
  bannerCheck: function bannerCheck(banner) {
    if (banner == "") {
      return false;
    } else {
      return true;
    }
  }
};

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
};

const AccountCheck = {
  emailCheck: function (email) {
    return email != "" ? true : false;
  },
  emailValidate: function (email) {
    const regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    
    return regex.test(email) ? true : false;
  },
  nameCheck: function (firstname, lastname) {
    return (firstname != "" && lastname != "") ? true : false;
  },
  nicknameCheck: function (nickname) {
    return nickname != "" ? true : false;
  },
  genderCheck: function (gender) {
    return (gender != null && gender != "") ? true : false;
  },
  phoneNumberCheck: function (phoneNumber) {
    return phoneNumber != "" ? true : false;
  },
  phoneNumberValidate: function (phoneNumber) {
    return (phoneNumber.length == 8) ? true : false;
  },
  birthCheck: function (birthYear, birthMonth) {
    return (birthYear != null && birthYear != "" && birthMonth != null && birthMonth != "") ? true : false;
  }
};

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
  $("#edit-btn").click(function () {
    // Hide the edit button
    $('#edit-btn').hide();

    // Enable the account details input box
    $('#account-details input').removeAttr('readonly');
    $('#account-details select').prop('disabled', false);

    // Show the update button and cancel button
    $('#update-btn').show();
    $('#cancel-btn').show();
  });
  $("#cancel-btn").click(function () {
    // Reset the form input
    $("#account-details")[0].reset();

    // Hide the edit button
    $('#cancel-btn').hide();
    $('#update-btn').hide();

    // Enable the account details input box
    $('#account-details input').attr('readonly', true);
    $('#account-details select').prop('disabled', true);

    // Show the update button and cancel button
    $('#edit-btn').show();
  });
})

// Account management
function adminUpdateDriverAccountDetails() {
  // Get the form values
  var id = $('#id').val();
  var email = $('#email').val();
  var firstname = $('#firstname').val();
  var lastname = $('#lastname').val();
  var nickname = $('#nickname').val();
  var gender = $('#gender').val();
  var phone_number = $('#phone_number').val();
  var birth_year = $('#birth_year').find(":selected").text();
  var birth_month = $('#birth_month').find(":selected").text();

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

  if (!AccountCheck.emailCheck(email)) {
    Toast.fire({
      title: '電郵不能為空白。'
    });
  } else if (!AccountCheck.emailValidate(email)) {
    Toast.fire({
      title: '電郵格式錯誤。'
    });
  } else if (!AccountCheck.nameCheck(firstname)) {
    Toast.fire({
      title: '名稱不能為空白。'
    });
  } else if (!AccountCheck.genderCheck(gender)) {
    Toast.fire({
      title: '請選擇性別。'
    });
  } else if (!AccountCheck.phoneNumberCheck(phone_number)) {
    Toast.fire({
      title: '電話號碼不能為空白。'
    });
  } else if (!AccountCheck.phoneNumberValidate(phone_number)) {
    Toast.fire({
      title: '電話號碼格式不正確。'
    });
  } else if (!AccountCheck.birthCheck(birth_year, birth_month)) {
    Toast.fire({
      title: '請選擇出身日期。'
    });
  } else {
    $.ajax({
      type: "POST",
      url: "/function.php?op=adminUpdateAccountDetails&id="+id,
      data: $("#account-details").serialize(),
      dataType: "json",
      success: function (res) {
        if (res.success === true) {
          Swal.fire({
            icon: 'success',
            title: '更新成功',
            text: '帳號資料更新成功。'
          }).then(function () {
            // Hide the edit button
            $('#cancel-btn').hide();
            $('#update-btn').hide();

            // Enable the account details input box
            $('#account-details input').attr('readonly', true);
            $('#account-details select').prop('disabled', true);

            // Show the update button and cancel button
            $('#edit-btn').show();
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: res.reason
          });
        }
      }
    });
  }
}

function adminChangeAccountStatus() {
  $.ajax({
    type: "POST",
    url: "/function.php?op=adminChangeAccountStatus",
    data: $("#account-status").serialize(),
    dataType: "json",
    success: function (res) {
      if (res.success === true) {
        Swal.fire({
          icon: 'success',
          title: '更新成功',
          text: '帳號狀態更新成功。'
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

// Attraction management
function adminCreateAttraction() {
  // Get the form values
  var chi_name = $("#chi-name").val();
  var eng_name = $("#eng-name").val();
  var district = $("#district").val();
  var chi_address = $("#chi-address").val();
  var eng_address = $("#eng-address").val();
  var phoneNumber = $("#phoneNumber").val();
  var email = $("#email").val();
  var type_selected = [];
  $("#type-checkboxes input:checked").each(function () {
    type_selected.push($(this).attr("value"));
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
  } else if (!AttractionCheck.phoneNumberValidate(phoneNumber)) {
    Toast.fire({
      title: '聯絡電話格式不正確。'
    });
  } else if (!AttractionCheck.emailValidate(email)) {
    Toast.fire({
      title: '電郵格式不正確。'
    });
  } else if (!AttractionCheck.typeCheck(type_selected)) {
    Toast.fire({
      title: '請選擇景點類型。'
    });
  } else {
    $.ajax({
      type: "POST",
      url: "/function.php?op=adminCreateAttraction",
      dataType: "json",
      data: $("#attraction-creation").serialize(),
      success: function (res) {
        if (res.success === true) {
          Swal.fire({
            icon: 'success',
            title: '成功新增景點',
            text: '景點已成功新增，公開設定預設為「隱藏」，請檢查內容是否正確後才「公開」。',
            showConfirmButton: true,
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: '前往編輯',
            denyButtonText: '前往景點列表',
            cancelButtonText: '繼續新增'
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.replace("attraction_editor.php?id=" + res.id);
            } else if (result.isDenied) {
              window.location.replace("attraction_existing_overview.php");
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
  }
}

function adminUpdateAttractionInfo(id) {
  // Get the form values
  var chi_name = $("#chi-name").val();
  var eng_name = $("#eng-name").val();
  var district = $("#district").val();
  var chi_address = $("#chi-address").val();
  var eng_address = $("#eng-address").val();
  var phoneNumber = $("#phoneNumber").val();
  var email = $("#email").val();
  var start_weekday = $("#start-weekday").val();
  var end_weekday = $("#end-weekday").val();
  var start_weekend = $("#start-weekend").val();
  var end_weekend = $("#end-weekend").val();
  var start_holiday = $("#start-holiday").val();
  var end_holiday = $("#end-holiday").val();
  var type_selected = [];
  $("#type-checkboxes input:checked").each(function () {
    type_selected.push($(this).attr("value"));
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
  });

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
  } else if (!AttractionCheck.phoneNumberValidate(phoneNumber)) {
    Toast.fire({
      title: '聯絡電話格式不正確。'
    });
  } else if (!AttractionCheck.emailValidate(email)) {
    Toast.fire({
      title: '電郵格式不正確。'
    });
  } else if (!AttractionCheck.typeCheck(type_selected)) {
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
  } else {
    $.ajax({
      type: "POST",
      url: "/function.php?op=adminUpdateAttractionInfo&id=" + id,
      dataType: "json",
      data: $("#basic-info").serialize(),
      success: function (res) {
        if (res.success === true) {
          Swal.fire({
            icon: 'success',
            title: '景點資料成功更新',
            text: '景點資料已成功更新。'
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

function adminUpdateAttractionStatus(id) {
  $.ajax({
    type: "POST",
    url: "/function.php?op=adminUpdateAttractionStatus&id=" + id,
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

// Restaurant management
function adminCreateRestaurant() {
  var chi_name = $("#chi-name").val();
  var eng_name = $("#eng-name").val();
  var district = $("#district").val();
  var chi_address = $("#chi-address").val();
  var eng_address = $("#eng-address").val();
  var phoneNumber = $("#phoneNumber").val();
  var email = $("#email").val();
  var seats = $("#seats").val();
  var start_weekday = $("#start-weekday").val();
  var end_weekday = $("#end-weekday").val();
  var start_weekend = $("#start-weekend").val();
  var end_weekend = $("#end-weekend").val();
  var start_holiday = $("#start-holiday").val();
  var end_holiday = $("#end-holiday").val();

  var cuisine_selected = [];
  $("#cuisine-checkboxes input:checked").each(function () {
    cuisine_selected.push($(this).attr("value"));
  });
  var type_selected = [];
  $("#type-checkboxes input:checked").each(function () {
    type_selected.push($(this).attr("value"));
  });
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
  if (!RestaurantCheck.nameCheck(chi_name, eng_name)) {
    Toast.fire({
      title: "餐廳名稱不能為空白。"
    });
  } else if (!RestaurantCheck.districtCheck(district)) {
    Toast.fire({
      title: "請選擇地區。"
    });
  } else if (!RestaurantCheck.chineseAddressCheck(chi_address)) {
    Toast.fire({
      title: "中文地址不能為空白。"
    });
  } else if (!RestaurantCheck.englishAddressCheck(eng_address)) {
    Toast.fire({
      title: "英文地址不能為空白。"
    });
  } else if (!RestaurantCheck.phoneNumberCheck(phoneNumber)) {
    Toast.fire({
      title: "餐廳電話不能為空白。"
    });
  } else if (!RestaurantCheck.phoneNumberValidate(phoneNumber)) {
    Toast.fire({
      title: "餐廳電話格式不正確。"
    });
  } else if (!RestaurantCheck.emailValidate(email)) {
    Toast.fire({
      title: "電郵格式不正確。"
    });
  } else if (!RestaurantCheck.cuisineCheck(cuisine_selected)) {
    Toast.fire({
      title: "請選擇菜式。"
    });
  } else if (!RestaurantCheck.typeCheck(type_selected)) {
    Toast.fire({
      title: "請選擇食品 / 餐廳類型。"
    });
  } else if (!RestaurantCheck.seatsCheck(seats)) {
    Toast.fire({
      title: "座位數目不能為空白。"
    });
  } else if (!RestaurantCheck.weekdayCheck(start_weekday, end_weekday)) {
    Toast.fire({
      title: "請輸入星期一至五的營業時間。"
    });
  } else if (!RestaurantCheck.weekendCheck(start_weekend, end_weekend)) {
    Toast.fire({
      title: "請輸入星期六至日的營業時間。"
    });
  } else if (!RestaurantCheck.holidayCheck(start_holiday, end_holiday)) {
    Toast.fire({
      title: "請輸入公眾假期的營業時間。"
    });
  } else if (!RestaurantCheck.paymentCheck(payment_selected)) {
    Toast.fire({
      title: "請選擇付款方式"
    });
  } // End of validation checking
  // Pass form data to function.php
  else {
    $.ajax({
      type: "POST",
      url: "/function.php?op=adminCreateRestaurant",
      dataType: "json",
      data: $("#restaurant-creation").serialize(),
      success: function (res) {
        if (res.success === true) {
          Swal.fire({
            icon: 'success',
            title: '成功新增餐廳',
            text: '餐廳已成功新增，公開設定預設為「隱藏」，請檢查內容是否正確後才「公開」。',
            showConfirmButton: true,
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: '前往編輯',
            denyButtonText: '前往餐廳列表',
            cancelButtonText: '繼續新增'
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.replace("restaurant_editor.php?id=" + res.id);
            } else if (result.isDenied) {
              window.location.replace("restaurant_existing_overview.php");
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

function adminUpdateRestaurantInfo(id) {
  var chi_name = $("#chi-name").val();
  var eng_name = $("#eng-name").val();
  var district = $("#district").val();
  var chi_address = $("#chi-address").val();
  var eng_address = $("#eng-address").val();
  var phoneNumber = $("#phoneNumber").val();
  var email = $("#email").val();
  var seats = $("#seats").val();
  var start_weekday = $("#start-weekday").val();
  var end_weekday = $("#end-weekday").val();
  var start_weekend = $("#start-weekend").val();
  var end_weekend = $("#end-weekend").val();
  var start_holiday = $("#start-holiday").val();
  var end_holiday = $("#end-holiday").val();

  var cuisine_selected = [];
  $("#cuisine-checkboxes input:checked").each(function () {
    cuisine_selected.push($(this).attr("value"));
  });
  var type_selected = [];
  $("#type-checkboxes input:checked").each(function () {
    type_selected.push($(this).attr("value"));
  });
  var payment_selected = [];
  $("#payment-checkboxes input:checked").each(function () {
    payment_selected.push($(this).attr("value"));
  });
  
  console.log(district);

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
  if (!RestaurantCheck.nameCheck(chi_name, eng_name)) {
    Toast.fire({
      title: "餐廳名稱不能為空白。"
    });
  } else if (!RestaurantCheck.districtCheck(district)) {
    Toast.fire({
      title: "請選擇地區。"
    });
  } else if (!RestaurantCheck.chineseAddressCheck(chi_address)) {
    Toast.fire({
      title: "中文地址不能為空白。"
    });
  } else if (!RestaurantCheck.englishAddressCheck(eng_address)) {
    Toast.fire({
      title: "英文地址不能為空白。"
    });
  } else if (!RestaurantCheck.phoneNumberCheck(phoneNumber)) {
    Toast.fire({
      title: "餐廳電話不能為空白。"
    });
  } else if (!RestaurantCheck.phoneNumberValidate(phoneNumber)) {
    Toast.fire({
      title: "餐廳電話格式不正確。"
    });
  } else if (!RestaurantCheck.emailValidate(email)) {
    Toast.fire({
      title: "電郵格式不正確。"
    });
  } else if (!RestaurantCheck.cuisineCheck(cuisine_selected)) {
    Toast.fire({
      title: "請選擇菜式。"
    });
  } else if (!RestaurantCheck.typeCheck(type_selected)) {
    Toast.fire({
      title: "請選擇食品 / 餐廳類型。"
    });
  } else if (!RestaurantCheck.seatsCheck(seats)) {
    Toast.fire({
      title: "座位數目不能為空白。"
    });
  } else if (!RestaurantCheck.weekdayCheck(start_weekday, end_weekday)) {
    Toast.fire({
      title: "請輸入星期一至五的營業時間。"
    });
  } else if (!RestaurantCheck.weekendCheck(start_weekend, end_weekend)) {
    Toast.fire({
      title: "請輸入星期六至日的營業時間。"
    });
  } else if (!RestaurantCheck.holidayCheck(start_holiday, end_holiday)) {
    Toast.fire({
      title: "請輸入公眾假期的營業時間。"
    });
  } else if (!RestaurantCheck.paymentCheck(payment_selected)) {
    Toast.fire({
      title: "請選擇付款方式"
    });
  } // End of validation checking
  // Pass form data to function.php
  else {
    $.ajax({
      type: "POST",
      url: "/function.php?op=adminUpdateRestaurantInfo&id=" + id,
      dataType: "json",
      data: $("#basic-info").serialize(),
      success: function (res) {
        if (res.success === true) {
          Swal.fire({
            icon: 'success',
            title: '餐廳資料成功更新',
            text: '餐廳資料已成功更新。'
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

function adminUpdateRestaurantStatus(id) {
  $.ajax({
    type: "POST",
    url: "/function.php?op=adminUpdateRestaurantStatus&id=" + id,
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

function adminUpdateRestaurantStorefront(id) {
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

  if (!RestaurantCheck.storefrontCheck(storefront)) {
    Toast.fire({
      title: '請上傳門面照片。'
    });
  } else {
    var form = $("#image-management")[0];
    var formData = new FormData(form);
    $.ajax({
      type: "POST",
      url: "/function.php?op=adminUpdateRestaurantStorefront&id="+id,
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

function adminUpdateRestaurantBanner(id) {
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

  if (!RestaurantCheck.bannerCheck(banner)) {
    Toast.fire({
      title: '請上傳海報照片。'
    });
  } else {
    var form = $("#image-management")[0];
    var formData = new FormData(form);
    $.ajax({
      type: "POST",
      url: "/function.php?op=adminUpdateRestaurantBanner&id="+id,
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

// Guesthouse management
function adminCreateGuesthouse() {
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
      url: "/function.php?op=adminCreateGuesthouse",
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

function adminUpdateGuesthouseInfo(id) {
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

function adminUpdateGuesthouseStatus(id) {
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

function adminUpdateGuesthouseStorefront(id) {
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

function adminUpdateGuesthouseBanner(id) {
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

function adminUpdateGuesthouseRoom(id) {} // Not complete

// Collaboration request management
function under_review(id) {
  const text = "點擊確定後，申請編號: " + id + "的申請將會進入「審核中」的狀態。";

  Swal.fire({
    icon: 'warning',
    title: '警告',
    text: text,
    showConfirmButton: true,
    showCancelButton: true,
    confirmButtonText: '確定',
    cancelButtonText: '取消'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location = "details.php?id=" + id;
    }
  });
}

function confirmCollabApplication(id, action, type, email) {
  var actionName, actionType, url, text;

  switch (action) {
    case 'accept':
      actionName = '接受';
      break;
    case 'reject':
      actionName = '拒絕';
      break;
  }
  switch (type) {
    case 'restaurant':
      actionType = 'restaurant';
      break;
    case 'guesthouse':
      actionType = 'guesthouse';
      break;
  }

  text = '是否確定「' + actionName + '」申請？';
  url = "/function.php?op=adminCollabRequestControl&id="+id+"&type="+actionType+"&action="+action+"&"+email;

  Swal.fire({
    icon: 'warning',
    title: '確認申請',
    text: text,
    showDenyButton: true,
    confirmButtonText: '確定',
    denyButtonText: '取消'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        url: url,
        dataType: "json",
        success: function (res) {
          if (res.success === true) {
            Swal.fire({
              icon: 'success',
              title: '完成',
              text: res.message
            }).then(function () {
              location.reload();
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
  });
}

// Driver application management
function wd_under_review(id) {
  const text = "點擊確定後，申請編號: " + id + "的司機工作申請將會進入「審核中」的狀態。";

  Swal.fire({
    icon: 'warning',
    title: '警告',
    text: text,
    showConfirmButton: true,
    showCancelButton: true,
    confirmButtonText: '確定',
    cancelButtonText: '取消'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location = "application.php?id=" + id;
    }
  });
}

function confirmDriverApplication(id, action, email) {
  switch (action) {
    case 'accept':
      actionName = '接受';
      break;
    case 'reject':
      actionName = '拒絕';
      break;
  }
  Swal.fire({
    icon: 'warning',
    title: '確認申請',
    text: '是否確定「' + actionName + '」申請？',
    showDenyButton: true,
    confirmButtonText: '確定',
    denyButtonText: '取消'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        url: "/function.php?op=adminWorkerApplicationControl&id="+id+"&type=driver&action="+action+"&"+email,
        dataType: "json",
        success: function (res) {
          if (res.success) {
            location.reload();
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
  });
}

// Tourist guide application management
function wt_under_review(id) {
  const text = "點擊確定後，申請編號: " + id + "的導遊工作申請將會進入「審核中」的狀態。";

  Swal.fire({
    icon: 'warning',
    title: '警告',
    text: text,
    showConfirmButton: true,
    showCancelButton: true,
    confirmButtonText: '確定',
    cancelButtonText: '取消'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location = "application.php?id=" + id;
    }
  });
}

function confirmTouristGuideApplication(id, action, email) {
  switch (action) {
    case 'accept':
      actionName = '接受';
      break;
    case 'reject':
      actionName = '拒絕';
      break;
  }
  Swal.fire({
    icon: 'warning',
    title: '確認申請',
    text: '是否確定「' + actionName + '」申請？',
    showDenyButton: true,
    confirmButtonText: '確定',
    denyButtonText: '取消'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        url: "/function.php?op=adminWorkerApplicationControl&id="+id+"&type=tourist_guide&action="+action+"&"+email,
        dataType: "json",
        success: function (res) {
          if (res.success) {
            location.reload();
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
  });
}

// Discovery management
function confirmAttractionDiscovery(id, action) {
  switch (action) {
    case 'accept':
      text = '是否確定「<b>接受</b>」新景點資訊？<br>確定之後將會新增新景點記錄到資料庫。';
      break;
    case 'reject':
      text = '是否確定「<b>拒絕</b>」新景點資訊？'
      break;
  }
  Swal.fire({
    icon: 'warning',
    title: '確認資訊',
    html: text,
    showDenyButton: true,
    confirmButtonText: '確定',
    denyButtonText: '取消',
    showLoaderOnConfirm: true,
    preConfirm: () => {
      return fetch(`/function.php?op=adminConfirmAttractionDiscovery&id=${id}&action=${action}`)
        .then(response => {
          if (!response.ok) {
            throw new Error(response.statusText)
          }
          return response.json()
        })
        .catch(error => {
          Swal.showValidationMessage(
            `Request failed: ${error}`
          )
        })
    },
    allowOutsideClick: () => !Swal.isLoading()
  }).then((result) => {
    if (result.value.success) {
      Swal.fire({
        icon: 'success',
        title: result.value.title,
        html: result.value.html,
        confirmButtonText: result.value.btn
      }).then(function () {
        if (action == 'accept') {
          window.location.assign(`/admin/site/attraction/attraction_editor.php?id=${result.value.id}`);
        } else if (action == 'reject') {
          window.location.reload();
        }
      })
    } else if (!result.value.success) {
      Swal.fire({
        icon: 'error',
        title: result.value.title,
        html: result.value.html
      })
    }
  })
  // .then((result) => {
  //   if (result.isConfirmed) {
  //     $.ajax({
  //       type: "POST",
  //       url: `/function.php?op=adminConfirmAttractionDiscovery&id=${id}&action=${action}`,
  //       dataType: "json",
  //       success: function (res) {
  //         if (res.success) {
  //           Swal.fire({
  //             icon: 'success',
  //             title: res.title,
  //             html: res.html,
  //             confirmButtonText: res.btn
  //           }).then(function () {
  //             console.log(result.value.action);
  //             // if (result.value.action == 'accept') {
  //             //   window.location.assign(`/admin/site/attraction/attraction_editor.php?id=${result.value.id}`);
  //             // } else if (result.value.action == 'reject') {
  //             //   window.location.reload();
  //             // }
  //           });
  //         } else {
  //           Swal.fire({
  //             icon: 'error',
  //             title: '錯誤！',
  //             text: res.reason
  //           });
  //         }
  //       },
  //       error: function (res) {
  //         Swal.fire({
  //           icon: 'error',
  //           title: '錯誤！',
  //           text: res.responseText
  //         });
  //       }
  //     });
  //   }
  // });
}

function confirmRestaurantDiscovery(id, action) {
  switch (action) {
    case 'accept':
      text = '是否確定「<b>接受</b>」新餐廳資訊？<br>確定之後將會新增新餐廳記錄到資料庫。';
      break;
    case 'reject':
      text = '是否確定「<b>拒絕</b>」新餐廳資訊？'
      break;
  }
  Swal.fire({
    icon: 'warning',
    title: '確認資訊',
    html: text,
    showDenyButton: true,
    confirmButtonText: '確定',
    denyButtonText: '取消',
    showLoaderOnConfirm: true,
    preConfirm: () => {
      return fetch(`/function.php?op=adminConfirmRestaurantDiscovery&id=${id}&action=${action}`)
        .then(response => {
          if (!response.ok) {
            throw new Error(response.statusText)
          }
          return response.json()
        })
        .catch(error => {
          Swal.showValidationMessage(
            `Request failed: ${error}`
          )
        })
    },
    allowOutsideClick: () => !Swal.isLoading()
  }).then((result) => {
    if (result.value.success) {
      Swal.fire({
        icon: 'success',
        title: result.value.title,
        html: result.value.html,
        confirmButtonText: result.value.btn
      }).then(function () {
        if (action == 'accept') {
          window.location.assign(`/admin/site/restaurant/restaurant_editor.php?id=${result.value.id}`);
        } else if (action == 'reject') {
          window.location.reload();
        }
      })
    } else if (!result.value.success) {
      Swal.fire({
        icon: 'error',
        title: result.value.title,
        html: result.value.html
      })
    }
  })
}

function confirmGuesthouseDiscovery(id, action) {
  switch (action) {
    case 'accept':
      text = '是否確定「<b>接受</b>」新民宿資訊？<br>確定之後將會新增新民宿記錄到資料庫。';
      break;
    case 'reject':
      text = '是否確定「<b>拒絕</b>」新民宿資訊？'
      break;
  }
  Swal.fire({
    icon: 'warning',
    title: '確認資訊',
    html: text,
    showDenyButton: true,
    confirmButtonText: '確定',
    denyButtonText: '取消',
    showLoaderOnConfirm: true,
    preConfirm: () => {
      return fetch(`/function.php?op=adminConfirmGuesthouseDiscovery&id=${id}&action=${action}`)
        .then(response => {
          if (!response.ok) {
            throw new Error(response.statusText)
          }
          return response.json()
        })
        .catch(error => {
          Swal.showValidationMessage(
            `Request failed: ${error}`
          )
        })
    },
    allowOutsideClick: () => !Swal.isLoading()
  }).then((result) => {
    if (result.value.success) {
      Swal.fire({
        icon: 'success',
        title: result.value.title,
        html: result.value.html,
        confirmButtonText: result.value.btn
      }).then(function () {
        if (action == 'accept') {
          window.location.assign(`/admin/site/guesthouse/details.php?id=${result.value.id}`);
        } else if (action == 'reject') {
          window.location.reload();
        }
      })
    } else if (!result.value.success) {
      Swal.fire({
        icon: 'error',
        title: result.value.title,
        html: result.value.html
      })
    }
  })
}