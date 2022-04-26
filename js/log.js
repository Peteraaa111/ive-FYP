function log(user_id, item_id, event, custom_weight = '', target_type) {
  $.ajax({
    type: "GET",
    url: "/function.php?op=attractionEventLogGenerate&type="+target_type,
    data: {user_id: user_id, item_id: item_id, event_type: event, custom_weight: custom_weight, target_type: target_type},
    dataType: "json",
    success: function (response) {
      if (!response.success) {
        console.log(response.reason);
      }
    },
    error: function (response) {
      Swal.fire({
        icon: 'error',
        text: response.responseText
      });
    }
  });
}