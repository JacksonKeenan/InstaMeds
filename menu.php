<?php
  session_start();

  if (!isset($_SESSION['userId'])) {
    header("Location: ../login.php");
    exit();
  }
?>
<head>
  <link rel="stylesheet" href="css/menu.css?version=3">
</head>

<div id="menu" class="menu-pad">
  <div class="jumbotron">
    <div class="narrow text-center">
      <div class="col-12">
        <h3 class="heading">Menu</h3>
        <div class="heading-underline"></div>
      </div>
      <div class="row text-center">
        <div class="col-md-4">
          <div class="menu-entry">
            <i class="fas fa-cannabis fa-7x" data-fa-transform="shrink-3 up-5"></i>
            <br>
            <a href="/store.php?section=flowers"><button>Flowers</button></a>
          </div>
        </div>
        <div class="col-md-4">
          <div class="menu-entry">
            <i class="fas fa-cookie-bite fa-7x" data-fa-transform="shrink-3 up-5"></i>
            <br>
            <a href="/store.php?section=edibles"><button>Edibles</button></a>
          </div>
        </div>
        <div class="col-md-4">
          <div class="menu-entry">
            <i class="fas fa-tint fa-7x" data-fa-transform="shrink-3 up-5"></i>
            <br>
            <a href="/store.php?section=extracts"><button>Extracts</button></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
