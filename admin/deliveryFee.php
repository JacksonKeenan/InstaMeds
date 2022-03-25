<?php
  session_start();

  if (!isset($_SESSION['adminId'])) {
    header("Location: login.php");
    exit();
  }

  include_once 'includes/dbh.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>IndaMeds ∙ Fee</title>
  <link rel="stylesheet" href="/bootstrap-4.1.3-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/deliveryFee.css?version=3">
  <link rel="icon" href="img/logo.png">
</head>

<!--- Script Source Files -->
<script src="/js/jquery-3.4.1.min.js"></script>
<script src="/bootstrap-4.1.3-dist/js/bootstrap.min.js"></script>
<script src="https://use.fontawesome.com/releases/v5.9.0/js/all.js"></script>
<!--- End of Script Source Files -->

<body data-spy="scroll" data-target="#navbarResponsive">
  <div>
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
        <div class="fee-wrapper">
          <div class="container">
            <div class="row text-center">
              <div class="col-12">
                <h2 class="text-center"><i class="fas fa-money-bill"></i> Delivery Fee</h2>
                <div class="fee-header-underline text-center"></div>
                <?php
                if (isset($_GET['error'])) {
                  if ($_GET['error'] == "emptyfields") {
                    echo '
                        <div class="text-center">
                          <p class="field-error">Please Fill in all Fields !</p>
                        </div>';
                  }
                }
                ?>
                <form class="update-fee-form text-center" action="includes/deliveryFee.inc.php" method="post">
                  <div class="col-12">
                    <p class="text-center">Current Fee: $<?php
                    $fee_sql = "SELECT * FROM delivery_fee WHERE id='1';";
                    $fee_result = mysqli_query($conn, $fee_sql);
                    $fee_row = mysqli_fetch_assoc($fee_result);
                    echo $fee_row['fee'];
                    ?>
                    <div class="wrap-input text-center">
                    <input class="input" type="text" name="fee" placeholder="Eg. 15">
                    <span class="focus-input"></span>
                    </div>
                  </div>
                  <div class="col-12"><button class="btn btn-secondary" type="submit" name="update-fee">
                    Update
                  </button>
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
