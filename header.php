<?php
  session_start();

  if (!isset($_SESSION['userId'])) {
    header("Location: ../login.php");
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
        <a class="nav-link" href="/">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/#about">About</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/store.php?section=flowers">Store</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/#faq">FAQ</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/#contact">Contact</a>
      </li>
      <li class="nav-item">
        <p class="nav-link">∙</p>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/account.php">
          Account
          <i class="far fa-user-circle"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/checkout.php">
          Checkout
          <i class="fas fa-shopping-cart"></i>
        </a>
      </li>
      <li class="nav-item">
        <form class="logout-form" action="includes/logout.inc.php" method="post">
          <button class="nav-link" type="submit" name="logout-submit">
            Sign Out
            <i class="fas fa-sign-out-alt"></i>
          </button>
        </form>
      </li>
  </div>
</nav>
