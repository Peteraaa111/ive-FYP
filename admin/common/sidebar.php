<link rel="stylesheet" href="/css/admin_sidebar.css">

<ul class="navbar-nav bg-secondary bg-gradient sidebar shadow fw-bold">

  <!-- Sidebar - Brand -->
  <a href="/admin/dashboard.php" class="sidebar-brand d-flex align-items-center justify-content-center">
    <div class="sidebar-brand-icon">
      <img src="/assets/img/web_logo/logo_sm.png" alt="Logo">
    </div>
    <div class="sidebar-brand-text ms-3">
      TravelHK
    </div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item active">
    <a href="/admin/dashboard.php" class="nav-link">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>主頁</span>
    </a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">
    景點管理
  </div>

  <!-- Nav Item - Existing Attraction Overview -->
  <li class="nav-item">
    <a class="nav-link" href="/admin/site/attraction/attraction_existing_overview.php">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>現有景點</span></a>
  </li>

  <!-- Nav Item - Attraction Creation -->
  <li class="nav-item">
    <a class="nav-link" href="/admin/site/attraction/attraction_creation.php">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>新增景點</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">
    餐廳管理
  </div>

  <!-- Nav Item - Existing Restaurant Overview -->
  <li class="nav-item">
    <a class="nav-link" href="/admin/site/restaurant/restaurant_existing_overview.php">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>現有餐廳</span></a>
  </li>

  <!-- Nav Item - Restaurant Creation -->
  <li class="nav-item">
    <a class="nav-link" href="/admin/site/restaurant/restaurant_creation.php">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>新增餐廳</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">
    民宿管理
  </div>

  <!-- Nav Item - Guesthouse List -->
  <li class="nav-item">
    <a class="nav-link" href="/admin/site/guesthouse/list.php">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>現有民宿</span></a>
  </li>

  <!-- Nav Item - Guesthouse Creation -->
  <li class="nav-item">
    <a class="nav-link" href="/admin/site/guesthouse/create.php">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>新增民宿</span></a>
  </li>

  <!-- Heading -->
  <div class="sidebar-heading">
    司機 / 導遊管理
  </div>

  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-toggle="collapse" href="#driverWorkerCollapse" role="button" aria-expanded="false" aria-controls="driverWorkerCollapse">
      <i class="fas fa-fw fa-cog"></i>
      <span>司機</span>
    </a>
    <div id="driverWorkerCollapse" class="collapse">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">司機帳戶管理</h6>
        <a class="collapse-item" href="/admin/worker/driver/account_management.php">帳號管理</a>
        <a class="collapse-item" href="/admin/worker/driver/application_management.php">工作申請</a>
      </div>
    </div>
  </li>

  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-toggle="collapse" href="#TouristGuideWorkerCollapse" role="button" aria-expanded="false" aria-controls="TouristGuideWorkerCollapse">
      <i class="fas fa-fw fa-cog"></i>
      <span>導遊</span>
    </a>
    <div id="TouristGuideWorkerCollapse" class="collapse">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">導遊帳戶管理</h6>
        <a class="collapse-item" href="/admin/worker/tourist_guide/account_management.php">帳號管理</a>
        <a class="collapse-item" href="/admin/worker/tourist_guide/application_management.php">工作申請</a>
      </div>
    </div>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">
    合作夥伴管理
  </div>

  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-toggle="collapse" href="#existingCollabCollapse" role="button" aria-expanded="false" aria-controls="existingCollabCollapse">
      <i class="fas fa-fw fa-cog"></i>
      <span>現有合作夥伴</span>
    </a>
    <div id="existingCollabCollapse" class="collapse">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">合作夥伴帳戶管理</h6>
        <a class="collapse-item" href="/admin/collaboration/restaurant/account_management.php">餐廳</a>
        <a class="collapse-item" href="/admin/collaboration/guesthouse/account_management.php">民宿</a>
      </div>
    </div>
  </li>

  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-toggle="collapse" href="#collabRequestCollapse" role="button" aria-expanded="false" aria-controls="collabRequestCollapse">
      <i class="fas fa-fw fa-cog"></i>
      <span>合作夥伴申請</span>
    </a>
    <div id="collabRequestCollapse" class="collapse">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">合作夥伴申請:</h6>
        <a class="collapse-item" href="/admin/collaboration/restaurant/restaurant_collab_request_list.php">餐廳合作夥伴</a>
        <a class="collapse-item" href="/admin/collaboration/guesthouse/list.php">民宿合作夥伴</a>
      </div>
    </div>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">
    新地點資訊管理
  </div>

  <!-- Nav Item - New Attraction Information -->
  <li class="nav-item">
    <a class="nav-link" href="/admin/discovery/attraction/list.php">
    <i class="fas fa-fw fa-chart-area"></i>
    <span>新景點資訊</span></a>
  </li>

  <!-- Nav Item - New Restaurant Information -->
  <li class="nav-item">
    <a class="nav-link" href="/admin/discovery/restaurant/list.php">
    <i class="fas fa-fw fa-chart-area"></i>
    <span>新餐廳資訊</span></a>
  </li>

  <!-- Nav Item - New Guesthouse Information -->
  <li class="nav-item">
    <a class="nav-link" href="/admin/discovery/guesthouse/list.php">
    <i class="fas fa-fw fa-chart-area"></i>
    <span>新民宿資訊</span></a>
  </li>

</ul>