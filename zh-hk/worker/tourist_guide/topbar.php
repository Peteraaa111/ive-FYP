<nav class="navbar navbar-expand bg-light topbar mb-4 static-top shadow">

  <!-- Topbar Navbar -->
  <ul class="navbar-nav ms-auto">

    <!-- Nav Item - User Information -->
    <li class="nav-item dropdown no-arrow">
      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="mr-2 d-none d-lg-inline text-gray-600 small">
          <?php
          echo $_SESSION['guide_firstname'] . " " . $_SESSION['guide_lastname'];
          ?>
        </span>
        <img class="img-profile rounded-circle" src="
          <?php
          // if (!isset($_SESSION['guide_iconPath'])) {
            echo "/assets/img/account/default_icon.png";
          // } else {
          //   echo "/data/user/restaurant/" . $_SESSION['guide_id'] . "/" . $_SESSION['guide_iconPath'];
          // }
          ?>
        ">
      </a>

      <!-- Dropdown - User Information -->
      <div class="dropdown-menu shadow" aria-labelledby="userDropdown">
        <a class="dropdown-item" href="#">
          <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
          個人檔案
        </a>
        <a class="dropdown-item" href="#">
          <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
          設定
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="/function.php?op=logout" data-toggle="modal" data-target="#logoutModal">
          <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
          登出
        </a>
      </div>
    </li>

  </ul>

</nav>