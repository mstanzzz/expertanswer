<?php
if(strpos($_SERVER['REQUEST_URI'], 'Expert Answer/' )){    
	$real_root = $_SERVER['DOCUMENT_ROOT'].'/Expert Answer'; 
}else{
	$real_root = '..'; 	
}

require_once('../includes/config.php'); 
require_once('../includes/class.customer_login.php');
$lgn = new CustomerLogin;

$msg = (isset($_GET['msg'])) ? $_GET['msg'] : ""; 

if($msg == 'na') $msg = 'Could Not Authenticate'; 

$signout = (isset($_GET['signout'])) ? $_GET['signout'] : 0;

if($signout){
	$lgn->logOut();
}

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
		
		<script>
			function signOut() {
				
				if(typeof gapi.auth2 === 'undefined'){
					console.log('Not Deffff.');
				}else{
					var auth2 = gapi.auth2.getAuthInstance();
					auth2.signOut().then(function () {
					console.log('User signed out.');
					});
				}
			}

			function validate(theform){
						
				return true;
			}
		</script>

	</head>

	<?php
		if($signout){
			echo "<body onload='signOut()'>";
		}else{
			echo "<body style='background-color: #FFF1E5;'>";	
		}
	?>
		<nav class="navbar navbar-expand-lg navbar-dark">
			<div class="container d-flex flex-column">
				<div class="d-flex justify-content-center navbar-translate w-100">
					<div class="navbar-brand">
						<img src="../img/nat.png" />
					</div>
				</div>
			</div>
		</nav>

		<main class="d-flex flex-column align-items-center">
			<div class="card shadow-sm">
				<div class="card-header">Profile Administration Panel Login</div>
				<div class="card-body">
					<form action="user-admin-login.php" method="post">
						<div class="form-group">
							<label for="user_name">User Name (email)</label>
							<input class="form-control" type="email" name="user_name" placeholder="User Name (email)">
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input class="form-control" type="password" name="password" placeholder="Password">
						</div>
						
						<div class="d-flex justify-content-end mt-3">
							<button type="submit" class="btn btn-primary"><i class="icon-signin"></i> Sign in</button>
						</div>
					</form>
				</div>

				<div class="d-flex justify-content-center my-3">      
					<a class="btn btn-info" href="../"><i class="icon-signout"></i> EXIT to main page</a>
				</div>
			</div>

		</main>

	</body>
</html>