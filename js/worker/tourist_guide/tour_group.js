function finishTourGroup() {
  var tourgroup_id = $('#tourgroup_id').val();

  Swal.fire({
    icon: 'warning',
    title: '操作確認',
    text: '是否確定結束旅行團？',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: '結束旅行團',
    cancelButtonText: '關閉'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        url: "/itinerary_function.php?op=finishTourGroup",
        data: {id: tourgroup_id},
        dataType: "json",
        success: function (res) {
          if (res.success === true) {
            Swal.fire({
              icon: 'success',
              title: '操作完成',
              text: '旅行團已結束。'
            }).then(function () {
              window.location.reload();
            })
          } else {
            Swal.fire({
              icon: 'success',
              title: 'Error',
              text: res.reason
            });
          }
        }
      });
    }
  })
}

function cancelTourGroup() {
  var tourgroup_id = $('#tourgroup_id').val();

  Swal.fire({
    icon: 'warning',
    title: '操作確認',
    text: '是否確定取消旅行團？',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: '取消旅行團',
    cancelButtonText: '關閉'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        url: "/itinerary_function.php?op=cancelTourGroup",
        data: {id: tourgroup_id},
        dataType: "json",
        beforeSend: function () {
          $.LoadingOverlay("show");
        },
        success: function (res) {
          $.LoadingOverlay("hide");
          if (res.success === true) {
            Swal.fire({
              icon: 'success',
              title: '操作完成',
              text: '旅行團已取消。'
            }).then(function () {
              window.location.reload();
            })
          } else {
            Swal.fire({
              icon: 'success',
              title: 'Error',
              text: res.reason
            });
          }
        }
      });
    }
  })
}