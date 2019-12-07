<?php
  session_start();

  if (!isset($_SESSION['userId'])) {
    header("Location: ../login.php");
    exit();
  }
?>
<head>
  <link rel="stylesheet" href="css/faq.css?version=2">
</head>

<div id="faq" class="faq-pad">
  <div class="fixed-background">
    <div class="row dark text-center">
      <div class="col-12">
        <h3 class="heading-faq">FAQ</h3>
        <div class="heading-underline-faq"></div>
      </div>
      <div class="col-md-4">
        <details>
          <summary>
            <h2>How do I place an order?</h2>
          </summary>
          <p>Lorem ipsum dolor sit amet, vocent viderer tamquam his ad, mei ut atqui gubergren. Aperiri appareat reprehendunt an cum, ullum dicta debet has te. Has posse doming scribentur ex, qui ea rebum soleat. Vel aeterno aperiri in.</p>
        </details>
      </div>
      <div class="col-md-4">
        <details>
          <summary>
            <h2>How much can I order?</h2>
          </summary>
          <p>Lorem ipsum dolor sit amet, vocent viderer tamquam his ad, mei ut atqui gubergren. Aperiri appareat reprehendunt an cum, ullum dicta debet has te. Has posse doming scribentur ex, qui ea rebum soleat. Vel aeterno aperiri in.</p>
        </details>
      </div>
      <div class="col-md-4">
        <details>
          <summary>
            <h2>How long will my order take?</h2>
          </summary>
          <p>Lorem ipsum dolor sit amet, vocent viderer tamquam his ad, mei ut atqui gubergren. Aperiri appareat reprehendunt an cum, ullum dicta debet has te. Has posse doming scribentur ex, qui ea rebum soleat. Vel aeterno aperiri in.</p>
        </details>
      </div>
    </div>
    <div class="row dark text-center">
      <div class="col-md-4">
        <details>
          <summary>
            <h2>Which payment methods are accepted?</h2>
          </summary>
          <p>Lorem ipsum dolor sit amet, vocent viderer tamquam his ad, mei ut atqui gubergren. Aperiri appareat reprehendunt an cum, ullum dicta debet has te. Has posse doming scribentur ex, qui ea rebum soleat. Vel aeterno aperiri in.</p>
        </details>
      </div>
      <div class="col-md-4">
        <details>
          <summary>
            <h2>I didn't receive my order</h2>
          </summary>
          <p>Lorem ipsum dolor sit amet, vocent viderer tamquam his ad, mei ut atqui gubergren. Aperiri appareat reprehendunt an cum, ullum dicta debet has te. Has posse doming scribentur ex, qui ea rebum soleat. Vel aeterno aperiri in.</p>
        </details>
      </div>
      <div class="col-md-4">
        <details>
          <summary>
            <h2>I didn't get what I ordered</h2>
          </summary>
          <p>Lorem ipsum dolor sit amet, vocent viderer tamquam his ad, mei ut atqui gubergren. Aperiri appareat reprehendunt an cum, ullum dicta debet has te. Has posse doming scribentur ex, qui ea rebum soleat. Vel aeterno aperiri in.</p>
        </details>
      </div>
    </div>
    <div class="fixed-wrap">
      <div class="fixed" style="background-image: url('img/bg-01-mask.jpg');"></div>
    </div>
  </div>
</div>
