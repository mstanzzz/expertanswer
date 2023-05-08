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

		<div class="container my-3 p-0">
			<div class="d-flex justify-content-end">
				<a class="btn btn-info" href="profile-gallery.php"><i class="icon-arrow-left"></i> Back</a>
			</div>
		</div>

		<main class="container my-3 p-0">
			<div class="card shadow-sm">
				<div class="card-header">Edit Gallery Image</div>
					<div class="card-body mt-3">
						<form name="form" action="profile-gallery.php" method="post">
							<div class="d-flex justify-content-end">
								<button type="submit" class="btn btn-primary" name="add_article"><i class="icon-ok"></i> Save</button>
							</div>

							<div class="d-flex justify-content-center">
								<div class="card mt-3">
									<div class="card-body">
										<div class="row">
											<div class="col-md card-img-cont">
												<img src="../img/nat.png" alt="Uploaded Image">
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="form-group mt-3">
								<label for="activeEditor">Description</label>
								<textarea class="form-control" id="activeEditor" name="activeEditor" rows="10"></textarea>
							</div>
							
							<div class="d-flex justify-content-end">
								<?php 
								$_SESSION['ret_dir'] = 'user-admin';
								$_SESSION['ret_page'] = 'add-gallery-img';
								$url_str = "../upload/upload-pre-crop.php";
								$url_str .= "?img_type=gallery";
								?>
								<a href="<?php echo $url_str; ?>" onClick="ajax_set_blog_session();"  
								class="btn btn-info"><i class="icon-cloud-upload"></i> Upload Main Image</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</main>

		<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

	</body>
</html>
