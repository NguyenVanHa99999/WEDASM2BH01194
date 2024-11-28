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



// Xử lý yêu cầu POST để cập nhật thông tin sản phẩm
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = trim($_POST['product_id']);
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = trim($_POST['price']);
    $sale_price = trim($_POST['sale_price']);
    $stock_quantity = trim($_POST['stock_quantity']);
    $category = trim($_POST['category']);

    // Cập nhật thông tin sản phẩm trong cơ sở dữ liệu
    $stmt = $conn->prepare("UPDATE products SET name = :name, description = :description, price = :price, stock_quantity = :stock_quantity, category = :category WHERE product_id = :product_id");
    $stmt->bindParam(':product_id', $product_id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':price', $price);
 
    $stmt->bindParam(':stock_quantity', $stock_quantity);
    $stmt->bindParam(':category', $category);

    if ($stmt->execute()) {
        // Chuyển hướng người dùng về trang quản lý sản phẩm sau khi cập nhật thành công
        header('Location: /WEDASM2/dashboard/order.php');
        exit();
    } else {
        die('Có lỗi xảy ra trong quá trình cập nhật thông tin sản phẩm.');
    }
}
?>