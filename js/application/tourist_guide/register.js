$(document).ready(function () {
  $('#login-btn').hide();
  $('#register-btn').hide();
  
  $('#step-2').hide();
  $('#finish').hide();
  $('#finished').hide();
  
  // Step 1 Button -  Next to register button
  $('#next-to-register').click(function () {
    $('#step-1').fadeOut().promise().done(function () {
      $('.progress-bar').prop('aria-valuenow', '50');
      $('.progress-bar').css('width', '50%');
      $('#step-2').fadeIn();
    })
  })

  $('#next-to-finish').click(function () {
    var email       = $('#worker-email').val();
    var psw         = $('#worker-psw').val();
    var confPsw     = $('#worker-confPsw').val();
    var firstname   = $('#worker-firstname').val();
    var lastname    = $('#worker-lastname').val();
    var birth_year  = $('#worker-birth_year').val();
    var birth_month = $('#worker-birth_month').val();
    var phoneNo     = $('#worker-phoneNo').val();
    var gender      = $('#worker-gender').val();

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

    if (!registerCheck.emailCheck(email)) {
      Toast.fire({
        title: '電郵地址不能為空白。'
      });
    } else if (!registerCheck.passwordCheck(psw)) {
      Toast.fire({
        title: '密碼不能為空白。'
      });
    } else if (!registerCheck.passwordValidate(psw)) {
      Toast.fire({
        title: '密碼格式不正確。',
        text: '密碼為8~16位數，須包含英文大小寫、數字。'
      });
    } else if (!registerCheck.passwordEqual(psw, confPsw)) {
      Toast.fire({
        title: '密碼不一致。'
      });
    } else if (!registerCheck.lastnameCheck(lastname)) {
      Toast.fire({
        title: '姓氏不能為空白。'
      });
    } else if (!registerCheck.firstnameCheck(firstname)) {
      Toast.fire({
        title: '名字不能為空白。'
      });
    } else if (!registerCheck.birthDateCheck(birth_year, birth_month)) {
      Toast.fire({
        title: '出身日期不能為空白。'
      });
    } else if (!registerCheck.phoneNumberCheck(phoneNo)) {
      Toast.fire({
        title: '電話號碼不能為空白。'
      });
    } else if (!registerCheck.genderCheck(gender)) {
      Toast.fire({
        title: '性別不能為空白。'
      });
    } else {
      var register = $('#tourist-guide-register').serialize();
      $.ajax({
        type: "POST",
        url: "/function.php?op=workerUserRegister&type=4",
        data: register,
        dataType: "json",
        success: function (res) {
          if (res.success) {
            $('#step-2').fadeOut().promise().done(function () {
              $('.progress-bar').prop('aria-valuenow', '100');
              $('.progress-bar').css('width', '100%');
              $('.progress-bar').addClass('bg-success');
              $('#finish').fadeIn();
            })
          } else {
            Toast.fire({
              title: res.reason
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
  })
});

var registerCheck = {
  emailCheck: function (email) {
    const regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email) ? true : false;
  },
  passwordCheck: function (psw) {
    return psw != "" ? true : false;
  },
  passwordValidate: function (psw) {
    const regex =
      /^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])([^\s]){8,16}$/gm;
    return regex.test(psw) ? true : false;
  },
  passwordEqual: function (psw, cpsw) {
    return psw == cpsw ? true : false;
  },
  firstnameCheck: function (firstname) {
    return firstname != "" ? true : false;
  },
  lastnameCheck: function (lastname) {
    return lastname != "" ? true : false;
  },
  birthDateCheck: function (birth_year, birth_month) {
    return birth_year != "" && birth_month != "" ? true : false;
  },
  phoneNumberCheck: function (phoneNo) {
    return phoneNo != "" && phoneNo.length == 8 ? true : false;
  },
  genderCheck: function (gender) {
    return gender != "" ? true : false;
  }
}