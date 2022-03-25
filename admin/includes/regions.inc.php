<?php

if (isset($_POST['add-region'])) {
  require 'dbh.inc.php';

  $name = $_POST['name'];

  if (empty($name)) {
    header("Location: ../regions.php?error=emptyfields");
    exit();
  }
  else {
    $sql = "INSERT INTO regions (name) VALUES (?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../regions.php?error=sqlerror");
      exit();
    }
    else {
      mysqli_stmt_bind_param($stmt, "s", $name);
      mysqli_stmt_execute($stmt);

      header("Location: ../regions.php?signup=success");
      exit();
    }
  }

  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
else {
  header("Location: ../regions.php");
  exit();
}
