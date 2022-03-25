<?php

if (isset($_POST['login-submit'])) {
  require 'dbh.inc.php';

  $email = $_POST['email'];
  $password = $_POST['password'];

  if (empty($email) || empty($password)) {
    header("Location: ../login.php?error=emptyfields");
    exit();
  }
  else {
    $sql = "SELECT * FROM users WHERE usr_email=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../login.php?error=sqlerror");
      exit();
    }
    else {
      mysqli_stmt_bind_param($stmt, "s", $email);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if ($row = mysqli_fetch_assoc($result)) {
        $pwdCheck = password_verify($password, $row['usr_pwd']);
        if ($pwdCheck == false) {
          header("Location: ../login.php?error=wrongpwd");
          exit();
        }
        else if ($pwdCheck == true) {
          if ($row['active_status'] == 0) {
            header("Location: ../login.php?error=accountinactive");
            exit();
          }
          else {
            session_start();
            $_SESSION['userId'] = $row['id'];
            $_SESSION['userEmail'] = $row['usr_email'];
            $_SESSION['userArea'] = $row['usr_area'];
            $_SESSION['userAddress'] = $row['usr_address'];
            $_SESSION['shopping_cart'] = array();

            if($row['first_name'] == null){$_SESSION['signUpFlag'] = 1;}

            header("Location: ../index.php?login=sucess");
            exit();
          }
        }
        else {
          header("Location: ../login.php?error=wrongpwd");
          exit();
        }
      }
      else {
        header("Location: ../login.php?error=nouser");
        exit();
      }
    }
  }
}
else {
  header("Location: ../index.php");
  exit();
}
