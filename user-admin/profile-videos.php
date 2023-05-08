<?php
$msg = '';
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

	</head>

	<body style="background-color: #FFF1E5;">
		<?php
			require_once('includes/user-admin-nav.php');
		?>

		<main class="container my-3 p-0">
			<div class="card shadow-sm">
				<div class="card-header">VIDEOS</div>
				<div class="card-body">
					<form name="form" action="profile-videos.php" method="post">
						<div class="d-flex justify-content-end">
							<div>
								<button class="btn btn-primary btn-sm" name="set_active" type="submit"><i class="icon-ok"></i> Save Changes</button>
							</div>

							<div class="ml-3">
								<a class="btn btn-info btn-sm" href="add-video.php"><i class="icon-plus"></i> Add a New Video</a>
							</div>
						</div>
									
						<div class="card mt-3 shadow-sm">
							<div class="card-body">
								<div class="table-responsive">
									<table class="table">
										<thead>
										<tr class="table-secondary">
											<th width="20%">&nbsp;</th>
											<th width="10%">Active</th>
											<th>&nbsp;</th>
											<th>&nbsp;</th>
										</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div>
							</div>
						</div>

					</form>
				</div>
			</div>
		</main>

		<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

		<script>
			let activeNav="profile-video";
		</script>

		<?php
			require_once('navbar-effect.php');
		?>

	</body>
</html>
