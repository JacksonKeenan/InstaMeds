<?php
  session_start();

  if (!isset($_SESSION['adminId'])) {
    header("Location: login.php");
    exit();
  }
?>
<head>
  <link rel="stylesheet" href="css/header.css?version=3">
</head>

<nav class="navbar navbar-expand-md navbar-dark fixed-top">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarResponsive">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="members.php">Members</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="orders.php">Orders</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="drivers.php">Drivers</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="regions.php">Regions</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="products.php?section=flowers">Products</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="deliveryFee.php">Delivery Fee</a>
      </li>
      <li class="nav-item">
        <form class="logout-form" action="includes/logout.inc.php" method="post">
          <button class="nav-link" type="submit" name="logout-submit">
            Sign Out
            <i class="fas fa-sign-out-alt"></i>
          </button>
        </form>
      </li>
    </ul>
  </div>
</nav>
