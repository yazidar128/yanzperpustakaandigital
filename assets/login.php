<?php
	$username = "";
	$password = "";

$errorMesssage = "";
$succesMessage = "";

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
</head>
<body>

	<div class="container my-5">
		<h2>LOGIN</h2>
	<form action="../controler/crud.php?aksi=login" method="POST">
			<div class="row mb-3">
				<label class="col-sm-3 col-form-label">Username</label>
				<div class="col sm-6">
					<input type="text" class="form-control" name="username" value="<?php echo $username; ?>">
				</div>
			</div>

			<div class="row mb-3">
				<label class="col-sm-3 col-form-label">password</label>
				<div class="col sm-6">
					<input type="password" class="form-control" name="password" value="<?php echo $password; ?>">
				</div>
			</div>

			<div class="row mb-3">
				<div class="offset-sm-3 col-sm-3 d-grid">
					<button type="submit" class="btn btn-success">Login</button>
					<a class="btn btn-outline-primary" href="daftar.php" role="button">Create</a>
				</div>
			 </div>
	</form>
    </div>

</body>
</html>