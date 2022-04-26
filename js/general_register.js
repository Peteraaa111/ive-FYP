$(document).ready(function () {
  // Email format validation
  $("#r_email").keyup(function () {
    email_emptyChecking($("#r_email").val());
    email_validationChecking($("#r_email").val());
  });
  $("#r_email").focusout(function () {
    email_emptyChecking($("#r_email").val());
    email_validationChecking($("#r_email").val());
  });
  // Password format validation
  $("#r_psw").keyup(function () {
    const password = $("#r_psw").val();
    const confirm_password = $("#r_cpsw").val();

    password_emptyChecking(password);
    password_validationChecking(password);
    password_confirmationChecking(password, confirm_password);
  });
  $("#r_psw").focusout(function () {
    const password = $("#r_psw").val();
    const confirm_password = $("#r_cpsw").val();

    password_emptyChecking(password);
    password_validationChecking(password);
    password_confirmationChecking(password, confirm_password);
  });

  // Password equals validation
  $("#r_cpsw").keyup(function () {
    const password = $("#r_psw").val();
    const confirm_password = $("#r_cpsw").val();

    password_confirmationChecking(password, confirm_password);
  });
  $("#r_cpsw").focusout(function () {
    const password = $("#r_psw").val();
    const confirm_password = $("#r_cpsw").val();

    password_confirmationChecking(password, confirm_password);
  });

  // Nickname checking
  $("#r_nickname").keyup(function () {
    var nickname = $("#r_nickname").val();

    nickname_validationChecking(nickname);
    nickname_emptyChecking(nickname);
  });
  $("#r_nickname").focusout(function () {
    var nickname = $("#r_nickname").val();

    nickname_validationChecking(nickname);
    nickname_emptyChecking(nickname);
  });

  // Phone Number checking
  $("#r_phoneNo").keyup(function () {
    var phoneNumber = $("#r_phoneNo").val();

    phoneNumber_emptyChecking(phoneNumber);
    phoneNumber_validationChecking(phoneNumber);
  });
  $("#r_phoneNo").focusout(function () {
    var phoneNumber = $("#r_phoneNo").val();

    phoneNumber_emptyChecking(phoneNumber);
    phoneNumber_validationChecking(phoneNumber);
  });

  // Sex checking
  $("#r_gender").on("change", function (e) {
    var gender = $("#r_gender").val();

    gender_validationChecking(gender);
  });

  // Birth year checking
  $("#r_birth_year").on("change", function (e) {
    var birth_year = $("#r_birth_year").val();

    birthYear_validationChecking(birth_year);
  });

  // Birth month checkgin
  $("#r_birth_month").on("change", function (e) {
    var birth_month = $("#r_birth_month").val();

    birthMonth_validationChecking(birth_month);
  });
});

function email_emptyChecking(email_address) {
  if (email_address == "") {
    $(".r_email").addClass("error");
    $("#r_email").removeClass("is-valid");
    $("#r_email").addClass("is-invalid");
    return false;
  } else {
    $(".r_email").removeClass("error");
    $("#r_email").removeClass("is-invalid");
    $("#r_email").addClass("is-valid");
    return true;
  }
}

function email_validationChecking(email_address) {
  const regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

  if (regex.test(email_address)) {
    // Valid format
    $(".r_email").removeClass("error");
    $("#r_email").removeClass("is-invalid");
    $("#r_email").addClass("is-valid");
    return true;
  } else {
    // Invalid format
    $(".r_email").addClass("error");
    $("#r_email").removeClass("is-valid");
    $("#r_email").addClass("is-invalid");
    return false;
  }
}

function password_emptyChecking(password) {
  if (password == "") {
    $(".r_psw").addClass("error");
    $("#r_psw").removeClass("is-valid");
    $("#r_psw").addClass("is-invalid");
    $("#r_psw").addClass("error_not_valid");
    return false;
  } else {
    $(".r_psw").removeClass("error");
    $("#r_psw").removeClass("is-invalid");
    $("#r_psw").addClass("is-valid");
    $("#r_psw").removeClass("error_not_valid");
    return true;
  }
}

function password_validationChecking(password) {
  const regex =
    /(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z!@#$%^&*()+=~_-]{8,16}/;

  if (regex.test(password)) {
    // Valid format
    $(".r_psw").removeClass("error");
    $("#r_psw").removeClass("is-invalid");
    $("#r_psw").addClass("is-valid");
    $("#r_psw").removeClass("error_not_valid");
    return true;
  } else {
    // Invalid format and not equals
    $(".r_psw").addClass("error");
    $("#r_psw").removeClass("is-valid");
    $("#r_psw").addClass("is-invalid");
    $("#r_psw").addClass("error_not_valid");
    return false;
  }
}

function confirmPassword_emptyChecking(confirm_password) {
  if (confirm_password == "") {
    $(".r_cpsw").addClass("error");
    $("#r_cpsw").removeClass("is-valid");
    $("#r_cpsw").addClass("is-invalid");
    $("#r_cpsw").addClass("error_not_equals");
    return false;
  } else {
    $(".r_cpsw").removeClass("error");
    $("#r_cpsw").removeClass("is-invalid");
    $("#r_cpsw").addClass("is-valid");
    $("#r_cpsw").removeClass("error_not_equals");
    return true;
  }
}

function password_confirmationChecking(password, confirm_password) {
  if (password === confirm_password) {
    // Equals the password
    $(".r_cpsw").removeClass("error");
    $("#r_cpsw").removeClass("is-invalid");
    $("#r_cpsw").addClass("is-valid");
    $("#r_cpsw").removeClass("error_not_equals");
    return true;
  } else {
    // Not equals the password
    $(".r_cpsw").addClass("error");
    $("#r_cpsw").removeClass("is-valid");
    $("#r_cpsw").addClass("is-invalid");
    $("#r_cpsw").addClass("error_not_equals");
    return false;
  }
}

function nickname_emptyChecking(nickname) {
  if (nickname == "") {
    $(".r_nickname").addClass("error");
    $("#r_nickname").removeClass("is-valid");
    $("#r_nickname").addClass("is-invalid");
    return false;
  } else {
    $(".r_nickname").removeClass("error");
    $("#r_nickname").removeClass("is-invalid");
    $("#r_nickname").addClass("is-valid");
    return true;
  }
}

function nickname_validationChecking(nickname) {
  if (nickname.length < 3 || nickname.length > 20) {
    $(".r_nickname").addClass("error");
    $("#r_nickname").removeClass("is-valid");
    $("#r_nickname").addClass("is-invalid");
    return false;
  } else {
    $(".r_nickname").removeClass("error");
    $("#r_nickname").removeClass("is-invalid");
    $("#r_nickname").addClass("is-valid");
    return true;
  }
}

function phoneNumber_emptyChecking(phoneNumber) {
  if (phoneNumber == "") {
    $(".r_phoneNo").addClass("error");
    $("#r_phoneNo").removeClass("is-valid");
    $("#r_phoneNo").addClass("is-invalid");
    return false;
  } else {
    $(".r_phoneNo").removeClass("error");
    $("#r_phoneNo").removeClass("is-invalid");
    $("#r_phoneNo").addClass("is-valid");
    return true;
  }
}

function phoneNumber_validationChecking(phoneNumber) {
  if (phoneNumber == "" || phoneNumber.length < 8) {
    $(".r_phoneNo").addClass("error");
    $("#r_phoneNo").removeClass("is-valid");
    $("#r_phoneNo").addClass("is-invalid");
    return false;
  } else {
    $(".r_phoneNo").removeClass("error");
    $("#r_phoneNo").removeClass("is-invalid");
    $("#r_phoneNo").addClass("is-valid");
    return true;
  }
}

function gender_validationChecking(gender) {
  if (gender == "") {
    $("#r_gender").removeClass("is-valid");
    $("#r_gender").addClass("is-invalid");
    return false;
  } else {
    $("#r_gender").removeClass("is-invalid");
    $("#r_gender").addClass("is-valid");
    return true;
  }
}

function birthYear_validationChecking(birth_year) {
  if (birth_year == "") {
    $("#r_birth_year").removeClass("is-valid");
    $("#r_birth_year").addClass("is-invalid");
    return false;
  } else {
    $("#r_birth_year").removeClass("is-invalid");
    $("#r_birth_year").addClass("is-valid");
    return true;
  }
}

function birthMonth_validationChecking(birth_month) {
  if (birth_month == "") {
    $("#r_birth_month").removeClass("is-valid");
    $("#r_birth_month").addClass("is-invalid");
    return false;
  } else {
    $("#r_birth_month").removeClass("is-invalid");
    $("#r_birth_month").addClass("is-valid");
    return true;
  }
}

// Register a new General User if all information is CORRECT
function register() {
  // Get the values from the register form
  var email = $("#r_email").val();
  var password = $("#r_psw").val();
  var confirm_password = $("#r_cpsw").val();
  var nickname = $("#r_nickname").val();
  var phone_number = $("#r_phoneNo").val();
  var gender = $("#r_gender").val();
  var birth_year = $("#r_birth_year").val();
  var birth_month = $("#r_birth_month").val();

  const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer),
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  });



  if (!email_emptyChecking(email)) {
    alert("電郵不能為空白。");
  } else if (!email_validationChecking(email)) {
    alert("電郵格式錯誤。");
  } else if (!password_emptyChecking(password)) {
    alert("密碼不能為空白。");
  } else if (!password_validationChecking(password)) {
    alert("密碼格式錯誤。");
  } else if (!confirmPassword_emptyChecking(confirm_password)) {
    alert("確認密碼不能為空白。");
  } else if (!password_confirmationChecking(password, confirm_password)) {
    alert("密碼不一致。");
  } else if (!nickname_emptyChecking(nickname)) {
    alert("暱稱不能為空白。");
  } else if (!nickname_validationChecking(nickname)) {
    alert("暱稱含有非法符號／詞語。");
  } else if (!phoneNumber_emptyChecking(phone_number)) {
    alert("電話號碼不能為空白。");
  } else if (!phoneNumber_validationChecking(phone_number)) {
    alert("電話號碼格式錯誤。");
  } else if (!gender_validationChecking(gender)) {
    alert("請選擇性別。");
  } else if (!birthYear_validationChecking(birth_year)) {
    alert("請選擇出生年份。");
  } else if (!birthMonth_validationChecking(birth_month)) {
    alert("請選擇出生月份。");
  } else {
    generateAvatar(nickname);

    var form = $('#register-form')[0];
    var formData = new FormData(form);

    $.ajax({
      method: "POST",
      url: "/function.php?op=generalUserRegister",
      
      data: formData,
      dataType: "json",

      enctype: "multipart/form-data",
      contentType: false,
      processData: false,

      success: function (res) {
        if (res.success === true) {
          // calls the avatar generator

          $("#register-modal").modal('hide');
          $("#register-form").trigger("reset");
          $(".is-valid").removeClass("is-valid");
          Swal.fire({
            icon: 'success',
            title: '註冊成功',
            text: '你的帳號註冊成功，請到登入頁面進行登入。'
          }).then(function () {
            $("#login-modal").modal('show');
          })
        } else {
          Toast.fire({
            icon: 'error',
            title: res.reason
          });
        }
      },
      error: function (res) {
        alert(res.responseText);
      },
    });
  }
}

function generateAvatar(text) {

  let color = generateLightColorHex();
  render(
    text.substring(0, 2).toUpperCase(),
    "white",
    color
  );

}

var dataURL = "";

function render(text, foregroundColor = "white", backgroundColor = "black") {
  const canvas = document.createElement("canvas");
  const context = canvas.getContext("2d");

  canvas.width = 200;
  canvas.height = 200;

  // Draw background
  context.fillStyle = backgroundColor;
  context.fillRect(0, 0, canvas.width, canvas.height);

  // Draw text
  context.font = "bold 100px Arial";
  context.fillStyle = foregroundColor;
  context.textAlign = "center";
  context.textBaseline = "middle";
  context.fillText(text, canvas.width / 2, canvas.height / 2);

  dataURL = canvas.toDataURL();
  document.getElementById("avatar").value  = dataURL;

  return canvas.toDataURL("image/png");
}

function generateLightColorHex() {
  let color = "#";
  for (let i = 0; i < 3; i++)
    color += ("0" + Math.floor(((1 + Math.random()) * Math.pow(16, 2)) / 2).toString(16)).slice(-2);
  return color;
}