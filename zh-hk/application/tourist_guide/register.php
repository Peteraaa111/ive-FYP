<?php
session_start();

// Get database connection variable
include_once('/xampp/htdocs/travelHK.com/dbConnect.php');
global $conn;

// Get the application id
$id = $_GET['id'];

// Get the request details
$details_sql = "SELECT * FROM `tourist_guide_application` WHERE `id` = $id;";
$details_rs = mysqli_query($conn, $details_sql);
$details = mysqli_fetch_assoc($details_rs);

// Get the status
$status_sql = "SELECT * FROM `worker_application_status` WHERE `status_ID` = ".$details['status'].";";
$status_rs = mysqli_query($conn, $status_sql);
$status = mysqli_fetch_assoc($status_rs);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>導遊帳戶註冊 - 香港本地旅遊平台 | 本地遊</title>

  <!-- Link the default css and js library -->
  <?php include_once('/xampp/htdocs/travelHK.com/library.php'); ?>

  <script src="/js/application/tourist_guide/register.js"></script>
  <link rel="stylesheet" href="/css/collab_register.css">
</head>

<body>

  <!-- Header -->
  <?php include_once('/xampp/htdocs/travelhk.com/zh-hk/common/header.php'); ?>

  <!-- Main Content -->
  <div class="container">
    <!-- Progress Bar -->
    <div class="row">
      <div class="col-md-10 offset-1">
        <div class="progress">
          <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
        </div>
      </div>
    </div>
    <!-- Form -->
    <div class="row">
      <div class="col-md-12">

        <!-- Step 1 - driver request details -->
        <section id="step-1">
          <div class="row">
            <div class="col-md-10 offset-1">
              <!-- Title -->
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-8">
                      <h3 class="text-secondary">導遊工作申請申請 (ID: <?php echo $details['id']; ?>)</h3>
                    </div>
                    <div class="col-md-4 text-end">
                      <?php
                      switch($details['status'])
                      {
                        case 1:
                          echo '<span class="badge bg-primary fs-5">'.$status['zh-hk'].'</span>';
                          break;
                        case 2:
                          echo '<span class="badge bg-info text-dark fs-5">'.$status['zh-hk'].'</span>';
                          break;
                        case 3:
                          echo '<span class="badge bg-success fs-5">'.$status['zh-hk'].'</span>';
                          break;
                        case 4:
                          echo '<span class="badge bg-success fs-5">'.$status['zh-hk'].'</span>';
                          break;
                        case 5:
                          echo '<span class="badge bg-danger fs-5">'.$status['zh-hk'].'</span>';
                          break;
                      }
                      ?>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Applicant Information -->
              <div class="card">
                <div class="card-body">
                  <h3 class="text-secondary">申請人資料</h3>
                  <div class="row">
                    <div class="col-md-2">
                      <label>姓名</label>
                      <span class="text-danger">*</span>
                    </div>
                    <div class="col-md-5">
                      <input class="form-control" type="text" placeholder="名稱" value=<?php echo '"' . $details['chinese_firstname'] . '"'; ?> readonly>
                    </div>
                    <div class="col-md-5">
                      <input class="form-control" type="text" placeholder="姓氏" value=<?php echo '"' . $details['chinese_lastname'] . '"'; ?> readonly>
                    </div>
                  </div>
                  <!-- Birth -->
                  <div class="row">
                    <div class="col-md-2">
                      出身日期
                    </div>
                    <div class="col-md-10">
                      <div class="input-group mb-3">
                        <label class="input-group-text" for="birth_year">年</label>
                        <select class="form-select" id="display_birth_year" disabled>
                        </select>
                        <label class="input-group-text" for="birth_month">月</label>
                        <select class="form-select" disabled>
                          <option value="1" <?php echo ($details['birth_month'] == 1 ? 'selected="selected"' : '');  ?>>1</option>
                          <option value="2" <?php echo ($details['birth_month'] == 2 ? 'selected="selected"' : '');  ?>>2</option>
                          <option value="3" <?php echo ($details['birth_month'] == 3 ? 'selected="selected"' : '');  ?>>3</option>
                          <option value="4" <?php echo ($details['birth_month'] == 4 ? 'selected="selected"' : '');  ?>>4</option>
                          <option value="5" <?php echo ($details['birth_month'] == 5 ? 'selected="selected"' : '');  ?>>5</option>
                          <option value="6" <?php echo ($details['birth_month'] == 6 ? 'selected="selected"' : '');  ?>>6</option>
                          <option value="7" <?php echo ($details['birth_month'] == 7 ? 'selected="selected"' : '');  ?>>7</option>
                          <option value="8" <?php echo ($details['birth_month'] == 8 ? 'selected="selected"' : '');  ?>>8</option>
                          <option value="9" <?php echo ($details['birth_month'] == 9 ? 'selected="selected"' : '');  ?>>9</option>
                          <option value="10" <?php echo ($details['birth_month'] == 10 ? 'selected="selected"' : '');  ?>>10</option>
                          <option value="11" <?php echo ($details['birth_month'] == 11 ? 'selected="selected"' : '');  ?>>11</option>
                          <option value="12" <?php echo ($details['birth_month'] == 12 ? 'selected="selected"' : '');  ?>>12</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-2">
                      <label>身份證號碼</label>
                      <span class="text-danger">*<span>
                    </div>
                    <div class="col-md-10">
                      <input class="form-control" type="text" placeholder="身份證號碼" value="<?php echo $details['hkid']; ?>" readonly>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-2">
                      <label>聯絡電話</label>
                      <span class="text-danger">*<span>
                    </div>
                    <div class="col-md-10">
                      <input class="form-control" type="tel" placeholder="聯絡電話" value="<?php echo $details['phone_number']; ?>" readonly>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-2">
                      <label>電郵地址</label>
                      <span class="text-danger">*<span>
                    </div>
                    <div class="col-md-10">
                      <input class="form-control" type="email" placeholder="電郵" value="<?php echo $details['email']; ?>" readonly>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Document Information -->
              <div class="card">
                <div class="card-body">
                  <h3 class="text-secondary">文件資料</h3>
                  <div class="row">
                    <div class="col-md-2">
                      導遊證編號
                      <span class="text-danger">*</span>
                    </div>
                    <div class="col-md-10">
                      <div class="input-group">
                        <span class="input-group-text">TG</span>
                        <input type="text" name="tgid" id="tgid" class="form-control" value=<?php echo '"' . $details['tgid'] . '"'; ?> readonly>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-2">
                      導遊證
                      <span class="text-danger">*</span>
                    </div>
                    <div class="col-md-10">
                      <a class="btn btn-primary" href="<?php echo "/data/job_application/tourist_guide/" . $details['id'] . "/guide_pass.jpg"; ?>" target="_blank">查看相片</a>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-2">
                      個人自拍照片
                      <span class="text-danger">*</span>
                    </div>
                    <div class="col-md-10">
                      <a class="btn btn-primary" href="<?php echo "/data/job_application/tourist_guide/" . $details['id'] . "/guide_selfie.jpg"; ?>" target="_blank">查看相片</a>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Action Buttons -->
              <div class="card next">
                <div class="card-body text-end">
                  <button id="next-to-register" class="btn btn-primary next-btn">下一步</button>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Step 2 - Register form -->
        <section id="step-2">
          <div class="row">
            <div class="col-md-10 offset-1">
              <!-- Title -->
              <div class="card mb-3">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-8">
                      <h3 class="text-secondary">帳號註冊</h3>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Account Information -->
              <form id="tourist-guide-register">
                <!-- Account Information -->
                <div class="card mb-3">
                  <div class="card-body">
                    <!-- Application ID (Hidden) -->
                    <input type="hidden" name="id" value="<?php echo $details['id']; ?>">
                    <!-- Email Address -->
                    <div class="row">
                      <div class="col-md-2">
                        <label>電郵地址</label>
                        <span class="text-danger">*</span>
                      </div>
                      <div class="col-md-10">
                        <input type="email" class="form-control" name="worker-email" id="worker-email" value="<?php echo $details['email']; ?>">
                      </div>
                    </div>
                    <!-- Password -->
                    <div class="row">
                      <div class="col-md-2">
                        <label>密碼</label>
                        <span class="text-danger">*</span>
                      </div>
                      <div class="col-md-10">
                        <input type="password" class="form-control" name="worker-psw" id="worker-psw">
                      </div>
                    </div>
                    <!-- Confirm Password -->
                    <div class="row">
                      <div class="col-md-2">
                        <label>確認密碼</label>
                        <span class="text-danger">*</span>
                      </div>
                      <div class="col-md-10">
                        <input type="password" class="form-control" name="worker-confPsw" id="worker-confPsw">
                      </div>
                    </div>
                  </div>
                </div>
                <!-- User Information -->
                <div class="card mb-3">
                  <div class="card-body">
                    <!-- Name -->
                    <div class="row">
                      <div class="col-2">
                        姓名
                        <span class="text-danger">*</span>
                      </div>
                      <div class="col-10">
                        <div class="input-group mb-3">
                          <span class="input-group-text">姓</span>
                          <input type="text" class="form-control" id="worker-lastname" name="worker-lastname" value="<?php echo $details['chinese_lastname']; ?>">
                          <span class="input-group-text">名</span>
                          <input type="text" class="form-control" id="worker-firstname" name="worker-firstname" value="<?php echo $details['chinese_firstname']; ?>">
                        </div>
                      </div>
                    </div>
                    <!-- Birth -->
                    <div class="row">
                      <div class="col-md-2">
                        出身日期
                        <span class="text-danger">*</span>
                      </div>
                      <div class="col-md-10">
                        <div class="input-group mb-3">
                          <label class="input-group-text" for="birth_year">年</label>
                          <select class="form-select" name="worker-birth_year" id="worker-birth_year">
                          </select>
                          <label class="input-group-text" for="birth_month">月</label>
                          <select class="form-select" name="worker-birth_month" id="worker-birth_month">
                          <option value="1" <?php echo ($details['birth_month'] == 1 ? 'selected="selected"' : '');  ?>>1</option>
                          <option value="2" <?php echo ($details['birth_month'] == 2 ? 'selected="selected"' : '');  ?>>2</option>
                          <option value="3" <?php echo ($details['birth_month'] == 3 ? 'selected="selected"' : '');  ?>>3</option>
                          <option value="4" <?php echo ($details['birth_month'] == 4 ? 'selected="selected"' : '');  ?>>4</option>
                          <option value="5" <?php echo ($details['birth_month'] == 5 ? 'selected="selected"' : '');  ?>>5</option>
                          <option value="6" <?php echo ($details['birth_month'] == 6 ? 'selected="selected"' : '');  ?>>6</option>
                          <option value="7" <?php echo ($details['birth_month'] == 7 ? 'selected="selected"' : '');  ?>>7</option>
                          <option value="8" <?php echo ($details['birth_month'] == 8 ? 'selected="selected"' : '');  ?>>8</option>
                          <option value="9" <?php echo ($details['birth_month'] == 9 ? 'selected="selected"' : '');  ?>>9</option>
                          <option value="10" <?php echo ($details['birth_month'] == 10 ? 'selected="selected"' : '');  ?>>10</option>
                          <option value="11" <?php echo ($details['birth_month'] == 11 ? 'selected="selected"' : '');  ?>>11</option>
                          <option value="12" <?php echo ($details['birth_month'] == 12 ? 'selected="selected"' : '');  ?>>12</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <!-- Phone Number -->
                    <div class="row">
                      <div class="col-md-2">
                        <label>電話號碼</label>
                        <span class="text-danger">*</span>
                      </div>
                      <div class="col-md-10">
                        <input type="text" class="form-control" name="worker-phoneNo" id="worker-phoneNo" maxlength="8" oninput="value=value.replace(/[^\d]/g,'')" value="<?php echo $details['phone_number']; ?>">
                      </div>
                    </div>
                    <!-- Gender -->
                    <div class="row">
                      <div class="col-md-2">
                        <label>性別</label>
                        <span class="text-danger">*</span>
                      </div>
                      <div class="col-md-10">
                        <select id="worker-gender" name="worker-gender" class="form-select input">
                          <option value="" selected="selected" hidden="hidden">性別</option>
                          <option value="m">男</option>
                          <option value="f">女</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </form>

              <!-- Button -->
              <div class="card next">
                <div class="card-body text-end">
                  <button id="next-to-finish" class="btn btn-primary next-btn">註冊</button>
                </div>
              </div>
              
            </div>
          </div>
        </section>
        
        <!-- Finish -->
        <section id="finish">
          <div class="row">
            <div class="col-md-10 offset-1 text-center">
              <div class="card">
                <div class="card-body">
                  <p>你的帳號創建成功！</p>
                  <p>請到工作頁面登入。</p>
                  <p>
                    <a href="/<?php echo $_COOKIE['lang']; ?>/worker" class="btn btn-primary">前往</a>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Finished -->
        <section id="finished"></section>

      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php include_once('/xampp/htdocs/travelHK.com/zh-hk/common/footer.php'); ?>

  <script>
    let year_start = 1901;
    let year_end = (new Date).getFullYear(); // current year
    let year_selected = <?php echo $details['birth_year']; ?>;

    let option = '';

    for (let i = year_start; i <= year_end; i++) {
      let selected = (i === year_selected ? ' selected' : '');
      option += '<option value="' + i + '"' + selected + '>' + i + '</option>';
    }

    document.getElementById("display_birth_year").innerHTML = option;
    document.getElementById("worker-birth_year").innerHTML = option;
  </script>
</body>

</html>