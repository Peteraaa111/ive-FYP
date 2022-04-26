<?php
session_start();
include_once('/xampp/htdocs/travelHK.com/dbConnect.php');

if (!isset($_SESSION['user_email'])) {
  header("Location: /");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>會員中心 - 香港本地旅遊平台 | 本地遊</title>

  <!-- Link the default css and js library -->
  <?php include_once('/xampp/htdocs/travelHK.com/library.php'); ?>

  <!-- User Profile CSS -->
  <link rel="stylesheet" href="/css/user_profile.css">

  <!-- Update User Info JS -->
  <script src="/js/updateUserInfo.js"></script>
</head>

<body>

  <!-- Header -->
  <?php include_once('../common/header.php'); ?>

  <?php
  global $conn;

  // Get the account information from database
  $query = "SELECT * FROM account WHERE `email` = '{$_SESSION['user_email']}';";
  $rs = mysqli_query($conn, $query);
  $rd = mysqli_fetch_assoc($rs);
  ?>

  <!-- Main Content -->
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <!-- User profile -->
        <div id="user-profile" class="card">
          <?php
          $id = $_SESSION['user_id'];
          $user_iconPath = "/data/account/general/$id/icon.png";
          echo '<img id="user-profile-icon" src="'.$user_iconPath.'" class="card-img-top rounded-circle" alt="User Icon">';
          ?>
          <div class="card-body">
            <h5 class="card-title">
              <?php echo $rd['nickname']; ?>
            </h5>
            <p class="card-text">
              會員ID : <?php echo $rd['account_id']; ?>
            </p>
          </div>
        </div>
        <!-- User menu -->
        <div id="user-menu" class="card">
          <div class="card-body">
            <h5 class="card-title">
              選單
            </h5>
          </div>
          <div class="list-group">
            <a href="user.php" class="list-group-item list-group-item-action active" aria-current="true">帳號設定</a>
            <a href="booking.php" class="list-group-item list-group-item-action" aria-current="true">預約記錄</a>
            <a href="itineray_booking.php" class="list-group-item list-group-item-action" aria-current="true">行程記錄</a>
            <a href="tourgroup_list.php" class="list-group-item list-group-item-action" aria-current="true">旅行團記錄</a>
          </div>
        </div>
      </div>
      <div class="col-md-9">
        <div id="user-profile-info" class="card">
          <div id="user-profile-info-body" class="card-body">
            <h3 class="card-title">
              帳號設定
            </h3>
            <div class="card-text">
              <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                  <button class="nav-link active" id="nav-info-tab" data-bs-toggle="tab" data-bs-target="#nav-info" type="button" role="tab" aria-controls="nav-info" aria-selected="true">
                    基本資料
                  </button>
                  <button class="nav-link" id="nav-security-tab" data-bs-toggle="tab" data-bs-target="#nav-security" type="button" role="tab" aria-controls="nav-security" aria-selected="false">
                    帳戶安全
                  </button>
                </div>
              </nav>
              <div class="tab-content" id="nav-tabContent">
                <!-- Basic Information Tab -->
                <div class="tab-pane fade show active" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab">
                  <div class="container">
                    <form id="update-info">
                      <h3 class="sub-title">
                        修改帳號資料
                      </h3>
                      <div class="row">
                        <label for="_email" hidden>電郵</label>
                        <input id="_email" name="_email" class="form-control" type="text" value="<?php echo $rd['email']; ?>" hidden>
                        <div class="col">
                          <label for="_firstname">姓氏</label>
                          <input id="_firstname" name="_firstname" class="form-control" type="text" value="<?php echo $rd['firstname']; ?>">
                        </div>
                        <div class="col">
                          <label for="_lastname">名稱</label>
                          <input id="_lastname" name="_lastname" class="form-control" type="text" value="<?php echo $rd['lastname']; ?>">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col">
                          <label for="_nickname">暱稱</label>
                          <span class="text-danger">*</span>
                          <input id="_nickname" name="_nickname" class="form-control" type="text" value="<?php echo $rd['nickname']; ?>">
                        </div>
                        <div class="col">
                          <label for="_gender">性別</label>
                          <span class="text-danger">*</span>
                          <select id="_gender" name="_gender" class="form-select">
                            <option value="m" <?php
                                              if ($rd['gender'] == 'm')
                                                echo 'selected="selected"';
                                              ?>>男</option>
                            <option value="f" <?php
                                              if ($rd['gender'] == 'f')
                                                echo 'selected="selected"';
                                              ?>>女</option>
                          </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col">
                          <label for="_phoneNumber">電話號碼</label>
                          <input id="_phoneNumber" name="_phoneNumber" class="form-control" type="text" value="<?php echo $rd['phone_number']; ?>">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col">
                          <label for="_birthYear">出生年份</label>
                          <span class="text-danger">*</span>
                          <select id="_birthYear" name="_birthYear" class="form-select"></select>
                        </div>
                        <div class="col">
                          <?php
                          function checkBirthMonth($month)
                          {
                            global $rd;
                            if ($month == $rd['birth_month'])
                              echo 'selected="selected"';
                          }
                          ?>
                          <label for="_birthMonth">出生月份</label>
                          <span class="text-danger">*</span>
                          <select id="_birthMonth" name="_birthMonth" class="form-select">
                            <option value="1" <?php checkBirthMonth(1) ?>>1</option>
                            <option value="2" <?php checkBirthMonth(2) ?>>2</option>
                            <option value="3" <?php checkBirthMonth(3) ?>>3</option>
                            <option value="4" <?php checkBirthMonth(4) ?>>4</option>
                            <option value="5" <?php checkBirthMonth(5) ?>>5</option>
                            <option value="6" <?php checkBirthMonth(6) ?>>6</option>
                            <option value="7" <?php checkBirthMonth(7) ?>>7</option>
                            <option value="8" <?php checkBirthMonth(8) ?>>8</option>
                            <option value="9" <?php checkBirthMonth(9) ?>>9</option>
                            <option value="10" <?php checkBirthMonth(10) ?>>10</option>
                            <option value="11" <?php checkBirthMonth(11) ?>>11</option>
                            <option value="12" <?php checkBirthMonth(12) ?>>12</option>
                          </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col text-end">
                          <button type="button" id="save_info" class="btn btn-primary" onclick="updateUserInfo();">
                            儲存
                          </button>
                        </div>
                      </div>
                    </form>
                  </div> <!-- End container -->
                </div> <!-- End Information Tab -->
                <!-- Account Security Tab -->
                <div class="tab-pane fade" id="nav-security" role="tabpanel" aria-labelledby="nav-security-tab">
                  <div class="container">
                    <form id="update-psw">
                      <label for="__email" hidden>電郵</label>
                      <input id="__email" name="__email" class="form-control" type="text" value="<?php echo $rd['email']; ?>" hidden>
                      <div class="sub-title">
                        更改密碼
                      </div>
                      <div class="row">
                        <div class="col">
                          <div class="form-floating">
                            <input type="password" name="_oldPassword" id="_oldPassword" class="form-control" placeholder="********">
                            <label for="_oldPassword">
                              舊密碼
                              <span class="text-danger">*</span>
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col">
                          <div class="form-floating">
                            <input type="password" name="_newPassword" id="_newPassword" class="form-control" placeholder="********">
                            <label for="_newPassword">
                              新密碼
                              <span class="text-danger">*</span>
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col">
                          <div class="form-floating">
                            <input type="password" name="_confNewPassword" id="_confNewPassword" class="form-control" placeholder="********">
                            <label for="_confNewPassword">
                              確認新密碼
                              <span class="text-danger">*</span>
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col text-end">
                          <button type="button" id="save_password" class="btn btn-primary" onclick="updatePassword();">
                            儲存
                          </button>
                        </div>
                      </div>
                    </form>
                  </div> <!-- End container -->
                </div> <!-- End Security Tab -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php include_once('../common/footer.php'); ?>

  <!-- Script for Account Profile's Birth Year Selector -->
  <script>
    (function() {
      let year_start = 1901;
      let year_end = (new Date).getFullYear(); // current year
      let year_selected = <?php echo $rd['birth_year']; ?>;

      let option = '';

      for (let i = year_start; i <= year_end; i++) {
        let selected = (i === year_selected ? ' selected' : '');
        option += '<option value="' + i + '"' + selected + '>' + i + '</option>';
      }

      document.getElementById("_birthYear").innerHTML = option;
    })();
  </script>

</body>

</html>