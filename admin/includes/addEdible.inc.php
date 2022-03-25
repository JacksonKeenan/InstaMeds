<?php

if (isset($_POST['add-edible'])) {
  require 'dbh.inc.php';

  $name = $_POST['name'];
  $price = $_POST['price'];
  $desc = $_POST['desc'];

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
  $fileDestination = '../../img/products/edibles/'.$fileNameNew;

  if (empty($name) || empty($price) || empty($fileName)) {
    header("Location: ../products.php?section=edibles&error=emptyfields");
    exit();
  }
  else if (!in_array($fileActualExt, $allowed)) {
    header("Location: ../products.php?section=edibles&error=filetype");
    exit();
  }
  else if ($fileError != 0) {
    header("Location: ../products.php?section=edibles&error=fileerror");
    exit();
  }
  else if ($fileSize > 1000000) {
    header("Location: ../products.php?section=edibles&error=filesize");
    exit();
  }
  else {
    $sql = "INSERT INTO edibles (name, unit_price, item_desc, img_name) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../products.php?section=edibles&error=sqlerror");
      exit();
    }
    else {
      mysqli_stmt_bind_param($stmt, "sdss", $name, $price, $desc, $fileNameNew);
      mysqli_stmt_execute($stmt);

      move_uploaded_file($fileTmpName, $fileDestination);

      header("Location: ../products.php?section=edibles&add=success");
      exit();
    }
  }

  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
else {
  header("Location: ../products.php?section=edibles");
  exit();
}
