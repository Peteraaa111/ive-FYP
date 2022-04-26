<?php
// Session Start
session_start();

// Get database connection variable
include_once('/xampp/htdocs/travelHK.com/dbConnect.php');
global $conn;

// Get the account id
$account_id = $_GET['id'];

// Get the account details
$sql = "SELECT *, ty.`zh-hk` AS `account_type`
          FROM `account` ac
          INNER JOIN `account_type` ty ON ac.`type_id` = ty.`type_id`
          WHERE `account_id` = $account_id;";
$rs = mysqli_query($conn, $sql);
$rc = mysqli_fetch_assoc($rs);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>民宿合作夥伴帳號 (ID:<?php echo $account_id; ?>) - 管理頁面</title>

  <?php
  require_once('/xampp/htdocs/travelHK.com/library.php');
  ?>
  <link rel="stylesheet" href="/css/admin_form.css">
  <script src="/js/admin.js"></script>

  <!-- Datatable -->
  <link rel="stylesheet" type="text/css" href="/lib/datatables/datatables.css" />
  <script type="text/javascript" src="/lib/datatables/datatables.min.js"></script>
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
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-8">
                      <h3 class="card-title text-secondary">
                        民宿合作夥伴帳號資料 <?php echo '(ID:'.$rc['account_id'].')'; ?>
                      </h3>
                    </div>
                    <div class="col-md-4 text-end">
                      <?php
                      switch ($rc['status']) {
                        case 0:
                          echo "<span class='badge bg-warning text-dark fs-5'>已凍結</span>";
                          break;
                        case 1:
                          echo "<span class='badge bg-primary fs-5'>正常</span>";
                          break;
                        case 2:
                          echo "<span class='badge bg-danger fs-5'>已刪除</span>";
                          break;
                      }
                      ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Account details -->
          <div class="row">
            <div class="col-md-10 offset-1">
              <div class="card">
                <div class="card-body">
                  <!-- Title -->
                  <div class="row">
                    <div class="col-md-12">
                      <h3 class="card-title text-secondary">帳號資料</h3>
                    </div>
                  </div>
                  <!-- Account details form -->
                  <form id="account-details">
                    <!-- Account ID -->
                    <div class="row">
                      <div class="col-md-2">
                        ID
                      </div>
                      <div class="col-md-10">
                        <input type="text" name="id" id="id" class="form-control" value="<?php echo $rc['account_id']; ?>" disabled="true">
                      </div>
                    </div>
                    <!-- Email -->
                    <div class="row">
                      <div class="col-md-2">
                        電郵
                      </div>
                      <div class="col-md-10">
                        <input type="email" class="form-control" name="email" id="email" value="<?php echo $rc['email']; ?>" readonly>
                      </div>
                    </div>
                    <!-- Full name -->
                    <div class="row">
                      <div class="col-md-2">
                        姓名
                      </div>
                      <div class="col-md-10">
                        <div class="input-group">
                          <span class="input-group-text">名</span>
                          <input type="text" class="form-control" name="firstname" id="firstname" value="<?php echo $rc['firstname']; ?>" readonly>
                          <span class="input-group-text">姓</span>
                          <input type="text" class="form-control" name="lastname" id="lastname" value="<?php echo $rc['lastname']; ?>" readonly>
                        </div>
                      </div>
                    </div>
                    <!-- Gender -->
                    <div class="row">
                      <div class="col-md-2">
                        性別
                      </div>
                      <div class="col-md-10">
                        <select name="gender" id="gender" class="form-select" disabled>
                          <option value="m" <?php echo ($rc['gender'] == 'm' ? 'selected="selected"' : '123'); ?>>男</option>
                          <option value="f" <?php echo ($rc['gender'] == 'f' ? 'selected="selected"' : '123'); ?>>女</option>
                        </select>
                      </div>
                    </div>
                    <!-- Phone number -->
                    <div class="row">
                      <div class="col-md-2">
                        電話號碼
                      </div>
                      <div class="col-md-10">
                        <input type="tel" name="phone_number" id="phone_number" class="form-control" value="<?php echo $rc['phone_number']; ?>" minlength="8" maxlength="8" oninput="value=value.replace(/[^\d]/g,'')" readonly>
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
                            <option value="1" <?php echo ($rc['birth_month'] == 1 ? 'selected="selected"' : '');  ?>>1</option>
                            <option value="2" <?php echo ($rc['birth_month'] == 2 ? 'selected="selected"' : '');  ?>>2</option>
                            <option value="3" <?php echo ($rc['birth_month'] == 3 ? 'selected="selected"' : '');  ?>>3</option>
                            <option value="4" <?php echo ($rc['birth_month'] == 4 ? 'selected="selected"' : '');  ?>>4</option>
                            <option value="5" <?php echo ($rc['birth_month'] == 5 ? 'selected="selected"' : '');  ?>>5</option>
                            <option value="6" <?php echo ($rc['birth_month'] == 6 ? 'selected="selected"' : '');  ?>>6</option>
                            <option value="7" <?php echo ($rc['birth_month'] == 7 ? 'selected="selected"' : '');  ?>>7</option>
                            <option value="8" <?php echo ($rc['birth_month'] == 8 ? 'selected="selected"' : '');  ?>>8</option>
                            <option value="9" <?php echo ($rc['birth_month'] == 9 ? 'selected="selected"' : '');  ?>>9</option>
                            <option value="10" <?php echo ($rc['birth_month'] == 10 ? 'selected="selected"' : '');  ?>>10</option>
                            <option value="11" <?php echo ($rc['birth_month'] == 11 ? 'selected="selected"' : '');  ?>>11</option>
                            <option value="12" <?php echo ($rc['birth_month'] == 12 ? 'selected="selected"' : '');  ?>>12</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <!-- Icon -->
                    <!-- <div class="row">
                      <div class="col-md-2">
                        頭像
                      </div>
                      <div class="col-md-10">
                        <img src="<?php //echo '/data/account/general/'.$rc['account_id'].'/icon.png'; ?>" alt="icon" width="200" height="200">
                      </div>
                    </div> -->
                    <!-- Account type -->
                    <div class="row">
                      <div class="col-md-2">
                        帳號類型
                      </div>
                      <div class="col-md-10">
                        <input type="text" class="form-control" value="<?php echo $rc['account_type']; ?>" disabled>
                      </div>
                    </div>
                    <!-- Control panel -->
                    <div class="row">
                      <div class="col-md-12 text-end">
                        <button type="button" class="btn btn-warning" id="edit-btn">編輯</button>
                        <button type="button" class="btn btn-primary" id="update-btn" onclick="adminUpdateDriverAccountDetails()" style="display: none;">更新</button>
                        <button type="button" class="btn btn-danger" id="cancel-btn" style="display: none;">取消</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- Account status control -->
          <div class="row">
            <div class="col-md-10 offset-1">
              <div class="card">
                <div class="card-body">
                  <!-- Title -->
                  <div class="row">
                    <div class="col-md-12">
                      <h3 class="card-title text-secondary">帳號狀態</h3>
                    </div>
                  </div>
                  <!-- Account status form -->
                  <form id="account-status">
                    <!-- Account id (Hidden) -->
                    <input type="text" name="id" value="<?php echo $rc['account_id']; ?>" style="display: none;">
                    <!-- Status setting -->
                    <div class="row">
                      <div class="col-md-2">
                        狀態設定
                      </div>
                      <div class="col-md-10">
                        <?php
                        $sql = "SELECT * FROM `account_status`;";
                        $rs = mysqli_query($conn, $sql);
                        while ($status = mysqli_fetch_assoc($rs)) {
                          echo '
                          <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="status" id="' . $status['status_id'] . '" value="' . $status['status_id'] . '"'. ($rc['status'] == $status['status_id'] ? 'checked="checked"' : '') .'>
                            <label class="form-check-label" for="' . $status['status_id'] . '">
                              ' . $status['zh-hk'] . '
                            </label>
                          </div>
                          ';
                        }
                        ?>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 text-end">
                        <button type="button" class="btn btn-primary" onclick="adminChangeAccountStatus()">變更</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- Restaurant list -->
          <div class="row">
            <div class="col-md-10 offset-1">
              <div class="card">
                <div class="card-body">
                  <!-- Title -->
                  <div class="row">
                    <div class="col-md-12">
                      <h3 class="card-title text-secondary">持有的民宿列表</h3>
                    </div>
                  </div>
                  <!-- Table -->
                  <div class="row">
                    <div class="col-md-12">
                      <table id="guesthouseList" class="table table-hover">
                        <thead>
                          <th>ID</th>
                          <th>中文名稱</th>
                          <th>英文名稱</th>
                          <th>地區</th>
                          <th>創建日期</th>
                          <th>狀態</th>
                        </thead>
                        <tbody>
                          <?php
                          // Get the booking record
                          $sql = "SELECT
                                    `guesthouse`.`guesthouse_id` AS `id`,
                                    `guesthouse`.`guesthouse_chinese_name` AS `chi_name`,
                                    `guesthouse`.`guesthouse_english_name` AS `eng_name`,
                                    `district`.`zh-hk` AS `district`,
                                    `guesthouse`.`create_datetime` AS `create_date`,
                                    `status`.`zh-hk` AS `status`
                                  FROM `guesthouse` `guesthouse`
                                  INNER JOIN `hong_kong_district` `district` ON `guesthouse`.`district` = `district`.`district_id`
                                  INNER JOIN `guesthouse_status` `status` ON `guesthouse`.`status` = `status`.`status_id`
                                  WHERE `guesthouse`.`partner_id` = {$rc['account_id']}
                                  ORDER BY `create_date` ASC;";
                          $rs = mysqli_query($conn, $sql);
                          while ($guesthouse = mysqli_fetch_assoc($rs)) {
                            echo '<tr onclick="window.location.assign(\'/admin/site/guesthouse/details.php?id='.$guesthouse['id'].'\')">';
                            echo "<td>".$guesthouse['id']."</td>";
                            echo "<td>".$guesthouse['chi_name']."</td>";
                            echo "<td>".$guesthouse['eng_name']."</td>";
                            echo "<td>".$guesthouse['district']."</td>";
                            echo "<td>".$guesthouse['create_date']."</td>";
                            echo "<td>".$guesthouse['status']."</td>";
                            echo "</tr>";
                          }
                          ?>
                        </tbody>
                        <tfoot>
                          <th>ID</th>
                          <th>中文名稱</th>
                          <th>英文名稱</th>
                          <th>地區</th>
                          <th>創建日期</th>
                          <th>狀態</th>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>
    <!-- End of Content Wrapper -->

  </div>

  <!-- Script for Birth Year Selector -->
  <script>
    $(document).ready(function () {
      $('#guesthouseList').DataTable();
      $('#tourGroupRecord').DataTable();
    });

    let year_start = 1901;
    let year_end = (new Date).getFullYear(); // current year
    let year_selected = <?php echo $rc['birth_year']; ?>;

    let option = '';

    for (let i = year_start; i <= year_end; i++) {
      let selected = (i === year_selected ? ' selected' : '');
      option += '<option value="' + i + '"' + selected + '>' + i + '</option>';
    }

    document.getElementById("birth_year").innerHTML = option;
  </script>

</body>

</html>

<?php
// Close the database connection
mysqli_close($conn);
?>