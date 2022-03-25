<?php
session_start();

if (isset($_POST['delete-driver'])) {
  require 'dbh.inc.php';

  $driverId = $_POST['driver-id'];

  $sql = "DELETE FROM `drivers` WHERE `id` =".$driverId.";";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../drivers.php?error=sqlerror");
    exit();
  }
  else {
    mysqli_stmt_execute($stmt);
    header("Location: ../drivers.php?signup=success");
    exit();
  }

  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
