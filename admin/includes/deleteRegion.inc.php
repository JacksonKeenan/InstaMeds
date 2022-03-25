<?php
session_start();

if (isset($_POST['delete-region'])) {
  require 'dbh.inc.php';

  $regionId = $_POST['region-id'];

  $sql = "DELETE FROM `regions` WHERE `id` =".$regionId.";";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../regions.php?error=sqlerror");
    exit();
  }
  else {
    mysqli_stmt_execute($stmt);
    header("Location: ../regions.php?signup=success");
    exit();
  }

  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
