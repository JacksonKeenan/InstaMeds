<?php
session_start();

if (isset($_POST['information-submit'])) {
  require 'dbh.inc.php';

  $fname = $_POST['first_name'];
  $lname = $_POST['last_name'];
  $area = $_POST['area'];
  $address = $_POST['address'];
  $phone = $_POST['phone'];

  if (empty($fname) || empty($lname) || empty($area) || empty($address) || empty($phone)) {
    header("Location: ../information.php?error=emptyfields");
    exit();
  }
  else {
    $sql = "UPDATE users SET first_name=?, last_name=?, usr_phone=?, usr_area=?, usr_address=? WHERE users.id = ".$_SESSION['userId'].";";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../information.php?error=sqlerror");
      exit();
    }
    else {
      mysqli_stmt_bind_param($stmt, "sssss", $fname, $lname, $phone, $area, $address);
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
