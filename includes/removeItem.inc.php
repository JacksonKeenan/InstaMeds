<?php
  session_start();
  unset($_SESSION['shopping_cart'][$_POST[index]]);
  $_SESSION['shopping_cart'] = array_values($_SESSION['shopping_cart']);
