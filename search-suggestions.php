<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/WEDASM2/config/connect.php';

$conn = getDatabaseConnection();

if ($conn === null) {
    echo json_encode(["error" => "Kết nối cơ sở dữ liệu thất bại!"]);
    exit;
}

// Lấy từ khóa tìm kiếm
if (isset($_GET['query']) && !empty($_GET['query'])) {
    $query = trim($_GET['query']);

    // Truy vấn sản phẩm dựa trên từ khóa
    $stmt = $conn->prepare("SELECT product_id, name FROM products WHERE name LIKE :query LIMIT 10");
    $searchTerm = '%' . $query . '%';
    $stmt->bindParam(':query', $searchTerm, PDO::PARAM_STR);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Trả dữ liệu JSON
    echo json_encode($results);
} else {
    echo json_encode([]);
}
?>