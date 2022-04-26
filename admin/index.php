<?php
session_start();
if (isset($_SESSION['admin_id'])) {
  header("Location: dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>管理員登入</title>

  <?php include_once("/xampp/htdocs/travelHK.com/library.php") ?>
  <link rel="stylesheet" href="/css/admin_login.css">
</head>

<body>

  <section id="navbar">
    <nav class="navbar navbar-light" style="background-color: #e3f2fd;">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">
          <img src="/assets/img/web_logo/logo_sm.png" alt="" width="40" height="30" class="d-inline-block align-text-top">
          TravelHK
        </a>
      </div>
    </nav>
  </section>

  <section id="staff-login">
    <div class="container mt-5 pt-5">
      <div class="row">
        <div class="col-12 col-sm-8 col-md-6 col-lg-4 m-auto">
          <div class="card">
            <div class="card-body border-0 shadow">
              <div class="text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                  <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                  <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                </svg>
              </div>
              <div class="mt-2 text-center fw-bold">
                管理員登入
              </div>
              <!-- Form start -->
              <form id="login" action="../function.php?op=checkStaffLogin" method="POST">
                <input type="text" name="email" id="email" class="form-control my-3 py-2" placeholder="Email" required>
                <input type="password" name="password" id="password" class="form-control my-3 py-2" placeholder="Password" required>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary" name="login">Login</button>
                </div>
              </form>
              <!-- Form end -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

</body>

</html>