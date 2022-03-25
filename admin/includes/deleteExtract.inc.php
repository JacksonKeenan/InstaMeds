<?php
session_start();

if (isset($_POST['delete-extract'])) {
  require 'dbh.inc.php';

  $extractId = $_POST['extract-id'];

  $sql = "DELETE FROM `extracts` WHERE `id` =".$extractId.";";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../products.php?section=extracts&error=sqlerror");
    exit();
  }
  else {
    mysqli_stmt_execute($stmt);
    header("Location: ../products.php?section=extracts&remove=success");
    exit();
  }

  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
