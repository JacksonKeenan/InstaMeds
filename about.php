<?php
  session_start();

  if (!isset($_SESSION['userId'])) {
    header("Location: ../login.php");
    exit();
  }
?>
<head>
  <link rel="stylesheet" href="css/about.css?version=11">
</head>
<div id="about" class="offset">
    <div class="fixed-background">
      <div class="row dark text-center">
        <div class="col-12">
          <h3 class="heading-faq">About IndaMeds</h3>
          <div class="heading-underline-about"></div>
        </div>
      </div>
      <div class="row dark text-center">
        <div class="col-md-6 about-vr">
          <div class="about-txt">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vitae venenatis turpis, id pharetra enim. Maecenas luctus massa eleifend eros accumsan tempor. Duis iaculis nec ligula id iaculis. Nunc laoreet nisi non tempor bibendum. Nulla pharetra mi ut libero fermentum consectetur. Nunc condimentum sem ut aliquam scelerisque. Sed ullamcorper augue nunc, ut iaculis magna blandit tempus. Nam tincidunt elit eu lobortis commodo. Donec libero felis, lobortis ac feugiat id, pretium at erat.</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam cursus massa nibh, et molestie magna sodales quis.</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="about-info">
            <div class="row">
            <div class="col-md-6">
              <i class="fas fa-map-marked-alt fa-4x" data-fa-transform="up-5.5 right-.5"></i>
              <p>Ontario, Canada</p>
            </div>
            <div class="col-md-6">
              <i class="fas fa-clock fa-4x" data-fa-transform="up-4"></i>
              <table class="hours">
                  <tr><th>Mon-Thurs</th><td>10:00am-12:00am</td></tr>
                  <tr><th>Friday</th><td>10:00am-03:00am</td></tr>
                  <tr><th>Saturday</th><td>12:00pm-03:00am</td></tr>
                  <tr><th>Sunday</th><td>12:00pm-02:00am</td></tr>
              </table>
            </div>
          </div>
          </div>
        </div>
      <div class="fixed-wrap">
        <div class="fixed" style="background-image: url('img/bg-02-mask.jpg');"></div>
      </div>
    </div>
  </div>
</div>
