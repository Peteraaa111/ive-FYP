$(document).ready(function () {
  $("#l_email").on('keypress', function (e) {
    if (e.which == 13) {
      login();
    }
  })
  $("#l_psw").on('keypress', function (e) {
    if (e.which == 13) {
      login();
    }
  })
})

function login() {
  var email = $("#l_email").val();
  var psw   = $("#l_psw").val();
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

  $.ajax({
    type: "POST",
    url: "/function.php?op=checkLogin",
    data: {email: email, psw: psw},
    dataType: "json",
    success: function (res) {
      if (res.success) {
        Swal.fire({
          icon: 'success',
          title: '登入成功',
          text: '將會2秒後重新載入頁面。',
          showConfirmButton: false,
          timer: 2000,
          timerProgressBar: true
        }).then(function () {
          window.location.reload();
        });
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
      Toast.fire({
        icon: 'error',
        title: '發生不明錯誤。'
      });
    }
  });
}