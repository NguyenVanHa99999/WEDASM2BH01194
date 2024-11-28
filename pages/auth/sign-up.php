<?php
session_start();
if (isset($_SESSION['user_id'])) {
  // Nếu đã đăng nhập, chuyển hướng về trang index.php
  header('Location: /WEDASM2/index.php');
  exit();
} ?>
<!DOCTYPE html>

<html lang="en">

<head>

  <!-- Basic Page Needs
  ================================================== -->
  <meta charset="utf-8">
  <title>VANHASHOP | E-commerce </title>

  <!-- Mobile Specific Metas
  ================================================== -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Construction Html5 Template">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <meta name="author" content="Themefisher">
  <meta name="generator" content="Themefisher Constra HTML Template v1.0">

  <!-- Favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="/WEDASM2/images/Caesium.png" />


  <!-- Themefisher Icon font -->
  <link rel="stylesheet" href="../../plugins/themefisher-font/style.css">
  <!-- bootstrap.min css -->
  <link rel="stylesheet" href="../../plugins/bootstrap/css/bootstrap.min.css">

  <!-- Animate css -->
  <link rel="stylesheet" href="../../plugins/animate/animate.css">
  <!-- Slick Carousel -->
  <link rel="stylesheet" href="../../plugins/slick/slick.css">
  <link rel="stylesheet" href="../../plugins/slick/slick-theme.css">

  <!-- Main Stylesheet -->
  <link rel="stylesheet" href="../../css/style.css">
  <link rel="stylesheet" href="../../styles/main.css">
   <script>
    function validateForm() {
      const fullName = document.forms["registerForm"]["full_name"].value.trim();
      const email = document.forms["registerForm"]["email"].value.trim();
      const password = document.forms["registerForm"]["password"].value;
      const confirmPassword = document.forms["registerForm"]["confirm_password"].value;
      const errorMessage = document.getElementById("error-message");

      errorMessage.innerHTML = "";

      if (fullName === "" || email === "" || password === "" || confirmPassword === "") {
        errorMessage.innerHTML = "Vui lòng điền đầy đủ thông tin.";
        return false;
      }

      if (password.length < 6) {
        errorMessage.innerHTML = "Mật khẩu phải có ít nhất 6 ký tự.";
        return false;
      }

      if (password !== confirmPassword) {
        errorMessage.innerHTML = "Mật khẩu xác nhận không khớp.";
        return false;
      }

      return true;
    }
  </script>
</head>

<body id="body">
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

            <!-- Home -->
            <li class="dropdown ">
              <a href="<?php echo '/WEDASM2/index.php'; ?>">Home</a>
            </li><!-- / Home -->





            <!-- Pages -->
            <li class="dropdown full-width dropdown-slide">
              <a href="#!" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                data-delay="350" role="button" aria-haspopup="true" aria-expanded="false">Pages <span
                  class="tf-ion-ios-arrow-down"></span></a>
              <div class="dropdown-menu">
                <div class="row">



                  <!-- Contact -->
                  <div class="col-sm-3 col-xs-12">
                    <ul>
                      <li class="dropdown-header">Dashboard</li>
                      <li role="separator" class="divider"></li>
                      <li><a href="<?php echo '/WEDASM2/dashboard/home.php' ?>">Users manager</a></li>
                      <li><a href="<?php echo '/WEDASM2/dashboard/order.php' ?>">Orders manager</a></li>

                    </ul>
                  </div>

                  <!-- Utility -->
                  <div class="col-sm-3 col-xs-12">
                    <ul>
                      <li class="dropdown-header">Utility</li>
                      <li role="separator" class="divider"></li>
                      <li><a href="<?php echo '/WEDASM2/pages/auth/sign-in.php'; ?>">Login </a></li>
                      <li><a href="<?php echo '/WEDASM2/pages/auth/sign-up.php'; ?>">Register </a></li>

                    </ul>
                  </div>

                  <!-- Mega Menu -->
                  <div class="col-sm-3 col-xs-12">
                    <a href="https://www.facebook.com/nobelg.ha/" target="_blank">
                      <img class="img-responsive"
                        src="/WEDASM2/images/page.png"
                        alt="menu image" />
                    </a>
                  </div>
                  <div class="col-sm-3 col-xs-12">
                    <a href="#shop-section" target="_blank">
                      <img class="img-responsive" src="https://cdn.mobilecity.vn/mobilecity-vn/images/2024/05/hinh-nen-gaming-top-200.jpg.webp" alt="menu image 2" />
                    </a>
                  </div>
                </div><!-- / .row -->
              </div><!-- / .dropdown-menu -->
            </li><!-- / Pages -->

          </ul><!-- / .nav .navbar-nav -->

        </div>
        <!--/.navbar-collapse -->
      </div><!-- / .container -->
    </nav>
  </section>
  <section class="signin-page account">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <div class="block text-center">
            <a class="logo" href="index.php">
              <img src="../../images/logo.png" alt="logo">
            </a>
            <h2 class="text-center">Create Your Account</h2>
            <form name="registerForm" class="text-left clearfix" action="<?php echo '/WEDASM2/utils/register_process.php'; ?>" method="POST" onsubmit="return validateForm()">
              <div class="form-group">
                <input type="text" name="full_name" class="form-control" placeholder="Nguyen van A" required>
              </div>
              <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="@gmail.com" required>
              </div>
              <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
              </div>
              <div class="form-group">
                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
              </div>
              <div id="error-message" class="text-danger mb-3"></div>
              <div class="text-center">
                <button type="submit" class="btn btn-main text-center">Register</button>
              </div>
            </form>
            <p class="mt-20">Already have an account ?<a href="sign-in.php"> Login</a></p>
            <p><a href="forget-password.php"> Forgot your password?</a></p>
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
  <!-- 
    Essential Scripts
    =====================================-->

  <!-- Main jQuery -->
  <script src="plugins/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.1 -->
  <script src="plugins/bootstrap/js/bootstrap.min.js"></script>
  <!-- Bootstrap Touchpin -->
  <script src="plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
  <!-- Instagram Feed Js -->
  <script src="plugins/instafeed/instafeed.min.js"></script>
  <!-- Video Lightbox Plugin -->
  <script src="plugins/ekko-lightbox/dist/ekko-lightbox.min.js"></script>
  <!-- Count Down Js -->
  <script src="plugins/syo-timer/build/jquery.syotimer.min.js"></script>

  <!-- slick Carousel -->
  <script src="plugins/slick/slick.min.js"></script>
  <script src="plugins/slick/slick-animation.min.js"></script>

  <!-- Google Mapl -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCV-Pn9ApMuIanKJGMe4yVeZEyrY9aC9yQ"></script>
  <script type="text/javascript" src="plugins/google-map/gmap.js"></script>

  <!-- Main Js File -->
  <script src="js/script.js"></script>



</body>

</html>