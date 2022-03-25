<?php

if (isset($_POST['filter-orders'])) {
  require 'dbh.inc.php';

  $area = $_POST['area'];
  header("Location: ../pastorders.php?region=".$area);
  exit();

}
else {
  header("Location: ../pastorders.php");
  exit();
}
