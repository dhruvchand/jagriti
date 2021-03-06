<!DOCTYPE html>
<html>
	<head>
		<title>The Jagriti Project</title>
	</head>

<link rel="stylesheet" href="css/main.css"/>
<link rel="stylesheet" href="css/bootstrap.min.css"/>
<link rel="stylesheet" href="css/bootstrap-theme.min.css"/>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,100' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Raleway:100,300' rel='stylesheet' type='text/css'>
<script src="js/jquery-1.8.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
<script src="js/formValidation.js"></script>

<body>
<div id="main-container">
	<div id="menu" class="row">

    	<a href="http://blog.projectjagriti.org"><div class="col-md-2">Blog</div></a>
    	<a href="aboutus.html"><div class="col-md-2">About Us</div></a>
    	<a href="index.html"><div class="col-md-4" id="logo" data-goto="1"><img src="img/logo.png"/></div></a>
    	<a href="ourpartners.html"><div class="col-md-2">Our Partners</div></a>
    	<a href="contactus.html"><div class="col-md-2">Contact Us</div></a>
  	</div>

  	<div class="accent" style="margin:auto auto; width:720px;">
  		
			Thank you for your interest shown in The Jagriti Project.</br>
			Please fill in the form given below, and your complaint will be registered. We assure you, those children WILL be helped.
			<!--
		  <form>
			  </br><li>Cateogry of Report<br></li>
		  <input type="checkbox" name="complaint" value"child_abuse"> Child Abuse<br>
		  <input type="checkbox" name="complaint" value"child_labour"> Child Labour<br>
		  <input type="checkbox" name="complaint" value"child_prostitution"> Child Prostitution<br>
		  <input type="checkbox" name="complaint" value"other"> Other<br>
  	
		  </form>
		  -->
		<form enctype="multipart/form-data" name="submit_form" onsubmit="return validateForm();" method="post" action="php/verify.php" >
		  	<ol>
		  		<br><li>Address of Location</li><br/>
		  		<textarea name="address" placeholder="Enter Address"></textarea>
		  		<br/>

		  
		  		<br><li>Email ID</li>

		  		<input type="text" placeholder="Your email address" name="email"><br><br/>

		  		<li>
		  			Broad Category of Complaint (Select multiple boxes if necessary)
		  		</li><br/>

		  		<input type="checkbox" name="category[]" value="Physical Abuse">&nbspPhysical Abuse<br>
				<input type="checkbox" name="category[]" value="Sexual Abuse">&nbspSexual Abuse<br> 
				<input type="checkbox" name="category[]" value="Emotional Abuse">&nbspEmotional Abuse<br>
				<input type="checkbox" name="category[]" value="Neglect">&nbspNeglect<br>
				<input type="checkbox" name="category[]" value="Child Marriage">&nbspChild Marriage<br>
				<input type="checkbox" name="category[]" value="Child Prostitution">&nbspChild Prostitution<br>
				<input type="checkbox" name="category[]" value="Child Exploitation">&nbspChild Exploitation<br>
				<input type="checkbox" name="category[]" value="Child Labour">&nbspChild Labour<br>
				

		  		<br/>
		  		<li>
	  				Description
	  			</li>
	  			<textarea name="description" placeholder="Any description that will help us"></textarea>
	  			
	  			<br/>

		  		
	  		</ol>
	  		<br/>
	  		<h3>Optional Details</h3><br/>

	  		These will help us contact you, if we have any questions related to your report and/or to inform you of the status of your report. We will do so only if you wish to be contacted.

	  		<ol>
	  			<br/>
	  			<li>
	  				Name
	  			</li>
	  			<input type="text" name="name"><br/>
	  			
	  			<br/>
	  			<li>
	  				Contact Number
	  			</li>
	  			<input type="text" name="number"><br/>

	  	  		<br/>
	  	  		<li>
	  					Add Photo (Adding photo increases the effectiveness of the complaint)<br/><br/>

	  			</li>
	  			<input type="file" name="file" id="file">
	  		
	  			
	  		</ol>

	  		<?php
          		require_once('php/recaptchalib.php');
          		$publickey = "6Leuiu8SAAAAAMNC1-PTWyZa_rMo3XozPEy7rljX"; // you got this from the signup page
          		echo recaptcha_get_html($publickey);
        	?>

	  		<br/><br/>

	  		<div style="margin:auto auto; width:100%; padding-left:40%;">
	  		<input type="submit" name="submit" value="Submit Form">
	  		<br/>
	  		<br/>
	  		<br/>
	 		</div>

	 	</form>
	 		
	</div>
</div>
</body>
</html>