<?php
  session_start();

  if (!isset($_SESSION['userId'])) {
    header("Location: ../login.php");
    exit();
  }
?>
<head>
  <link rel="stylesheet" href="css/footer.css?version=2">
</head>
<div id="contact">
  <div class="offset">
    <footer>
      <div class="row justify-content-center">
        <div class="col-md-5 text-center">
          <img src="img/logo.png">
          <p class="footer-quote">Fresh Cannabis Right to Your Door!</p>
          <strong>Contact Info</strong>
				  <p>(123) 456-7890<br>indaMeds@gmail.com</p>
          <a href="" target="_blank"><i class="fab fa-facebook"></i></a>
          <a href="" target="_blank"><i class="fab fa-instagram"></i></a>
          <a href="" target="_blank"><i class="fab fa-twitter"></i></a>
        </div>
      </div>
      <p class="text-center copyright">IndaMeds 420. &copy; 2019</p>
    </footer>
  </div>
</div>
