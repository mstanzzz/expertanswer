<?php
require_once('includes/config.php'); 										
require_once('includes/class.customer_login.php');
$lgn = new CustomerLogin;
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
<link rel="stylesheet" href="css/magnific-popup.css">    
    <!-- owl.carousel -->
    <!-- owl.theme -->
</head>
<body>

<?php
if(!isset($msg)) $msg = '';
require_once('nav.php');
?>
   	
    <section class="ftco-section ftco-no-pt" style="background-color: #FFF1E5;">
    	<div class="container">
    		<div class="row d-flex no-gutters">
    			<div class="col-md-6 d-flex">
    				<div class="img img-video d-flex align-self-stretch align-items-center justify-content-center justify-content-md-center mb-4 mb-sm-0" style="background-image:url(images/about.jpg);">
    				</div>
    			</div>
    			<div class="col-md-6 pl-md-5 py-md-5">
    				<div class="heading-section pl-md-4 pt-md-5">
    					<span class="subheading">Ask an Expert Get an Expert Answer</span>
					<h2 class="mb-4">Community Collaboration</h2>
					
					<p>
					As people’s skill sets get increasingly specialized, collaboration as a practice becomes more important 
					than ever. But what does that mean exactly? What is collaboration?
					<br />
					Although “collaboration” has become a bit of a corporate buzzword, that doesn’t mean that it’s an empty cliche. 
					On the contrary, collaboration in the virtual workplace is what makes teamwork successful. 
					It’s really that simple.
					<br />
					Collaboration is when a group of people come together and contribute their expertise for the benefit of a 
					shared objective, project, or mission. It’s a photographer working with a designer to create a cover image, 
					or a technology department regularly convening with the marketing team to plug away at quarterly goals. 
					In other words, collaboration is the process of group work. But it’s also a learned skill. How well you 
					collaborate with others will greatly impact the outcome of the group project.
					
					</p>								
				
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


<!--
    <section class="ftco-counter bg-light ftco-no-pt" id="section-counter">
    	<div class="container">
				<div class="row">
          <div class="col-md-6 col-lg-3 d-flex justify-content-center counter-wrap ftco-animate">
            <div class="block-18 text-center">
              <div class="text">
                <strong class="number" data-number="50">0</strong>
              </div>
              <div class="text">
              	<span>Years of Experienced</span>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-3 d-flex justify-content-center counter-wrap ftco-animate">
            <div class="block-18 text-center">
              <div class="text">
                <strong class="number" data-number="8500">0</strong>
              </div>
              <div class="text">
              	<span>Cases Completed</span>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-3 d-flex justify-content-center counter-wrap ftco-animate">
            <div class="block-18 text-center">
              <div class="text">
                <strong class="number" data-number="20">0</strong>
              </div>
              <div class="text">
              	<span>Awards Won</span>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-3 d-flex justify-content-center counter-wrap ftco-animate">
            <div class="block-18 text-center">
              <div class="text">
                <strong class="number" data-number="50">0</strong>
              </div>
              <div class="text">
              	<span>Expert Consultant</span>
              </div>
            </div>
          </div>
        </div>
    	</div>
    </section>



-->
















