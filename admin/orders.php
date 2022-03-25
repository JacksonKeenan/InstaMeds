<?php
  session_start();

  if (!isset($_SESSION['adminId'])) {
    header("Location: login.php");
    exit();
  }

  include_once 'includes/dbh.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>IndaMeds ∙ Orders</title>
  <link rel="stylesheet" href="/bootstrap-4.1.3-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/orders.css?version=22">
  <link rel="icon" href="img/logo.png">
</head>

<!--- Script Source Files -->
<script src="/js/jquery-3.4.1.min.js"></script>
<script src="/bootstrap-4.1.3-dist/js/bootstrap.min.js"></script>
<script src="https://use.fontawesome.com/releases/v5.9.0/js/all.js"></script>
<!--- End of Script Source Files -->

<body data-spy="scroll" data-target="#navbarResponsive">
  <div>
    <?php
      require('header.php');
    ?>
    <div class="video-background">
      <div class="video-wrap">
        <div id="video">
          <video id="bgvid" autoplay loop muted playsinline>
            <source src="img/bg-video.mp4" type="video/mp4">
          </video>
        </div>
        <div class="orders-wrapper">
            <div class="row">
              <div class="col-12 text-center">
                <h2 class="text-center"><i class="fas fa-truck"></i> Orders</h2>
                <div class="orders-header-underline text-center"></div>
                <div class = "region-search">
                  <form class="order-filter-form" action="includes/filterOrders.inc.php" method="post">
                    <div class="wrap-input text-center">
                    <select class="input" name="area">
                    <option selected disabled hidden>Select Region ...</option>
                    <?php
                    $sql = "SELECT * FROM regions;";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                      header("Location: ../index.php?error=sqlerror");
                      exit();
                    }
                    else {
                      mysqli_stmt_execute($stmt);
                      $result = mysqli_stmt_get_result($stmt);
                      while ($row = mysqli_fetch_assoc($result)){
                        echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';
                      }
                    }
                    ?>
                    <option value="">All Regions</option>
                    </select>
                    <span class="focus-input"></span>
                  </div>
                  <button class="btn btn-tertiary" type="submit" name="filter-orders">
                    Go
                  </button>
                  </form>
                </div>
                <?php

                if (isset($_GET['error'])) {
                  if ($_GET['error'] == "emptyfields") {
                    echo '
                        <div class="text-center">
                          <p class="field-error">No Driver Selected !</p>
                        </div>';
                  }
                }

                $region = "";
                if (isset($_GET['region'])) {
                  $region = $_GET['region'];
                }
                if ($region == "") {
                  $sql = "SELECT * FROM orders WHERE (status = 'pending' OR status = 'on route') ORDER BY order_id DESC";
                }
                else {
                  $sql = "SELECT * FROM orders WHERE (status = 'pending' OR status = 'on route') AND order_area='".$region."' ORDER BY order_id DESC";
                }
                $result = mysqli_query($conn, $sql);

                if(mysqli_num_rows($result) == 0){
                  echo '<p>No Orders</p>';
                }
                else {
                  echo '
                  <table class="order-table text-center">
                    <tr>
                      <th class="hidden-cell">Order No.</th>
                      <th class="hidden-cell">Area</th>
                      <th class="hidden-cell">Order Time</th>
                      <th class="hidden-cell">Client No.</th>
                      <th class="hidden-cell">Name</th>
                      <th class="address-cell">Address</th>
                      <th class="hidden-cell">Phone</th>
                      <th class="hidden-cell order-details">Details</th>
                      <th class="">Price</th>
                      <th class="">Options</th>
                    </tr>';

                    while($row = mysqli_fetch_assoc($result)){
                      $clientSql = "SELECT * FROM users WHERE id = '".$row['usr_id']."'";
                      $clientResult = mysqli_query($conn, $clientSql);
                      $client = mysqli_fetch_assoc($clientResult);

                      if ($row['status'] == 'pending') {
                        echo '
                        <tr class = "order-row">
                          <td class="hidden-cell">'.$row['order_id'].'</td>
                          <td class="hidden-cell">'.$row['order_area'].'</td>
                          <td class="hidden-cell">'.$row['placed_time'].'</td>
                          <td class="hidden-cell">'.$row['usr_id'].'</td>
                          <td class="hidden-cell">'.$client['first_name'].' '.$client['last_name'].'</td>
                          <td class="address-cell">'.$row['order_address'].'</td>
                          <td class="hidden-cell">'.$client['usr_phone'].'</td>
                          <td class="hidden-cell order-details">'.$row['order_details'].'</td>
                          <td class="price-cell">$'.$row['order_price'].'</td>
                          <td>
                          <form class="confirm-order-form" action="includes/confirmOrder.inc.php" method="post">
                          <input type="hidden" name="order-id" value="'.$row['order_id'].'" />
                          <div class="wrap-input wrap-input-driver text-center">
                          <select class="input" name="driver-id">
                            <option selected disabled hidden>Select Driver ...</option>';
                          $sql_2 = "SELECT * FROM drivers WHERE driver_area='".$row['order_area']."';";
                          $stmt_2 = mysqli_stmt_init($conn);
                          if (!mysqli_stmt_prepare($stmt_2, $sql_2)) {
                            header("Location: ../admin/orders.php?error=sqlerror");
                            exit();
                          }
                          else {
                            mysqli_stmt_execute($stmt_2);
                            $result_2 = mysqli_stmt_get_result($stmt_2);
                            while ($row_2 = mysqli_fetch_assoc($result_2)){
                              echo '<option value="'.$row_2['id'].'">'.$row_2['name'].'</option>';
                            }
                          }
                          echo '
                          </select>
                          <span class="focus-input"></span>
                          </div>
                          ';


                          echo '
                          <br>
                          <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#confirm-order-modal-'.$row[order_id].'">Confirm Order</a>
                          <div class="modal fade" id="confirm-order-modal-'.$row[order_id].'" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal">
                              <div class="modal-content">
                              <div class="col-12 text-center">
                              <p class="text-center">Do you really want to confirm this order?</p>
                                <button class="btn btn-secondary" type="submit" name="order-confirm">
                                  Yes
                                </button>
                                </form>
                              </div>
                              </div>
                            </div>
                          </div>
                          <br>
                          <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#delete-order-modal-'.$row[order_id].'">Delete Order</a>
                          <div class="modal fade" id="delete-order-modal-'.$row[order_id].'" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal">
                              <div class="modal-content">
                              <div class="col-12 text-center">
                              <p class="text-center">Do you really with to delete this order?</p>
                              <form class="delete-order-form" action="includes/deleteOrder.inc.php" method="post">
                                <input type="hidden" name="order-id" value="'.$row['order_id'].'" />
                                <button class="btn btn-secondary order-button" type="submit" name="order-delete">
                                  Yes
                                </button>
                              </form>
                              </div>
                              </div>
                            </div>
                          </div>
                          </td>
                        </tr>
                        ';
                      }
                      else if ($row['status'] == 'on route') {
                        echo '
                        <tr class = "order-row">
                          <td class="hidden-cell">'.$row['order_id'].'</td>
                          <td class="hidden-cell">'.$row['order_area'].'</td>
                          <td class="hidden-cell">'.$row['placed_time'].'</td>
                          <td class="hidden-cell">'.$row['usr_id'].'</td>
                          <td class="hidden-cell">'.$client['first_name'].' '.$client['last_name'].'</td>
                          <td class="address-cell">'.$row['order_address'].'</td>
                          <td class="hidden-cell">'.$client['usr_phone'].'</td>
                          <td class="hidden-cell order-details">'.$row['order_details'].'</td>
                          <td class="price-cell">$'.$row['order_price'].'</td>
                          <td>
                          <a href="#" class="btn btn-primary order-btn" data-toggle="modal" data-target="#confirm-delivery-modal-'.$row[order_id].'">Confirm Delivery</a>
                          <div class="modal fade" id="confirm-delivery-modal-'.$row[order_id].'" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal">
                              <div class="modal-content">
                              <div class="col-12 text-center">
                              <p class="text-center">This order has been delivered?</p>
                              <form class="confirm-delivery-form" action="includes/confirmDelivery.inc.php" method="post">
                                <input type="hidden" name="order-id" value="'.$row['order_id'].'" />
                                <button class="btn btn-secondary order-button" type="submit" name="delivery-confirmation">
                                  Yes
                                </button>
                              </form>
                              </div>
                              </div>
                            </div>
                          </div>
                          </td>
                        </tr>';
                      }
                    }
                    echo '</table>';
                }
                ?>
                <a class="past-orders" href="pastorders.php">View Past Orders</a>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</body>
