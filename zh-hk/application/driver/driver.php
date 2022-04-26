<?php
// Start the SESSION
session_start();

include_once('/xampp/htdocs/travelHK.com/dbConnect.php');
global $conn;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>司機工作申請 - 香港本地旅遊平台 | 本地遊</title>

  <!-- Link the default css and js library -->
  <?php include_once('/xampp/htdocs/travelHK.com/library.php'); ?>

  <link href="/css/apply_form.css" rel="stylesheet">

  <script src="/js/application/apply.js"></script>
</head>

<body>

  <!-- Header -->
  <?php include_once('/xampp/htdocs/travelHK.com/zh-hk/common/header.php'); ?>

  <!-- Category -->
  <?php include_once('/xampp/htdocs/travelHK.com/zh-hk/common/category.php'); ?>

  <!-- Main Content -->
  <form id="driver-application-form" enctype="multipart/form-data" method="POST">
    <div class="container card">
      <div class="card-body">
        <div class="row card">
          <div class="card-body">
            <div class="col">
              <h4 class="card-title fw-bold">司機工作申請</h4>
              <span class="text-danger fw-bold">*</span>
              <span class="fw-bold">必需填寫</span>
            </div>
          </div>
        </div>
        <div class="row card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title">申請人資料</h5>
              </div>
            </div>
            <div class="row">
              <div class="col-2">
                姓名
                <span class="text-danger">*</span>
              </div>
              <div class="col-10">
                <div class="input-group mb-3">
                  <span class="input-group-text">姓</span>
                  <input type="text" class="form-control" id="chi-lastname" name="chi-lastname">
                  <span class="input-group-text">名</span>
                  <input type="text" class="form-control" id="chi-firstname" name="chi-firstname">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-2">
                出身日期
                <span class="text-danger">*</span>
              </div>
              <div class="col-md-10">
                <div class="input-group mb-3">
                  <label class="input-group-text" for="birth_year">年</label>
                  <select class="form-select" name="birth_year" id="birth_year">
                  </select>
                  <label class="input-group-text" for="birth_month">月</label>
                  <select class="form-select" name="birth_month" id="birth_month" >
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-2">
                身份證號碼
                <span class="text-danger">*<span>
              </div>
              <div class="col">
                <input type="text" class="form-control" id="hkid" name="hkid">
              </div>
            </div>
            <div class="row">
              <div class="col-2">
                聯絡電話
                <span class="text-danger">*<span>
              </div>
              <div class="col">
                <input type="tel" class="form-control" id="phone-number" name="phone-number" minlength="8" maxlength="8" oninput="value=value.replace(/[^\d]/g,'')">
              </div>
            </div>
            <div class="row">
              <div class="col-2">
                電郵地址
                <span class="text-danger">*<span>
              </div>
              <div class="col">
                <input type="email" class="form-control" id="email" name="email">
              </div>
            </div>
          </div>
        </div>
        <div class="row card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title">車輛資料</h5>
              </div>
            </div>
            <div class="row">
              <div class="col-md-2">
                座位數目
                <span class="text-danger">*</span>
              </div>
              <div class="col-md-10">
                <div class="input-group">
                  <input type="number" name="seats" id="seats" class="form-control">
                  <span class="input-group-text">位</span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-2">
                車牌號碼
                <span class="text-danger">*</span>
              </div>
              <div class="col-md-10">
                <input type="text" name="license-plate-number" id="license-plate-number" class="form-control">
              </div>
            </div>
            <div class="row">
              <div class="col-md-2">
                車輛外部
                <span class="text-danger">*</span>
              </div>
              <div class="col-md-10">
                <input type="file" name="vehicle-exterior" id="vehicle-exterior" class="form-control">
              </div>
            </div>
            <div class="row">
              <div class="col-md-2">
                車輛內部
                <span class="text-danger">*</span>
              </div>
              <div class="col-md-10">
                <input type="file" name="vehicle-inside" id="vehicle-inside" class="form-control">
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col text-end">
            <button type="button" class="btn btn-primary" onclick="submitDriverApplication();">提交</button>
          </div>
        </div>
      </div>
    </div> <!-- Container -->
  </form>

  <!-- Footer -->
  <?php include_once('/xampp/htdocs/travelHK.com/zh-hk/common/footer.php'); ?>

</body>

<script>
  let year_start = 1901;
  let year_end = (new Date).getFullYear(); // current year
  let year_selected = 0;

  let option = '';

  for (let i = year_start; i <= year_end; i++) {
    let selected = (i === year_selected ? ' selected' : '');
    option += '<option value="' + i + '"' + selected + '>' + i + '</option>';
  }

  document.getElementById("birth_year").innerHTML = option;
</script>

</html>