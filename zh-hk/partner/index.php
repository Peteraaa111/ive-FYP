<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>合作夥伴登入</title>

  <?php include_once("/xampp/htdocs/travelHK.com/library.php") ?>
  <link rel="stylesheet" href="/css/partner_login.css">
  <script src="/js/partner/login.js"></script>
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
                合作夥伴登入
              </div>
              <!-- Accordion start -->
              <div class="accordion mt-2" id="partner-select">
                <!-- Restaurant partner login form -->
                <div class="accordion-item">
                  <h2 class="accordion-header" id="restaurant">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#restaurant-login" aria-expanded="false" aria-controls="restaurant-login">
                      餐廳管理員
                    </button>
                  </h2>
                  <div id="restaurant-login" class="accordion-collapse collapse" aria-labelledby="restaurant" data-bs-parent="#partner-select">
                    <div class="accordion-body">
                      <form id="restaurant-login-form" novalidate>
                        <div class="form-floating mb-3">
                          <input type="email" name="email" id="r_email" class="form-control" placeholder="example@example.com" required>
                          <label for="r_email">電郵</label>
                        </div>
                        <div class="form-floating mb-3">
                          <input type="password" name="password" id="r_password" class="form-control" placeholder="********" required>
                          <label for="r_password">密碼</label>
                        </div>
                        <div class="text-center">
                          <button type="button" class="btn btn-primary" onclick="login('restaurant');">登入</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- End of restaurant partner login form -->
                <div class="accordion-item">
                  <h2 class="accordion-header" id="guesthouse">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#guesthouse-login" aria-expanded="false" aria-controls="guesthouse-login">
                      民宿管理員
                    </button>
                  </h2>
                  <div id="guesthouse-login" class="accordion-collapse collapse" aria-labelledby="guesthouse-login" data-bs-parent="#partner-select">
                    <div class="accordion-body">
                      <form id="guesthouse-login-form" novalidate>
                        <div class="form-floating mb-3">
                          <input type="email" name="email" id="g_email" class="form-control" placeholder="example@example.com" required>
                          <label for="g_email">電郵</label>
                        </div>
                        <div class="form-floating mb-3">
                          <input type="password" name="password" id="g_password" class="form-control" placeholder="********" required>
                          <label for="g_password">密碼</label>
                        </div>
                        <div class="text-center">
                          <button type="button" class="btn btn-primary" onclick="login('guesthouse');">登入</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Accordion end -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

</body>

</html>