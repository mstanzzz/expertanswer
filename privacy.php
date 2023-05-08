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
Please read before using this site.
</h4>
<br />
<hr />
<strong>
Privacy Policy
</strong>
<br />
Last updated October 20, 2020
<br />
Thank you for choosing to be part of our community at ExprtNat Inc ("Company", "we", "us", "our"). 
We are committed to protecting your personal information and your right to privacy. 
If you have any questions or concerns about this privacy notice, or our practices with 
regards to your personal information, please contact us at mark@nazardesigns.com.
<br />
When you visit our website , and more generally, use any of our services, 
we appreciate that you are trusting us with your personal information. 
We take your privacy very seriously. 
In this privacy notice, we seek to explain to you in the clearest way possible what 
information we collect, how we use it and what rights you have in relation to it. 
We hope you take some time to read through it carefully, as it is important. 
If there are any terms in this privacy notice that you do not agree with, 
please discontinue use of our Services immediately.
<br />
This privacy notice applies to all information collected through our Services, 
as well as, any related services, sales, marketing or events.
<br />
Please read this privacy notice carefully as it will help you understand what 
we do with the information that we collect.
<br />
<br />
<strong>
WHAT INFORMATION DO WE COLLECT?
</strong>
<br />
<strong>
Personal information you disclose to us
</strong>
<br />
In Short:  We collect personal information that you provide to us.
<br />
We collect personal information that you voluntarily provide to us when you register on the Website, express an interest in obtaining information about us or our products and Services, when you participate in activities on the Website (such as by posting messages in our online forums or entering competitions, contests or giveaways) or otherwise when you contact us.
<br />
The personal information that we collect depends on the context of your interactions with us and the Website, the choices you make and the products and features you use. The personal information we collect may include the following:
<br />
Personal Information Provided by You. We collect names; phone numbers; email addresses; job titles; and other similar information.
<br />
All personal information that you provide to us must be true, complete and accurate, and you must notify us of any changes to such personal information.
<br />
Information automatically collected
<br />
In Short:  Some information — such as your Internet Protocol (IP) address and/or browser and device characteristics — is collected automatically when you visit our Website.
<br />
We automatically collect certain information when you visit, use or navigate the Website. This information does not reveal your specific identity (like your name or contact information) but may include device and usage information, such as your IP address, browser and device characteristics, operating system, language preferences, referring URLs, device name, country, location, information about how and when you use our Website and other technical information. This information is primarily needed to maintain the security and operation of our Website, and for our internal analytics and reporting purposes.
<br />
Like many businesses, we also collect information through cookies and similar technologies.
<br />
HOW DO WE USE YOUR INFORMATION?
<br />
In Short:  We process your information for purposes based on legitimate business interests, the fulfillment of our contract with you, compliance with our legal obligations, and/or your consent.
<br />
We use personal information collected via our Website for a variety of business purposes described below. We process your personal information for these purposes in reliance on our legitimate business interests, in order to enter into or perform a contract with you, with your consent, and/or for compliance with our legal obligations. We indicate the specific processing grounds we rely on next to each purpose listed below.
<br />
We use the information we collect or receive:
<br />
To facilitate account creation and logon process. If you choose to link your account with us to a third-party account (such as your Google or Facebook account), we use the information you allowed us to collect from those third parties to facilitate account creation and logon process for the performance of the contract.
<br />
To post testimonials. We post testimonials on our Website that may contain personal information. 
Prior to posting a testimonial, we will obtain your consent to use your name and the content 
of the testimonial. If you wish to update, or delete your testimonial, please log in to your account.
Request feedback. We may use your information to request feedback and to contact you about your 
use of our Website.
<br />
To enable user-to-user communications. We may use your information in order to enable 
user-to-user communications with each user's consent.
<br />
<strong>
WILL YOUR INFORMATION BE SHARED WITH ANYONE?
</strong>
<br />
In Short:  We only share information with your consent, to comply with laws, to provide you 
with services, to protect your rights, or to fulfill business obligations.
<br />
HOW LONG DO WE KEEP YOUR INFORMATION?
</strong>
<br />
In Short:  We keep your information for as long as necessary to fulfill the purposes outlined in 
this privacy notice unless otherwise required by law.
<br />
We will only keep your personal information for as long as it is necessary for the 
purposes set out in this privacy notice, unless a longer retention period is 
 or permitted by law (such as tax, accounting or other legal requirements). 
 No purpose in this notice will require us keeping your personal information 
 for longer than the period of time in which users have an account with us.
<br />
When we have no ongoing legitimate business need to process your personal information, we will either delete or anonymize such information, or, if this is not possible (for example, because your personal information has been stored in backup archives), then we will securely store your personal information and isolate it from any further processing until deletion is possible.
<br />
<strong>
WHAT ARE YOUR PRIVACY RIGHTS?
</strong>
In Short:  In some regions, such as the European Economic Area, you have rights that allow you 
greater access to and control over your personal information. You may review, 
change, or terminate your account at any time.
<br />
In some regions (like the European Economic Area), you have certain rights under applicable 
data protection laws. These may include the right (i) to request access and obtain a copy 
of your personal information, (ii) to request rectification or erasure; 
(iii) to restrict the processing of your personal information; and 
(iv) if applicable, to data portability. In certain circumstances, 
you may also have the right to object to the processing of your personal information. 
To make such a request, please use the contact details provided below. 
We will consider and act upon any request in accordance with applicable data protection laws.
<br />
If we are relying on your consent to process your personal information, you have the right 
to withdraw your consent at any time. 
Please note however that this will not affect the lawfulness of the processing before 
its withdrawal, nor will it affect the processing of your personal information conducted 
in reliance on lawful processing grounds other than consent.
<br />
If you are a resident in the European Economic Area and you believe we are unlawfully 
processing your personal information, you also have the right to complain to your local 
data protection supervisory authority. You can find their contact details 
here: http://ec.europa.eu/justice/data-protection/bodies/authorities/index_en.htm.
<br />
If you are a resident in Switzerland, the contact details for the data protection authorities are available here: https://www.edoeb.admin.ch/edoeb/en/home.html.
<br />
<br />
<strong>
Account Information
</strong>
<br />
If you would at any time like to review or change the information in your account or terminate your account, you can:
Log in to your account settings and update your user account.
<br />
<br />
Upon your request to terminate your account, we will deactivate or delete your account and 
information from our active databases. However, we may retain some information in our 
files to prevent fraud, troubleshoot problems, assist with any investigations, enforce 
our Terms of Use and/or comply with applicable legal requirements.
<br />
<br />
Cookies and similar technologies: Most Web browsers are set to accept cookies by default. 
If you prefer, you can usually choose to set your browser to remove cookies and to reject cookies. 
If you choose to remove cookies or reject cookies, this could affect certain features or services 
of our Website. To opt-out of interest-based advertising by advertisers on our Website 
visit http://www.aboutads.info/choices/.
<br />
<br />
Opting out of email marketing: You can unsubscribe from our marketing email list at any time 
by clicking on the unsubscribe link in the emails that we send or by contacting us using the details provided below. You will then be removed from the marketing email list — however, we may still communicate with you, for example to send you service-related emails that are necessary for the administration and use of your account, to respond to service requests, or for other non-marketing purposes. To otherwise opt-out, you may:
Access your account settings and update your preferences.
<br />
<br />
Your rights with respect to your personal data
<br />
<br />
Right to request deletion of the data - Request to delete
<br />
<br />
You can ask for the deletion of your personal information. If you ask us to delete your personal information, we will respect your request and delete your personal information, subject to certain exceptions provided by law, such as (but not limited to) the exercise by another consumer of his or her right to free speech, our compliance requirements resulting from a legal obligation or any processing that may be required to protect against illegal activities.
<br />
<br />
Right to be informed - Request to know
<br />
<br />
We will not discriminate against you if you exercise your privacy rights.
<br />
<strong>
Verification process
</strong>
<br />
Upon receiving your request, we will need to verify your identity to determine you are the same person about whom we have the information in our system. These verification efforts require us to ask you to provide information so that we can match it with information you have previously provided us. For instance, depending on the type of request you submit, we may ask you to provide certain information so that we can match the information you provide with the information we already have on file, or we may contact you through a communication method (e.g. phone or email) that you have previously provided to us. We may also use other verification methods as the circumstances dictate.
<br />
We will only use personal information provided in your request to verify your identity or authority to make the request. To the extent possible, we will avoid requesting additional information from you for the purposes of verification. If, however, if we cannot verify your identity from the information already maintained by us, we may request that you provide additional information for the purposes of verifying your identity, and for security or fraud-prevention purposes. We will delete such additionally provided information as soon as we finish verifying you.
<br />
If you have questions or comments about this notice, you may email us
<br />
<br />
ExprtNat Inc
<br />
3942 Alton Rd
<br />
Miami Beach, FL 33140
<br />
United States
<br />



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
