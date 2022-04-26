function login(type) {
  // Set the toast message setting
  const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  });

  if (type == "touristGuide") {
    // Get the login form values
    var email = $("#t_email").val();
    var psw = $("#t_password").val();
    
    if (email == "") {
      Toast.fire({
        icon: 'info',
        title: '請輸入電郵。'
      });
    } else if (psw == "") {
      Toast.fire({
        icon: 'info',
        title: '請輸入密碼。'
      });
    } else {
      $.ajax({
        method: "POST",
        url: "/function.php?op=checkWorkerLogin&type=tourist_guide",
        data: {email: email, psw: psw},
        dataType: "json",
        success: function (res) {
          if (res.success) {
            window.location.assign("tourist_guide");
          } else {
            switch (res.reason) {
              case "not exist":
              Toast.fire({
                icon: 'error',
                title: '你的電郵或密碼錯誤。'
              });
              break;
            case "password invalid":
              Toast.fire({
                icon: 'error',
                title: '你的電郵或密碼錯誤。'
              });
              break;
            case "freezed":
              Toast.fire({
                icon: 'info',
                title: '此帳號已凍結，請聯絡客戶服務。'
              });
              break;
            }
          }
        },
        error: function (res) {
          console.log(res.responseText);
        }
      });
    }
  } else if (type == "driver") {
    // Get the login form values
    var email = $("#d_email").val();
    var psw = $("#d_password").val();

    if (email == "") {
      Toast.fire({
        icon: 'info',
        title: '請輸入電郵。'
      });
    } else if (psw == "") {
      Toast.fire({
        icon: 'info',
        title: '請輸入密碼。'
      });
    } else {
      $.ajax({
        method: "POST",
        url: "/function.php?op=checkWorkerLogin&type=driver",
        data: {email: email, psw: psw},
        dataType: "json",
        success: function (res) {
          if (res.success) {
            window.location.assign("driver");
          } else {
            switch (res.reason) {
              case "not exist":
              Toast.fire({
                icon: 'error',
                title: '你的電郵或密碼錯誤。'
              });
              break;
            case "password invalid":
              Toast.fire({
                icon: 'error',
                title: '你的電郵或密碼錯誤。'
              });
              break;
            case "freezed":
              Toast.fire({
                icon: 'info',
                title: '此帳號已凍結，請聯絡客戶服務。'
              });
              break;
            }
          }
        },
        error: function (res) {
          console.log(res.responseText);
        }
      });
    }
  }
}