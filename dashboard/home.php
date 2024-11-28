<?php
// Bắt đầu session
session_start();

// Kết nối cơ sở dữ liệu
require_once $_SERVER['DOCUMENT_ROOT'] . '/WEDASM2/config/connect.php';
$conn = getDatabaseConnection();
// Kiểm tra kết nối cơ sở dữ liệu
if (!$conn) {
    die("Kết nối cơ sở dữ liệu không thành công!");
}

// Lấy danh sách người dùng
$stmt = $conn->prepare("SELECT user_id, email, full_name, phone, address, role_id FROM users");

$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Basic Page Needs ================================================== -->
    <meta charset="utf-8">
    <title>VANHASHOP | E-commerce </title>
    <!-- Mobile Specific Metas ================================================== -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Construction Html5 Template">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="author" content="Themefisher">
    <meta name="generator" content="Themefisher Constra HTML Template v1.0">

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
<script>
    // Lấy thông tin người dùng từ localStorage
    const user = JSON.parse(localStorage.getItem('user'));

    // Kiểm tra nếu không phải Admin, chuyển hướng về trang chủ
    if (!user || user.role !== 'admin') {
        sessionStorage.setItem('accessDenied', 'true');
        window.location.href = '/WEDASM2/index.php'; // Chuyển về trang chủ
    }
</script>

<body id="body">
    <?php include '../components/header.php'; ?>

    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <h1 class="page-name">Dashboard</h1>
                        <ol class="breadcrumb">
                            <li><a href="index.php">Home</a></li>
                            <li class="active">User Management</li>
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
                    <ul class="list-inline dashboard-menu text-center">
                        <li><a class="active" href="user-manager.php">User manager</a></li>
                        <li><a href="order.php">Products manager</a></li>
                    </ul><br>

                    <div class="dashboard-wrapper user-dashboard">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>User ID</th>
                                        <th>Role ID</th>
                                        <th>Email</th>
                                        <th>Full Name</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user) : ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                                            <td><?php echo htmlspecialchars($user['role_id']); ?></td>
                                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                                            <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                                            <td><?php echo htmlspecialchars($user['phone']); ?></td>
                                            <td><?php echo htmlspecialchars($user['address']); ?></td>
                                            <td>
                                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editUserModal" onclick="openEditModal(<?php echo htmlspecialchars(json_encode($user)); ?>)">Edit</button>
                                                <a href="/WEDASM2/utils/delete-user.php?user_id=<?php echo $user['user_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Edit User Modal -->
    <div id="editUserModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="editUserModalLabel">Edit User</h4>
                </div>
                <div class="modal-body">
                    <form id="editUserForm" action="/WEDASM2/utils/edit-user.php" method="POST">
                        <input type="hidden" name="user_id" id="editUserId">
                        <div class="form-group">
                            <label for="editRoleId">Role ID</label>
                            <input type="number" class="form-control" name="role_id" id="editRoleId" required>
                        </div>

                        <div class="form-group">
                            <label for="editFullName">Full Name</label>
                            <input type="text" class="form-control" name="full_name" id="editFullName">
                        </div>
                        <div class="form-group">
                            <label for="editPhone">Phone</label>
                            <input type="text" class="form-control" name="phone" id="editPhone">
                        </div>
                        <div class="form-group">
                            <label for="editAddress">Address</label>
                            <input type="text" class="form-control" name="address" id="editAddress">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include '../components/footer.php'; ?>

    <script src="../plugins/jquery/dist/jquery.min.js"></script>
    <script src="../plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="../plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
    <script src="../plugins/instafeed/instafeed.min.js"></script>
    <script src="../plugins/ekko-lightbox/dist/ekko-lightbox.min.js"></script>
    <script src="../plugins/syo-timer/build/jquery.syotimer.min.js"></script>
    <script src="../plugins/slick/slick.min.js"></script>
    <script src="../plugins/slick/slick-animation.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCC72vZw-6tGqFyRhhg5CkF2fqfILn2Tsw"></script>
    <script type="text/javascript" src="../plugins/google-map/gmap.js"></script>
    <script src="../js/script.js"></script>
    <script>
        function openEditModal(user) {
            document.getElementById('editUserId').value = user.user_id;
             document.getElementById('editRoleId').value = user.role_id;
            document.getElementById('editFullName').value = user.full_name;
            document.getElementById('editPhone').value = user.phone;
            document.getElementById('editAddress').value = user.address;
        }
    </script>

</body>

</html>