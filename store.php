<?php
  session_start();

  if (!isset($_SESSION['userId'])) {
    header("Location: ../login.php");
    exit();
  }

  include_once 'includes/dbh.inc.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>IndaMeds ∙ Store</title>
  <link rel="stylesheet" href="bootstrap-4.1.3-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/store.css?version=29">
  <link rel="icon" href="img/logo.png">
</head>

<!--- Script Source Files -->
<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/store.js"></script>
<script src="bootstrap-4.1.3-dist/js/bootstrap.min.js"></script>
<script src="https://use.fontawesome.com/releases/v5.9.0/js/all.js"></script>
<!--- End of Script Source Files -->

<body data-spy="scroll" data-target="#navbarResponsive">
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
      <div class="store-wrapper">
        <div class="store-header">
        <div class="col-md-12 text-center row">
          <div class="col-md-4">
            <a href="/store.php?section=flowers" class="<?php if($_SERVER['REQUEST_URI'] == '/store.php?section=flowers'){echo 'activeSection';}?>"><i class="fas fa-cannabis fa-3x"></i><h1>Flowers</h1></a>
          </div>
          <div class="col-md-4">
            <a href="/store.php?section=edibles" class="<?php if($_SERVER['REQUEST_URI'] == '/store.php?section=edibles'){echo 'activeSection';}?>"><i class="fas fa-cookie-bite fa-3x"></i><h1>Edibles</h1></a>
          </div>
          <div class="col-md-4">
            <a href="/store.php?section=extracts" class="<?php if($_SERVER['REQUEST_URI'] == '/store.php?section=extracts'){echo 'activeSection';}?>"><i class="fas fa-tint fa-3x"></i><h1>Extracts</h1></a>
          </div>
        </div>
        </div>
        <div class="store-header-underline"></div>
        <?php
          $uri = $_SERVER['REQUEST_URI'];
          if ($uri == '/store.php?section=flowers'){
            $sql = "SELECT * FROM strains ORDER BY (CASE type WHEN 'Indica' THEN 1 WHEN 'Sativa' THEN 2 WHEN 'Hybrid' THEN 3 END) ASC;";
            $result = mysqli_query($conn, $sql);
            echo "
            <div class='col-md-12 text-center type-links'>
              <a href='#indica'>Indica</a> ∙ <a href='#sativa'>Sativa</a> ∙ <a href='#hybrid'>Hybrid</a>
            </div>";
            echo "<div class='store-header-underline'></div>";
            echo "<div class='col-md-12 row text-center'>";
            echo "<div id='indica'></div>";
            $sativa_flag = 0;
            $hybrid_flag = 0;
            $i = 0;
            while($row = mysqli_fetch_assoc($result)){
              $i++;
              $item_num = 'I' . $i;
              if($row['type'] == 'Sativa' && $sativa_flag == 0){
                $sativa_flag = 1;
                echo "<div id='sativa'></div>";
              }
              if($row['type'] == 'Hybrid' && $hybrid_flag == 0){
                $hybrid_flag = 1;
                echo "<div id='hybrid'></div>";
              }
              $name = $row['name'];
              $thc = $row['thc'];
              $cbd = $row['cbd'];
              $price_quarter = $row['price_quarter'];
              $price_half = $row['price_half'];
              $price_oz = $row['price_oz'];

              if($thc == '' || $thc == 0){$thc = '-';}
              else{$thc = $thc.' %';}
              if($cbd == '' || $cbd == 0){$cbd = '-';}
              else{$cbd = $cbd.' %';}

              if($price_quarter == null || $price_quarter == 0){$price_quarter = 'n / a';}
              else{$price_quarter = '$ '.$price_quarter;}

              if($price_half == null || $price_half == 0){$price_half = 'n / a';}
              else{$price_half = '$ '.$price_half;}

              if($price_oz == null || $price_oz == 0){$price_oz = 'n / a';}
              else{$price_oz = '$ '.$price_oz;}

              echo '<div class="col-md-4">';
              echo '
              <div class="card">
                <div class="card-body">
                  <h2 class="card-title">' . $name . '</h2>
                  <div class="text-center">
                    <img class="rounded-circle border border-light" src="img/products/strains/'.$row['img_name'].'">
                    <h3 class="strain-type">'.$row['type'].'</h3>
                    <table class="card-info">
                        <tr><th>THC</th><td>'.$thc.'</td></tr>
                        <tr><th>CBD</th><td>'.$cbd.'</td></tr>
                        <tr><th>1/4 Oz.</th><td>'.$price_quarter.'</td></tr>
                        <tr><th>1/2 Oz.</th><td>'.$price_half.'</td></tr>
                        <tr><th>1 Oz.</th><td>'.$price_oz.'</td></tr>
                    </table>
                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#' . $item_num . '-modal">View</a>
                    <div class="modal fade" id="' . $item_num . '-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header"><h4 class="modal-title">' . $row['name'] . '</h4><button type="button" class="close" data-dismiss="modal">&times;</button></div>
                            <div class="col-md-12 row text-center">
                              <div class="col-md-4">
                                <div class="col-md-12">
                                <img src="img/products/strains/'.$row['img_name'].'">
                                </div>
                                <div class="col-md-12">
                                <table class="text-center">
                                    <tr><th>THC</th><td>'.$thc.'</td></tr>
                                    <tr><th>CBD</th><td>'.$cbd.'</td></tr>
                                </table>
                                </div>
                              </div>
                              <div class="col-md-8">
                                <div class="product-info">
                                <p>'.$row['strain_desc'].'</p>
                                <div class="order-buttons">';
                                if($price_quarter != 'n / a'){
                                  echo '<a onclick="launch_toast(\''.$name.'\', \'1/4 Oz\', \''.$row['price_quarter'].'\', \''.$item_num.'\')" class="btn btn-secondary" data-toggle="" data-target="">1/4 - '.$price_quarter.'</a>';
                                }
                                if($price_half != 'n / a'){
                                  echo '<a onclick="launch_toast(\''.$name.'\', \'1/2 Oz\', \''.$row['price_half'].'\', \''.$item_num.'\')" class="btn btn-secondary" data-toggle="" data-target="">1/2 - '.$price_half.'</a>';
                                }
                                if($price_oz != 'n / a'){
                                  echo '<a onclick="launch_toast(\''.$name.'\', \'1 Oz\', \''.$row['price_oz'].'\', \''.$item_num.'\')" class="btn btn-secondary" data-toggle="" data-target="">1Oz - '.$price_oz.'</a>';
                                }
                          echo '</div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div id="'.$item_num.'" class="toast"><div id="img"><i class="fas fa-cannabis fa-2x" data-fa-transform="up-4"></i></div><div id="desc"> '.$name.' Added to Cart!</div></div>
                    </div>
                  </div>
                </div>
              </div>
              ';
              echo '</div>';
            }
          }
          else if ($uri == '/store.php?section=edibles'){
            $sql = "SELECT * FROM edibles;";
            $result = mysqli_query($conn, $sql);
            echo "<div class='col-md-12 row text-center'>";
            $i = 0;
            while($row = mysqli_fetch_assoc($result)){
              $i++;
              $item_num = 'I' . $i;
              $name = $row['name'];
              $price = $row['unit_price'];
              $quantity = $row['quantity'];
              echo '<div class="col-md-4">';
              echo '
              <div class="card">
                <div class="card-body">
                  <h2 class="card-title">' . $name . '</h2>
                  <div class="text-center">
                    <img class="rounded-circle border border-light" src="img/products/edibles/'.$row['img_name'].'">
                    <h3 class="strain-type">Edible</h3>
                    <table class="card-info">
                        <tr><th>QTY</th><td> '.$quantity.'</td></tr>
                        <tr><th>Price</th><td>$ '.$price.'</td></tr>
                    </table>
                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#' . $item_num . '-modal">View</a>
                    <div class="modal fade" id="' . $item_num . '-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header"><h4 class="modal-title">' . $row['name'] . '</h4><button type="button" class="close" data-dismiss="modal">&times;</button></div>
                            <div class="col-md-12 row">
                              <div class="col-md-4">
                                <div class="col-md-12">
                                <img src="img/products/edibles/'.$row['img_name'].'">
                                </div>
                              </div>
                              <div class="col-md-8">
                                <div class="product-info">
                                <p>'.$row['item_desc'].'</p>
                                <div class="order-buttons">
                                <a onclick="launch_toast(\''.$row['name'].'\', \'1\', \''.$price.'\', \''.$item_num.'\')" class="btn btn-secondary" data-toggle="" data-target="">$ '.$price.'</a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div id="'.$item_num.'" class="toast"><div id="img"><i class="fas fa-cannabis fa-2x" data-fa-transform="up-4"></i></div><div id="desc"> '.$name.' Added to Cart!</div></div>
                    </div>
                  </div>
                </div>
              </div>
              ';
              echo '</div>';
            }
          }
          else if ($uri == '/store.php?section=extracts'){
            $sql = "SELECT * FROM extracts;";
            $result = mysqli_query($conn, $sql);
            echo "<div class='col-md-12 row text-center'>";
            $i = 0;
            while($row = mysqli_fetch_assoc($result)){
              $i++;
              $item_num = 'I' . $i;
              $name = $row['name'];
              $price = $row['unit_price'];
              $quantity = $row['quantity'];
              echo '<div class="col-md-4">';
              echo '
              <div class="card">
                <div class="card-body">
                  <h2 class="card-title">' . $name . '</h2>
                  <div class="text-center">
                    <img class="rounded-circle border border-light" src="img/products/extracts/'.$row['img_name'].'">
                    <h3 class="strain-type">Extract</h3>
                    <table class="card-info">
                        <tr><th>QTY</th><td> '.$quantity.'</td></tr>
                        <tr><th>Price</th><td>$ '.$price.'</td></tr>
                    </table>
                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#' . $item_num . '-modal">View</a>
                    <div class="modal fade" id="' . $item_num . '-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header"><h4 class="modal-title">' . $row['name'] . '</h4><button type="button" class="close" data-dismiss="modal">&times;</button></div>
                            <div class="col-md-12 row">
                              <div class="col-md-4">
                                <div class="col-md-12">
                                <img src="img/products/extracts/'.$row['img_name'].'">
                                </div>
                              </div>
                              <div class="col-md-8">
                                <div class="product-info">
                                <p>'.$row['item_desc'].'</p>
                                <div class="order-buttons">
                                <a onclick="launch_toast(\''.$row['name'].'\', \'1\', \''.$price.'\', \''.$item_num.'\')" class="btn btn-secondary" data-toggle="" data-target="">$ '.$price.'</a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div id="'.$item_num.'" class="toast"><div id="img"><i class="fas fa-cannabis fa-2x" data-fa-transform="up-4"></i></div><div id="desc"> '.$name.' Added to Cart!</div></div>
                    </div>
                  </div>
                </div>
              </div>
              ';
              echo '</div>';
            }
          }
        ?>
    </div>
  </div>
</div>
</body>

<script>
(function ($) {
    var navbar = $('.navbar');
    $(window).scroll(function () {
        var st = $(this).scrollTop();
        // Scroll down
        if (st > 40) {
          navbar.addClass('navbar-nontransparent');
        }

        // Reached top
        else {
            navbar.removeClass('navbar-nontransparent');
        }
        lastScrollTop = st;
    });
})(jQuery);
</script>
