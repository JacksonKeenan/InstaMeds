<?php

if (isset($_POST['filter-members'])) {
  require 'dbh.inc.php';

  $area = $_POST['area'];


  if (empty($area)) {
    header("Location: ../members.php?error=emptyfields");
    exit();
  }
  else {
    header("Location: ../members.php?region=".$area);
    exit();
  }

  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
else {
  header("Location: ../members.php");
  exit();
}
