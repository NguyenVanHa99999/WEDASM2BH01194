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

// Xử lý yêu cầu GET để xóa người dùng
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['user_id'])) {
    $user_id = trim($_GET['user_id']);

    // Xóa người dùng khỏi cơ sở dữ liệu
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);

    if ($stmt->execute()) {
        // Chuyển hướng người dùng về trang quản lý người dùng sau khi xóa thành công
        header('Location: /WEDASM2/dashboard/home.php');
        exit();
    } else {
        die('Có lỗi xảy ra trong quá trình xóa người dùng.');
    }
} else {
    die('Yêu cầu không hợp lệ.');
}
?>
