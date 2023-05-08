<?php

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

		tinyMCE.init({
			mode : "textareas",
			theme : "advanced",
			content_css : "../css/mce.css"
		});

		</script>
	</head>
	<body style="background-color: #FFF1E5;">
		<?php
			require_once('includes/user-admin-nav.php');
		?>

		<main class="container my-3 p-0">
			<div class="card shadow-sm">
				<div class="card-header">Article Comments</div>
				<div class="card-body">

					<form name="form" action="article-comments.php?article_id=1" method="post" enctype="multipart/form-data">       
						<input type="hidden" name="set_active" value="1">

						<div class="d-flex justify-content-end mb-3">
							<button class="btn btn-primary" name="add" type="submit"><i class="icon-ok"></i> Set Actives</button>
						</div>
						
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr class="table-secondary">
										<th width="40%">
											Comment
										</th>
										<th width="20%">
											Name
										</th>
										
										<th width="20%">
											Email
										</th>
										
										<th width="10%">
											Date
										</th>
										<th width="5%">
											Active
										</th>
										<th width="5%">
										</th>
									</tr>
								</thead>

								<tbody>
								</tbody>
							</table>
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

