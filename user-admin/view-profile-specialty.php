<?php
$msg = (isset($_GET["msg"])) ? $_GET["msg"] : "";
$specialty_id = (isset($_GET["specialty_id"])) ? $_GET["specialty_id"] : 0;
?>
<!doctype html>
<html lang="en">
	<head>
		<link rel="icon" 
			type="image/png" 
			href="<?php echo "../favicon.png"; ?>" >

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title>Expert Answer</title>

		<!-- Bootstrap CSS -->
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

			<div class="card shadow-sm mt-3">
				<div class="card-header">Edit Specialty</div>
				<div class="card-body">
					<form name="edit_specialty_form" action="profile-specialties.php" method="post" target="_top">
						<input id="specialty_id" type="hidden" name="specialty_id" value="<?php echo $specialty_id;  ?>" />
						<div class="form-group">
							<label form="name">Name</label>
							<input class="form-control" id="name" type="text" name="name" value="" maxlength="255" />
						</div>
						<div class="form-group">
							<label form="description">Description</label>
							<textarea class="form-control" id="description" name="description" rows="10"></textarea>
						</div>
						<div class="d-flex justify-content-end">
							<button class="btn btn-primary" name="edit_specialty" type="submit"><i class="icon-ok"></i> Save Changes</button>
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
