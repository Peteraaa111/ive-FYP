<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>工作平台登入</title>

  <?php include_once("/xampp/htdocs/travelHK.com/library.php") ?>
  <link rel="stylesheet" href="/css/worker_login.css">
  <script src="/js/worker/login.js"></script>
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

  <section id="partner-login">
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
                工作者登入
              </div>
              <!-- Accordion start -->
              <div class="accordion mt-2" id="partner-select">
                <!-- Tourist Guide login form -->
                <div class="accordion-item">
                  <h2 class="accordion-header" id="tourist-guide">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tourist-guide-login" aria-expanded="false" aria-controls="tourist-guide-login">
                      導遊
                    </button>
                  </h2>
                  <div id="tourist-guide-login" class="accordion-collapse collapse" aria-labelledby="tourist-guide" data-bs-parent="#partner-select">
                    <div class="accordion-body">
                      <form id="tourist-guide-login-form" novalidate>
                        <div class="form-floating mb-3">
                          <input type="email" name="email" id="t_email" class="form-control" placeholder="example@example.com" required>
                          <label for="t_email">電郵</label>
                        </div>
                        <div class="form-floating mb-3">
                          <input type="password" name="password" id="t_password" class="form-control" placeholder="********" required>
                          <label for="t_password">密碼</label>
                        </div>
                        <div class="text-center">
                          <button type="button" class="btn btn-primary" onclick="login('touristGuide');">登入</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- End of Tourist Guide login form -->
                <!-- Driver login form -->
                <div class="accordion-item">
                  <h2 class="accordion-header" id="driver">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#driver-login" aria-expanded="false" aria-controls="driver-login">
                      司機
                    </button>
                  </h2>
                  <div id="driver-login" class="accordion-collapse collapse" aria-labelledby="driver-login" data-bs-parent="#partner-select">
                    <div class="accordion-body">
                      <form id="driver-login-form" novalidate>
                        <div class="form-floating mb-3">
                          <input type="email" name="email" id="d_email" class="form-control" placeholder="example@example.com" required>
                          <label for="d_email">電郵</label>
                        </div>
                        <div class="form-floating mb-3">
                          <input type="password" name="password" id="d_password" class="form-control" placeholder="********" required>
                          <label for="d_password">密碼</label>
                        </div>
                        <div class="text-center">
                          <button type="button" class="btn btn-primary" onclick="login('driver');">登入</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End of Driver login form -->
              <!-- Accordion end -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

</body>

</html>