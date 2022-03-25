<?php

$servername = "localhost";
$dBUsername = "phpmyadmin";
$dBPassword = "funK.3ky";
$dBName = "indameds";

$conn = mysqli_connect($server, $dBUsername, $dBPassword, $dBName);

if(!$conn){
  die("Connect Failed: ".mysqli_connect_error());
}
