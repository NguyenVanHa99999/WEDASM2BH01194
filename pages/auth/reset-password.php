<?php
session_start();
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

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Kiểm tra token có tồn tại và chưa hết hạn
    $stmt = $conn->prepare("SELECT user_id FROM password_resets WHERE token = :token AND expires_at > :current_time");
    $stmt->execute([
        'token' => $token,
        'current_time' => time()
    ]);
    $reset_request = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($reset_request) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            if ($password === $confirm_password) {
                // Cập nhật mật khẩu mới
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                $stmt = $conn->prepare("UPDATE users SET password = :password WHERE user_id = :user_id");
                $stmt->execute([
                    'password' => $hashed_password,
                    'user_id' => $reset_request['user_id']
                ]);

                // Xóa token sau khi sử dụng
                $stmt = $conn->prepare("DELETE FROM password_resets WHERE token = :token");
                $stmt->execute(['token' => $token]);

                $_SESSION['success_message'] = "Your password has been reset successfully.";
                header('Location: /WEDASM2/pages/auth/sign-in.php');
                exit();
            } else {
                $_SESSION['error_message'] = "Passwords do not match.";
            }
        }
    } else {
        $_SESSION['error_message'] = "Invalid or expired token.";
        header('Location: /WEDASM2/pages/auth/forgot-password.php');
        exit();
    }
} else {
    $_SESSION['error_message'] = "No token provided.";
    header('Location: /WEDASM2/pages/auth/forgot-password.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Your Password</h2>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div style="color: red;">
            <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div>
            <label for="password">New Password:</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" required>
        </div>
        <div>
            <button type="submit">Reset Password</button>
        </div>
    </form>
</body>
</html>