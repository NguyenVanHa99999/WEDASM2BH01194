		<script>
			const user = JSON.parse(localStorage.getItem('user'));
			if (user && user.email) {
				document.cookie = `user_email=${user.email};path=/`;
			}
		</script>
		<?php
		// Kết nối cơ sở dữ liệu
		require_once $_SERVER['DOCUMENT_ROOT'] . '/WEDASM2/config/connect.php';

		// Lấy kết nối
		$conn = getDatabaseConnection();

		if ($conn === null) {
			die("Kết nối cơ sở dữ liệu không thành công!");
		}



		// Lấy email từ cookie
		$user_email = isset($_COOKIE['user_email']) ? $_COOKIE['user_email'] : null;
		$user_full_name = "Guest"; // Mặc định nếu không có thông tin

		if ($user_email) {
			$stmt = $conn->prepare("SELECT full_name FROM users WHERE email = :email");
			$stmt->bindParam(':email', $user_email, PDO::PARAM_STR);
			$stmt->execute();
			$user = $stmt->fetch(PDO::FETCH_ASSOC);

			if ($user) {
				$user_full_name = $user['full_name'];
			}
		}
		$stmt = $conn->prepare("SELECT user_id FROM users WHERE email = :email");
		$stmt->bindValue(':email', $user_email, PDO::PARAM_STR);
		$stmt->execute();
		$user = $stmt->fetch(PDO::FETCH_ASSOC);





		?>

		<section class="top-header">
			<div class="container">
				<div class="row">
					<div class="col-md-4 col-xs-12 col-sm-4">
						<div class="user-avatar">
							<a href="#!" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
								<img src="/WEDASM2/images/User.gif" alt="User Avatar" class="avatar-img avt">
								<?php echo htmlspecialchars($user_full_name); ?>
							</a>
							<ul class="dropdown-menu">
								<li><a href="<?php echo '/WEDASM2/pages/profile.php'; ?>">Profile</a></li>
								<li><a href="<?php echo '/WEDASM2/utils/logout.php'; ?>">Logout</a></li>
							</ul>
						</div>
					</div>
					<style>
						.user-avatar {
							position: relative;
						}

						.user-avatar .dropdown-menu {
							position: absolute;
							top: 100%;
							left: 0;
							margin-top: 0.5em;
							transform: none;
						}

						.contact-number {
							display: flex;
							align-items: center;
							margin-left: 4em;
						}

						.contact-number i {
							margin-right: 0.5em;
							color: #333;
							font-size: 1.2em;
						}
					</style>
					<div class="col-md-4 col-xs-12 col-sm-4">
						<!-- Site Logo -->
						<div class="logo text-center">
							<a href="<?php echo '/WEDASM2/index.php'; ?>">
								<!-- replace logo here -->
								<svg width="500px" height="150px" viewBox="0 0 600 200" version="1.1"
									xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
									<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"
										font-size="70" font-family="AustinBold, Austin" font-weight="bold">
										<g id="Group" transform="translate(-108.000000, -297.000000)" fill="#000000">
											<text id="VAN HA SHOP">
												<tspan x="108.94" y="400">VAN HA SHOP</tspan>
											</text>
										</g>
									</g>
								</svg>
							</a>
						</div>
					</div>
					<div class="col-md-4 col-xs-12 col-sm-4">
						<!-- Cart -->
						<ul class="top-menu text-right list-inline">
							<li class="dropdown cart-nav dropdown-slide">
								<a href="<?php echo '/WEDASM2/pages/cart.php'; ?>"><i
										class="tf-ion-android-cart"></i>Cart</a>


							</li><!-- / Cart -->


							<!-- Search -->
							<li class="dropdown search dropdown-slide">
								<a href="#!" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
									<i class="tf-ion-ios-search-strong"></i> Search
								</a>
								<ul class="dropdown-menu search-dropdown">
									<li>
										<form>
											<input type="search" id="search-input" name="query" class="form-control" placeholder="Search for products..." autocomplete="off">
											<ul id="search-suggestions" style="position: absolute; z-index: 1000; background: white; list-style: none; padding: 0; margin: 0; display: none; width: 100%; border: 1px solid #ccc;">
											</ul>
										</form>
									</li>
								</ul>
							</li>
							<style>
								#search-suggestions li {
									padding: 8px 12px;
									cursor: pointer;
								}

								#search-suggestions li:hover {
									background-color: #f0f0f0;
								}
							</style>
							<script>
								document.addEventListener("DOMContentLoaded", function() {
									const searchInput = document.getElementById("search-input");
									const suggestionsBox = document.getElementById("search-suggestions");

									searchInput.addEventListener("input", function() {
										const query = searchInput.value.trim();

										if (query.length >= 3) { // Chỉ tìm kiếm khi có ít nhất 3 ký tự
											fetch(`/WEDASM2/search-suggestions.php?query=${encodeURIComponent(query)}`)
												.then(response => response.json())
												.then(data => {
													suggestionsBox.innerHTML = ""; // Xóa các gợi ý trước đó
													if (data.length > 0) {
														data.forEach(item => {
															const listItem = document.createElement("li");
															listItem.textContent = item.name;
															listItem.dataset.productId = item.product_id; // Gắn ID sản phẩm
															suggestionsBox.appendChild(listItem);
														});
														suggestionsBox.style.display = "block";
													} else {
														suggestionsBox.style.display = "none";
													}
												})
												.catch(error => console.error("Error fetching search suggestions:", error));
										} else {
											suggestionsBox.style.display = "none";
										}
									});

									// Chuyển hướng khi nhấp vào sản phẩm
									suggestionsBox.addEventListener("click", function(e) {
										if (e.target.tagName === "LI") {
											const productId = e.target.dataset.productId; // Lấy ID sản phẩm
											if (productId) {
												// Chuyển hướng đến trang chi tiết sản phẩm với product_id
												window.location.href = `/WEDASM2/pages/product-details.php?product_id=${productId}`;
											} else {
												alert("Không thể xác định sản phẩm!"); // Hiển thị thông báo nếu không có productId
											}
										}
									});

									// Ẩn gợi ý khi nhấp ra ngoài
									document.addEventListener("click", function(e) {
										if (!suggestionsBox.contains(e.target) && e.target !== searchInput) {
											suggestionsBox.style.display = "none";
										}
									});
								});
							</script>

							<!-- Languages -->
							<li class="commonSelect">
								<select class="form-control">
									<option>EN</option>
									<option>VN</option>
									<option>FR</option>
									<option>ES</option>
								</select>
							</li><!-- / Languages -->

						</ul><!-- / .nav .navbar-nav .navbar-right -->
					</div>
				</div>
			</div>
		</section><!-- End Top Header Bar -->
		<section class="menu">
			<nav class="navbar navigation">
				<div class="container">
					<div class="navbar-header">
						<h2 class="menu-title">Menu</h2>
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
							aria-expanded="false" aria-controls="navbar">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>

					</div><!-- / .navbar-header -->

					<!-- Navbar Links -->
					<div id="navbar" class="navbar-collapse collapse text-center">
						<ul class="nav navbar-nav">

							<!-- Home -->
							<li class="dropdown ">
								<a href="<?php echo '/WEDASM2/index.php'; ?>">Home</a>
							</li><!-- / Home -->




							<!-- Pages -->
							<li class="dropdown full-width dropdown-slide">
								<a href="#!" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
									data-delay="350" role="button" aria-haspopup="true" aria-expanded="false">Pages <span
										class="tf-ion-ios-arrow-down"></span></a>
								<div class="dropdown-menu">
									<div class="row">



										<!-- Contact -->
										<div class="col-sm-3 col-xs-12">
											<ul>
												<li class="dropdown-header">Dashboard</li>
												<li role="separator" class="divider"></li>
												<li><a href="<?php echo '/WEDASM2/dashboard/home.php' ?>">Users manager</a></li>
												<li><a href="<?php echo '/WEDASM2/dashboard/order.php' ?>">Products manager</a></li>
												<li><a href="<?php echo '/WEDASM2/dashboard/post-product.php' ?>">Post product</a></li>

											</ul>
										</div>

										<!-- Utility -->
										<div class="col-sm-3 col-xs-12">
											<ul>
												<li class="dropdown-header">Utility</li>
												<li role="separator" class="divider"></li>
												<li><a href="<?php echo '/WEDASM2/pages/auth/sign-in.php'; ?>">Login </a></li>
												<li><a href="<?php echo '/WEDASM2/pages/auth/sign-up.php'; ?>">Register </a></li>

											</ul>
										</div>

										<!-- Mega Menu -->
										<div class="col-sm-3 col-xs-12">
											<a href="https://www.facebook.com/nobelg.ha/" target="_blank">
												<img class="img-responsive"
													src="/WEDASM2/images/page.png"
													alt="menu image" />
											</a>
										</div>
										<div class="col-sm-3 col-xs-12">
											<a href="#shop-section" target="_blank">
												<img class="img-responsive" src="https://cdn.mobilecity.vn/mobilecity-vn/images/2024/05/hinh-nen-gaming-top-200.jpg.webp" alt="menu image 2" />
											</a>
										</div>

									</div><!-- / .row -->
								</div><!-- / .dropdown-menu -->
							</li><!-- / Pages -->

						</ul><!-- / .nav .navbar-nav -->

					</div>
					<!--/.navbar-collapse -->
				</div><!-- / .container -->
			</nav>
		</section>