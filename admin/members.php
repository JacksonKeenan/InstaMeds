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
  <title>IndaMeds ∙ Members</title>
  <link rel="stylesheet" href="/bootstrap-4.1.3-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/members.css?version=35">
  <link rel="icon" href="img/logo.png">
</head>

<!--- Script Source Files -->
<script src="/js/jquery-3.4.1.min.js"></script>
<script src="js/members.js?version=12"></script>
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
        <div class="members-wrapper">
            <div class="row">
              <div class="col-12">
                <h2 class="text-center"><i class="fas fa-user-circle"></i> Members</h2>
                <div class="members-header-underline text-center"></div>
                <div class="row">
                  <div class="col-md-3 text-center">
                  </div>
                  <div class="col-md-3 text-center">
                    <form class="member-filter-form text-center" action="includes/filterMembers.inc.php" method="post">

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
                      </div>
                      <span class="focus-input"></span>
                      <button class="btn btn-secondary" type="submit" name="filter-members-area">
                        Go
                      </button>
                    </form>
                  </div>
                  <div class="col-md-3 text-center">
                    <form class="member-filter-form" action="includes/filterMembers.inc.php" method="post">
                      <div class="wrap-input text-center">
                        <input class="input" type="text" name="search" placeholder="Search">
                        <span class="focus-input"></span>
                      </div>
                      <button class="btn btn-secondary" type="submit" name="filter-members-text">
                        Search
                      </button>
                    </form>
                  </div>
                  <div class="col-md-3 text-center">
                  </div>
                </div>
                  <?php
                  $region = "";
                  $search = "";
                  if (isset($_GET['region'])) {
                    $region = $_GET['region'];

                    if ($region == "") {
                      $sql = "SELECT * FROM users WHERE active_status=0 ORDER BY id DESC;";
                    }
                    else {
                      $sql = "SELECT * FROM users WHERE active_status=0 AND usr_area='".$region."' ORDER BY id DESC;";
                    }

                    $result = mysqli_query($conn, $sql);
                  }
                  else if (isset($_GET['search'])) {
                    $search = $_GET['search'];
                    if ($search == "") {
                      $sql = "SELECT * FROM users WHERE active_status=0 ORDER BY id DESC;";
                      $result = mysqli_query($conn, $sql);
                    }
                    else {
                      $serach = "%".$search."%";
                      $sql = "SELECT * FROM users WHERE active_status=0 AND (first_name LIKE ? OR last_name LIKE ? OR usr_email LIKE ?) ORDER BY id DESC;";

                      $stmt = mysqli_stmt_init($conn);
                      if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header("Location: ../members.php?error=sqlerror");
                        exit();
                      }
                      else {
                        mysqli_stmt_bind_param($stmt, "sss", $serach, $serach, $serach);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                      }
                    }
                  }
                  else {
                    $sql = "SELECT * FROM users WHERE active_status=0 ORDER BY id DESC;";
                    $result = mysqli_query($conn, $sql);
                  }

                  echo '
                  <table class="member-table text-center">
                    <tr>
                      <th>ID No.</th>
                      <th class = "hidden-cell">Signup</th>
                      <th class = "hidden-cell">Name</th>
                      <th class = "hidden-cell">Region</th>
                      <th class = "hidden-cell">Address</th>
                      <th class = "hidden-cell">Phone</th>
                      <th class = "hidden-cell">Email</th>
                      <th class="id-link">ID</th>
                    </tr>';

                    while($row = mysqli_fetch_assoc($result)){
                      $date = explode(" ", $row['signup-date']);
                      echo '
                      <tr>
                        <td>'.$row['id'].'</td>
                        <td class = "hidden-cell">'.$date[0].'</td>
                        <td class = "hidden-cell">-</td>
                        <td class = "hidden-cell">-</td>
                        <td class = "hidden-cell">-</td>
                        <td class = "hidden-cell">-</td>
                        <td class = "hidden-cell">'.$row['usr_email'].'</td>
                        <td class="id-link"><a href="img/photo_ids/'.$row['usr_id'].'" target="_blank">View</a></td>
                        <td><a onclick="approve_member('.$row['id'].')" class="btn btn-primary">Approve ✓ </a></td>
                        <td><a onclick="decline_member('.$row['id'].')" class="btn btn-primary">Decline X </a></td>
                      </tr>
                      ';
                    }

                    $region = "";
                    $search = "";
                    if (isset($_GET['region'])) {
                      $region = $_GET['region'];

                      if ($region == "") {
                        $sql = "SELECT * FROM users WHERE active_status=1 ORDER BY id DESC;";
                      }
                      else {
                        $sql = "SELECT * FROM users WHERE active_status=1 AND usr_area='".$region."' ORDER BY id DESC;";
                      }

                      $result = mysqli_query($conn, $sql);
                    }
                    else if (isset($_GET['search'])) {
                      $search = $_GET['search'];
                      if ($search == "") {
                        $sql = "SELECT * FROM users WHERE active_status=1 ORDER BY id DESC;";
                        $result = mysqli_query($conn, $sql);
                      }
                      else {
                        $serach = "%".$search."%";
                        $sql = "SELECT * FROM users WHERE active_status=1 AND (first_name LIKE ? OR last_name LIKE ? OR usr_email LIKE ?) ORDER BY id DESC;";

                        $stmt = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                          header("Location: ../members.php?error=sqlerror");
                          exit();
                        }
                        else {
                          mysqli_stmt_bind_param($stmt, "sss", $serach, $serach, $serach);
                          mysqli_stmt_execute($stmt);
                          $result = mysqli_stmt_get_result($stmt);
                        }
                      }
                    }
                    else {
                      $sql = "SELECT * FROM users WHERE active_status=1 ORDER BY id DESC;";
                      $result = mysqli_query($conn, $sql);
                    }

                    while($row = mysqli_fetch_assoc($result)){
                      $date = explode(" ", $row['signup-date']);
                      echo '
                      <tr>
                        <td>'.$row['id'].'</td>
                        <td class = "hidden-cell">'.$date[0].'</td>
                        <td class = "hidden-cell">'.$row['first_name'].' '.$row['last_name'].'</td>
                        <td class = "hidden-cell">'.$row['usr_area'].'</td>
                        <td class = "hidden-cell">'.$row['usr_address'].'</td>
                        <td class = "hidden-cell">'.$row['usr_phone'].'</td>
                        <td class = "hidden-cell">'.$row['usr_email'].'</td>
                        <td class="id-link"><a href="img/photo_ids/'.$row['usr_id'].'" target="_blank">View</a></td>
                        <td><a onclick="decline_member('.$row['id'].')" class="btn btn-primary">Delete X </a></td>
                      </tr>
                      ';
                    }
                  echo '</table>';
                  ?>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</body>
