<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/WEDASM2/config/connect.php';
$conn = getDatabaseConnection();
if (!$conn) {
    die("Database connection failed!");
}
session_start();
if (isset($_SESSION['user_id'])) {
    // If logged in, redirect to index.php page
    header('Location: /WEDASM2/index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check if email and password are correct
    $stmt = $conn->prepare("SELECT u.user_id, u.email, u.password, r.name AS role_name
                            FROM users u
                            JOIN roles r ON u.role_id = r.role_id
                            WHERE u.email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
      
        $_SESSION['user_id'] = $user['user_id']; 

   
        $response = [
            'user' => [
                'email' => $user['email'],
                'role' => $user['role_name']
            ]
        ];

        echo json_encode($response); 
        exit();
    } else {
        $error_message = "Incorrect username or password.";
        echo json_encode(['error' => $error_message]);
        exit();
    }
}
?>

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

    <!-- Custom CSS for logo alignment -->
    <style>
        /* Center the logo */
        .logo img {
            display: block;
            margin: 0 auto;
            max-width: 100%;
            height: auto;
        }
    </style>

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
                        <h2 class="text-center">Welcome Back</h2>
                        <!-- Hiển thị lỗi nếu có -->
                        <?php if (!empty($error_message)): ?>
                            <div class="alert alert-danger">
                                <?php echo htmlspecialchars($error_message); ?>
                            </div>
                        <?php endif; ?>
                        <form class="text-left clearfix" action="" method="POST">
                            <div class="form-group">
                                <input type="text" name="email" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-main text-center">Login</button>
                            </div>
                        </form>


                        <p class="mt-20">New in this site? <a href="sign-up.php">Create New Account</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script>
    // Attach an event listener to the form's submit event
    document.querySelector('form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        const email = document.querySelector('input[name="email"]').value.trim();
        const password = document.querySelector('input[name="password"]').value.trim();

        // Client-side validation
        if (!email || !password) {
            alert("Email and password fields cannot be empty.");
            return;
        }

        // Email format validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            alert("Please enter a valid email address.");
            return;
        }

        // Password length validation
        if (password.length < 6) {
            alert("Password must be at least 6 characters long.");
            return;
        }

        // Send the data to the server using AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'sign-in.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);

                if (response.user) {
                    // Success: Save user info to localStorage
                    const userInfo = {
                        email: response.user.email,
                        role: response.user.role
                    };
                    localStorage.setItem('user', JSON.stringify(userInfo));

                    // Show success notification
                    alert("Login successful! Redirecting to the homepage...");
                    
                    // Redirect to the main page
                    window.location.href = '/WEDASM2/index.php';
                } else if (response.error) {
                    // Show server error message
                    alert(response.error);
                } else {
                    alert("An unknown error occurred. Please try again.");
                }
            } else {
                alert("Failed to connect to the server. Please try again later.");
            }
        };

        // Encode the data and send it
        xhr.send(`email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`);
    });
</script>
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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCC72vZw-6tGqFyRhhg5CkF2fqfILn2Tsw"></script>
    <script type="text/javascript" src="plugins/google-map/gmap.js"></script>

    <!-- Main Js File -->
    <script src="js/script.js"></script>


</body>

</html>
