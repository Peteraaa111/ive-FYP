<!-- Register Validation JS -->
<script src="/js/general_register.js"></script>

<!-- Login Validation JS -->
<script src="/js/general_login.js"></script>

<!-- Navbar CSS -->
<link rel="stylesheet" href="/css/navbar.css">

<!-- Register CSS -->
<link rel="stylesheet" href="/css/register.css">

<?php
// Check the language cookie is exist
if (!isset($_COOKIE['lang'])) {
  // Get the browser language
  // $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

  // Set the chinese language array
  // $acceptLang = ['zh', 'zh-hk', 'zh-tw', 'zh-cn'];

  // Determine language
  // $lang = in_array($lang, $acceptLang) ? 'zh-hk' : 'en' ;
  $lang = 'zh-hk';

  // Set the cookie
  setcookie("lang", $lang, time() + 31556926);
}
?>

<!-- Top Header -->
<nav id="top" class="navbar navbar-expand-lg navbar-light">
  <div class="container">
    <a class="navbar-brand" href="/">
      <img id="web_logo" src="/assets/img/web_logo/banner.png" alt="TravelHK Logo">
      <!-- TravelHK -->
    </a>
    <div class="d-flex">
      <?php
      // Check if the user is logged in
      if (isset($_SESSION['user_email'])) {
        $user_email = $_SESSION['user_email'];
        $user_nickname = $_SESSION['user_nickname'];
        $id = $_SESSION['user_id'];
        $user_iconPath = "/data/account/general/$id/icon.png";
        echo '
        <div id="user_dropdown" class="dropdown">
          <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle">
            <img id="user_icon" src="'.$user_iconPath.'" alt="" width="32" height="32" class="rounded-circle me-2">
            <strong>' . $user_nickname . '</strong>
          </a>
          <ul class="dropdown-menu text-small shadow">
            <li><a class="dropdown-item" href="/' . $_COOKIE['lang'] . '/membership/user.php">會員中心</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="/function.php?op=logout">登出</a></li>
          </ul>
        </div>
        ';
      } else {
        echo '
        <button id="login-btn" type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#login-modal">
          <i class="fas fa-user"></i>
          登入
        </button>
        <button id="register-btn" type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#register-modal">
          <i class="fas fa-edit"></i>
          註冊
        </button>
        ';
      }
      ?>
    </div>
  </div>
</nav>

<!-- Login Modal -->
<div class="modal fade" id="login-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">登入</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- Login Form -->
      <form id="login-form" novalidate>
        <div class="modal-body">
          <div class="or-td-wrap clearfix">
            <div class="td1"></div>
            <div class="td2">登入資料</div>
            <div class="td1"></div>
          </div>
          <!-- Email Address -->
          <div class="form-floating mb-3">
            <input type="email" name="l_email" id="l_email" class="form-control" placeholder="name@example.com" require>
            <label for="l_email">
              電郵地址<span class="text-danger">*</span>
            </label>
          </div>
          <!-- Password -->
          <div class="form-floating mb-3">
            <input type="password" name="l_psw" id="l_psw" class="form-control" placeholder="********" require>
            <label for="l_psw">
              密碼<span class="text-danger">*</span>
            </label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
          <button type="button" class="btn btn-primary" onclick="login();">登入</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- End of Login Modal -->

<!-- Register Modal -->
<div class="modal fade" id="register-modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLabel">新用戶註冊</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- Register Form -->
      <form id="register-form" enctype="multipart/form-data" method="POST" novalidate>
        
        <div class="modal-body">

          <div class="or-td-wrap clearfix">
            <span class="td1"></span>
            <span class="td2">登入資料</span>
            <span class="td1"></span>
          </div>

          <!-- Email Address -->
          <div class="mb-3">
            <div class="form-floating mb-2 r_email">
              <input type="email" name="r_email" id="r_email" class="form-control" placeholder="name@example.com" require>
              <label for="r_email">
                電郵地址<span class="text-danger">*</span>
              </label>
            </div>
            <ul class="bullet_list">
              <li>請填寫實際使用之電子信箱地址。</li>
              <li id="email_not_valid" class="error">格式不符合。請確認後重新輸入。</li>
            </ul>
          </div>

          <!-- Password -->
          <div class="mb-3">
            <div class="form-floating mb-3 r_psw">
              <input type="password" name="r_psw" id="r_psw" class="form-control" minlength="8" maxlength="16" placeholder="********" require>
              <label for="r_psw">
                密碼<span class="text-danger">*</span>
              </label>
            </div>
            <div class="form-floating mb-2 r_cpsw">
              <input type="password" name="r_cpsw" id="r_cpsw" class="form-control" minlength="8" maxlength="16" placeholder="********" require>
              <label for="r_cpsw">
                確認密碼<span class="text-danger">*</span>
              </label>
            </div>
            <ul class="bullet_list">
              <li>密碼為8~16位數，須包含英文大小寫、數字。</li>
              <li>區分英文大小寫，特殊符號僅可使用!@#$%^&*()+=~_-</li>
              <li id="not_valid" class="error error_not_valid">不符合密碼規定。請輸入符合規定的密碼。</li>
              <li id="not_equals" class="error error_not_equals">密碼不一致。請確認後重新輸入。</li>
            </ul>
          </div>

          <div class="or-td-wrap clearfix">
            <div class="td1"></div>
            <div class="td2">用戶資料</div>
            <div class="td1"></div>
          </div>

          <!-- Nickname -->
          <div class="mb-3">
            <div class="form-floating mb-2 r_nickname">
              <input type="text" name="r_nickname" id="r_nickname"class="form-control"  placeholder="Nickname" maxlength="20" require>
              <label for="r_nickname">
                暱稱<span class="text-danger">*</span>
              </label>
            </div>
            <ul class="bullet_list">
              <li>暱稱為3~20位。</li>
              <li>暱稱會在討論區、留言、點評中顯示。</li>
            </ul>
          </div>

          <!-- Phone Number -->
          <div class="mb-3">
            <div class="form-floating r_phoneNo">
              <input type="text" name="r_phoneNo" id="r_phoneNo" class="form-control" placeholder="12345678" maxlength="8" oninput="value=value.replace(/[^\d]/g,'')" require>
              <label for="r_phoneNo">
                電話號碼<span class="text-danger">*</span>
              </label>
            </div>
            <ul class="bullet_list">
              <li>請填寫8位數字電話號碼。</li>
            </ul>
          </div>

          <!-- Gender -->
          <div class="mb-2">
            <select name="r_gender" id="r_gender" class="form-select" required="required">
              <option value="" selected="selected" hidden="hidden">性別</option>
              <option value="m">男</option>
              <option value="f">女</option>
            </select>
          </div>

          <!-- Birth Year and Month -->
          <div class="input-group mb-2">
            <select name="r_birth_year" id="r_birth_year" class="form-select" required="required"></select>
            <select name="r_birth_month" id="r_birth_month" class="form-select" required="required">
              <option value="" selected="selected" hidden="hidden">出生月份</option>
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
          <input type="hidden" name="avatar" id="avatar" value="">

          <!-- <input type="image" name="avatar" id="avatar" class="form-control" src="../../../testing.jpg"> -->
          <!-- style="display:none" -->

        </div> <!-- End of modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
          <button type="button" class="btn btn-primary" onclick="register();">註冊</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- End of Register Modal -->

<!-- Script for Register Form's Birth Year Selector -->
<script>
  (function() {
    let year_start = 1901;
    let year_end = (new Date).getFullYear(); // current year
    let year_selected = 0;

    let option = '';
    option = '<option selected="selected" hidden="hidden">出生年份</option>'; // first option

    for (let i = year_start; i <= year_end; i++) {
      let selected = (i === year_selected ? ' selected' : '');
      option += '<option value="' + i + '"' + selected + '>' + i + '</option>';
    }

    document.getElementById("r_birth_year").innerHTML = option;
  })();
</script>