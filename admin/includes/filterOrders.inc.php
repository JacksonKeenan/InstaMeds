<?php

if (isset($_POST['filter-orders'])) {
  require 'dbh.inc.php';

  $area = $_POST['area'];
  header("Location: ../orders.php?region=".$area);
  exit();

}
else {
  header("Location: ../orders.php");
  exit();
}
