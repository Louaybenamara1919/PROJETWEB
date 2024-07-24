<?php 
	include 'components/connection.php';
	session_start();

	if (isset($_SESSION['user_id'])) {
		$user_id = $_SESSION['user_id'];
	}else{
		$user_id = '';
	}

	//register user
	if (isset($_POST['submit'])) {

		$email = $_POST['email'];
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);
		$pass = $_POST['pass'];
		$pass = filter_var($pass, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

		// Check if user exists in users table
		$select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
		$select_user->execute([$email, $pass]);
		$row_user = $select_user->fetch(PDO::FETCH_ASSOC);

		// Check if user exists in admin table
		$select_admin = $conn->prepare("SELECT * FROM `admin` WHERE email = ? AND password = ?");
		$select_admin->execute([$email, $pass]);
		$row_admin = $select_admin->fetch(PDO::FETCH_ASSOC);

		if ($select_user->rowCount() > 0) {
			$_SESSION['user_id'] = $row_user['id'];
			$_SESSION['user_name'] = $row_user['name'];
			$_SESSION['user_email'] = $row_user['email'];
			header('location: home.php');
		} elseif ($select_admin->rowCount() > 0) {
			$_SESSION['user_id'] = $row_admin['id'];
			$_SESSION['user_name'] = $row_admin['name'];
			$_SESSION['user_email'] = $row_admin['email'];
			header('location: admin_dashboard.php'); // Redirect to admin dashboard
		} else {
			$warning_msg[] = 'Incorrect username or password';
		}
	}
?>
<style type="text/css">
	<?php include 'style.css'; ?>
</style>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>green tea - login now</title>
</head>
<body>
	<div class="main-container">
		<section class="form-container">
			<div class="title">
				<img src="img/download.png">
				<h1>login now</h1>
				<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto dolorum deserunt minus veniam
                    tenetur
                </p>
			</div>
			<form action="" method="post">
				<div class="input-field">
					<p>your email <sup>*</sup></p>
					<input type="email" name="email" required placeholder="enter your email" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
				</div>
				<div class="input-field">
					<p>your password <sup>*</sup></p>
					<input type="password" name="pass" required placeholder="enter your password" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
				</div>
				
				<input type="submit" name="submit" value="login now" class="btn">
				<p>do not have an account? <a href="register.php">register now</a></p>
			</form>
		</section>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<?php include 'components/alert.php'; ?>
</body>
</html>
