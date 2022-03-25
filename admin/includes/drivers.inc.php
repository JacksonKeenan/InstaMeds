<?php

if (isset($_POST['add-driver'])) {
  require 'dbh.inc.php';

  $name = $_POST['name'];
  $phone = $_POST['phone'];
  $area = $_POST['area'];


  if (empty($name) || empty($phone) || empty($area)) {
    header("Location: ../drivers.php?error=emptyfields");
    exit();
  }
  else {
    $sql = "INSERT INTO drivers (name, cell_num, driver_area) VALUES (?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../drivers.php?error=sqlerror");
      exit();
    }
    else {
      mysqli_stmt_bind_param($stmt, "sss", $name, $phone, $area);
      mysqli_stmt_execute($stmt);

      header("Location: ../drivers.php?signup=success");
      exit();
    }
  }

  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
else {
  header("Location: ../drivers.php");
  exit();
}
