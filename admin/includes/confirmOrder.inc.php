<?php
require './vendor/autoload.php';
use Twilio\Rest\Client;

session_start();

if (isset($_POST['order-confirm'])) {
  require 'dbh.inc.php';

  $orderId = $_POST['order-id'];
  $driverId = $_POST['driver-id'];

  if (empty($orderId) || empty($driverId)) {
    header("Location: ../orders.php?error=emptyfields");
    exit();
  }
  else {
    $sql = "UPDATE `orders` SET `status` = 'on route' WHERE `orders`.`order_id` ='".$orderId."';";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../orders.php?error=sqlerror");
      exit();
    }
    else {
      $orderSql = "SELECT * FROM orders WHERE order_id='".$orderId."';";
      $orderResult = mysqli_query($conn, $orderSql);
      $order = mysqli_fetch_assoc($orderResult);

      $driverSql = "SELECT * FROM drivers WHERE id='".$driverId."';";
      $driverResult = mysqli_query($conn, $driverSql);
      $driver = mysqli_fetch_assoc($driverResult);

      $phone = preg_replace("/[^0-9]/", "", $driver['cell_num']);
      $phone = preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "+1$1$2$3", $phone);

      $message = "Order No. ". $order['order_id'] . "\n\nAddress: " . $order['order_address'] . "\n\nOrder: " . $order['order_details'] . "\n\nTotal: $" . $order['order_price'];

      // Your Account SID and Auth Token from twilio.com/console
      $account_sid = getenv('TWILIO_SID');
      $auth_token = getenv('TWILIO_AUTH_TOKEN');

      // A Twilio number you own with SMS capabilities
      $twilio_number = "+12267807065";

      $client = new Client($account_sid, $auth_token);
      try {
        $client->messages->create(
            // Where to send a text message (your cell phone?)
            $phone,
            array(
                'from' => $twilio_number,
                'body' => $message
            )
        );
      } catch (\Exception $e) {
        header("Location: ../orders.php?error=twilioError");
        exit();
      }
      mysqli_stmt_execute($stmt);
      header("Location: ../orders.php?confirmation=success");
      exit();
    }
  }
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
