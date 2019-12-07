<?php
session_start();

if (isset($_POST['account-submit'])) {
  require 'dbh.inc.php';

  $email = $_POST['email'];
  $area = $_POST['area'];
  $address = $_POST['address'];
  $phone = $_POST['phone'];

  if (empty($email) || empty($area) || empty($address) || empty($phone)) {
    header("Location: ../account.php?error=emptyfields");
    exit();
  }
  else {
    $sql = "UPDATE users SET usr_phone=?, usr_email=?, usr_area=?, usr_address=? WHERE users.id = ".$_SESSION['userId'].";";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../account.php?error=sqlerror");
      exit();
    }
    else {
      mysqli_stmt_bind_param($stmt, "ssss", $phone, $email, $area, $address);
      mysqli_stmt_execute($stmt);
      $_SESSION['userArea'] = $area;
      header("Location: ../account.php?edit=success");
      exit();
    }
  }
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
