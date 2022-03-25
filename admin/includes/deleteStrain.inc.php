<?php
session_start();

if (isset($_POST['delete-strain'])) {
  require 'dbh.inc.php';

  $strainId = $_POST['strain-id'];

  $sql = "DELETE FROM `strains` WHERE `id` =".$strainId.";";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../products.php?section=flowers&error=sqlerror");
    exit();
  }
  else {
    mysqli_stmt_execute($stmt);
    header("Location: ../products.php?section=flowers&remove=success");
    exit();
  }

  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
