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



// Xử lý yêu cầu POST để cập nhật thông tin người dùng
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = trim($_POST['user_id']);
    $role_id = trim($_POST['role_id']);
    $email = trim($_POST['email']);
    $full_name = trim($_POST['full_name']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);



    // Cập nhật thông tin người dùng trong cơ sở dữ liệu
    $stmt = $conn->prepare("UPDATE users SET full_name = :full_name, phone = :phone, address = :address, role_id = :role_id WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':role_id', $role_id);
    $stmt->bindParam(':full_name', $full_name);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':address', $address);

    if ($stmt->execute()) {
        // Chuyển hướng người dùng về trang quản lý người dùng sau khi cập nhật thành công
        header('Location: /WEDASM2/dashboard/home.php');
        exit();
    } else {
        die('Có lỗi xảy ra trong quá trình cập nhật thông tin người dùng.');
    }
}
?>
