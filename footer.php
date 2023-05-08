<!--

https://developer.linkedin.com/docs/signin-with-linkedin#

Authentication Keys
Client ID:	77yved5uvpp766
 
Client Secret:	XFuNd9UbQziwW3Oy


network solutions get ssl
Use promo code SAVE30SSL at checkout


GOOGLE
https://developers.google.com/identity/sign-in/web/sign-in

<script src="https://apis.google.com/js/platform.js" async defer></script>


?onload=renderButton
-->

  <script src="https://apis.google.com/js/platform.js" async defer></script>

<script>


function testttt(){	
	alert("aaa");	
}

function set_google_data(googleUser) {
	var profile = googleUser.getBasicProfile();

	document.getElementById("w_google_id").value = profile.getId();
	document.getElementById("w_google_name").value = profile.getName();
	document.getElementById("w_google_image").value = profile.getImageUrl();
	document.getElementById("w_google_email").value = profile.getEmail();
	
	document.getElementById("login_with_google").submit();
}

function onSuccess(googleUser) {
	//console.log('Logged in as: ' + googleUser.getBasicProfile().getName());	
	set_google_data(googleUser);
}
function onFailure(error) {
	console.log(error);
}

function renderButton() {
	
      gapi.signin2.render('my-signin2', {
        'scope': 'profile email',
        'width': 240,
        'height': 50,
        'longtitle': true,
        'theme': 'dark',
        'onsuccess': onSuccess,
        'onfailure': onFailure
      });
}

function show_google_btn(){
	
	//alert("UUUUU");		
	var gb_container = document.getElementById("gb_container");	
	gb_container.innerHTML = "<div id='my-signin2'></div>";
	
	renderButton();
	
}


function validate_signup_signin(){	

	var si_msg = document.getElementById("si_msg");
	
	//alert(si_msg.innerHTML);
	//si_msg.innerHTML = "UUUUUUUUUUUUU";		
	
	var ele_input_username = document.getElementById("input_username");
	var ele_input_password = document.getElementById("input_password");
	var username = ele_input_username.value;
	var password = ele_input_password.value;

		ele_input_username.style.border = "none";		
		ele_input_password.style.border = "none";

	
	if(!isValidEmail(username)){
		ele_input_username.style.border = "thick solid #cf0623";		
		si_msg.innerHTML = "Please Enter a Valid Email Address for User Name";
		return false;
	}
		
	if(password.length < 6){		
		ele_input_password.style.border = "thick solid #cf0623";
		si_msg.innerHTML = "Please Enter at Leat 6 characters for Password";
		return false;		
	}
				
	return true;
	
	//return false;

}

function show_this_password(){
	
	var x = document.getElementById("input_password");
	if (x.type === "password") {
		x.type = "text";
	} else {
		x.type = "password";
	}
	
}

function isValidEmail(str) {

	var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
	return pattern.test(str);
}

function setForgotPswdForm(){


	var forgot_password_form = '';

forgot_password_form += "<div class='form-group'>";		
forgot_password_form += "<input name='email_addr' type='email' class='form-control'"; 
forgot_password_form += " id='input_email_addr' aria-describedby='emailHelp' placeholder='Enter email'>";
forgot_password_form += "<small id='emailHelp' class='form-text text-muted'>";
forgot_password_form += "We will never share your email with anyone else.";
forgot_password_form += "</small>";	
forgot_password_form += "</div>";


	//alert(forgot_password_form);
	
	document.getElementById("get_pswd").innerHTML = forgot_password_form;
	
}


function send_password_reset(){
	
	var email_addr = $("#input_email_addr").val();
	var msg = "";
	var msg_container = document.getElementById("input_email_addr_msg");
	var modal_sub_btn = document.getElementById("modal_sub_btn");
		
	if(isValidEmail(email_addr)){
		
		$.ajaxSetup({ cache: false}); 		
		$.ajax({
			method: "GET",
			url: "ajax/ajax-send-reset-pasword.php",
			data: { email_addr: email_addr }
		})
		.done(function(data) {
			if(data.indexOf("y") > -1){
				msg = "<span style='color:#154360;'><b>An email was sent to "+email_addr+"</b></span>";	
				modal_sub_btn.style.display = "none";
				msg_container.innerHTML = msg;
			}else{
				msg = "<span style='color:red;'><b>There is no account for "+email_addr+"</b></span>";
				msg_container.innerHTML = msg;
			}
		
		});

		
	}else{
		
		msg = "<span style='color:red;'><b>"+email_addr+" is not a valid email address</b></span>";
		msg_container.innerHTML = msg;
	
	}
	
}



/*
function onSignIn(googleUser) {
	var profile = googleUser.getBasicProfile();

	console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
	console.log('Name: ' + profile.getName());
	console.log('Image URL: ' + profile.getImageUrl());
	console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.

	document.getElementById("w_google_id").value = profile.getId();
	document.getElementById("w_google_name").value = profile.getName();
	document.getElementById("w_google_image").value = profile.getImageUrl();
	document.getElementById("w_google_email").value = profile.getEmail();
	
	document.getElementById("login_with_google").submit();

}
*/

</script>


<form id="login_with_google" action="user-admin/user-admin-login.php" method="post" enctype="multipart/form-data">

	<input type="hidden" name="from_google" value="1" />
	<input type="hidden" id="w_google_id" name="id" />
	<input type="hidden" id="w_google_name" name="name" />
	<input type="hidden" id="w_google_image" name="image" />
	<input type="hidden" id="w_google_email" name="email" />
	

</form>

<section class="ftco-section ftco-no-pb ftco-no-pt bg-secondary" id="lgn">

	<form action="index.php" method="post" 
	onSubmit="return validate_signup_signin();" enctype="multipart/form-data">
	
	<div class="container py-5">
		<div style="color:red; font-size:20px;" id="si_msg">
		<?php echo $msg; ?>
		</div>

		<div style="color:black; font-size: 26px; margin-bottom:10px;">
		Sign Up or Sign In
		</div>
		<div class="row">		
			<div class="form-group col-md-6">
<label for="input_username" style="color:black; font-size:22px;">Email</label>
<input style="width:90%;" type="email" name="username" class="form-control" 
		id="input_username" placeholder="Email">
			</div>
			<div class="form-group col-md-6">
<label for="input_password" style="color:black; font-size:22px;">Password</label>
<input style="width:90%;" type="password" name="password" class="form-control" 
		id="input_password" placeholder="Password">
				
<span style="cursor:pointer; position:relative; top:-42px; left:80%;" 
onclick="show_this_password();">
<img src="images/cartoon-eye.png"/>
</span>
				
			</div>
		</div>		
		
		<div class="row">
			<div class="form-group col-md-2" style="padding-top:10px;">		
				<input type="submit" name="submit_type" value="Sign Up" class="btn btn-success">
			</div>
			<div class="form-group col-md-2" style="padding-top:10px;">		
				<input type="submit" name="submit_type" value="Sign In" class="btn btn-info">
			</div>
			<div class="form-group col-md-4" style="padding-top:10px;">
				<span type="button" class="btn btn-info btn-sm" style="height:44px;"
					data-toggle="modal" data-target="#forgot_modal" onClick='setForgotPswdForm();'>
					<span style="color:black;">Forgot Password</span>
				</span>
			</div>

			<div class="form-group col-md-4" style="padding-top:10px;">				
				<div id="gb_container">
				
					<img style="width:200px; height:46px;" 
					src="images/gooog.png" onClick="show_google_btn();" />
				</div>
			</div>
		</div>
	</div>
	</form>
</section>
    
<footer class="footer">
	<div class="container-fluid px-lg-5">
		<div class="row">
			<div class="col-md-9 py-5">
				<p>We hope this site can you in many aspects of your organization.</p>
				<div class="row">
				
					<div class="col-md-4 mb-md-0 mb-4">
						<h2 class="footer-heading">About us</h2>
						
<ul class="list-unstyled">
<li><a href="about.html" class="py-1 d-block">About us</a></li>
<li><a href="index.html#contact" class="py-1 d-block">Contact us</a></li>
<li><a href="terms.html" class="py-1 d-block">Terms &amp; Conditions</a></li>
<li><a href="privacy.html" class="py-1 d-block">Privacy</a></li>
</ul>						

					</div>

					<div class="col-md-4">
						<div class="row justify-content-center">
							<div class="col-md-12 col-lg-10">
								<div class="row">

									<div class="col-md-4 mb-md-0 mb-4">
										<h2 class="footer-heading">Services</h2>
<ul class="list-unstyled">
<li><a href="./#cc" class="py-1 d-block">Collaboration</a></li>
<li><a href="./#cc" class="py-1 d-block">Communication</a></li>
<li><a href="./#cc" class="py-1 d-block">Marketing</a></li>
<!--
<li><a href="explore.html" class="py-1 d-block">Research</a></li>
-->
<li><a href="explore.html" class="py-1 d-block">Explore</a></li>
</ul>
									</div>

									
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-4">
						<div class="row justify-content-center">
							<div class="col-md-12 col-lg-10">
								<div class="row">

									<div class="col-md-4 mb-md-0 mb-4">					
					
					<ul class="ftco-footer-social p-0">						
<li class="ftco-animate"><a href="#" data-toggle="tooltip" data-placement="top" title="Twitter"><span class="fa fa-twitter"></span></a></li>
<li class="ftco-animate"><a href="#" data-toggle="tooltip" data-placement="top" title="Facebook"><span class="fa fa-facebook"></span></a></li>
<li class="ftco-animate"><a href="#" data-toggle="tooltip" data-placement="top" title="Instagram"><span class="fa fa-instagram"></span></a></li>
</ul>

					
								</div>
							</div>
						</div>
					</div>
					
				</div>
			</div>					
		</div>

	</div>

	<p class="copyright">
	<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
	Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib.com</a>
	<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
	</p>

	<span style="float:right;">
	<a href="https://www.expertanswer.org/manage/" target="_blank">:i-Ms:</a>
	<br />
	</span>
	
</footer>


<!-- Modal -->
<div class="modal fade" id="forgot_modal" tabindex="-1" role="dialog" aria-labelledby="forgot_modalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		
			<div id="input_email_addr_msg" style="margin-left:20px;"></div>
		
			<div class="modal-header">
				<h5 class="modal-title" id="forgot_modalLabel">Enter Email Address (user name)</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div id="get_pswd" class="modal-body"></div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button id="modal_sub_btn" type="button" class="btn btn-primary" onclick="send_password_reset();">
				Submit
				</button>
			</div>
		</div>
	</div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<!--

	  /*

	var jqxhr = $.ajax( "ajax/ajax-login-with-google.php" )
		.done(function() {
		
		})
			.fail(function() {
		})
			.always(function() {
		});
	  */

-->



