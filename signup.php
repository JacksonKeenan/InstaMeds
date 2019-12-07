<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>IndaMeds ∙ Sign Up</title>
  <link rel="stylesheet" href="bootstrap-4.1.3-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/login.css?version=10">
  <link rel="icon" href="img/logo.png">
</head>

<body>
  <div class="login-page" style="background-image: url('img/bg-01.jpg');">
      <div class="login-wrapper">
        <form class="login-form" action="includes/signup.inc.php" method="post" enctype="multipart/form-data">
          <!--- Title --->
          <div class="text-center logo">
            <img src="img/logo.png">
          </div>

          <?php
            if (isset($_GET['error'])) {
              if ($_GET['error'] == "emptyfields") {
                echo '
                <div class="text-center">
                  <p class="field-error">Please fill in all fields !</p>
                </div>';
              }
              else if ($_GET['error'] == "invalidmailpass") {
                echo '
                <div class="text-center">
                  <p class="field-error">Invalid Email !</p>
                  <p class="field-error">Invalid Password !</p>
                </div>';
              }
              else if ($_GET['error'] == "invalidmail") {
                echo '
                <div class="text-center">
                  <p class="field-error">Invalid Email !</p>
                </div>';
              }
              else if ($_GET['error'] == "invalidpass") {
                echo '
                <div class="text-center">
                  <p class="field-error">Invalid Password !</p>
                </div>';
              }
              else if ($_GET['error'] == "passcheck") {
                echo '
                <div class="text-center">
                  <p class="field-error">Please make sure your passwords match !</p>
                </div>';
              }
              else if ($_GET['error'] == "sqlerror") {
                echo '
                <div class="text-center">
                  <p class="field-error">Database Error !</p>
                </div>';
              }
              else if ($_GET['error'] == "emailtaken") {
                echo '
                <div class="text-center">
                  <p class="field-error">An account with that email already exists !</p>
                </div>';
              }
              else if ($_GET['error'] == "filetype") {
                echo '
                <div class="text-center">
                  <p class="field-error">Only image files are accepted for IDs !</p>
                </div>';
              }
              else if ($_GET['error'] == "filesize") {
                echo '
                <div class="text-center">
                  <p class="field-error">ID Image size too large !</p>
                </div>';
              }
              else if ($_GET['error'] == "fileerror") {
                echo '
                <div class="text-center">
                  <p class="field-error">Error uploading ID !</p>
                </div>';
              }
            }
            else if ($_GET["signup"] == "success") {
              echo '
              <div class="text-center">
                <p class="field-error">Signup successful !</p>
              </div>';
            }
          ?>

          <!--- Email Input --->
          <div class="wrap-input">
            <input class="input" type="text" name="email" placeholder="Email">
            <span class="focus-input"></span>
          </div>

          <!--- Password Input --->
          <div class="wrap-input">
            <input class="input" type="password" name="password" placeholder="Password">
            <span class="focus-input"></span>
          </div>

          <!--- Confirm Password Input --->
          <div class="wrap-input">
            <input class="input" type="password" name="password-confirm" placeholder="Confirm Password">
            <span class="focus-input"></span>
          </div>

          <!--- ID Input --->
          <div class="wrap-input text-center">
            <input class="input" type="file" id="photo_id" accept="image/*" name="file">
            <label for="photo_id">Photo ID<i class="fas fa-id-card fa-2x" data-fa-transform="right-4"></i></label>
            <span id="upload-text">No file Chosen, yet.</span>
            <script type="text/javascript">
              const realFileBtn = document.getElementById("photo_id");
              const uploadText = document.getElementById("upload-text");

              realFileBtn.addEventListener("change", function functionName() {
                if(realFileBtn.value){
                  uploadText.innerHTML = realFileBtn.value.match(/[\/\\]([\w\d\s\.\-\(\)]+)$/)[1];
                } else {
                  uploadText.innerHTML = "No file Chosen, yet.";
                }
              });
            </script>
          </div>

          <!--- Sign-Up Button --->
          <div class="container-login-form-btn">
            <button class="login-form-btn" type="submit" name="signup-submit">
              Sign Up
            </button>
          </div>
        </form>

        <!--- Sign-Up --->
        <div class="text-center">
          <p class="noMember">
            Already a Member?
          </p>
        </div>
        <div class="text-center">
          <a href="/" class="signUp">
            Sign In
          </a>
        </div>
      </div>
    </div>
<!--- Script Source Files -->
<script src="js/jquery-3.4.1.min.js"></script>
<script src="bootstrap-4.1.3-dist/js/bootstrap.min.js"></script>
<script src="https://use.fontawesome.com/releases/v5.9.0/js/all.js"></script>
<!--- End of Script Source Files -->
</body>
</html>
