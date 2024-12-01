<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Basic Page Needs ================================================== -->
  <meta charset="utf-8">
  <title>Forgot Password - VANHASHOP</title>

  <!-- Mobile Specific Metas ================================================== -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <meta name="author" content="Themefisher">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- Favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="/WEDASM2/images/Caesium.png" />

  <!-- CSS -->
  <link rel="stylesheet" href="../../plugins/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../css/style.css">

  <!-- JavaScript Validation -->
  <script>
    function validateForm() {
      const email = document.forms["forgetForm"]["email"].value.trim();
      const errorMessage = document.getElementById("error-message");

      errorMessage.innerHTML = "";

      if (email === "") {
        errorMessage.innerHTML = "Please enter your email address.";
        return false;
      }

      // Validate email format
      const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
      if (!emailRegex.test(email)) {
        errorMessage.innerHTML = "Invalid email format.";
        return false;
      }

      return true;
    }
  </script>
</head>

<body id="body">
  <!-- Navbar -->
  <section class="menu">
    <nav class="navbar navigation">
      <div class="container">
        <div class="navbar-header">
          <h2 class="menu-title">Menu</h2>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
            aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div><!-- / .navbar-header -->

        <!-- Navbar Links -->
        <div id="navbar" class="navbar-collapse collapse text-center">
          <ul class="nav navbar-nav">
            <li><a href="/WEDASM2/index.php">Home</a></li>
            <li><a href="/WEDASM2/pages/auth/sign-in.php">Login</a></li>
            <li><a href="/WEDASM2/pages/auth/sign-up.php">Register</a></li>
          </ul>
        </div>
      </div>
    </nav>
  </section>

  <!-- Main Section -->
  <section class="signin-page account">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <div class="block text-center">
            <a class="logo" href="/WEDASM2/index.php">
              <img src="../../images/logo.png" alt="logo">
            </a>
            <h2 class="text-center">Forgot Your Password?</h2>
            <p class="text-center">Enter your email address below, and we will send you instructions to reset your password.</p>

            <!-- Success or Error messages -->
            <?php if (isset($_SESSION['success_message'])): ?>
              <div class="alert alert-success">
                <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
              </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error_message'])): ?>
              <div class="alert alert-danger">
                <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
              </div>
            <?php endif; ?>

            <!-- Form -->
            <form name="forgetForm" class="text-left clearfix" action="/WEDASM2/utils/forgot_password_process.php" method="POST" onsubmit="return validateForm()">
              <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Enter your email address" required>
              </div>
              <div id="error-message" class="text-danger mb-3"></div>
              <div class="text-center">
                <button type="submit" class="btn btn-main text-center">Send Reset Link</button>
              </div>
            </form>
            <p class="mt-20">Remember your password? <a href="sign-in.php">Login</a></p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <style>
    /* Center the logo */
    .logo img {
      display: block;
      margin: 0 auto;
      max-width: 100%;
      height: auto;
    }
  </style>

  <!-- Essential Scripts -->
  <script src="../../plugins/jquery/dist/jquery.min.js"></script>
  <script src="../../plugins/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>