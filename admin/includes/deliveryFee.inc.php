<?php

if (isset($_POST['update-fee'])) {
  require 'dbh.inc.php';

  $fee = $_POST['fee'];


  if (empty($fee)) {
    header("Location: ../deliveryFee.php?error=emptyfields");
    exit();
  }
  else {
    $sql = "UPDATE delivery_fee SET fee=? WHERE delivery_fee.id = 1;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../deliveryFee.php?error=sqlerror");
      exit();
    }
    else {
      mysqli_stmt_bind_param($stmt, "d", $fee);
      mysqli_stmt_execute($stmt);

      header("Location: ../deliveryFee.php?signup=success");
      exit();
    }
  }

  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
else {
  header("Location: ../deliveryFee.php");
  exit();
}
