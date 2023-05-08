<?php
require_once('includes/config.php'); 										
require_once('includes/class.customer_login.php');
$lgn = new CustomerLogin;

$ts = time();
$msg = '';

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
	
</head>
<body>


<?php
//require_once('top.php');
require_once('nav.php');
?>

<?php
echo "<div style='color:red; margin:10px;'>".$msg."</div>";
?>

   	
<section class="ftco-section ftco-no-pt" style="background-color: #FFF1E5;">
	<div class="container">
<h4>
Please read these terms of service before using this site.
</h4>
<br />
<hr />
<strong>
Conditions of Use
</strong>
<br />
We will provide free services to you, which are subject to the conditions stated below 
in this document. Every time you visit this website, use its services or 
make a purchase, you accept the following conditions. 
<br />
<hr />
<strong>
Privacy Policy
</strong>
<br />
Before you continue using our website we advise you to read our privacy policy 
regarding our user data collection. 
<br />
<hr />
<strong>
Copyright
</strong>
<br />
Content published on this website (digital downloads, images, texts, graphics, logos) 
is the property of site users and owner or its content creators and protected by 
international copyright laws. 
<br />
<hr />
<strong>
Communications
</strong>
<br />
The entire communication with us is electronic. Every time you send us an email 
or visit our website, you are going to be communicating with us or users 
engaged in public participation. 
If you subscribe to the our website, you might receive occasional emails. 
<br />
<hr />
<strong>
Disputes
</strong>
<br />
Any dispute related in any way to your visit to this website or to products you get 
from us shall are not guaranteed.
<br />
<hr />
<strong>
Comments, Reviews, and Emails
</strong>
<br />
Visitors may post content as long as it is not obscene, illegal, defamatory, threatening, 
infringing of intellectual property rights, invasive of privacy or injurious 
in any other way to third parties. 
Content has to be free of software viruses, political campaign, and commercial solicitation.
We reserve all rights but not the obligation to remove andor edit such content. 
When you post your content, you grant us non-exclusive, royalty-free and irrevocable right to use, 
reproduce, publish, modify such content throughout the world in any media.
<br />
<hr />
<strong>
License and Site Access
</strong>
<br />
We grant you unlimited license to access and make personal use of this website. 
<br />
<hr />
<strong>
User Account
</strong>
<br />
If you are an owner of an account on this website, you are solely responsible for 
maintaining the confidentiality of your private email, username and password. 
You are responsible for all activities that occur under your account or password.
We reserve all rights to terminate accounts, edit or remove content and cancel orders in 
their sole discretion.
<br />
<br />
Expert Answer 

	</div>
</section>


	
<?php
require_once('footer.php');
?>
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
