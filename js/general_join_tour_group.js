function submitTourGroupRegistration() {
  var tourGroupId = $('#tourgroup-id').val();
  var applicantId = $('#applicant-id').val();
  var contactNumber = $('#contact-number').val();
  var numberOfPeople = $('#number-of-people').val();

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

  if (!submitTourGroupCheck.contactNumberCheck(contactNumber)) {
    Toast.fire({
      title: '請輸入聯絡電話。'
    });
  } else if (!submitTourGroupCheck.numberOfPeopleCheck(numberOfPeople)) {
    Toast.fire({
      title: '請輸入參加人數。'
    });
  } else {
    $.ajax({
      type: "POST",
      url: "/function.php?op=submitTourGroupRegistration",
      data: {tourGroupId: tourGroupId, applicantId: applicantId, contactNumber: contactNumber, numberOfPeople: numberOfPeople},
      dataType: "json",
      success: function (res) {
        if (res.success === true) {
          if (res.join_success === true) {
            Swal.fire({
              icon: 'success',
              title: '報名成功',
              text: '旅行團報名申請已提交。'
            }).then(function () {
              location.href = '/zh-hk/membership/tourgroup_list.php';
            });
          } else {
            if (res.reason === "Registration is full") {
              Swal.fire({
                icon: 'warning',
                title: '人數已滿',
                text: '報名人數已滿'
              });
            } else if (res.reason === "Insufficient balance") {
              Swal.fire({
                icon: 'warning',
                title: '報名餘額不足',
                text: '報名餘額不足，請重新輸入參加人數。'
              });
            } else if (res.reason === "Duplicate registration") {
              Swal.fire({
                icon: 'warning',
                title: '重複報名',
                html: '如需要更改參加人數，請到<a href="/zh-hk/membership/tourgroup_list.php" style="text-decoration: none;">「會員中心」－「旅行團記錄」</a>取消報名，再重新報名。'
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: res.responseText
              });
            }
          }
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
          title: 'Unknown error',
          text: res.responseText
        });
      }
    });
  }
}

const submitTourGroupCheck = {
  contactNumberCheck: function (contactNumber) {
    return contactNumber.length == 8 ? true : false;
  },
  numberOfPeopleCheck: function (numberOfPeople) {
    return numberOfPeople > 0 ? true : false;
  }
}