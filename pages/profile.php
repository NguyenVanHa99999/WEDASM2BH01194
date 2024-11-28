<script>
    // Lấy thông tin user từ localStorage và lưu email vào cookie
    const user = JSON.parse(localStorage.getItem('user'));
    if (user && user.email) {
        document.cookie = `user_email=${user.email};path=/`;
    }
</script>

<?php
// Kết nối cơ sở dữ liệu
require_once $_SERVER['DOCUMENT_ROOT'] . '/WEDASM2/config/connect.php';
$conn = getDatabaseConnection();
if (!$conn) {
    die("Kết nối cơ sở dữ liệu không thành công!");
}

// Lấy email từ cookie
$user_email = isset($_COOKIE['user_email']) ? $_COOKIE['user_email'] : null;

// Khởi tạo thông tin mặc định
$user_full_name = "Guest";
$user_phone = "N/A";
$user_address = "N/A"; // Đảm bảo giá trị mặc định là "N/A"

// Nếu có email, truy vấn thông tin người dùng
if ($user_email) {
    $stmt = $conn->prepare("SELECT full_name, phone, address FROM users WHERE email = :email");
    $stmt->bindParam(':email', $user_email, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $user_full_name = $user['full_name'];
        $user_phone = $user['phone'];
        // Kiểm tra xem trường 'address' có tồn tại trong kết quả không
        $user_address = isset($user['address']) ? $user['address'] : "N/A"; // Nếu không có, sử dụng "N/A"
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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="/WEDASM2/images/Caesium.png" />

  
  <!-- Themefisher Icon font -->
  <link rel="stylesheet" href="../plugins/themefisher-font/style.css">
  <!-- bootstrap.min css -->
  <link rel="stylesheet" href="../plugins/bootstrap/css/bootstrap.min.css">
  
  <!-- Animate css -->
  <link rel="stylesheet" href="../plugins/animate/animate.css">
  <!-- Slick Carousel -->
  <link rel="stylesheet" href="../plugins/slick/slick.css">
  <link rel="stylesheet" href="../plugins/slick/slick-theme.css">
  
  <!-- Main Stylesheet -->
  <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../styles/main.css">

</head>

<body id="body">

 <?php include '../components/header.php'; ?>
    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <h1 class="page-name">USER</h1>
                        <ol class="breadcrumb">
                            <li><a href="index.php">Home</a></li>
                            <li class="active">Profile</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="user-dashboard page-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="dashboard-wrapper dashboard-user-profile">
                        <div class="media">
                            <div class="pull-left text-center">
                                <img id="profileImage" class="media-object user-img"
                                   src="../../images/User.gif"
                                    alt="Image">
                                <button id="changeImageButton" class="btn btn-transparent mt-20">Change Image</button>
                                <input type="file" id="imageUpload" accept="image/*" style="display: none;">
                            </div>
                            <div class="media-body">
                                <ul class="user-profile-list">
                                    <li><span>Name:</span> <span id="displayEmail"> <?= htmlspecialchars($user_full_name); ?></span></li>
                                    <li><span>Email:</span> <span id="displayEmail"> <?= htmlspecialchars($user_email); ?></span></li>
                                    <li><span>Phone:</span> <span id="displayPhone"><?= htmlspecialchars($user_phone); ?></span></li>
                                    <li><span>Address:</span> <span id="displayPhone"><?= htmlspecialchars($user_address); ?></span></li>
                                </ul>
                                  <ul>
    

    </ul>
                                <button class="btn btn-primary mt-3" data-toggle="modal" data-target="#editProfileModal"
                                    style="margin-left: 800px;">Edit Profile</button>
                            </div>
                            <style>
                                .user-profile-list {
                                    list-style: none;
                                    padding: 0;
                                }

                                .user-profile-list li {
                                    display: flex;
                                    justify-content: space-between;
                                    padding: 5px 0;
                                    border-bottom: 1px solid #e0e0e0;
                                }

                                .user-profile-list li span:first-child {
                                    font-weight: bold;
                                    width: 150px;
                                    /* Độ rộng cố định cho nhãn */
                                }

                                .user-profile-list li span:last-child {
                                    flex-grow: 1;
                                    /* Chiếm khoảng trống còn lại */
                                    text-align: right;
                                }
                            </style>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editProfileForm">

                        <div class="form-group">
                            <label for="editName">Full Name</label>
                            <input type="text" class="form-control" id="editName" value="<?= htmlspecialchars($user_full_name); ?>">
                        </div>
                        <div class="form-group">
                            <label for="editPhone">Phone</label>
                            <input type="text" class="form-control" id="editPhone" value="<?= htmlspecialchars($user_phone); ?>">
                        </div>
                        <div class="form-group">
                            <label for="editAddress">Address</label>
                            <input type="text" class="form-control" id="editAddress" value="<?= htmlspecialchars($user_address); ?>">
                        </div>

                        <button type="button" class="btn btn-primary" onclick="saveChanges()">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



<footer class="footer section text-center">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<ul class="social-media">
						<li>
							<a href="https://www.facebook.com/nobelg.ha/">
								<i class="tf-ion-social-facebook"></i>
							</a>
						</li>
						<li>
							<a href="https://www.instagram.com/nvh.201/">
								<i class="tf-ion-social-instagram"></i>
							</a>
						</li>
						<li>
							<a href="https://x.com/NguynvnH1233663">
								<i class="tf-ion-social-twitter"></i>
							</a>
						</li>
						<li>
							<a href="https://www.pinterest.com/nguyenduyha6600185/">
								<i class="tf-ion-social-pinterest"></i>
							</a>
						</li>
					</ul>
					
					<p class="copyright-text">2024 &copy; Designed by BTEC Student Nguyen Van Ha <a
							href="https://www.facebook.com/nobelg.ha/" target="_blank">Facebook</a></p>

				</div>
			</div>
		</div>
	</footer>
                                
    <script>
        // Function to open file selector and update profile image
        document.getElementById('changeImageButton').addEventListener('click', function () {
            document.getElementById('imageUpload').click();
        });

        document.getElementById('imageUpload').addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('profileImage').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        // Function to save changes made in the modal to profile details
        // Lưu thay đổi thông tin hồ sơ
     function saveChanges() {
    const data = {
        full_name: document.getElementById('editName').value,
        phone: document.getElementById('editPhone').value,
        address: document.getElementById('editAddress').value,
    };

    fetch('/WEDASM2/utils/update_profile.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data),
    })
        .then(response => {
            // Kiểm tra nếu phản hồi từ server có trạng thái không hợp lệ
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
         .then(result => {
            if (result.status === 'success') {
                // Hiển thị thông báo thành công
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: result.message,
                    confirmButtonText: 'OK',
                }).then(() => {
                    // Reload trang sau khi người dùng ấn OK
                    location.reload();
                });
            } else {
                // Hiển thị thông báo lỗi từ server
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: result.message || 'Something went wrong.',
                    confirmButtonText: 'Try Again',
                });
            }
        })
        .catch(error => {
            console.error('Error updating profile:', error);
            // Hiển thị thông báo lỗi không mong muốn
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred. Please try again.',
                confirmButtonText: 'Try Again',
            });
        });
}



    </script>


    <script src="../plugins/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.1 -->
    <script src="../plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- Bootstrap Touchpin -->
    <script src="../plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
    <!-- Instagram Feed Js -->
    <script src="../plugins/instafeed/instafeed.min.js"></script>
    <!-- Video Lightbox Plugin -->
    <script src="../plugins/ekko-lightbox/dist/ekko-lightbox.min.js"></script>
    <!-- Count Down Js -->
    <script src="../plugins/syo-timer/build/jquery.syotimer.min.js"></script>

    <!-- slick Carousel -->
    <script src="../plugins/slick/slick.min.js"></script>
    <script src="../plugins/slick/slick-animation.min.js"></script>

    <!-- Google Mapl -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCV-Pn9ApMuIanKJGMe4yVeZEyrY9aC9yQ"></script>
    <script type="text/javascript" src="plugins/google-map/gmap.js"></script>

    <!-- Main Js File -->
    <script src="../js/script.js"></script>



</body>

</html>