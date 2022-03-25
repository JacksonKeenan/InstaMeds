<?php
session_start();

if (isset($_POST['delivery-confirmation'])) {
  require 'dbh.inc.php';

  $orderId = $_POST['order-id'];

  if (empty($orderId)) {
    header("Location: ../orders.php?error=emptyfields");
    exit();
  }
  else {
    $sql = "UPDATE `orders` SET `status` = 'Completed' WHERE `orders`.`order_id` ='".$orderId."';";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../orders.php?error=sqlerror");
      exit();
    }
    else {
      mysqli_stmt_execute($stmt);
      header("Location: ../orders.php?confirmation=success");
      exit();
    }
  }
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
