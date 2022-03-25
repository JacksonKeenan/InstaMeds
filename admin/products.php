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
  <title>IndaMeds ∙ Products</title>
  <link rel="stylesheet" href="/bootstrap-4.1.3-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/products.css?version=9">
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
        <div class="account-wrapper">
          <div class="store-header">
            <div class="col-md-12 text-center row">
              <div class="col-md-4">
                <a href="products.php?section=flowers" class="<?php if ($_GET['section'] == "flowers"){echo 'activeSection';}?>"><i class="fas fa-cannabis fa-3x"></i><h1>Flowers</h1></a>
              </div>
              <div class="col-md-4">
                <a href="products.php?section=edibles" class="<?php if ($_GET['section'] == "edibles"){echo 'activeSection';}?>"><i class="fas fa-cookie-bite fa-3x"></i><h1>Edibles</h1></a>
              </div>
              <div class="col-md-4">
                <a href="products.php?section=extracts" class="<?php if ($_GET['section'] == "extracts"){echo 'activeSection';}?>"><i class="fas fa-tint fa-3x"></i><h1>Extracts</h1></a>
              </div>
            </div>
          </div>
          <div class="store-header-underline"></div>
          <?php

            if (isset($_GET['error'])) {
              if ($_GET['error'] == "emptyfields") {
                echo '
                    <div class="text-center">
                      <p class="field-error">Please make sure Name, Type, and Image are filled in !</p>
                    </div>';
              }
            }

            if ($_GET['section'] == "flowers"){
              $sql = "SELECT * FROM strains ORDER BY (CASE type WHEN 'Indica' THEN 1 WHEN 'Sativa' THEN 2 WHEN 'Hybrid' THEN 3 END) ASC;";
              $result = mysqli_query($conn, $sql);

              if(mysqli_num_rows($result) == 0){
                echo '<p class="text-center">No Strains</p>';
                echo '
                <div class="text-center">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#add-strain-modal">Add</a>
                <div class="modal fade" id="add-strain-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal">
                    <div class="modal-content">
                    <h3 class="text-center">Add Strain</h3>
                    <div class="col-12 row text-center">
                    <form class="add-strain-form text-center" action="includes/addStrain.inc.php" method="post" enctype="multipart/form-data">
                    <div class="wrap-input">
                      <input class="input" type="text" name="name" placeholder="Name">
                      <span class="focus-input"></span>
                    </div>
                    <div class="wrap-input">
                      <select class="input" name="type">
                        <option selected disabled hidden>Select Type ...</option>
                        <option value="Indica">Indica</option>
                        <option value="Sativa">Sativa</option>
                        <option value="Hybrid">Hybrid</option>
                      </select>
                      <span class="focus-input"></span>
                    </div>
                    <div class="wrap-input">
                      <input class="input" type="text" name="thc" placeholder="THC Percentage (Eg. 23)">
                      <span class="focus-input"></span>
                    </div>
                    <div class="wrap-input">
                    <input class="input" type="text" name="cbd" placeholder="CBD Percentage (Eg. 23)">
                    <span class="focus-input"></span>
                    </div>
                    <div class="wrap-input">
                    <input class="input" type="text" name="price_quarter" placeholder="Quarter Price (Eg. 60)">
                    <span class="focus-input"></span>
                    </div>
                    <div class="wrap-input">
                    <input class="input" type="text" name="price_half" placeholder="Half Price (Eg. 120)">
                    <span class="focus-input"></span>
                    </div>
                    <div class="wrap-input">
                    <input class="input" type="text" name="price_oz" placeholder="Oz Price (Eg. 180)">
                    <span class="focus-input"></span>
                    </div>
                    <div class="wrap-input">
                    <input class="input" type="text" name="desc" placeholder="Description">
                    <span class="focus-input"></span>
                    </div>
                    <div class="text-center">
                      <input class="input" type="file" id="photo_id" accept="image/*" name="file">
                      <label for="photo_id">Strain Photo</label>
                      <span id="upload-text">No file Chosen, yet.</span>
                      <script type="text/javascript">
                        const realFileBtn = document.getElementById("photo_id");
                        const uploadText = document.getElementById("upload-text");

                        realFileBtn.addEventListener("change", function functionName() {
                          if(realFileBtn.value){
                            uploadText.innerHTML = realFileBtn.value.match(/[\/\\\\]([\w\d\s\.\-\(\)]+)$/)[1];
                          } else {
                            uploadText.innerHTML = "No file Chosen, yet.";
                          }
                        });
                      </script>
                    </div>
                    <button class="btn btn-secondary" type="submit" name="add-strain">
                      Add
                    </button>
                    </form>
                    </div>
                    </div>
                  </div>
                </div>
              </div>';
              }
              else {
                echo '
                <table class="text-center product-table">
                  <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th class="hidden-cell">THC</th>
                    <th class="hidden-cell">CBD</th>
                    <th>1/4 Oz.</th>
                    <th>1/2 Oz.</th>
                    <th>1 Oz.</th>
                  </tr>';

                  while($row = mysqli_fetch_assoc($result)){
                    if ($row['thc'] == null || $row['thc'] == 0) {$row['thc'] = 'n/a';}
                    else {$row['thc'] = $row['thc'] . ' %';}

                    if ($row['cbd'] == null || $row['cbd'] == 0) {$row['cbd'] = 'n/a';}
                    else {$row['cbd'] = $row['cbd'] . ' %';}

                    if ($row['price_quarter'] == null || $row['price_quarter'] == 0) {$row['price_quarter'] = 'n/a';}
                    else {$row['price_quarter'] = '$ ' . $row['price_quarter'];}

                    if ($row['price_half'] == null || $row['price_half'] == 0) {$row['price_half'] = 'n/a';}
                    else {$row['price_half'] = '$ ' . $row['price_half'];}

                    if ($row['price_oz'] == null || $row['price_oz'] == 0) {$row['price_oz'] = 'n/a';}
                    else {$row['price_oz'] = '$ ' . $row['price_oz'];}
                    echo '
                    <tr>
                      <td>'.$row['name'].'</td>
                      <td>'.$row['type'].'</td>
                      <td class="hidden-cell">'.$row['thc'].'</td>
                      <td class="hidden-cell">'.$row['cbd'].'</td>
                      <td>'.$row['price_quarter'].'</td>
                      <td>'.$row['price_half'].'</td>
                      <td>'.$row['price_oz'].'</td>
                      <td>
                      <form class="delete-strain-form" action="includes/deleteStrain.inc.php" method="post">
                      <input type="hidden" name="strain-id" value="'.$row['id'].'" />
                        <button class="btn btn-primary" type="submit" name="delete-strain">
                          Remove
                        </button>
                      </form>
                      </td>
                    </tr>
                    ';
                  }
                  echo '</table>';

                  echo '
                  <div class="text-center">
                  <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#add-strain-modal">Add</a>
                  <div class="modal fade" id="add-strain-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal">
                      <div class="modal-content">
                      <h3 class="text-center">Add Strain</h3>
                      <div class="col-12 row text-center">
                      <form class="add-strain-form text-center" action="includes/addStrain.inc.php" method="post" enctype="multipart/form-data">
                      <div class="wrap-input">
                        <input class="input" type="text" name="name" placeholder="Name">
                        <span class="focus-input"></span>
                      </div>
                      <div class="wrap-input">
                        <select class="input" name="type">
                          <option selected disabled hidden>Select Type ...</option>
                          <option value="Indica">Indica</option>
                          <option value="Sativa">Sativa</option>
                          <option value="Hybrid">Hybrid</option>
                        </select>
                        <span class="focus-input"></span>
                      </div>
                      <div class="wrap-input">
                        <input class="input" type="text" name="thc" placeholder="THC Percentage (Eg. 23)">
                        <span class="focus-input"></span>
                      </div>
                      <div class="wrap-input">
                      <input class="input" type="text" name="cbd" placeholder="CBD Percentage (Eg. 23)">
                      <span class="focus-input"></span>
                      </div>
                      <div class="wrap-input">
                      <input class="input" type="text" name="price_quarter" placeholder="Quarter Price (Eg. 60)">
                      <span class="focus-input"></span>
                      </div>
                      <div class="wrap-input">
                      <input class="input" type="text" name="price_half" placeholder="Half Price (Eg. 120)">
                      <span class="focus-input"></span>
                      </div>
                      <div class="wrap-input">
                      <input class="input" type="text" name="price_oz" placeholder="Oz Price (Eg. 180)">
                      <span class="focus-input"></span>
                      </div>
                      <div class="wrap-input">
                      <input class="input" type="text" name="desc" placeholder="Description">
                      <span class="focus-input"></span>
                      </div>
                      <div class="text-center">
                        <input class="input" type="file" id="strain-photo" accept="image/*" name="file">
                        <label for="strain-photo">Strain Photo</label>
                        <span id="upload-text">No file Chosen, yet.</span>
                        <script type="text/javascript">
                          const realFileBtn = document.getElementById("strain-photo");
                          const uploadText = document.getElementById("upload-text");

                          realFileBtn.addEventListener("change", function functionName() {
                            if(realFileBtn.value){
                              uploadText.innerHTML = realFileBtn.value.match(/[\/\\\\]([\w\d\s\.\-\(\)]+)$/)[1];
                            } else {
                              uploadText.innerHTML = "No file Chosen, yet.";
                            }
                          });
                        </script>
                      </div>
                      <button class="btn btn-secondary" type="submit" name="add-strain">
                        Add
                      </button>
                      </form>
                      </div>
                      </div>
                    </div>
                  </div>
                </div>';
              }
            }
            else if ($_GET['section'] == "edibles"){
              $sql = "SELECT * FROM edibles;";
              $result = mysqli_query($conn, $sql);

              if(mysqli_num_rows($result) == 0){
                echo '<p class="text-center">No Edibles</p>';

                echo '
                <div class="text-center">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#add-edible-modal">Add</a>
                <div class="modal fade" id="add-edible-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal">
                    <div class="modal-content">
                    <h3 class="text-center">Add Edible</h3>
                    <div class="col-12 row text-center">
                    <form class="add-edible-form text-center" action="includes/addEdible.inc.php" method="post" enctype="multipart/form-data">
                    <div class="wrap-input">
                      <input class="input" type="text" name="name" placeholder="Name">
                      <span class="focus-input"></span>
                    </div>
                    <div class="wrap-input">
                      <input class="input" type="text" name="price" placeholder="Unit Price">
                      <span class="focus-input"></span>
                    </div>
                    <div class="wrap-input">
                      <input class="input" type="text" name="desc" placeholder="Description">
                      <span class="focus-input"></span>
                    </div>
                    <div class="text-center">
                      <input class="input" type="file" id="photo_id" accept="image/*" name="file">
                      <label for="photo_id">Edible Photo</label>
                      <span id="upload-text">No file Chosen, yet.</span>
                      <script type="text/javascript">
                        const realFileBtn = document.getElementById("photo_id");
                        const uploadText = document.getElementById("upload-text");

                        realFileBtn.addEventListener("change", function functionName() {
                          if(realFileBtn.value){
                            uploadText.innerHTML = realFileBtn.value.match(/[\/\\\\]([\w\d\s\.\-\(\)]+)$/)[1];
                          } else {
                            uploadText.innerHTML = "No file Chosen, yet.";
                          }
                        });
                      </script>
                    </div>
                    <button class="btn btn-secondary" type="submit" name="add-edible">
                      Add
                    </button>
                    </form>
                    </div>
                    </div>
                  </div>
                </div>
              </div>';
              }
              else {
                echo '
                <table class="text-center product-table">
                  <tr>
                    <th>Name</th>
                    <th>Unit Price</th>
                  </tr>';

                  while($row = mysqli_fetch_assoc($result)){
                    if ($row['unit_price'] == null || $row['unit_price'] == 0) {$row['unit_price'] = 'n/a';}
                    else {$row['unit_price'] = '$ '.$row['unit_price'];}

                    echo '
                    <tr>
                      <td>'.$row['name'].'</td>
                      <td>'.$row['unit_price'].'</td>
                      <td>
                      <form class="delete-edible-form" action="includes/deleteEdible.inc.php" method="post">
                      <input type="hidden" name="edible-id" value="'.$row['id'].'" />
                        <button class="btn btn-primary" type="submit" name="delete-edible">
                          Remove
                        </button>
                      </form>
                      </td>
                    </tr>
                    ';
                  }
                  echo '</table>';

                  echo '
                  <div class="text-center">
                  <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#add-edible-modal">Add</a>
                  <div class="modal fade" id="add-edible-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal">
                      <div class="modal-content">
                      <h3 class="text-center">Add Edible</h3>
                      <div class="col-12 row text-center">
                      <form class="add-edible-form text-center" action="includes/addEdible.inc.php" method="post" enctype="multipart/form-data">
                      <div class="wrap-input">
                        <input class="input" type="text" name="name" placeholder="Name">
                        <span class="focus-input"></span>
                      </div>
                      <div class="wrap-input">
                        <input class="input" type="text" name="price" placeholder="Unit Price">
                        <span class="focus-input"></span>
                      </div>
                      <div class="wrap-input">
                        <input class="input" type="text" name="desc" placeholder="Description">
                        <span class="focus-input"></span>
                      </div>
                      <div class="text-center">
                        <input class="input" type="file" id="photo_id" accept="image/*" name="file">
                        <label for="photo_id">Edible Photo</label>
                        <span id="upload-text">No file Chosen, yet.</span>
                        <script type="text/javascript">
                          const realFileBtn = document.getElementById("photo_id");
                          const uploadText = document.getElementById("upload-text");

                          realFileBtn.addEventListener("change", function functionName() {
                            if(realFileBtn.value){
                              uploadText.innerHTML = realFileBtn.value.match(/[\/\\\\]([\w\d\s\.\-\(\)]+)$/)[1];
                            } else {
                              uploadText.innerHTML = "No file Chosen, yet.";
                            }
                          });
                        </script>
                      </div>
                      <button class="btn btn-secondary" type="submit" name="add-edible">
                        Add
                      </button>
                      </form>
                      </div>
                      </div>
                    </div>
                  </div>
                </div>';
              }
            }
            else if ($_GET['section'] == "extracts"){
              $sql = "SELECT * FROM extracts;";
              $result = mysqli_query($conn, $sql);

              if(mysqli_num_rows($result) == 0){
                echo '<p class="text-center">No Extracts</p>';

                echo '
                <div class="text-center">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#add-extract-modal">Add</a>
                <div class="modal fade" id="add-extract-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal">
                    <div class="modal-content">
                    <h3 class="text-center">Add Extract</h3>
                    <div class="col-12 row text-center">
                    <form class="add-edible-form text-center" action="includes/addExtract.inc.php" method="post" enctype="multipart/form-data">
                    <div class="wrap-input">
                      <input class="input" type="text" name="name" placeholder="Name">
                      <span class="focus-input"></span>
                    </div>
                    <div class="wrap-input">
                      <input class="input" type="text" name="price" placeholder="Unit Price">
                      <span class="focus-input"></span>
                    </div>
                    <div class="wrap-input">
                      <input class="input" type="text" name="desc" placeholder="Description">
                      <span class="focus-input"></span>
                    </div>
                    <div class="text-center">
                      <input class="input" type="file" id="photo_id" accept="image/*" name="file">
                      <label for="photo_id">Extract Photo</label>
                      <span id="upload-text">No file Chosen, yet.</span>
                      <script type="text/javascript">
                        const realFileBtn = document.getElementById("photo_id");
                        const uploadText = document.getElementById("upload-text");

                        realFileBtn.addEventListener("change", function functionName() {
                          if(realFileBtn.value){
                            uploadText.innerHTML = realFileBtn.value.match(/[\/\\\\]([\w\d\s\.\-\(\)]+)$/)[1];
                          } else {
                            uploadText.innerHTML = "No file Chosen, yet.";
                          }
                        });
                      </script>
                    </div>
                    <button class="btn btn-secondary" type="submit" name="add-extract">
                      Add
                    </button>
                    </form>
                    </div>
                    </div>
                  </div>
                </div>
              </div>';
              }
              else {
                echo '
                <table class="text-center product-table">
                  <tr>
                    <th>Name</th>
                    <th>Unit Price</th>
                  </tr>';

                  while($row = mysqli_fetch_assoc($result)){
                    if ($row['unit_price'] == null || $row['unit_price'] == 0) {$row['unit_price'] = 'n/a';}
                    else {$row['unit_price'] = '$ '.$row['unit_price'];}

                    echo '
                    <tr>
                      <td>'.$row['name'].'</td>
                      <td>'.$row['unit_price'].'</td>
                      <td>
                      <form class="delete-extract-form" action="includes/deleteExtract.inc.php" method="post">
                      <input type="hidden" name="extract-id" value="'.$row['id'].'" />
                        <button class="btn btn-primary" type="submit" name="delete-extract">
                          Remove
                        </button>
                      </form>
                      </td>
                    </tr>
                    ';
                  }
                  echo '</table>';

                  echo '
                  <div class="text-center">
                  <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#add-extract-modal">Add</a>
                  <div class="modal fade" id="add-extract-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal">
                      <div class="modal-content">
                      <h3 class="text-center">Add Extract</h3>
                      <div class="col-12 row text-center">
                      <form class="add-edible-form text-center" action="includes/addExtract.inc.php" method="post" enctype="multipart/form-data">
                      <div class="wrap-input">
                        <input class="input" type="text" name="name" placeholder="Name">
                        <span class="focus-input"></span>
                      </div>
                      <div class="wrap-input">
                        <input class="input" type="text" name="price" placeholder="Unit Price">
                        <span class="focus-input"></span>
                      </div>
                      <div class="wrap-input">
                        <input class="input" type="text" name="desc" placeholder="Description">
                        <span class="focus-input"></span>
                      </div>
                      <div class="text-center">
                        <input class="input" type="file" id="photo_id" accept="image/*" name="file">
                        <label for="photo_id">Extract Photo</label>
                        <span id="upload-text">No file Chosen, yet.</span>
                        <script type="text/javascript">
                          const realFileBtn = document.getElementById("photo_id");
                          const uploadText = document.getElementById("upload-text");

                          realFileBtn.addEventListener("change", function functionName() {
                            if(realFileBtn.value){
                              uploadText.innerHTML = realFileBtn.value.match(/[\/\\\\]([\w\d\s\.\-\(\)]+)$/)[1];
                            } else {
                              uploadText.innerHTML = "No file Chosen, yet.";
                            }
                          });
                        </script>
                      </div>
                      <button class="btn btn-secondary" type="submit" name="add-extract">
                        Add
                      </button>
                      </form>
                      </div>
                      </div>
                    </div>
                  </div>
                </div>';
              }
            }
          ?>
        </div>
      </div>
    </div>
  </div>
</body>
