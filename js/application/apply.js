var driverApplicationCheck = {
  applicantChineseNameCheck: function(firstname, lastname) {
    return firstname != "" && lastname != "" ? true : false;
  },
  birthDateCheck: function (birth_year, birth_month) {
    return birth_year != "" && birth_month != "" ? true : false;
  },
  hkidCheck: function(hkid) {
    return hkid != "" ? true : false;
  },
  phoneNumberCheck: function(phoneNumber) {
    return phoneNumber != "" ? true : false;
  },
  phoneNumberValidate: function(phoneNumber) {
    return phoneNumber.length == 8 ? true : false
  },
  emailCheck: function(email) {
    return email != "" ? true : false;
  },
  seatsNumberCheck: function(seats) {
    return seats > 0 ? true : false;
  },
  licensePlateNumberCheck: function(licensePlateNumber) {
    return licensePlateNumber != "" ? true : false;
  },
  VehicleExteriorCheck: function(VehicleExterior) {
    return VehicleExterior != "" ? true : false;
  },
  VehicleInsideCheck: function(VehicleInside) {
    return VehicleInside != "" ? true : false;
  }
};

var touristGuideApplicationCheck = {
  nameCheck: function (firstname, lastname) {
    return firstname != "" && lastname != "" ? true : false;
  },
  birthDateCheck: function (birth_year, birth_month) {
    return birth_year != "" && birth_month != "" ? true : false;
  },
  hkIdCheck: function (hkid) {
    return hkid != "" ? true : false;
  },
  tgIdCheck: function(tgid) {
    return tgid != "" ? true : false;
  },
  phoneNumberCheck: function (phoneNumber) {
    return phoneNumber != "" ? true : false;
  },
  phoneNumberValidate: function (phoneNumber) {
    return phoneNumber.length == 8 ? true : false
  },
  emailCheck: function (email) {
    return email != "" ? true : false;
  },
  emailValidate: function (email) {
    const regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email) ? true : false;
  },
  selfieImageCheck: function (guideSelfie) {
    return guideSelfie != "" ? true : false;
  },
  guidePassImageCheck: function (guidePass) {
    return guidePass != "" ? true : false;
  }
};

function submitDriverApplication() {
  var chi_firstname = $("#chi-firstname").val();
  var chi_lastname = $("#chi-lastname").val();
  var birth_year = $('#birth_year').val();
  var birth_month = $('#birth_month').val();
  var hkid = $("#hkid").val();
  var phoneNumber = $('#phone-number').val();
  var email = $('#email').val();
  var seats = $('#seats').val();
  var licensePlateNumber = $('#license-plate-number').val();
  var vehicleExterior = $('#vehicle-exterior').val();
  var vehicleInside = $('#vehicle-inside').val();

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

  if (!driverApplicationCheck.applicantChineseNameCheck(chi_firstname, chi_lastname)) {
    Toast.fire({
      title: '姓名不能為空白。'
    });
  } else if (!driverApplicationCheck.birthDateCheck(birth_year, birth_month)) {
    Toast.fire({
      title: '出生日期不能為空白。'
    });
  } else if (!driverApplicationCheck.hkidCheck(hkid)) {
    Toast.fire({
      title: '身份證號碼不能為空白。'
    });
  } else if (!driverApplicationCheck.phoneNumberCheck(phoneNumber)) {
    Toast.fire({
      title: '電話號碼不能為空白。'
    });
  } else if (!driverApplicationCheck.phoneNumberValidate(phoneNumber)) {
    Toast.fire({
      title: '電話號碼格式不正確。'
    });
  } else if (!driverApplicationCheck.emailCheck(email)) {
    Toast.fire({
      title: '電郵地址不能為空白。'
    });
  } else if (!driverApplicationCheck.seatsNumberCheck(seats)) {
    Toast.fire({
      title: '座位數量不能為空白。'
    });
  } else if (!driverApplicationCheck.licensePlateNumberCheck(licensePlateNumber)) {
    Toast.fire({
      title: '駕駛執照號碼不能為空白。'
    });
  } else if (!driverApplicationCheck.VehicleExteriorCheck(vehicleExterior)) {
    Toast.fire({
      title: '請上傳車輛外部照片。'
    });
  } else if (!driverApplicationCheck.VehicleInsideCheck(vehicleInside)) {
    Toast.fire({
      title: '請上傳車輛內部照片。'
    });
  } else {
    var form = $('#driver-application-form')[0];
    var formData = new FormData(form);

    $.ajax({
      type: "POST",
      url: "/function.php?op=submitDriverJobApplication",
      data: formData,
      dataType: "json",
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      success: function (res) {
        if (res.success) {
          Swal.fire({
            icon: 'success',
            title: '成功提交',
            text: '我們已經收到你的申請，請等待我們確認，申請結果將會以電郵形式通知。'
          }).then(function() {
            window.location.assign("/");
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
      }
    });
  }
}

function submitTourGuideApplication() {
  var lastname = $("#lastname").val();
  var firstname = $("#firstname").val();

  var birth_year = $('#birth_year').val();
  var birth_month = $('#birth_month').val();

  var hkid = $("#hkid").val();
  var tgid = $("#tgid").val();

  var phone_number = $('#phone-number').val();
  var email = $('#email').val();

  var selfie_image = $('#guide-selfie').val();
  var guidePass_image = $('#guide-pass').val();

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

  if (!touristGuideApplicationCheck.nameCheck(firstname, lastname)) {
    Toast.fire({
      title: '姓名不能為空白。'
    });
  } else if (!touristGuideApplicationCheck.birthDateCheck(birth_year, birth_month)) {
    Toast.fire({
      title: '出身日期不能為空白。'
    });
  } else if (!touristGuideApplicationCheck.hkIdCheck(hkid)) {
    Toast.fire({
      title: '身份證號碼不能為空白。'
    });
  } else if (!touristGuideApplicationCheck.tgIdCheck(tgid)) {
    Toast.fire({
      title: '導遊證編號不能為空白。'
    });
  } else if (!touristGuideApplicationCheck.phoneNumberCheck(phone_number)) {
    Toast.fire({
      title: '電話號碼不能為空白。'
    });
  } else if (!touristGuideApplicationCheck.phoneNumberValidate(phone_number)) {
    Toast.fire({
      title: '電話號碼格式不正確。'
    });
  } else if (!touristGuideApplicationCheck.emailCheck(email)) {
    Toast.fire({
      title: '電郵地址不能為空白。'
    });
  } else if (!touristGuideApplicationCheck.emailValidate(email)) {
    Toast.fire({
      title: '電郵地址格式不正確。'
    });
  } else if (!touristGuideApplicationCheck.selfieImageCheck(selfie_image)) {
    Toast.fire({
      title: '請上傳申請人手持導遊證的自拍照片。'
    }); 
  } else if (!touristGuideApplicationCheck.guidePassImageCheck(guidePass_image)) {
    Toast.fire({
      title: '請上傳導遊證照片。'
    });
  } else {
    var form = $('#guide-application-form')[0];
    var formData = new FormData(form);

    $.ajax({
      type: "POST",
      url: "/function.php?op=submitTouristGuideJobApplication",
      data: formData,
      dataType: "json",
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      success: function (res) {
        if (res.success) {
          Swal.fire({
            icon: 'success',
            title: '成功提交',
            text: '我們已經收到你的申請，請等待我們確認，申請結果將會以電郵形式通知。'
          }).then(function() {
            window.location.assign("/");
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
      }
    });
  }
}