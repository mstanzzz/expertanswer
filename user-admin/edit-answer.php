<?php
$profile_id = 1;
$msg = (isset($_GET['msg'])) ? $_GET['msg'] : '';

?>
<!doctype html>
<html lang="en">
	<head>
		<link rel="icon" 
			type="image/png" 
			href="<?php echo "../favicon.png"; ?>" >

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
		<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

		<link rel="stylesheet" type="text/css" href="./assets/css/base.css">
		<title>Expert Answer</title>

		<script src="../js/tinymce/tinymce.min.js"></script>

		<script>
		tinymce.init({
			selector: 'textarea'
		});

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
				<div class="card-header">Edit Answer</div>
				<div class="card-body">
			
					<form name="form" action="view-question.php" method="post" target="_top">
						<input type="hidden" name="answer_id" value="1" />
						
						<div class="row">
							<div class="col-12 col-md-3"><h6>Customer Name</h6></div>
							<div class="col-12 col-md-9"><?php echo $visitor_name; ?></div>
						</div>
						<div class="row">
							<div class="col-12 col-md-3"><h6>Customer Email</h6></div>
							<div class="col-12 col-md-9"><?php echo $visitor_email; ?></div>
						</div>
						<div class="row">
							<div class="col-12 col-md-3"><h6>Date of Question</h6></div>
							<div class="col-12 col-md-9"></div>
						</div>

						<div class="row mt-3">
							<div class="col">
								<h2>Question</h2>
							</div>
						</div> 

						<div class="row">
							<div class="col">
								The question goes here
							</div>
						</div>

						<hr />
						
						<div class="form-group mt-3">
							<label for="answer">Your Answer</label>
							<textarea class="form-control" name="answer" rows="10"></textarea>
						</div>
						
						<div class="d-flex justify-content-end mt-3">
							<button class="btn btn-primary" name="update_answer" type="submit"><i class="icon-ok mr-2"></i>Submit Answer</button>
						</div>

					</form>
			
				</div>    
			</div>
		</div>

		<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

	</body>
</html>


