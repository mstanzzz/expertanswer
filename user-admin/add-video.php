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

	</head>
	<body style="background-color: #FFF1E5;">
		<?php
			require_once('includes/user-admin-nav.php');
		?>

		<div class="container my-3 p-0">
			<div class="d-flex justify-content-end">
				<a class="btn btn-info" href="profile-videos.php"><i class="icon-arrow-left"></i> Back</a>
			</div>
		</div>

		<main class="container my-3 p-0">
			<div class="card shadow-sm">
				<div class="card-header">Add Video Link</div>
					<div class="card-body mt-3">

					<form name="form" action="profile-videos.php" method="post" >

						<input type="hidden" name="add_video" value="1" />

						<div class="form-group">
							<label for="title">Title of Video</label>
							<input class="form-control" type="text" name="title" value="" maxlength="250"  />
						</div>
						
						<div class="form-group">
							<label for="url">Url (copy from source like youtube or bitchute)</label>
							<input class="form-control" type="text" name="url" value="" maxlength="250"  />
						</div>

						<div class="d-flex justify-content-end mt-5">
							<button class="btn btn-primary" name="add" type="submit"><i class="icon-plus"></i> ADD</button>
						</div>
						
						</table>
								
					</form>
				
				</div>
			</div>
		</main>

		<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

	</body>
</html>


