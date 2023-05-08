<?php

$twitter = '';
$facebook = '';
$linkedin = '';
$google_plus = '';
$youtube = '';
$instagram = '';

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
		function validate(theform){
					
			return true;
		}

		</script>

	</head>

	<body style="background-color: #FFF1E5;">
		<?php
			require_once('includes/user-admin-nav.php');
		?>

		<main class="container my-3 p-0">
			<div class="card shadow-sm">
				<div class="card-header">My Social Media</div>
				<div class="card-body">
					
					<form name="form" action="social-links.php" method="post" target="_top" class="pure-form">

						<div class="row">
							<div class="col-12 col-md-6 form-group">
								<label for="input_twitter">Twitter</label>
								<input type="text" name="twitter" value="<?php echo $twitter; ?>" class="form-control" id="input_twitter" >
								<small class="form-text">Enter the link to your Twitter page.</small>
							</div>
							
							<div class="col-12 col-md-6 form-group">
								<label for="input_facebook">Facebook</label>
								<input type="text" name="facebook" value="<?php echo $facebook; ?>" class="form-control" id="input_facebook" >
								<small class="form-text">Enter the link to your Facebook page.</small>
							</div>
						</div>

						<div class="row">		
							<div class="col-12 col-md-6 form-group">
								<label for="input_linkedin">LinkedIn</label>
								<input type="text" name="linkedin" value="<?php echo $linkedin; ?>" class="form-control" id="input_linkedin" >
								<small class="form-text">Enter the link to your LinkedIn page.</small>
							</div>
													
							<div class="col-12 col-md-6 form-group">
								<label for="input_google_plus">Google+</label>
								<input type="text" name="google_plus" value="<?php echo $google_plus; ?>" class="form-control" id="input_google_plus" >
								<small class="form-text">Enter the link to your Google+ page.</small>
							</div>
						</div>

						<div class="row">				
							<div class="col-12 col-md-6 form-group">
								<label for="input_youtube">YouTube</label>
								<input type="text" name="youtube" value="<?php echo $youtube; ?>" class="form-control" id="input_youtube" >
								<small class="form-text">Enter the link to your YouTube page.</small>
							</div>
													
							<div class="col-12 col-md-6 form-group">
								<label for="instagram">Instagram</label>
								<input type="text" name="instagram" value="<?php echo $instagram; ?>" class="form-control" id="instagram" >
								<small class="form-text">Enter the link to your YouTube page.</small>
							</div>
						</div>

						<div class="d-flex justify-content-end mt-5">
							<button class="btn btn-primary" name="update" type="submit"><i class="icon-ok"></i> Save</button>
						</div>
					</form>

				</div>
			</div>
		</main>

		<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

		<script>
			let activeNav="social-links";
		</script>

		<?php
			require_once('navbar-effect.php');
		?>

	</body>
</html>