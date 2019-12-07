<?php
  session_start();

  if (!isset($_SESSION['userId'])) {
    header("Location: ../login.php");
    exit();
  }

  include_once 'includes/dbh.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>IndaMeds ∙ Checkout</title>
  <link rel="stylesheet" href="bootstrap-4.1.3-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/checkout.css?version=22">
  <link rel="icon" href="img/logo.png">
</head>

<!--- Script Source Files -->
<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/checkout.js?version=5"></script>
<script src="bootstrap-4.1.3-dist/js/bootstrap.min.js"></script>
<script src="https://use.fontawesome.com/releases/v5.9.0/js/all.js"></script>
<!--- End of Script Source Files -->

<body data-spy="scroll" data-target="#navbarResponsive">
  <div id="home">
    <?php
      require('header.php');
    ?>
    <div class="video-background">
      <div class="video-wrap">
        <div id="video">
          <video id="bgvid" autoplay loop muted playsinline>
            <source src="img/bg-video.mp4" type="video/mp4">
          </video>
        </div>
        <div class="checkout-wrapper">
          <div class="container">
            <div class="col-12 row text-center">
              <div class="col-12">
                <?php
                  if (isset($_GET['error'])) {
                    if ($_GET['error'] == "sqlerror") {
                      echo '<p class="field-error text-center">Database Error !</p>';
                    }
                  }
                  else if (isset($_GET['order'])) {
                    if ($_GET['order'] == "success") {
                      echo '<p class="order-success text-center">Your order is pending! if you do not see an update within 15 minutes please call: 123-456-7890</p>';
                    }
                  }
                ?>
              </div>
              <div class="col-md-6">
                <h2><i class="fas fa-shopping-cart"></i> Cart</h2>
                <div class="checkout-header-underline text-center"></div>
                  <?php
                  if(sizeof($_SESSION['shopping_cart']) == 0){
                    echo '<p>No Items</p>';
                  }
                  else{
                    $i = 0;
                    $total_price = 0;
                    echo '
                    <table class="order-table">
                      <tr>
                        <th>Item</th>
                        <th>Amount</th>
                        <th>Price</th>
                      </tr> ';
                      foreach ($_SESSION['shopping_cart'] as &$row){
                        $total_price = $total_price + $row['price'];
                        echo '
                        <tr>
                          <td>' . $row['name'] . '</td>
                          <td>' . $row['quantity'] . '</td>
                          <td>' .'$ '. $row['price'] . '</td>
                          <td><a onclick="remove_item(\''.$i.'\')"id=button-'.$i.' class="btn btn-primary">Remove</a></td>
                        </tr>';
                        $i++;
                      }

                      $fee_sql = "SELECT * FROM delivery_fee WHERE id='1';";
                      $fee_result = mysqli_query($conn, $fee_sql);
                      $fee_row = mysqli_fetch_assoc($fee_result);
                      $total_price = $total_price + $fee_row['fee'];

                      echo '
                      <tr>
                        <td>Delivery</td>
                        <td>-</td>
                        <td>' .'$ '. $fee_row['fee'] . '</td>

                      </tr>';
                      echo '
                      <tr>
                        <td>Total</td>
                        <td>-</td>
                        <td>' .'$ '. $total_price . '</td>

                      </tr>';
                      echo '</table>';
                      $points_sql = "SELECT * FROM users WHERE id='".$_SESSION['userId']."';";
                      $points_result = mysqli_query($conn, $points_sql);
                      $points = mysqli_fetch_assoc($points_result);
                      echo '
                      <a href="#" class="btn btn-secondary order-btn" data-toggle="modal" data-target="#checkout-modal">Order Now</a>
                      <div class="modal fade" id="checkout-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal">
                          <div class="modal-content">
                          <div class="col-12 text-center">
                          <h3 class="text-center">Thank you for ordereing with IndaMeds 420!</h3>
                          <p class="text-center">Reward points for this order:<strong> '. ($total_price-$fee_row['fee']).'</strong></p>
                          <p class="text-center">Monthly reward points: <strong>'.$points['usr_points'].'</strong></p>
                          <h4 class="text-center">Order Total: $'. $total_price . '</h4>
                          <p class="text-center">Do you really with to place this order to: <strong>'. $_SESSION['userAddress'] . '</strong>?</p>
                          <form class="checkout-form" action="includes/checkout.inc.php" method="post">
                            <button class="btn btn-secondary checkout-button" type="submit" name="checkout-submit">
                              Yes, Order Now
                            </button>
                          </form>
                          </div>
                          </div>
                        </div>
                      </div>
                      ';
                  }
                  ?>
              </div>
              <div class="col-md-6">
                <h2><i class="fas fa-truck"></i> Orders</h2>
                <div class="checkout-header-underline text-center"></div>
                <?php
                $sql = "SELECT * FROM orders WHERE usr_id='".$_SESSION['userId']."' AND (status = 'pending' OR status = 'on route');";
                $result = mysqli_query($conn, $sql);

                if(mysqli_num_rows($result) == 0){
                  echo '<p>No Orders</p>';
                }
                else{
                  echo '
                  <table class="order-table">
                    <tr>
                      <th>Info</th>
                      <th>Price</th>
                      <th>Status</th>
                    </tr> ';
                    while($row2 = mysqli_fetch_assoc($result)){
                      $total_price = $total_price + $row['price'];
                      echo '
                      <tr>
                        <td class="order-info">' . $row2['order_details'] . '</td>
                        <td>' .'$ '. $row2['order_price'] . '</td>
                        <td>' . $row2['status'] . '</td>
                        <td></td>
                      </tr>';
                    }
                    echo '</table>';
                }
                ?>
                <a class="text-center" href="pastorders.php">View Previous Orders</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
