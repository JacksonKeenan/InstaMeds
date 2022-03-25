<?php
  session_start();

  if (!isset($_SESSION['userId'])) {
    header("Location: ../login.php");
    exit();
  }
?>
<div class="offset">
    <div id="slider" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner">
        <?php
        $class_active = true;
        $dirname = "img/news/";
        $images = glob($dirname."*.png");
        foreach($images as $image) {
          ?>
            <div class="carousel-item <?php if($class_active == true){ echo 'active'; $class_active = false;} ?>"><img class="d-block w-100" src="<?php echo $image; ?>" /></div>
          <?php
        }
        ?>
      </div>
      <a class="carousel-control-prev" href="#slider" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#slider" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
</div>
