<?php
// Session Start
session_start();

// Get database connection variable
include_once('/xampp/htdocs/travelHK.com/dbConnect.php');
global $conn;

// Get the application id
$id = $_GET['id'];

// Get the application details
$details_sql = "SELECT * FROM `tourist_guide_application` WHERE `id` = $id;";
$details_rs = mysqli_query($conn, $details_sql);
$details = mysqli_fetch_assoc($details_rs);

// Check the application status, if status is 1, change it to 2
// Then, show the toast message
// Toast message code at the bottom of thin file
if($details['status'] == 1){
  $update_status_sql = "UPDATE `tourist_guide_application`
                          SET `status` = 2
                          WHERE `id` = '".$details['id']."';";
  if(mysqli_query($conn, $update_status_sql)){
    // Reget the application details
    $details_sql = "SELECT * FROM `tourist_guide_application` WHERE `id` = $id;";
    $details_rs = mysqli_query($conn, $details_sql);
    $details = mysqli_fetch_assoc($details_rs);
  }
  echo "
  <script>
    var toast = true;
    var id = ".$details['id']."
  </script>";
} else {
  echo "
  <script>
    var toast = false;
  </script>";
}

// Get the status
$status_sql = "SELECT * FROM `worker_application_status` WHERE `status_id` = ".$details['status'].";";
$status_rs = mysqli_query($conn, $status_sql);
$status = mysqli_fetch_assoc($status_rs);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>導遊工作申請申請 編號: <?php echo $details['id']; ?> - 管理頁面</title>

  <?php
  require_once('/xampp/htdocs/travelHK.com/library.php');
  ?>
  <link rel="stylesheet" href="/css/admin_form.css">
  <script src="/js/admin.js"></script>
  <script>
    $(document).ready(function(){
      // Hidden the button if the status is not under review
      var status = <?php echo $details['status']; ?> ;
      if(!(status == 2)) {
        $('#confirmation').hide();
      }
      if (toast) {
        Swal.fire({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
          },
          icon: 'info',
          title: '導遊工作申請狀態已更新',
          text: '編號: '+id+' 的申請狀態已更新。由 已提交 至 審核中。',
        });
      }
    });
  </script>
</head>

<body>

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php require_once("/xampp/htdocs/travelHK.com/admin/common/sidebar.php"); ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <div id="content">

        <!-- Topbar -->
        <?php require_once("/xampp/htdocs/travelHK.com/admin/common/topbar.php"); ?>
        <!-- End of Topbar -->

        <div class="container-fluid">
          <div class="row">
            <div class="col-md-10 offset-1">
              <!-- Title -->
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-8">
                      <h3 class="text-secondary">導遊工作申請表 (ID: <?php echo $details['id']; ?>)</h3>
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
                        <select class="form-select" name="birth_year" id="birth_year" disabled>
                        </select>
                        <label class="input-group-text" for="birth_month">月</label>
                        <select class="form-select" name="birth_month" id="birth_month" disabled>
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
              <div id="confirmation" class="card">
                <div class="card-body text-end">
                  <button type="button" id="accept-btn" class="btn btn-success" onclick="confirmTouristGuideApplication('<?php echo $details['id']; ?>', 'accept', '<?php echo $details['email']; ?>');">接受</button>
                  <button type="button" id="reject-btn" class="btn btn-danger" onclick="confirmTouristGuideApplication('<?php echo $details['id']; ?>', 'reject', '<?php echo $details['email']; ?>');">拒絕</button>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>
    <!-- End of Content Wrapper -->

  </div>

  <script>
    let year_start = 1901;
    let year_end = (new Date).getFullYear(); // current year
    let year_selected = <?php echo $details['birth_year']; ?>;

    let option = '';

    for (let i = year_start; i <= year_end; i++) {
      let selected = (i === year_selected ? ' selected' : '');
      option += '<option value="' + i + '"' + selected + '>' + i + '</option>';
    }

    document.getElementById("birth_year").innerHTML = option;
  </script>

</body>

</html>