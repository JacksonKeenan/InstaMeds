<?php
  session_start();

  if (!isset($_SESSION['userId'])) {
    header("Location: ../login.php");
    exit();
  }
  require 'includes/dbh.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>IndaMeds ∙ Account</title>
  <link rel="stylesheet" href="bootstrap-4.1.3-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/account.css?version=12">
  <link rel="icon" href="img/logo.png">
</head>

<!--- Script Source Files -->
<script src="js/jquery-3.4.1.min.js"></script>
<script src="bootstrap-4.1.3-dist/js/bootstrap.min.js"></script>
<script src="https://use.fontawesome.com/releases/v5.9.0/js/all.js"></script>
<!--- End of Script Source Files -->

<body data-spy="scroll" data-target="#navbarResponsive">
  <div>
    <?php
      require('header.php');

      $sql = "SELECT * FROM users WHERE id=".$_SESSION['userId'].";";
      $stmt = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../index.php?error=sqlerror");
        exit();
      }
      else {
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        $email = $row['usr_email'];
        $fname = $row['first_name'];
        $lname = $row['last_name'];
        $phone = $row['usr_phone'];
        $address = $row['usr_address'];
        $region = $row['usr_area'];
      }

    ?>
    <div class="video-background">
      <div class="video-wrap">
        <div id="video">
          <video id="bgvid" autoplay loop muted playsinline>
            <source src="img/bg-video.mp4" type="video/mp4">
          </video>
        </div>
        <div class="account-wrapper">
          <h2 class="text-center"><i class="fas fa-user-circle"></i> Account</h2>
          <div class="account-header-underline text-center"></div>
          <form class="account-form" action="includes/account.inc.php" method="post" enctype="multipart/form-data">
            <div class="row dark">
                <div class="col-md-6">
                  <h3>First Name</h3>
                  <div class="wrap-input">
                    <input class="input" type="text" name="first-name" value="<?php echo $fname ?>" readonly>
                    <span class="focus-input"></span>
                  </div>
                </div>

                <div class="col-md-6">
                  <h3>Last Name</h3>
                  <div class="wrap-input">
                    <input class="input" type="text" name="last-name" value="<?php echo $lname ?>" readonly>
                    <span class="focus-input"></span>
                  </div>
                </div>

                <div class="col-md-6">
                  <h3>Phone</h3>
                  <div class="wrap-input">
                    <input class="input" type="text" name="phone" value="<?php echo $phone ?>">
                    <span class="focus-input"></span>
                  </div>
                </div>

                <div class="col-md-6">
                  <h3>Email</h3>
                  <div class="wrap-input">
                    <input class="input" type="text" name="email" value="<?php echo $email ?>">
                    <span class="focus-input"></span>
                  </div>
                </div>

                <div class="col-md-6">
                  <h3>Address</h3>
                  <div class="wrap-input">
                    <input class="input" type="text" name="address" value="<?php echo $address ?>">
                    <span class="focus-input"></span>
                  </div>
                </div>

                <div class="col-md-6">
                  <h3>Area</h3>
                  <div class="wrap-input">
                    <select class="input" name="area">
                      <option selected disabled hidden>Select Region ...</option>
                      <?php
                      $sql = "SELECT * FROM regions;";
                      $stmt = mysqli_stmt_init($conn);
                      if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header("Location: ../index.php?error=sqlerror");
                        exit();
                      }
                      else {
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        while ($row = mysqli_fetch_assoc($result)){
                          echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';
                        }
                      }
                      ?>
                    </select>
                    <span class="focus-input"></span>
                  </div>
                </div>

                <div class="col-md-6">
                  <p class="user-points text-center"><i class="fas fa-coins"></i> Reward Points:
                    <?php
                      $sql = "SELECT * FROM users WHERE id='".$_SESSION['userId']."';";
                      $result = mysqli_query($conn, $sql);
                      $points = mysqli_fetch_assoc($result);
                      echo $points['usr_points'];
                    ?></p>
                    <P class="point-expiry text-center">Expires on:
                      <?php
                        $lastDayThisMonth = date("Y-m-t");
                        echo $lastDayThisMonth;
                        ?></p>
                </div>

                <div class="col-md-6">
                  <div class="container-account-form-btn">
                    <button class="account-form-btn" type="submit" name="account-submit">
                      Update
                    </button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
