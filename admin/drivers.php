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
  <title>IndaMeds ∙ Drivers</title>
  <link rel="stylesheet" href="/bootstrap-4.1.3-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/drivers.css?version=8">
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
        <div class="drivers-wrapper">
            <div class="row text-center">
              <div class="col-12">
                <h2 class="text-center"><i class="fas fa-car"></i> Drivers</h2>
                <div class="drivers-header-underline text-center"></div>
                <?php

                if (isset($_GET['error'])) {
                  if ($_GET['error'] == "emptyfields") {
                    echo '
                        <div class="text-center">
                          <p class="field-error">Please Fill in all Fields !</p>
                        </div>';
                  }
                }

                $sql = "SELECT * FROM drivers";
                $result = mysqli_query($conn, $sql);

                if(mysqli_num_rows($result) == 0){
                  echo '<p>No Drivers</p>';
                }
                else {
                  echo '
                  <table class="driver-table text-center">
                    <tr>
                      <th>Area</th>
                      <th>Name</th>
                      <th>Phone</th>
                    </tr>';

                    while($row = mysqli_fetch_assoc($result)){
                      echo '
                      <tr>
                        <td>'.$row['driver_area'].'</td>
                        <td>'.$row['name'].'</td>
                        <td>'.$row['cell_num'].'</td>
                        <td>
                        <form class="delete-driver-form" action="includes/deleteDriver.inc.php" method="post">
                        <input type="hidden" name="driver-id" value="'.$row['id'].'" />
                          <button class="btn btn-primary" type="submit" name="delete-driver">
                            Remove
                          </button>
                        </form>
                        </td>
                      </tr>
                      ';
                    }
                    echo '</table>';
                }
                ?>
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#add-driver-modal">Add</a>
                <div class="modal fade" id="add-driver-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal">
                    <div class="modal-content">
                    <div class="col-12 row text-center">
                    <div class="col-12"><h3>Add Driver</h3></div>
                    <form class="add-driver-form text-center" action="includes/drivers.inc.php" method="post">
                      <div class="col-12"><input class="input" type="text" name="name" placeholder="Name"></div>
                      <div class="col-12"><input class="input" type="text" name="phone" placeholder="Phone"></div>
                      <div class="col-12"><select class="input" name="area">
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
                      </select></div>
                      <div class="col-12"><button class="btn btn-secondary" type="submit" name="add-driver">
                        Add
                      </button>
                    </form>
                    </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</body>
