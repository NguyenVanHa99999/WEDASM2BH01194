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


// Xử lý yêu cầu GET để xóa sản phẩm
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['product_id'])) {
    $product_id = trim($_GET['product_id']);

    // Xóa sản phẩm khỏi cơ sở dữ liệu
    $stmt = $conn->prepare("DELETE FROM products WHERE product_id = :product_id");
    $stmt->bindParam(':product_id', $product_id);

    if ($stmt->execute()) {
        // Chuyển hướng người dùng về trang quản lý sản phẩm sau khi xóa thành công
        header('Location: /WEDASM2/dashboard/order.php');
        exit();
    } else {
        die('Có lỗi xảy ra trong quá trình xóa sản phẩm.');
    }
} else {
    die('Yêu cầu không hợp lệ.');
}
?>
