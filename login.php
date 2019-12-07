<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>IndaMeds</title>
  <link rel="stylesheet" href="bootstrap-4.1.3-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/login.css?version=4">
  <link rel="icon" href="img/logo.png">
</head>

<body>
<div class="login-page" style="background-image: url('img/bg-01.jpg');">
    <div class="login-wrapper">
      <form class="login-form" action="includes/login.inc.php" method="post">

        <!--- Title --->
        <div class="text-center">
          <img src="img/logo.png">
        </div>

<?php
if (isset($_GET['error'])) {
  if ($_GET['error'] == "emptyfields") {
    echo '
        <div class="text-center">
          <p class="field-error">Please fill in all fields !</p>
        </div>';
  }
  else if ($_GET['error'] == "sqlerror") {
    echo '
        <div class="text-center">
          <p class="field-error">Database Error !</p>
        </div>';
  }
  else if ($_GET['error'] == "wrongpwd") {
    echo '
        <div class="text-center">
          <p class="field-error">Wrong Password !</p>
        </div>';
  }
  else if ($_GET['error'] == "nouser") {
    echo '
        <div class="text-center">
          <p class="field-error">Account Does Not Exist !</p>
        </div>';
  }
  else if ($_GET['error'] == "accountinactive") {
    echo '
        <div class="text-center">
          <p class="field-error">Account is Not Yet Active</p><br><p class="field-error">Please Wait 24 Hours for Account Approval.</p>
        </div>';
  }
}
?>
        <!--- Email Input --->
        <div class="wrap-input">
          <input class="input" type="text" name="email" placeholder="Email">
          <span class="focus-input"></span>
        </div>

        <!--- Password Input --->
        <div class="wrap-input">
          <input class="input" type="password" name="password" placeholder="Password">
          <span class="focus-input"></span>
        </div>

      <!--- Sign-In Button --->
      <div class="container-login-form-btn">
        <button class="login-form-btn" type="submit" name="login-submit">
          Sign In
        </button>
      </div>
    </form>

    <!--- Sign-Up --->
    <div class="text-center">
      <p class="noMember">
        Not a Member?
      </p>
    </div>

    <div class="text-center">
      <a href="signup.php" class="signUp">Sign Up</a>
    </div>

    <div class="contact text-center">
      <a href="" target="_blank"><i class="fab fa-facebook"></i></a>
      <a href="" target="_blank"><i class="fab fa-instagram"></i></a>
      <a href="" target="_blank"><i class="fab fa-twitter"></i></a>
    </div>
  </div>
</div>
</body>
</html>
<!--- Script Source Files -->
<script src="js/jquery-3.4.1.min.js"></script>
<script src="bootstrap-4.1.3-dist/js/bootstrap.min.js"></script>
<script src="https://use.fontawesome.com/releases/v5.9.0/js/all.js"></script>
<!--- End of Script Source Files -->
