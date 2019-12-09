<?php

if (isset($_POST['signup-submit'])) {
  require 'dbh.inc.php';

  $activeStatus = 1;
  $email = $_POST['email'];
  $password = $_POST['password'];
  $passwordConfirm = $_POST['password-confirm'];

  $file = $_FILES['file'];
  $fileName = $_FILES['file']['name'];
  $fileTmpName = $_FILES['file']['tmp_name'];
  $fileSize = $_FILES['file']['size'];
  $fileError = $_FILES['file']['error'];
  $fileType = $_FILES['file']['type'];

  $fileExt = explode('.', $fileName);
  $fileActualExt = strtolower(end($fileExt));

  $allowed = array('jpg', 'jpeg', 'png');

  $fileNameNew = uniqid('', true).".".$fileActualExt;
  $fileDestination = '../admin/img/photo_ids/'.$fileNameNew;

  if (empty($email) || empty($password) || empty($passwordConfirm)) {
    header("Location: ../signup.php?error=emptyfields&mail=".$email);
    exit();
  }
  else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/((?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20})/", $password)) {
    header("Location: ../signup.php?error=invalidmailpass");
    exit();
  }
  else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../signup.php?error=invalidmail");
    exit();
  }
  else if (!preg_match("/((?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20})/", $password)) {
    header("Location: ../signup.php?error=invalidpass&mail=".$email);
    exit();
  }
  else if ($password !== $passwordConfirm) {
    header("Location: ../signup.php?error=passcheck&mail=".$email);
    exit();
  }
  else if (!in_array($fileActualExt, $allowed)) {
    header("Location: ../signup.php?error=filetype");
    exit();
  }
  else if ($fileError != 0) {
    header("Location: ../signup.php?error=fileerror");
    exit();
  }
  else if ($fileSize > 1000000) {
    header("Location: ../signup.php?error=filesize");
    exit();
  }
  else{
    $sql = "SELECT usr_email FROM users WHERE usr_email=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../signup.php?error=sqlerror");
      exit();
    }
    else {
      mysqli_stmt_bind_param($stmt, "s", $email);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      $resultCheck = mysqli_stmt_num_rows($stmt);
      if ($resultCheck > 0){
        header("Location: ../signup.php?error=emailtaken");
        exit();
      }
      else {
        $sql = "INSERT INTO users (usr_email, usr_pwd, usr_id, active_status) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
          header("Location: ../signup.php?error=sqlerror");
          exit();
        }
        else {
          $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
          mysqli_stmt_bind_param($stmt, "sssi", $email, $hashedPwd, $fileNameNew, $activeStatus);
          mysqli_stmt_execute($stmt);

          move_uploaded_file($fileTmpName, $fileDestination);

          header("Location: ../signup.php?signup=success");
          exit();
        }
      }
    }
  }
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
else {
  header("Location: ../signup.php");
  exit();
}
