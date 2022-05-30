<?php session_start();if(isset($_SESSION['login'])){header('location: dashboard.php');}?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../../asset/bs5/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../../asset/bs5/icon/bs-icon/bootstrap-icons.css">
	<link rel="stylesheet" type="text/css" href="../../asset/fa6/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<title> Login </title>
</head>
<body>
	<div class="bg-image">

	</div>

	<div class="d-flex align-items-center justify-content-center vh-100" style="z-index: 99;">
		<div class="card border-0 shadow m-2" style="width: 24rem;">
			<div class="card-body">
				<h3 class="text-center mb-2">
					Sistem Logistik
				</h3>

				<form method="post" action="process.php" enctype="multipart/form-data">
					<input value="login" name="request" hidden>

					<div class="form-group">
						<label for="username"> Username </label>
						<div class="input-group">
							<span class="input-group-text bi-person-fill"></span>
							<input type="text" id="username" name="username" class="form-control" placeholder="Username" >
						</div>
					</div>

					<div class="form-group">
						<label for="password"> Password </label>
						<div class="input-group">
							<span class="input-group-text bi-key "></span>
							<input type="password" id="password" name="password" class="form-control" placeholder="Password" >
						</div>
					</div>

					<?php if( isset($_SESSION['login_error'])){?>
					<div class="bg-danger text-white p-2 mt-1 mb-1 rounded">
						<p class="text-center">
							<?php echo $_SESSION['login_error']; unset($_SESSION['login_error']);?>
						</p>
					</div>
					<?php }?>

					<div class=" mt-2">
						<button type="submit" class="w-100 btn btn-primary text-white">
							Login
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

<script type="text/javascript" src="../../asset/bs5/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../../asset/fa6/js/all.min.js"></script>
</body>
</html>