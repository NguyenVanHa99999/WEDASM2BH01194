<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/WEDASM2/config/connect.php';

// Lấy kết nối
$conn = getDatabaseConnection();

function getFeaturedProducts($limit = 9, $minPrice = null, $maxPrice = null)
{
    global $conn;

    if ($conn === null) {
        error_log("Kết nối cơ sở dữ liệu không tồn tại!");
        return [];
    }

    try {
        $query = "SELECT * FROM products WHERE 1=1";

        // Thêm điều kiện lọc theo giá
        if ($minPrice !== null) {
            $query .= " AND price >= :min_price";
        }
        if ($maxPrice !== null) {
            $query .= " AND price <= :max_price";
        }

        $query .= " ORDER BY created_at DESC LIMIT :limit";

        $stmt = $conn->prepare($query);

        // Ràng buộc các tham số
        if ($minPrice !== null) {
            $stmt->bindParam(':min_price', $minPrice, PDO::PARAM_INT);
        }
        if ($maxPrice !== null) {
            $stmt->bindParam(':max_price', $maxPrice, PDO::PARAM_INT);
        }
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Lỗi truy vấn sản phẩm: " . $e->getMessage());
        return [];
    }
}
$minPrice = isset($_GET['min_price']) ? (int)$_GET['min_price'] : null;
$maxPrice = isset($_GET['max_price']) ? (int)$_GET['max_price'] : null;

// Lấy sản phẩm với bộ lọc
$featured_products = getFeaturedProducts(9, $minPrice, $maxPrice);

?>


<<section class="products section bg-gray" id="shop-section">
    </section>
    <div class="container">
        <div class="row">
            <div class="title text-center">
                <h1>SHOP PRODUCTS</h1>
            </div>
        </div>
        <div class="col-md-3">
            <div class="widget">
                <form method="GET" action="" style="display: flex; flex-direction: column; gap: 15px; max-width: 300px; margin: auto;">
                    <div style="display: flex; flex-direction: column;">
                        <label for="min_price" style="margin-bottom: 5px;">Min Price:</label>
                        <input
                            type="number"
                            id="min_price"
                            name="min_price"
                            class="form-control"
                            placeholder="Min price"
                            style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                    <div style="display: flex; flex-direction: column;">
                        <label for="max_price" style="margin-bottom: 5px;">Max Price:</label>
                        <input
                            type="number"
                            id="max_price"
                            name="max_price"
                            class="form-control"
                            placeholder="Max price"
                            style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                    <div>
                        <button
                            type="submit"
                            class="btn btn-primary"
                            style="padding: 10px; background-color: #337ab7; color: white; border: none; border-radius: 4px; cursor: pointer;">
                            Apply Filter
                        </button>
                    </div>
                </form>


            </div>
        </div>
        <div class="col-md-9">

            <div class="row">
                <?php foreach ($featured_products as $product): ?>

                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="product-item">
                            <div class="product-thumb">
                                <style>
                                    .product-thumb {
                                        width: 100%;
                                        height: 450px;
                                        /* Chiều cao cố định */
                                        overflow: hidden;
                                        /* Ẩn phần hình ảnh vượt quá khung */
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        background-color: #191818;
                                        /* Màu nền cho khung */
                                    }

                                    .product-thumb img {
                                        width: 100%;
                                        /* Chiều rộng toàn bộ khung */
                                        height: auto;
                                        /* Đảm bảo hình ảnh không bị méo */
                                        object-fit: cover;
                                        /* Cắt hình ảnh để vừa khung mà không bị biến dạng */
                                    }
                                </style>


                                <img class="img-responsive" src="<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['image']) ?> ?>">

                                <div class="preview-meta">
                                    <ul>
                                        <li>
                                            <a href="<?php echo '/WEDASM2/pages/product-details.php?product_id=' . $product['product_id']; ?>">
                                                <i class="tf-ion-ios-search-strong"></i>
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                            <div class="product-content">
                                <h4><?php echo htmlspecialchars($product['name']); ?></h4>
                                <p class="price">$ <?php echo htmlspecialchars($product['price']) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        </section>