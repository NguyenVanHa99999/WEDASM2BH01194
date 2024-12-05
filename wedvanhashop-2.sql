-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost
-- Thời gian đã tạo: Th12 05, 2024 lúc 02:15 PM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `wedvanhashop`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `product_id`, `quantity`, `added_at`, `updated_at`) VALUES
(8, 1, 8, 1, '2024-12-01 10:28:39', '2024-12-01 10:28:39'),
(9, 1, 11, 1, '2024-12-01 15:11:08', '2024-12-01 15:11:08');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_number` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `shipping_fee` decimal(10,2) DEFAULT 0.00,
  `discount_amount` decimal(10,2) DEFAULT 0.00,
  `final_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','shipped','delivered','canceled') DEFAULT 'pending',
  `payment_status` enum('pending','paid','failed','refunded') DEFAULT 'pending',
  `shipping_address_id` int(11) NOT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `order_detail_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `unit_price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `password_resets`
--

INSERT INTO `password_resets` (`id`, `user_id`, `token`, `expires_at`) VALUES
(5, 6, '37a5e97b6d5ad2b92211f9910fc67a5dfd3acf0c2a5aa22f6875d16c02e1ea9f915f498eef5bfcf5f579ae1fef52a0adc4f8', 1733092335),
(11, 6, '6e3a42d7007967de9816e5b51a92aff5ce67fc270a7f1147f015bf2bb6da37048e17e7138a45a5cc08cfbe3b7fb591eb68bd', 1733092942),
(12, 6, 'd2284d21578bacd4d8a11ff0b5f2fac20d8f93b97c0c98e582261264797b3acb149d45878d968bd54d5ac5f0ac05c1a333aa', 1733095399);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `sale_price` decimal(10,2) DEFAULT NULL,
  `stock_quantity` int(11) DEFAULT 0,
  `category` enum('Laptops','Screen','Mac-mini') DEFAULT NULL,
  `status` enum('draft','active','inactive') DEFAULT 'draft',
  `is_featured` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`product_id`, `name`, `description`, `image`, `price`, `sale_price`, `stock_quantity`, `category`, `status`, `is_featured`, `created_at`, `updated_at`) VALUES
(4, 'MAC MINI M4', 'Mac Mini M4 / M4 Pro was officially launched to users on October 29, 2024\r\nEquipped with Apple M4 chip, CPU processing speed is 1.8 times faster and GPU is 2.2 times faster than M1 chip.\r\n256GB SSD memory along with 16GB RAM is enough to meet the needs of most customers\r\nDimensions 5 x 12.7 x 12.7 cm, compact design with Silver color and super light weight of 0.67 Kg\r\nMac Mini M4 2024 still fully integrates connection ports: Ethernet, Thunderbolt, HDMI, USB-A, 3.5mm jack', 'uploads/products/67472fdfbf10d_MAC MINI M4.png', 5000.00, NULL, 42, 'Mac-mini', 'active', 0, '2024-11-27 14:42:39', '2024-11-27 14:42:39'),
(5, 'Dell UltraSharp', 'Screen style: Flat\r\n Aspect ratio: 16:9\r\n Default size: 23.8 inches\r\n Panel technology: IPS\r\n Pixel resolution: FHD - 1920 x 1080\r\n Display brightness: 250 Nits cd/m2\r\n Screen scanning frequency: 120 Hz (Hertz)\r\n Response time: 8 ms (Normal) - 5 ms (Fast)\r\n Color index: 16.7 million colors - s100% sRGB, 100% BT.709, 85% DCI-P3, Delta E &lt; 2 (average) (sRGB and BT.709)\r\n Standard support: VESA (100 mm x 100 mm), DRR for Microsoft Windows, TMDS as per specified in HDMI 1.4', 'uploads/products/674730c624512_dell UltraSharp.jpeg', 700.00, NULL, 43, 'Screen', 'active', 0, '2024-11-27 14:46:30', '2024-11-27 14:46:30'),
(6, 'Dell Xps 9510', 'Dell Xps 9510 is the thinnest, lightest and most durable 2 in 1 business laptop today. In addition to its luxurious, modern design, this laptop is also highly appreciated for its powerful performance, allowing it to handle all tasks quickly. Therefore, let\'s learn more about this laptop with Ngoc Nguyen Store in the article below.', 'uploads/products/6747319f6596f_DELL.png', 2000.00, NULL, 24, 'Laptops', 'active', 0, '2024-11-27 14:50:07', '2024-11-27 14:50:07'),
(7, 'Apple MacBook Air 13 inch M3', 'CPU: Apple M3 chip with 8-core CPU and 8-core GPU\r\nRAM: 16 GB\r\nSSD: 256 GB\r\nDisplay: 13.6 inches, 2560 x 1644 at 224 pixels per inch, IPS,500 nits, True Tone Technology\r\nWeight: 1.24kg\r\nFeatures: Touch ID\r\nOS: MacOS', 'uploads/products/6747329bbbed6_Macbook m3.jpeg', 1900.00, NULL, 23, 'Laptops', 'active', 0, '2024-11-27 14:54:19', '2024-11-27 14:54:19'),
(8, 'ThinkPad', 'ThinkPad X1 Carbon Gen 12 (2024) is the latest generation of Lenovo\'s famous ThinkPad X1 Carbon business laptop line. This business laptop is a symbol of innovation, not only in design but also in performance and security. With a sharp 120Hz display, powerful Intel Core Ultra processor, redesigned keyboard, and great security features, the X1 Carbon Gen 12 is the perfect choice for professionals looking for a great product. great product. High quality laptop products, supporting high productivity, entertainment and work anywhere.', 'uploads/products/67475a7ea89d1_thinkpad.png', 2500.00, NULL, 40, 'Laptops', 'active', 0, '2024-11-27 17:44:30', '2024-11-27 17:44:30'),
(9, 'Laptop Acer', 'Acer Aspire 3 Spin 14 A3SP14-31PT-387Z laptop with Intel Core i3-N305 chip, 8GB RAM and 512GB SSD, provides stable performance for tasks, including graphics. This device also has a 14-inch touch screen, making operation more intuitive and convenient. More specifically, this Acer Aspire laptop segment can also rotate 360 ​​degrees, easily transforming into a quick and flexible tablet.', 'uploads/products/67475bcaa9aa5_Acer.png', 1000.00, NULL, 213, 'Laptops', 'active', 0, '2024-11-27 17:50:02', '2024-11-27 17:50:02'),
(11, '9', 'CPU: Apple M3 chip with 8-core CPU and 8-core GPU\r\nRAM: 16 GB\r\nSSD: 256 GB\r\nDisplay: 13.6 inches, 2560 x 1644 at 224 pixels per inch, IPS,500 nits, True Tone Technology\r\nWeight: 1.24kg\r\nFeatures: Touch ID\r\nOS: MacOS', 'uploads/products/674c3fb5e3be8_Macbook m3.jpeg', 2999.00, NULL, 23, 'Laptops', 'active', 0, '2024-12-01 10:51:33', '2024-12-01 10:51:33'),
(12, 'MacBook', 'CPU: Apple M3 chip with 8-core CPU and 8-core GPU\r\nRAM: 16 GB\r\nSSD: 256 GB\r\nDisplay: 13.6 inches, 2560 x 1644 at 224 pixels per inch, IPS,500 nits, True Tone Technology\r\nWeight: 1.24kg\r\nFeatures: Touch ID\r\nOS: MacOS', 'uploads/products/674c409a207c9_macbook.jpeg', 2000.00, NULL, 32, 'Laptops', 'active', 0, '2024-12-01 10:55:22', '2024-12-01 10:55:22'),
(13, 'Laptop 1', 'Description for Laptop 1', NULL, 1000.00, 950.00, 10, 'Laptops', 'active', 1, '2024-12-01 20:38:47', '2024-12-01 20:38:47'),
(16, 'Laptop 1', 'Description for Laptop 1', NULL, 1000.00, 950.00, 10, 'Laptops', 'active', 1, '2024-12-03 14:44:22', '2024-12-03 14:44:22'),
(17, 'Monitor 1', 'Description for Monitor 1', NULL, 300.00, 280.00, 20, 'Screen', 'active', 0, '2024-12-03 14:44:22', '2024-12-03 14:44:22'),
(18, 'Mac Mini 1', 'Description for Mac Mini 1', NULL, 1200.00, 1100.00, 15, 'Mac-mini', 'active', 1, '2024-12-03 14:44:22', '2024-12-03 14:44:22');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `review_text` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `roles`
--

INSERT INTO `roles` (`role_id`, `name`, `description`, `created_at`) VALUES
(1, 'admin', 'Quản trị viên', '2024-11-27 13:54:35'),
(2, 'user', 'Người dùng thường', '2024-11-27 13:54:35'),
(3, 'admin', 'Quản trị viên', '2024-12-01 20:38:47'),
(4, 'user', 'Người dùng thường', '2024-12-01 20:38:47'),
(5, 'admin', 'Quản trị viên', '2024-12-03 14:44:22'),
(6, 'user', 'Người dùng thường', '2024-12-03 14:44:22');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `reset_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `role_id`, `full_name`, `address`, `phone`, `created_at`, `updated_at`, `reset_token`) VALUES
(1, 'nguyenvanha@gmail.com', '$2y$10$Hx63xYiStHErZGkWEnGVjOKLl7NmjyaKzg924LHSiEH3ZB7Hi.nmy', 1, 'nguyenvanha233', 'minh cat - quang cu - sam son', '0972867256', '2024-11-27 13:58:04', '2024-12-01 10:34:31', NULL),
(3, 'nguyenvanhaaa2@gmail.com', '$2y$10$Ax7ah3WjLFYAjhnAp1qlweSRKX.vFhU0nEiwro7GciUSlpi4sYfJW', 2, 'nguyenvanaaaa', NULL, NULL, '2024-12-01 10:41:43', '2024-12-01 10:41:43', NULL),
(4, 'admin@example.com', 'admin_password', 1, 'Admin User', NULL, NULL, '2024-12-01 20:38:47', '2024-12-01 20:38:47', NULL),
(5, 'user@example.com', 'user_password', 2, 'Regular User', NULL, NULL, '2024-12-01 20:38:47', '2024-12-01 20:38:47', NULL),
(6, 'nguyenduyha660@gmail.com', '$2y$10$faEv/fXNlMcWzNxm6DqwIe2OCPFjASf.TDaAg3pZFVQie9Yy5mB3m', 2, 'nguyen vanhaaa', NULL, NULL, '2024-12-01 20:50:38', '2024-12-01 21:22:54', '0f7a626defc057b51d5dc6b165003ee632643c61b5449b8beb30e49949de4b2fbecee3ede205d7aead1cd351c3ac14f10880');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD UNIQUE KEY `order_number` (`order_number`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_detail_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_detail_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Các ràng buộc cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Các ràng buộc cho bảng `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `password_resets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Các ràng buộc cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Các ràng buộc cho bảng `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
