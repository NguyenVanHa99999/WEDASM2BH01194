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

// Lấy danh sách sản phẩm
$stmt = $conn->prepare("SELECT product_id, name, description, image, price, stock_quantity FROM products");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

<body id="body">
    <script>
        // Lấy thông tin người dùng từ localStorage
        const user = JSON.parse(localStorage.getItem('user'));

        // Kiểm tra nếu không phải Admin, chuyển hướng về trang chủ
        if (!user || user.role !== 'admin') {
            sessionStorage.setItem('accessDenied', 'true');
            window.location.href = '/WEDASM2/index.php'; // Chuyển về trang chủ
        }
    </script>
    <?php include '../components/header.php'; ?>
    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <h1 class="page-name">Dashboard</h1>
                        <ol class="breadcrumb">
                            <li><a href="index.php">Home</a></li>
                            <li class="active">Product Management</li>
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
                        <li><a href="home.php">User manager</a></li>
                        <li><a class="active" href="order.php">Products manager</a></li>
                    </ul>
                    <div class="dashboard-wrapper user-dashboard">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($products as $product) : ?>
                                        <tr >
                                            <td><img src="<?php echo htmlspecialchars('http://' . $_SERVER['HTTP_HOST'] . '/WEDASM2/'. $product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="width: 200px;    object-fit: cover; height: 240px;"></td>
                                            <td ><?php echo htmlspecialchars($product['name']); ?></td>
                                            <td><?php echo htmlspecialchars($product['description']); ?></td>
                                            <td><?php echo htmlspecialchars($product['price']); ?></td>
                                            <td><?php echo htmlspecialchars($product['stock_quantity']); ?></td>
                                            <td>
                                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editProductModal" onclick="openEditModal(<?php echo htmlspecialchars(json_encode($product)); ?>)">Edit</button>
                                                <a href="/WEDASM2/utils/delete-product.php?product_id=<?php echo $product['product_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
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
<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editProductsForm" action="/WEDASM2/utils/edit-product.php" method="POST">
	<input  type="hidden" id="editProductId" name="product_id">
											<div class="form-group">
													<label for="editProductName">Name</label>
													<input type="text" class="form-control" id="editProductName" name="name" required>
											</div>
											<div class="form-group">
													<label for="editProductDescription">Description</label>
													<textarea class="form-control" id="editProductDescription" name="description" rows="3" required></textarea>
											</div>
											<div class="form-group">
													<label for="editProductPrice">Price</label>
													<input type="text" class="form-control" id="editProductPrice" name="price" required>
											</div>

											<div class="form-group">
													<label for="editProductQuantity">Stock Quantity</label>
													<input type="number" class="form-control" id="editProductQuantity" name="stock_quantity" required>
											</div>
											<div class="form-group">
													<label for="category">Category</label>
													<select class="form-control" id="category" name="category" required>
															<option value="Laptops">Laptops</option>
															<option value="Desktops">Desktops</option>
															<option value="Accessories">Accessories</option>
													</select>
											</div>
											<button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

    <?php include '../components/footer.php'; ?>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <script src="../plugins/jquery/dist/jquery.min.js"></script>
    <script src="../plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="../plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
    <script src="../plugins/instafeed/instafeed.min.js"></script>
    <script src="../plugins/ekko-lightbox/dist/ekko-lightbox.min.js"></script>
    <script src="../plugins/syo-timer/build/jquery.syotimer.min.js"></script>
    <script src="../plugins/slick/slick.min.js"></script>
    <script src="../plugins/slick/slick-animation.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCV-Pn9ApMuIanKJGMe4yVeZEyrY9aC9yQ"></script>
    <script type="text/javascript" src="../plugins/google-map/gmap.js"></script>
    <script src="../js/script.js"></script>
    <script>
        function openEditModal(product) {
            document.getElementById('editProductId').value = product.product_id;
            document.getElementById('editProductName').value = product.name;
            document.getElementById('editProductDescription').value = product.description;
            document.getElementById('editProductPrice').value = product.price;
            document.getElementById('editProductQuantity').value = product.stock_quantity;
        }
    </script>

</body>

</html>
