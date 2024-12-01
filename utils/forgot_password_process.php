<?php
session_start();

// Bật thông báo lỗi để kiểm tra
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wedvanhashop";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    // Kiểm tra email có tồn tại không
    $stmt = $conn->prepare("SELECT user_id, full_name FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Tạo token reset mật khẩu và thời gian hết hạn
        $token = bin2hex(random_bytes(50)); // Sinh token ngẫu nhiên
        $expires_at = time() + 3600; // Token hết hạn sau 1 giờ (3600 giây)

        // Lưu token vào bảng password_resets
        $stmt = $conn->prepare("INSERT INTO password_resets (user_id, token, expires_at) VALUES (:user_id, :token, :expires_at)");
        $stmt->execute([
            'user_id' => $user['user_id'],
            'token' => $token,
            'expires_at' => $expires_at
        ]);

        // Tạo liên kết reset mật khẩu
        $reset_link = "http://localhost/WEDASM2/pages/auth/reset-password.php?token=$token";

        // Cấu hình email
        $to = $email;
        $subject = "Password Reset Request";
        $message = "
            Hi {$user['full_name']},<br><br>
            We received a request to reset your password. Click the link below to reset your password:<br>
            <a href='$reset_link'>$reset_link</a><br><br>
            If you did not request this, please ignore this email.<br><br>
            Regards,<br>
            VANHASHOP Team
        ";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
        $headers .= "From: no-reply@vanhashop.com" . "\r\n";

        // Gửi email
        if (mail($to, $subject, $message, $headers)) {
            $_SESSION['success_message'] = "An email has been sent with instructions to reset your password.";
        } else {
            $_SESSION['error_message'] = "Failed to send email. Please try again later.";
        }
    } else {
        $_SESSION['error_message'] = "No account found with that email address.";
    }

    // Quay lại trang quên mật khẩu
    header('Location: /WEDASM2/pages/auth/forget-password.php');
    exit();
}
?>