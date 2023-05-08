<?php
require_once('includes/config.php'); 										
require_once('includes/class.customer_login.php');
$lgn = new CustomerLogin;

$ts = time();
$msg = '';

$submit_type = isset($_POST['submit_type'])? $_POST['submit_type'] : '';

if($submit_type == "Sign Up"){

	$name = (isset($_POST['name'])) ? trim($_POST['name']) : 'New Member'; 	
	$password = (isset($_POST['password'])) ? trim($_POST['password']) : ''; 	
	$username = (isset($_POST['username'])) ? trim($_POST['username']) : ''; 	
	$u_id = $lgn->getProfileIdByEmail($username);
	if($u_id == 0){
		
		if($lgn->create_user($password, $username, $name)){								
			header('Location: '.SITEROOT.'/user-admin/user-admin-landing.php?thr=365');
		}		
	}else{
		$msg = "The Email Address Has Already Been Used";		
	}
	
}



if($submit_type == "Sign In"){
	$username = isset($_POST['username'])? trim($_POST['username']) : '';
	$password = isset($_POST['password'])? trim($_POST['password']) : '';	
			
	if($lgn->login($username,$password)){
		
		header('Location: '.SITEROOT.'/user-admin/user-admin-landing.php?thr=111555');
		
		//echo "<a href='/user-admin/user-admin-landing.php?thr=111555'>ADMIN</>";


	}else{
		$msg = 'The username and password was not recognized';	
	}
}

//echo "KVYHY";
//exit;





if(isset($_POST["contact"])){
	
	if(!isset($_SESSION['ip'])) $_SESSION['ip'] = '';

	$name = (isset($_POST["name"]))? addslashes($_POST["name"]) : "";
	
	$email = (isset($_POST["email"]))? addslashes($_POST["email"]) : "";
	$subject = (isset($_POST["subject"]))? addslashes($_POST["subject"]) : "";
	$message = (isset($_POST["message"]))? addslashes($_POST["message"]) : "";
	
	
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


require_once('includes/functions.php');
require_once('includes/class.profess.php');
require_once('includes/class.search.php');
require_once('includes/class.view.php');

$visitor_profile_id = $lgn->getProfileId();
$prof = new Professional;
$search = new Search;
$view = new View;

$slug = (isset($_GET['slug'])) ? $_GET['slug'] : 'home';

if($slug == 'signout'){	
	$lgn->logOut();
	$slug = 'home';	
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
	
	
<style>
.ex_cases_head{
	border-radius: 10px;
	background: black;
	padding-left: 20px;
	padding-top:1px;
	padding-bottom:1px;
	width: 300px;
	height: 40px;
	color: #DDEDEC;
	font-size:22px;
	cursor:pointer;

}

.ex_cases_list{
	display:none; 
	margin-left:-10px; 
	margin-top:6px;
	font-size:1.1em;
}

</style>

<!--
<script src="https://platform.linkedin.com/in.js" type="text/javascript">
        api_key: {YOUR_API_KEY_GOES_HERE}
        authorize: true
        lang:  es_ES
</script>

<script type="text/javascript" src="https://platform.linkedin.com/in.js">
    api_key: {YOUR_API_KEY_GOES_HERE}
    authorize: true
</script>

-->

</head>
<body style="background-color: #FFF1E5;">


<?php
//require_once('top.php');
require_once('nav.php');
?>

<?php
echo "<div style='color:red; margin:10px;'>".$msg."</div>";
?>


<?php
//echo "SITEROOT ".SITEROOT;
//exit;
?>




<div class="hero-wrap">
	<div class="home-slider owl-carousel">
		<div class="slider-item" style="background-image:url(images/bg_1.jpg);">
			<div class="overlay"></div>
			<div class="container">
				<div class="row no-gutters slider-text align-items-center justify-content-center">
					<div class="col-md-8 ">
						<div class="text w-100 text-center">
							<h2>Grow Your Business </h2>
							<h1 class="mb-4">Learn, Innovate and Collaborate</h1>
							<p><a href="#lgn" class="btn btn-white">
							Sign Up or Sign In
							</a></p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="slider-item" style="background-image:url(images/bg_2.jpg);">
			<div class="overlay"></div>
				<div class="container">
					<div class="row no-gutters slider-text align-items-center justify-content-center">
						<div class="col-md-8 ">
							<div class="text w-100 text-center">
								<h2>Get Expert Support</h2>
								<h1 class="mb-4">Get advice from professionals</h1>
								<p><a href="#" class="btn btn-white">Connect with us</a></p>
							</div>
						</div>
					</div>
			</div>
		</div>

		<div class="slider-item" style="background-image:url(images/bg_3.jpg);">
			<div class="overlay"></div>
			<div class="container">
				<div class="row no-gutters slider-text align-items-center justify-content-center">
					<div class="col-md-8 ">
						<div class="text w-100 text-center">
							<h2>Give Your Expert Advice</h2>
							<h1 class="mb-4">Give expert advice</h1>
							<p><a href="#" class="btn btn-white">Connect with us</a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

   	
<section class="ftco-section ftco-no-pt bg-light">
	<div class="container">
		<div class="row d-flex no-gutters">
			<div class="col-md-6 d-flex">
				<div class="img img-video d-flex align-self-stretch align-items-center justify-content-center justify-content-md-center mb-4 mb-sm-0" style="background-image:url(images/about.jpg);"></div>
			</div>
			<div class="col-md-6 pl-md-5 py-md-5">
				<div class="heading-section pl-md-4 pt-md-5">
					<span class="subheading">Use Expert Answer Without registering </span>
					<h2 class="mb-4">Anyone can use Expert Answer without registering</h2>
				</div>
				<div class="services-2 w-100 d-flex">
					<div class="icon d-flex align-items-center justify-content-center">
						<span class="flaticon-wealth"></span>
					</div>
					<div class="text pl-4">
						<h4>You can ask questions</h4>
						<p>Ask questions to all members or individual members</p>
					</div>
				</div>
				<div class="services-2 w-100 d-flex">
					<div class="icon d-flex align-items-center justify-content-center">
						<span class="flaticon-accountant"></span>
					</div>
					<div class="text pl-4">
						<h4>Search Through Questions and Answers</h4>
						<p>Search through existing questions and answers</p>
					</div>
				</div>
				<div class="services-2 w-100 d-flex">
					<div class="icon d-flex align-items-center justify-content-center">
						<span class="flaticon-teamwork"></span>
					</div>
					<div class="text pl-4">
						<h4>Search Articles and Profiles</h4>
						<p>Search through articles and member profiles</p>
					</div>
				</div>
				<div class="services-2 w-100 d-flex">
					<div class="icon d-flex align-items-center justify-content-center">
						<span class="flaticon-accounting"></span>
					</div>
					<div class="text pl-4">
						<h4>Your Questions Can Be Private or Public</h4>
						<p>You can control weather your questions are hidden or displayed to public viewers</p>
					</div>
				</div>
			</div>
		</div>
		
<span id="cc"></span>
	
	</div>
</section>




<section class="ftco-section bg-light ftco-no-pt">
	<center>    	
	<h2><strong>Example Areas of Expertise</strong></h2>
	<br />
	</center>		
	<div class="container">
    	<div class="row">
			<div class="col-md-6 col-lg-3 d-flex services align-self-stretch px-4">
				<div class="d-block">
					<div class="icon d-flex mr-2">
						<span class="flaticon-accounting-1"></span>
					</div>
					<div class="media-body">
						<h3 class="heading">Creativity and Aesthetics</h3>
						<p>Imaginative ideas that drive innovation and adds value in business, government or society</p>
					</div>
				</div>      
			</div>
			<div class="col-md-6 col-lg-3 d-flex services align-self-stretch px-4 ">
				<div class="d-block">
					<div class="icon d-flex mr-2">
						<span class="flaticon-tax"></span>
					</div>
					<div class="media-body">
						<h3 class="heading">Taxes, Finance &amp; Accounting</h3>
						<p>General business expertise specializing in taxation, accounting practices, and finance data analytics </p>
					</div>
				</div>    
			</div>
			<div class="col-md-6 col-lg-3 d-flex services align-self-stretch px-4 ">
				<div class="d-block">
					<div class="icon d-flex mr-2">
						<span class="flaticon-loan"></span>
					</div>
					<div class="media-body">
						<h3 class="heading">Technology &amp; Engineering</h3>
						<p>Engineering and technology management in areas like computing, manufacturing and construction services </p>
					</div>
				</div>      
			</div>
			<div class="col-md-6 col-lg-3 d-flex services align-self-stretch px-4">
				<div class="d-block">
					<div class="icon d-flex mr-2">
						<span class="flaticon-budget"></span>
					</div>
					<div class="media-body">
						<h3 class="heading">Business &amp; Entrepreneurship</h3>
						<p>
						Designing, launching and running a new business, which is often initially a small business including
						all cost, risk and profit in a business venture.	
						</p>
					</div>
				</div>      
			</div>
		</div>
	</div>
</section>

<section class="ftco-section ftco-no-pt bg-light ftco-faqs">
	<div class="container">
		<div class="row">
			<div class="col-lg-6">
				<div class="img-faqs w-100">
					<div class="img mb-4 mb-sm-0" style="background-image:url(images/about-2.jpg);"></div>
					<div class="img img-2 mb-4 mb-sm-0" style="background-image:url(images/about-1.jpg);"></div>
				</div>
			</div>
			<div class="col-lg-6 pl-lg-5">
				<div class="heading-section mb-5 mt-5 mt-lg-0">
					<span class="subheading">Free Membership</span>
					<h2 class="mb-3">Example Use Cases for Registered Members</h2>
				</div>
				<div class="myaccordion w-100">
					<div class="card" style="margin-bottom:10px;">
						<p class="mb-0 ex_cases_head" onClick="show_ex_cases_1();">Food and Cooking
						<span style="position:relative; left:80px; top:-3px;">
						<img src="images/PikPng.png" />
						</span>
						</p>				


						<div id="ex_cases_1" class="ex_cases_list">		
							<ol>
								<li>Job experience in food service and gastronomy</li>
								<li>Articles on cooking, kitchen and recipes</li>
								<li>Eating healthy foods affects the body</li>
								<li>Specialty cooking and ingredients used</li>
							</ol>
						</div>		
					</div>
					<div class="card" style="margin-bottom:10px;">
						<p class="mb-0 ex_cases_head" onClick="show_ex_cases_2();">Art and Graphics
						<span style="position:relative; left:96px; top:-2px;">
						<img src="images/PikPng.png" />
						</span>
						</p>				

						<div id="ex_cases_2" class="ex_cases_list">		
							<ol>
								<li>Showcase graphic arts portfolio</li>
								<li>Creative skills and experience</li>
								<li>Graphic design and visual communication</li>
								<li>Typography, photography and illustration </li>
							</ol>

						</div>			
					</div>
					<div class="card" style="margin-bottom:10px;">
						<p class="mb-0 ex_cases_head" onClick="show_ex_cases_3();">
						Branding and Marketing
						<span style="position:relative; left:288px; top:-43px;">
						<img src="images/PikPng.png" />
						</span>
						</p>				
						<div id="ex_cases_3" class="ex_cases_list">		
							<ol>
								<li>Brand marketing strategies </li>
								<li>Target audience, communicating emotion </li>
								<li>Establishing a company vision </li>
								<li>Techniques used in online branding</li>
							</ol>
						</div>		
					</div>
					<div class="card" style="margin-bottom:10px;">
						<p class="mb-0 ex_cases_head" onClick="show_ex_cases_4();">Auto Technician
						<span style="position:relative; left:106px; top:-1px;">
						<img src="images/PikPng.png" />
						</span>
						</p>				

						<div id="ex_cases_4" 
						style="display:none; margin-left:6px; margin-top:6px; font-size:1.1em;">		
							There are many skills that can be expressed in the field of auto mechanics as a variety of automobile makes and types exist. 
							In repairing cars, your role may be to diagnose the problem accurately and quickly. 
							Your job may involve the repair of a specific part or the replacement of one or more parts as assemblies.
							Basic vehicle maintenance is a fundamental part of a mechanic's work in modern industrialized countries while in others 
							they are only consulted when a vehicle is already showing signs of malfunction. 
							Preventive maintenance is also a fundamental part of a mechanic's job, but this is not possible in the case of vehicles 
							that are not regularly maintained by a mechanic. One misunderstood aspect of preventive maintenance is 
							scheduled replacement of various parts, which occurs before failure to avoid far more expensive damage. 
							Because this means that parts are replaced before any problem is observed, many vehicle owners will not 
							understand why the expense is necessary.
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<span id="contact"></span>

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
<form action="index.php" method="POST" id="contactForm" name="contactForm" class="contactForm">
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
								<div style="margin-top:40%;">
									<img src="images/neger.png" style="width:100%;" />
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

<script>
	function show_ex_cases_1(){
		var x = document.getElementById("ex_cases_1");
		if(x.style.display == "none"){		
			x.style.display = "block";
		}else{
			x.style.display = "none";			
		}
	}

	function show_ex_cases_2(){
		var x = document.getElementById("ex_cases_2");
		if(x.style.display == "none"){		
			x.style.display = "block";
		}else{
			x.style.display = "none";			
		}
	}

	function show_ex_cases_3(){
		var x = document.getElementById("ex_cases_3");
		if(x.style.display == "none"){		
			x.style.display = "block";
		}else{
			x.style.display = "none";			
		}
	}

	function show_ex_cases_4(){
		var x = document.getElementById("ex_cases_4");
		if(x.style.display == "none"){		
			x.style.display = "block";
		}else{
			x.style.display = "none";			
		}
	}
</script>




<a href="ask.html">ASK</a>

    
</body>
</html>



<!--

<section class="ftco-section testimony-section bg-light">
	<div class="overlay"></div>
		<div class="container">
			<div class="row justify-content-center pb-5 mb-3">
				<div class="col-md-7 heading-section heading-section-white text-center ">
					<h2>Testimonies &amp; Feedbacks</h2>
				</div>
			</div>
			<div class="row ">
				<div class="col-md-12">
					<div class="carousel-testimony owl-carousel ftco-owl">
						
						<div class="item">
							<div class="testimony-wrap py-4">
								<div class="icon d-flex align-items-center justify-content-center">
									<span class="fa fa-quote-left"></span>
								</div>
								<div class="text">
									<p class="mb-4" style="min-height:60px;">
									I need to customers for my home improvement business.
									After I set up my profile and began answering questions, 
									I built up a large customer base.  
									</p>
									<div class="d-flex align-items-center">
										<div class="user-img" style="background-image: url(images/person_1.jpg)"></div>
										<div class="pl-3">
											<p class="name">Roger Waters</p>
											<span class="position">Home Improvement Expert</span>
										</div>
									</div>
									<br />
									<br />
								</div>
							</div>
						</div>
						<div class="item">
							<div class="testimony-wrap py-4">
								<div class="icon d-flex align-items-center justify-content-center">
									<span class="fa fa-quote-left"></span>
								</div>
								<div class="text">
									<p class="mb-4" style="min-height:60px;">
Expert Answer gave me a free advertising platform to promote my skills and experience in chemical engineering. 
									</p>
									<div class="d-flex align-items-center">
										<div class="user-img" style="background-image: url(images/person_2.jpg)"></div>
										<div class="pl-3">
											<p class="name">Roger Scott</p>
											<span class="position">Chemical Engineer</span>
										</div>
									</div>
									<br />
									<br />									
								</div>
							</div>
						</div>
						<div class="item" >
							<div class="testimony-wrap py-4">
							<div class="icon d-flex align-items-center justify-content-center">
								<span class="fa fa-quote-left"></span>
							</div>
							<div class="text">
								<p class="mb-4" style="min-height:60px;">
								After I set up my profile and started answering questions and posting articles, 
								I received more work opportunities than I have time to take.   					
								</p>
								<div class="d-flex align-items-center">
									<div class="user-img" style="background-image: url(images/person_3.jpg)"></div>
									<div class="pl-3">
										<p class="name">Roger Scott</p>
										<span class="position">HVAC Technician</span>
									</div>
								</div>
								<br />
								<br />								
							</div>
						</div>
					</div>
					<div class="item">
						<div class="testimony-wrap py-4">
						<div class="icon d-flex align-items-center justify-content-center">
							<span class="fa fa-quote-left"></span>
						</div>
						<div class="text">
							<p class="mb-4" style="min-height:60px;">
							As a web developer, I use Expert Answer as a free platform to showcase my work and describe the programming languages
							and other technology I use.
							</p>
							<div class="d-flex align-items-center">
								<div class="user-img" style="background-image: url(images/person_1.jpg)"></div>
								<div class="pl-3">
									<p class="name">Roger Scott</p>
									<span class="position">Web Developer</span>
								</div>
							</div>
							<br />
							<br />
							
						</div>
					</div>
				</div>
				<div class="item">
					<div class="testimony-wrap py-4">
						<div class="icon d-flex align-items-center justify-content-center">
							<span class="fa fa-quote-left"></span>
						</div>
						<div class="text">
							<p class="mb-4" style="height:80px;">
							Expert Answer is a free platform to advertize my music production projects and decribe the technology I use 
							in recording, editing, mixing and mastering. 
							</p>
							<div class="d-flex align-items-center">
								<div class="user-img" style="background-image: url(images/person_2.jpg)"></div>
								<div class="pl-3">
										<p class="name">Roger Scott</p>
										<span class="position">Music Producer</span>
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



<section class="ftco-section">
	<div class="container">
		<div class="row justify-content-center pb-5 mb-3">
			<div class="col-md-7 heading-section text-center ">
				<h2>Latest Articles</h2>
			</div>
		</div>
		<div class="row d-flex">
			<div class="col-md-4 d-flex ">
				<div class="blog-entry align-self-stretch">
					<a href="full-article.php?aid=1" class="block-20 rounded" style="background-image: url('images/image_1.jpg');"></a>
					<div class="text p-4">
						<div class="meta mb-2">
							<div><a href="full-article.php?aid=1">March 31, 2020</a></div>                 
							<div><a href="full-article.php?aid=1" >Jack Frost</a></div>       
							<div><a href="full-article.php?aid=1" class="meta-chat"><span class="fa fa-comment"></span> 3</a></div>
						</div>
						<h3 class="heading">
							<a href="full-article.php?aid=1">
							Architects and engineers are inundated with the continual architectural cycle of projects 				
							</a>
						</h3>
					</div>
				</div>
			</div>
			<div class="col-md-4 d-flex ">
				<div class="blog-entry align-self-stretch">
					<a href="full-article.php?aid=2" class="block-20 rounded" style="background-image: url('images/image_2.jpg');"></a>
					<div class="text p-4">
						<div class="meta mb-2">
							<div><a href="full-article.php?aid=2">March 31, 2020</a></div>
							<div><a href="full-article.php?aid=2" >Don Trump</a></div>       
							<div><a href="full-article.php?aid=2" class="meta-chat"><span class="fa fa-comment"></span> 3</a></div>
						</div>
						<h3 class="heading">
							<a href="full-article.php?aid=2">
							The main task of an analyst is to perform an extensive analysis of financial statements. 
							</a>
						</h3>
					</div>
				</div>
			</div>
			<div class="col-md-4 d-flex ">
				<div class="blog-entry align-self-stretch">
					<a href="full-article.php?aid=3" class="block-20 rounded" style="background-image: url('images/image_3.jpg');"></a>
					<div class="text p-4">
						<div class="meta mb-2">
							<div><a href="full-article.php?aid=3">March 31, 2020</a></div>
							<div><a href="full-article.php?aid=3" >Joe Jackson</a></div>             
							<div><a href="full-article.php?aid=3" class="meta-chat"><span class="fa fa-comment"></span> 3</a></div>
						</div>
						<h3 class="heading">
							<a href="full-article.php?aid=3">
							Learn How to Trade Stocks the Market in 5 Steps
							</a>
						</h3>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


-->
