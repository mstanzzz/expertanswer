<?php
//define('__ROOT__', dirname(dirname(__FILE__)));
require_once('includes/config.php'); 

$msg = "";

$ts = time();

if(isset($_POST["contact"])){

	$name = (isset($_POST["name"]))? addslashes($_POST["name"]) : "";
	
	$email = (isset($_POST["email"]))? addslashes($_POST["email"]) : "";
	$subject = (isset($_POST["subject"]))? addslashes($_POST["subject"]) : "";
	$message = (isset($_POST["message"]))? addslashes($_POST["message"]) : "";
	
	if(!isset($_SESSION['ip'])) $_SESSION['ip'] = '';
	
	$stmt = $db->prepare("INSERT INTO contact
					   (name
						,email 
						,subject
						,message
						,when_sent
						,ip)
						VALUES
						(?,?,?,?,?,?)"); 
		
		//echo 'Error INSERT   '.$db->error;
	
		
			if(!$stmt->bind_param("ssssis",
						$name
						,$email 
						,$subject
						,$message
						,$ts
						,$_SESSION['ip'])){
		
			echo 'Error-2 '.$db->error;
		
		}else{
			$stmt->execute();
			$stmt->close();
			
			//$the_id = $db->insert_id;
			
			$msg = "Your message was sent, thank you!";
		}

	
	
}
										
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" 
      type="image/png" 
      href="<?php echo SITEROOT."/favicon.png"; ?>" >

<title>Expert Answer</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
<meta name="google-signin-client_id" content="874343353343-qlj921hrcnvt8srlhmvk69i4t0ivti2q.apps.googleusercontent.com">   
<link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/flat_icon.css">    	
<link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php
//require_once('top.php');
require_once('nav.php');
?>

<!--
<section class="hero-wrap hero-wrap-2" 
style="background-image: url('images/bg_2.jpg');" data-stellar-background-ratio="0.5">
	<div class="overlay"></div>
	<div class="container">
		<div class="row no-gutters slider-text align-items-end">
			<div class="col-md-9 ftco-animate pb-5">
				<p class="breadcrumbs mb-2"><span class="mr-2"><a href="index.html">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Contact Us <i class="ion-ios-arrow-forward"></i></span></p>
				<h1 class="mb-0 bread">Contact Us</h1>
			</div>
		</div>
	</div>
</section>
-->

<section class="ftco-section bg-light">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="wrapper">
					<div class="row no-gutters">
						<div class="col-lg-8 col-md-7 order-md-last d-flex align-items-stretch">
							<div class="contact-wrap w-100 p-md-5 p-4">
								<h3 class="mb-4">Get in touch</h3>
								<div id="form-message-warning" class="mb-4"></div> 
								<div id="form-message-success" class="mb-4">
								<?php
								echo $msg;
								?>
								</div>
								<form method="POST" id="contactForm" name="contactForm" class="contactForm">
								<input type="hidden" name="contact" value="1" />
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="label" for="name">Full Name</label>
											<input type="text" class="form-control" name="name" id="name" placeholder="Name">
										</div>
									</div>
									<div class="col-md-6"> 
										<div class="form-group">
											<label class="label" for="email">Email Address</label>
											<input type="email" class="form-control" name="email" id="email" placeholder="Email">
										</div>
									</div>
									
									
									<div class="col-md-12">
										<div class="form-group">
											<label class="label" for="subject">Subject</label>
											<input type="text" class="form-control" name="subject" id="subject" placeholder="Subject">
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<label class="label" for="#">Message</label>
											<textarea name="message" class="form-control" id="message" cols="30" rows="4" placeholder="Message"></textarea>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<input type="submit" value="Send Message" class="btn btn-primary">
											<div class="submitting"></div>
										</div>
									</div>
								</div>
								</form>
							</div>
						</div>
						<div class="col-lg-4 col-md-5 d-flex align-items-stretch">
							<div class="info-wrap bg-primary w-100 p-md-5 p-4">
								<h3>Let's get in touch</h3>
								<p class="mb-4">We're open for any suggestion or just to have a chat</p>
								<div class="dbox w-100 d-flex align-items-center">
									<div class="icon d-flex align-items-center justify-content-center">
										<span class="fa fa-paper-plane"></span>
									</div>
									<div class="text pl-3">
										<p><span>Email:</span> <a href="mailto:info@yoursite.com">admin@Expert Answer.com</a></p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<?php
require_once('footer.php');
?>
    
</body>
</html>






