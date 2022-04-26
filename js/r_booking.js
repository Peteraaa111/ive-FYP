$(document).ready(function () {
  
  var today = new Date().toISOString().split('T')[0];
  // document.getElementsByName("start-date")[0].setAttribute('min', today);
  // document.getElementsByName("end-date")[0].setAttribute('min', today);
  $("#start-date").attr("min", today);
  $("#end-date").attr("min", today);

  // restaurant cancel button event
  $("#cancel-btn").click(function() {
    if (confirm("所有預約資料會遺失，確定繼續？") == true) {
      document.location.href = "http://localhost/zh-hk/r_details.php?id=" + $("#restaurant-id").val();
    } else {
      return;
    }
  });

  // guesthouse cancel button event
  $("#g-cancel-btn").click(function() {
    if (confirm("所有預約資料會遺失，確定繼續？") == true) {
      document.location.href = "http://localhost/zh-hk/g_details.php?id=" + $("#guesthouse-id").val();
    } else {
      return;
    }
  });

  $("#start-date").change(function() {
    document.getElementsByName("end-date")[0].setAttribute('min', $("#start-date").val());
  });

});

function restaurantBooking() {
  // Get the values of booking from booking form
  var booking_date = document.getElementById("booking-date").value;
  var booking_time = document.getElementById("booking-time").value;
  var people = document.getElementById("people").value;
  var name = document.getElementById("contact-name").value;
  var phone = document.getElementById("contact-number").value;
  var email = document.getElementById("contact-email").value;

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
  if (booking_date == "") {
    Toast.fire({
      title: '預約日期不能為空白。'
    });
  } else if (booking_time == "") {
    Toast.fire({
      title: '預約時間不能為空白。'
    });
  } else if (people == "") {
    Toast.fire({
      title: '顧客人數不能為空白。'
    });
  }  else if (name == "") {
    Toast.fire({
      title: '顧客名稱不能為空白。'
    });
  } else if (phone == "") {
    Toast.fire({
      title: '電話號碼不能為空白。'
    });
  } else if (email == "") {
    Toast.fire({
      title: '電郵地址不能為空白。'
    });
  } else if (booking_date <= new Date().toISOString().split('T')[0]) {
    Toast.fire({
      title: '請輸入有效日期以進行預約。'
    });
  } else if (phone.length < 8) {
    Toast.fire({
      title: '請輸入有效電話號碼。'
    });
  } else {
    // Package the form data
    var form = $("#restaurant-booking-form")[0];
    var formData = new FormData(form);

    $.ajax({
      method: "POST",
      url: "/function.php?op=restaurantBookingRequest",
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
            text: '我們已經收到你的申請，請等待相關職員確認，預約結果將會以電郵形式通知。'
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
  } // end if
}

function guesthouseBooking() {
  // Get the values of booking from booking form
  var start_date = document.getElementById("start-date").value;
  var end_date = document.getElementById("end-date").value;
  var rooms = document.getElementById("rooms").value;
  var adult = document.getElementById("adult-number").value;
  var child = document.getElementById("child-number").value;
  var name = document.getElementById("contact-name").value;
  var phone = document.getElementById("contact-number").value;
  var email = document.getElementById("contact-email").value;

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
  if (start_date == "" || end_date == "") {
    Toast.fire({
      title: '預約日期不能為空白。'
    });
  } else if (rooms == "") {
    Toast.fire({
      title: '房間數目不能為空白。'
    });
  } else if (adult == "") {
    Toast.fire({
      title: '顧客人數不能為空白。'
    });
  } else if (child == "") {
    Toast.fire({
      title: '如沒有同行小童，請輸入數字零為小童人數。'
    });
  } else if (name == "") {
    Toast.fire({
      title: '顧客名稱不能為空白。'
    });
  } else if (phone == "") {
    Toast.fire({
      title: '電話號碼不能為空白。'
    });
  } else if (email == "") {
    Toast.fire({
      title: '電郵地址不能為空白。'
    });
  } else if (phone.length < 8) {
    Toast.fire({
      title: '請輸入有效電話號碼。'
    });
  } else if (adult <= 0 || child < 0) {
    Toast.fire({
      title: '顧客人數不能少於一位。'
    });
  } else if (end_date <= start_date) {
    Toast.fire({
      title: '退房日期格式錯誤。'
    });
  }else {
    // Package the form data
    var form = $("#guesthouse-booking-form")[0];
    var formData = new FormData(form);

    $.ajax({
      method: "POST",
      url: "/function.php?op=guesthouseBookingRequest",
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
            text: '我們已經收到你的申請，請等待相關職員確認，預約結果將會以電郵形式通知。'
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
  } // end if
}

// guesthouse cancel booking
function g_cancelBooking() {
  if (confirm("確定取消預約？") == true) {
    var booking_id = document.getElementById("booking-id").value;
    // Package the form data
    var form = $("#update-guesthouse-booking-form")[0];
    var formData = new FormData(form);

    $.ajax({
      method: "POST",
      url: "/function.php?op=cancelGuesthouseBooking",
      data: formData,
      dataType: "json",
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      success: function (res) {
        if (res.success === true) {
          Swal.fire({
            icon: 'success',
            title: '成功取消'
          }).then(function () {
             window.location.replace("/zh-hk/membership/booking.php");
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
 } else {
   return;
 }
}

// restaurant cancel booking
function r_cancelBooking() {
  if (confirm("確定取消預約？") == true) {
    var booking_id = document.getElementById("booking-id").value;
    // Package the form data
    var form = $("#update-restaurant-booking-form")[0];
    var formData = new FormData(form);

    $.ajax({
      method: "POST",
      url: "/function.php?op=cancelRestaurantBooking",
      data: formData,
      dataType: "json",
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      success: function (res) {
        if (res.success === true) {
          Swal.fire({
            icon: 'success',
            title: '成功取消'
          }).then(function () {
             window.location.replace("/zh-hk/membership/booking.php");
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
 } else {
   return;
 }
}