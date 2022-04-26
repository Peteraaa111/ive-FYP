function updateUserInfo() {
  // Get the values from the register form
  var email_address = $("#_email").val();
  var firstname = $("#_firstname").val();
  var lastname = $("#_lastname").val();
  var nickname = $("#_nickname").val();
  var phone_number = $("#_phoneNumber").val();
  var gender = $("#_gender").val();
  var birth_year = $("#_birthYear").val();
  var birth_month = $("#_birthMonth").val();

  // Set the toast message box
  const Toast = Swal.mixin({
    icon: 'error',
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

  if (!Update.nickname_emptyCheck(nickname)) {
    Toast.fire({
      title: '暱稱不能為空白。'
    });
  } else if (!Update.nickname_validationCheck(nickname)) {
    Toast.fire({
      title: '暱稱含有非法符號／詞語。'
    });
  } else if (!Update.phoneNumber_validationCheck(phone_number)) {
    Toast.fire({
      title: '電話號碼格式錯誤。'
    });
  } else if (!Update.gender_validationCheck(gender)) {
    Toast.fire({
      title: '請選擇性別。'
    });
  } else if (!Update.birthYear_validationCheck(birth_year)) {
    Toast.fire({
      title: '請選擇出生年份。'
    });
  } else if (!Update.birthMonth_validationCheck(birth_month)) {
    Toast.fire({
      title: '請選擇出生月份。'
    });
  } else {
    $.ajax({
      url: "/function.php?op=updateUserInfo",
      method: "POST",
      dataType: "json",
      data: $("#update-info").serialize(),
      success: function (res) {
        if (res.success === true) {
          Swal.fire({
            icon: 'success',
            title: '資料已更新',
            text: '你的帳號資料已成功更新。'
          })
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: res.reason
          })
        }
      },
      error: function (res) {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: res.responseText
        })
      },
    });
  }
}

function updatePassword() {
  // Get the values from the register form
  var old_password = document.getElementById("_oldPassword").value;
  var new_password = document.getElementById("_newPassword").value;
  var new_conf_password = document.getElementById("_confNewPassword").value;

  // Set the toast message box
  const Toast = Swal.mixin({
    icon: 'error',
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

  if (!Update.password_emptyCheck(old_password)) {
    Toast.fire({
      title: '舊密碼不能為空白。'
    });
  } else if (!Update.password_validationCheck(new_password)) {
    Toast.fire({
      title: '新密碼格式錯誤。'
    });
  } else if (!Update.confirmPassword_emptyCheck(new_conf_password)) {
    Toast.fire({
      title: '確認密碼不能為空白。'
    });
  } else if (!Update.password_confirmationCheck(new_password, new_conf_password)) {
    Toast.fire({
      title: '新密碼不一致。'
    });
  } else {
    $.ajax({
      url: "/function.php?op=updatePassword",
      method: "POST",
      dataType: "json",
      data: $("#update-psw").serialize(),
      success: function (res) {
        if (res.success) {
          Swal.fire({
            icon: 'success',
            title: '密碼已更新',
            text: '你的帳號密碼已成功更新。'
          })
        } else {
          alert(res.reason);
        }
      },
      error: function (res) {
        alert("error");
        console.log(res);
      },
    });
  }
}

var Update = {
  nickname_emptyCheck: function (nickname) {
    if (nickname == "") {
      return false;
    } else {
      return true;
    }
  },
  nickname_validationCheck: function (nickname) {
    if (nickname == "") {
      return false;
    } else if (nickname.length < 3 || nickname.length > 20) {
      return false;
    } else {
      return true;
    }
  },
  phoneNumber_emptyCheck: function (phoneNumber) {
    if (phoneNumber == "") {
      return false;
    } else {
      return true;
    }
  },
  phoneNumber_validationCheck: function (phoneNumber) {
    if (phoneNumber == "") {
      return true
    }else {
      return true;
    }
  },
  gender_validationCheck: function (gender) {
    if (gender == "") {
      return false;
    } else {
      return true;
    }
  },
  birthYear_validationCheck: function (birth_year) {
    if (birth_year == "") {
      return false;
    } else {
      return true;
    }
  },
  birthMonth_validationCheck: function (birth_month) {
    if (birth_month == "") {
      return false;
    } else {
      return true;
    }
  },
  password_emptyCheck: function (password) {
    if (password == "") {
      return false;
    } else {
      return true;
    }
  },
  password_validationCheck: function (password) {
    const regex =
      /(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z!@#$%^&*()+=~_-]{8,16}/;
  
    if (regex.test(password)) {
      // Valid format
      return true;
    } else {
      // Invalid format and not equals
      return false;
    }
  },
  confirmPassword_emptyCheck: function (confirm_password) {
    if (confirm_password == "") {
      return false;
    } else {
      return true;
    }
  },
  password_confirmationCheck: function (password, confirm_password) {
    if (password === confirm_password) {
      // Equals the password
      return true;
    } else {
      // Not equals the password
      return false;
    }
  }
};