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
  <title>IndaMeds ∙ Past Orders</title>
  <link rel="stylesheet" href="bootstrap-4.1.3-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/checkout.css?version=23">
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
            <h2 class="text-center"><i class="fas fa-shopping-cart"></i> Previous Orders</h2>
            <div class="checkout-header-underline text-center"></div>
            <div class="col-md-12 text-center row">
              <?php
              $sql = "SELECT * FROM orders WHERE usr_id='".$_SESSION['userId']."' AND status='Completed' ORDER BY placed_time DESC LIMIT 0,3;";
              $result = mysqli_query($conn, $sql);
              while($row = mysqli_fetch_assoc($result)){
                $date = explode(" ", $row['placed_time']);
                echo '
                <div class="col-md-4 previous">
                  <div class="previous-order">
                    <table class="previous-header">
                      <tr>
                        <th class="previous-title">Previous Order</th>
                        <th class="previous-date">'.$date[0].'</th>
                      </tr>
                      <tr>
                        <td class="previous-details">'.$row['order_details'].'</td>
                        <td class="previous-price">$ '.$row['order_price'].'</td>
                      </tr>
                    </table>
                  </div>
                </div>
                ';
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
