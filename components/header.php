<header class="header">
	<div class="flex">
		<a href="home.php" class="logo"><img src="img/logo.jpg"></a>
		<nav class="navbar">
			<a href="home.php">home</a>
			<a href="view_products.php">products</a>
			<a href="order.php">orders</a>
			<a href="about.php">about us</a>
			<a href="contact.php">contact us</a>
		</nav>
		<div class="icons">
			<i class="bx bxs-user" id="user-btn"></i>
			<?php 
				$count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
				$count_wishlist_items->execute([$user_id]);
				$total_wishlist_items = $count_wishlist_items->rowCount();
			?>
			<a href="wishlist.php" class="cart-btn"><i class="bx bx-heart"></i><sup><?=$total_wishlist_items ?></sup></a>
			<?php 
				$count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
				$count_cart_items->execute([$user_id]);
				$total_cart_items = $count_cart_items->rowCount();
			?>
			<a href="cart.php" class="cart-btn"><i class="bx bx-cart-download"></i><sup><?=$total_cart_items ?></sup></a>
			<i class='bx bx-list-plus' id="menu-btn" style="font-size: 2rem;"></i>
		</div>
		<div class="user-box">
			<?php
				if(isset($_SESSION['user_name']) && isset($_SESSION['user_email'])) {
					echo '<p>username : <span>' . $_SESSION['user_name'] . '</span></p>';
					echo '<p>Email : <span>' . $_SESSION['user_email'] . '</span></p>';
				} else {
					echo '<p><a href="login.php" class="btn" style="color: #000;">login</a></p>';
					echo '<p><a href="register.php" class="btn" style="color: #000;">register</a></p>';
				}
			?>
			<?php if(isset($_SESSION['user_name'])): ?>
				<form method="post">
					<button type="submit" name="logout" class="logout-btn">log out</button>
				</form>
			<?php endif; ?>
		</div>
	</div>
</header>
