<?php

if (isset($_POST['filter-members-area'])) {
  require 'dbh.inc.php';

  $area = $_POST['area'];
  header("Location: ../members.php?region=".$area);
  exit();

}
elseif (isset($_POST['filter-members-text'])) {
  require 'dbh.inc.php';

  $search = $_POST['search'];
  header("Location: ../members.php?search=".$search);
  exit();
}
else {
  header("Location: ../members.php");
  exit();
}
