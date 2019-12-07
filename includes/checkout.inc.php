<?php
session_start();
if (isset($_POST['checkout-submit'])) {
  require 'dbh.inc.php';
  $total_price = 0;
  $order_info = '';

  foreach ($_SESSION['shopping_cart'] as &$row){
    $total_price = $total_price + $row['price'];
    $order_info = $order_info . $row['name'] . ' ' . $row['quantity'] . ', ';
  }

  $fee_sql = "SELECT * FROM delivery_fee WHERE id='1';";
  $fee_result = mysqli_query($conn, $fee_sql);
  $fee_row = mysqli_fetch_assoc($fee_result);
  $total_price = $total_price + $fee_row['fee'];
  
  $order_info = rtrim($order_info,', ');

  $sql = "INSERT INTO `orders` (`order_id`, `usr_id`, `order_details`, `order_price`, `order_area`, `order_address`, `status`)
  VALUES (NULL, ".$_SESSION['userId'].", '".$order_info."', ".$total_price.", '".$_SESSION['userArea']."', '".$_SESSION['userAddress']."', 'pending');";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../checkout.php?error=sqlerror");
    exit();
  }
  else {
    $reward_points = $total_price * 1;

    $sql_2 = "SELECT * FROM users WHERE id='".$_SESSION['userId']."';";
    $result_2 = mysqli_query($conn, $sql_2);
    $row = mysqli_fetch_assoc($result_2);
    $reward_points = round($reward_points, 0, PHP_ROUND_HALF_DOWN) + $row['usr_points'];

    $sql_3 = "UPDATE users SET usr_points = ".$reward_points." WHERE users.id = ".$_SESSION['userId'].";";
    $stmt_3 = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt_3, $sql_3)) {
      header("Location: ../checkout.php?error=sqlerror");
      exit();
    }
    else {
      mysqli_stmt_execute($stmt);
      mysqli_stmt_execute($stmt_3);
      $_SESSION['shopping_cart'] = array();
      header("Location: ../checkout.php?order=success");
    }
  }
}
else {
  header("Location: ../index.php");
  exit();
}
