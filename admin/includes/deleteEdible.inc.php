<?php
session_start();

if (isset($_POST['delete-edible'])) {
  require 'dbh.inc.php';

  $edibleId = $_POST['edible-id'];

  $sql = "DELETE FROM `edibles` WHERE `id` =".$edibleId.";";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../products.php?section=edibles&error=sqlerror");
    exit();
  }
  else {
    mysqli_stmt_execute($stmt);
    header("Location: ../products.php?section=edibles&remove=success");
    exit();
  }

  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
