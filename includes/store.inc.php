<?php
  session_start();
  array_push($_SESSION['shopping_cart'], array('name' => $_POST[name], 'quantity' => $_POST[quantity], 'price' => $_POST[price]));
