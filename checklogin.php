<script>
function myFunction(){
  document.getElementById('login-btn').click();   
  if($('#login-modal').on('hidden.bs.modal', function () {
    // Setting up the Toast message
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

    Swal.fire({
      icon: 'error',
      title: '請先登入',
      showConfirmButton: false,
      timer: 2000,
      timerProgressBar: true
    }).then(function () {
      window.history.back();
    });

    // window.history.back();
    // Toast.fire({
    //   title: 'You should login first。'
    // });
    //window.history.back();
    //window.location.href = '/zh-hk';
  }));
}
</script>

<?php 
if (!isset($_SESSION)) {
    session_start();
}

if(!isset($_SESSION['user_id']))
{
  ?>
  <body onload=myFunction();>

  </body>
  
  <?php
  
}
?>




