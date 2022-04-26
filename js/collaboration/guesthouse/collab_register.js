$(document).ready(function () {
  var new_ac_id;

  $('#login-btn').hide();
  $('#register-btn').hide();
  // $('#step-1').hide();
  $('#step-2').hide();
  $('#step-3').hide();
  $('#finish').hide();
  $('#finished').hide();

  // Step 1 Button -  Next to register button
  $('#next-to-register').click(function () {
    $('#step-1').fadeOut().promise().done(function () {
      $('.progress-bar').prop('aria-valuenow', '33');
      $('.progress-bar').css('width', '33%');
      $('#step-2').fadeIn();
    })
  })

  // Step 2 Button - Next to guesthouse button
  $('#next-to-guesthouse').click(function () {
    var email       = $('#collab-email').val();
    var psw         = $('#collab-psw').val();
    var confPsw     = $('#collab-confPsw').val();
    var firstname   = $('#collab-firstname').val();
    var lastname    = $('#collab-lastname').val();
    var phoneNo     = $('#collab-phoneNo').val();
    var gender      = $('#collab-gender').val();

    if (!email_emptyChecking(email)) {
      alert("電郵不能為空白。");
    } else if (!email_validationChecking(email)) {
      alert("電郵格式錯誤。");
    } else if (!password_emptyChecking(psw)) {
      alert("密碼不能為空白。");
    } else if (!password_validationChecking(psw)) {
      alert("密碼格式錯誤。");
    } else if (!confirmPassword_emptyChecking(confPsw)) {
      alert("確認密碼不能為空白。");
    } else if (!password_confirmationChecking(psw, confPsw)) {
      alert("密碼不一致。");
    } else if (!firstname_emptyChecking(firstname)) {
      alert("名字不能為空白。");
    } else if (!lastname_emptyChecking(lastname)) {
      alert("姓氏不能為空白。");
    } else if (!phoneNumber_emptyChecking(phoneNo)) {
      alert("電話號碼不能為空白。");
    } else if (!phoneNumber_validationChecking(phoneNo)) {
      alert("電話號碼格式錯誤。");
    } else if (!gender_validationChecking(gender)) {
      alert("請選擇性別。");
    } else {
      $.ajax({
        url: "/function.php?op=collabUserRegister&type=3",
        method: "POST",
        dataType: "json",
        data: $("#collab-register").serialize(),
        success: function (res) {
          if (res.success === true) {
            new_ac_id = res.id;
            $('#step-2').fadeOut().promise().done(function () {
              $('.progress-bar').prop('aria-valuenow', '66');
              $('.progress-bar').css('width', '66%');
              $('#step-3').fadeIn();
            })
          } else {
            alert(res.reason);
          }
        },
        error: function (res) {
          alert(res.responseText);
        }
      })
    }
  })
  // End of Step 2 button on click event handler

  // Step 3 Button - Next to finish button
  $('#next-to-finish').click(function () {
    $.ajax({
      url: "/function.php?op=siteGenerator&type=guesthouse&account=" + new_ac_id,
      method: "POST",
      dataType: "json",
      data: $('#collab-guesthouse').serialize(),
      success: function (res) {
        if (res.success === true) {
          $('#step-3').fadeOut().promise().done(function () {
            $('.progress-bar').prop('aria-valuenow', '100');
            $('.progress-bar').css('width', '100%');
            $('.progress-bar').addClass('bg-success');
            $('#finish').fadeIn();
          })
        } else {
          alert(res.reason);
        }
      },
      error: function (res) {
        alert(res.responseText);
      }
    })
    $.ajax({
      type: "POST",
      url: "/function.php?op=completePartnerRequest&id="+$('#request-id').val(),
      dataType: "json",
      success: function (res) {
        if (res.success === false) {
          console.log(res.responseText);
        }
      },
      error: function (res) {
        console.log(res.responseText);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: res.responseText
        });
      }
    });
  })
})


// Register validation check
{
  function email_emptyChecking(email_address) {
    if (email_address == "") {
      $("#collab-email").addClass("error");
      return false;
    } else {
      $("#collab-email").removeClass("error");
      return true;
    }
  }
  
  function email_validationChecking(email_address) {
    const regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  
    if (regex.test(email_address)) {
      // Valid format
      $("#collab-email").removeClass("error");
      return true;
    } else {
      // Invalid format
      $("#collab-email").addClass("error");
      return false;
    }
  }
  
  function password_emptyChecking(password) {
    if (password == "") {
      $("#collab-psw").addClass("error");
      $("#collab-psw").addClass("error_not_valid");
      return false;
    } else {
      $("#collab-psw").removeClass("error");
      $("#collab-psw").removeClass("error_not_valid");
      return true;
    }
  }
  
  function password_validationChecking(password) {
    const regex =
      /(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z!@#$%^&*()+=~_-]{8,16}/;
  
    if (regex.test(password)) {
      // Valid format
      $("#collab-psw").removeClass("error");
      $("#collab-psw").removeClass("error_not_valid");
      return true;
    } else {
      // Invalid format and not equals
      $("#collab-psw").addClass("error");
      $("#collab-psw").addClass("error_not_valid");
      return false;
    }
  }
  
  function confirmPassword_emptyChecking(confirm_password) {
    if (confirm_password == "") {
      $("#collab-confPsw").addClass("error");
      $("#collab-confPsw").addClass("error_not_equals");
      return false;
    } else {
      $("#collab-confPsw").removeClass("error");
      $("#collab-confPsw").removeClass("error_not_equals");
      return true;
    }
  }
  
  function password_confirmationChecking(password, confirm_password) {
    if (password === confirm_password) {
      // Equals the password
      $("#collab-confPsw").removeClass("error");
      $("#collab-confPsw").removeClass("error_not_equals");
      return true;
    } else {
      // Not equals the password
      $("#collab-confPsw").addClass("error");
      $("#collab-confPsw").addClass("error_not_equals");
      return false;
    }
  }
  
  function firstname_emptyChecking(firstname) {
    if (firstname == "") {
      $("#collab-firstname").addClass("error");
      return false;
    } else {
      $("#collab-firstname").removeClass("error");
      return true;
    }
  }
  
  function lastname_emptyChecking(lastname) {
    if (lastname == "") {
      $("#collab-lastname").addClass("error");
      return false;
    } else {
      $("#collab-lastname").removeClass("error");
      return true;
    }
  }

  function phoneNumber_emptyChecking(phoneNumber) {
    if (phoneNumber == "") {
      $("#collab-phoneNo").addClass("error");
      return false;
    } else {
      $("#collab-phoneNo").removeClass("error");
      return true;
    }
  }
  
  function phoneNumber_validationChecking(phoneNumber) {
    if (phoneNumber == "" || phoneNumber.length < 8) {
      $("#collab-phoneNo").addClass("error");
      return false;
    } else {
      $("#collab-phoneNo").removeClass("error");
      return true;
    }
  }
  
  function gender_validationChecking(gender) {
    if (gender == "") {
      $("#collab-gender").addClass("error");
      return false;
    } else {
      $("#collab-gender").removeClass("error");
      return true;
    }
  }
}