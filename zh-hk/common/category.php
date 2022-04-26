<!-- Navbar CSS -->
<link rel="stylesheet" href="/css/navbar.css">

<!-- Category Menu -->
<nav id="category" class="navbar navbar-expand-lg navbar-light">
  <div class="container">
    <div>
      <!-- Empty div -->
    </div>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav_category" aria-controls="nav_category" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div id="nav_category" class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo "/".$_COOKIE["lang"]."/category/attraction.php" ?>">
            瀏覽景點
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo "/".$_COOKIE["lang"]."/category/restaurant.php" ?>">
            美食
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo "/".$_COOKIE["lang"]."/category/guesthouse.php" ?>">
            住宿
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo "/".$_COOKIE["lang"]."/tour_group" ?>">
            旅行團
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo "/".$_COOKIE["lang"]."/planner" ?>">
            計劃行程
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>