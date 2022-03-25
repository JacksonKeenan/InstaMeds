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
  <title>IndaMeds ∙ Information</title>
  <link rel="stylesheet" href="bootstrap-4.1.3-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/login.css?version=11">
  <link rel="icon" href="img/logo.png">
</head>

<body>
  <div class="login-page" style="background-image: url('img/bg-01.jpg');">
      <div class="login-wrapper">
        <form class="login-form" action="includes/information.inc.php" method="post">
          <!--- Title --->
          <div class="text-center logo">
            <img src="img/logo.png">
          </div>

          <div class="text-center">
            <p>
              Please fill out some additional information.
            </p>
          </div>

          <?php
            if (isset($_GET['error'])) {
              if ($_GET['error'] == "emptyfields") {
                echo '
                <div class="text-center">
                  <p class="field-error">Please fill in all fields !</p>
                </div>';
              }
            }
            else if ($_GET["signup"] == "success") {
              echo '
              <div class="text-center">
                <p class="field-error">Signup successful !</p>
              </div>';
            }
          ?>

          <!--- First Name Input --->
          <div class="wrap-input">
            <input class="input" type="text" name="first_name" placeholder="First Name">
            <span class="focus-input"></span>
          </div>

          <!--- Last Name Input --->
          <div class="wrap-input">
            <input class="input" type="text" name="last_name" placeholder="Last Name">
            <span class="focus-input"></span>
          </div>

          <!--- Phone Name Input --->
          <div class="wrap-input">
            <input class="input" type="text" name="phone" placeholder="Phone">
            <span class="focus-input"></span>
          </div>

          <!--- Area Name Input --->
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

          <!--- Address Name Input --->
          <div class="wrap-input">
            <input class="input" type="text" name="address" placeholder="Address">
            <span class="focus-input"></span>
          </div>

          <!--- Sign-Up Button --->
          <div class="container-login-form-btn">
            <button class="login-form-btn" type="submit" name="information-submit">
              Continue
            </button>
          </div>
        </form>
      </div>
    </div>
<!--- Script Source Files -->
<script src="js/jquery-3.4.1.min.js"></script>
<script src="bootstrap-4.1.3-dist/js/bootstrap.min.js"></script>
<script src="https://use.fontawesome.com/releases/v5.9.0/js/all.js"></script>
<!--- End of Script Source Files -->
</body>
</html>
