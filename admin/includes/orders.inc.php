<?php
session_start();

if (isset($_POST['order-submit'])) {
  require 'dbh.inc.php';

  $orderId = $_POST['order-id'];
  $driver = $_POST['driver'];

  if (empty($fname) || empty($lname) || empty($area) || empty($address)) {
    header("Location: ../information.php?error=emptyfields");
    exit();
  }
  else {
    $sql = "UPDATE users SET first_name=?, last_name=?, usr_area=?, usr_address=? WHERE users.id = ".$_SESSION['userId'].";";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../information.php?error=sqlerror");
      exit();
    }
    else {
      mysqli_stmt_bind_param($stmt, "ssss", $fname, $lname, $area, $address);
      mysqli_stmt_execute($stmt);
      unset($_SESSION['signUpFlag']);
      header("Location: ../index.php?signup=success");
      $_SESSION['userAddress'] = $address;
      $_SESSION['userArea'] = $area;
      exit();
    }
  }
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
