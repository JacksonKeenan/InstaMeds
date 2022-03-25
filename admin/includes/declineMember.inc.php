<?php
session_start();
require 'dbh.inc.php';
$id=$_POST[index];

$sql = "DELETE FROM `indameds`.`users` WHERE `users`.`id` = ".$id.";";
$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $sql)) {
  header("Location: ../members.php?error=sqlerror");
  exit();
}
else {
  mysqli_stmt_execute($stmt);
  exit();
}
