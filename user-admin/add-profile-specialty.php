<?php
$msg = (isset($_GET["msg"])) ? $_GET["msg"] : "";
?>
<!doctype html>
<html lang="en">
	<head>
		<link rel="icon" 
			type="image/png" 
			href="<?php echo "../favicon.png"; ?>" >

			<!-- Required meta tags -->
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title>Expert Answer</title>

		<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
		<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="./assets/css/base.css">

		<script>

		$(document).ready(function() {

		});
		</script>
	</head>
	<body style="background-color: #FFF1E5;">

		<?php
			require_once('includes/user-admin-nav.php');
		?>

		<main class="container my-3 p-0">
			<div class="card shadow-sm">
				<div class="card-header">Add a New Specialty</div>
				<div class="card-body mt-3">

					<form name="add_specialty_form" action="profile-specialties.php" method="post" target="_top">
						<fieldset>
							<div class="colcontainer formcols form-group">
								<label for="name">Name</label>
								<input type="text" id="name" class="form-control" name="name" value="" maxlength="255" />
							</div>
							<div class="colcontainer formcols form-group">
								<label for="description">Description</label>
								<textarea id="description" class="form-control" name="description" rows="15"></textarea>
							</div>
						</fieldset>
						<div class="d-flex justify-content-end">
							<button class="btn btn-large btn-primary" name="add_specialty" type="submit"><i class="icon-plus"></i> Add New Specialty</button>
						</div>
					</form>
			
				</div>
			</div>
		</main>

		<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>


	</body>
</html>


