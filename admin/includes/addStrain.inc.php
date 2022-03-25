<?php

if (isset($_POST['add-strain'])) {
  require 'dbh.inc.php';

  $name = $_POST['name'];
  $type = $_POST['type'];
  $thc = $_POST['thc'];
  $cbd = $_POST['cbd'];
  $price_quarter = $_POST['price_quarter'];
  $price_half = $_POST['price_half'];
  $price_oz = $_POST['price_oz'];
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
  $fileDestination = '../../img/products/strains/'.$fileNameNew;

  if (empty($name) || empty($type) || empty($fileName)) {
    header("Location: ../products.php?section=flowers&error=emptyfields");
    exit();
  }
  else if (!in_array($fileActualExt, $allowed)) {
    header("Location: ../products.php?section=flowers&error=filetype");
    exit();
  }
  else if ($fileError != 0) {
    header("Location: ../products.php?section=flowers&error=fileerror");
    exit();
  }
  else if ($fileSize > 1000000) {
    header("Location: ../products.php?section=flowers&error=filesize");
    exit();
  }
  else {
    $sql = "INSERT INTO strains (name, type, thc, cbd, price_quarter, price_half, price_oz, strain_desc, img_name) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../products.php?section=flowers&error=sqlerror");
      exit();
    }
    else {
      mysqli_stmt_bind_param($stmt, "ssdddddss", $name, $type, $thc, $cbd, $price_quarter, $price_half, $price_oz, $desc, $fileNameNew);
      mysqli_stmt_execute($stmt);

      move_uploaded_file($fileTmpName, $fileDestination);

      header("Location: ../products.php?section=flowers&add=success");
      exit();
    }
  }

  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
else {
  header("Location: ../products.php?section=flowers");
  exit();
}
