<?php
  session_start();

  if (!isset($_SESSION['userId'])) {
    header("Location: ../login.php");
    exit();
  }
  else if(isset($_SESSION['signUpFlag'])) {
    header("Location: ../information.php");
    exit();
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>IndaMeds</title>
  <link rel="stylesheet" href="bootstrap-4.1.3-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/index.css?version=14">
  <link rel="icon" href="img/logo.png">
</head>

<body data-spy="scroll" data-target="#navbarResponsive">
  <!--- Home Section ---->
  <div id="home">

    <?php
      require('header.php');
    ?>

  	<!-- Landing Page --->
    <div class="video-background">
  		<div class="video-wrap">
  			<div id="video">
  				<video id="bgvid" autoplay loop muted playsinline webkit-playsinline>
  					<source src="img/bg-video.mp4" type="video/mp4">
  				</video>
  			</div>
  		</div>
  	</div>
    <div class="logo row">
      <div class="col-md-4">
        <img src="img/logo_2.png">
        <div class="text-center bounce">
          <i class="fa fa-chevron-down fa-2x"></i>
        </div>
  		</div>
  	</div>
  </div>
  <!--- Landing Page END --->

  <?php
    require('about.php');
    require('news.php');
    require('menu.php');
    require('faq.php');
    require('footer.php');
  ?>

</body>
</html>
<!--- Script Source Files -->
<script src="js/jquery-3.4.1.min.js"></script>
<script src="bootstrap-4.1.3-dist/js/bootstrap.min.js"></script>
<script src="https://use.fontawesome.com/releases/v5.9.0/js/all.js"></script>
<!--- End of Script Source Files -->

<script>
(function ($) {
    var navbar = $('.navbar');
    $(window).scroll(function () {
        var st = $(this).scrollTop();
        // Scroll down
        if (st > 800) {
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
