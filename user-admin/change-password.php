<?php
$profile_id = 1;
$msg = (isset($_GET['msg'])) ? $_GET['msg'] : '';
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<link rel="icon" 
			type="image/png" 
			href="<?php echo "../favicon.png"; ?>" >

			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
			<title>Expert Answer</title>
			<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
		<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

			<link rel="stylesheet" type="text/css" href="./assets/css/base.css">

		<script>
		function validate(){
			
			
		}

		</script>

	</head>
	<body style="background-color: #FFF1E5;">
		<?php
			require_once('includes/user-admin-nav.php');
		?>

		<main class="container my-3 p-0">
			<div class="card shadow-sm">
				<div class="card-header">Change Password</div>
				<div class="card-body">
					<form name="form_2" action="user-admin-landing.php" onsubmit="return validate()" method="post" enctype="multipart/form-data" class="pure-form">	
						<div class="form-group">
							<label for="input_new_password">New Password</label>
							<input type="password" name="new_password" class="form-control" id="input_new_password" >
							<small class="form-text">Enter the link to your Twitter page.</small>
						</div>
						<div class="form-group">
							<label for="input_confirm_new_password">Confirm New Password</label>
							<input type="password" name="confirm_new_password" class="form-control" id="input_confirm_new_password" >
							<small class="form-text">Enter the link to your Twitter page.</small>
						</div>
						<div class="d-flex justify-content-end mt-3">
							<button type="submit" class="btn btn-primary" name="change_password"><i class="icon-exchange"></i> Change Password</button>
						</div>
					</form>
				</div>
			</div>
		</main>

		<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

		<script>
			let activeNav="profile-pass";
		</script>

		<?php
			require_once('navbar-effect.php');
		?>

	</body>
</html>


