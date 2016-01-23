<?php

	// Sessions/Cookies
	session_start();
	if ($_SESSION['loggedIn'] == TRUE) {
		?>
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<p class="lead">You Are Already Logged In.</p>
				</div>
			</div>
		</div>
		<?php
	} else {
		?>
		<!-- Page Content -->
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<!-- col-lg-12 -->
				<div class="col-lg-12">
					<h1>Registration Form</h1>
					<p class="lead">Please fill in all <span class="required">* required fields</span> in the registration form.</p>
					<p>By filling in this form and registering on this web site you agree to all the terms and conditions associated with this web site.</p>
					<!-- form -->
					<form action="registerResults.php" method="post">
						<fieldset>
							<label for="title">Title<span class="required">*</span><br>
								<select id="title" name="title">
									<option value="Mr">Mr</option>
									<option value="Miss">Miss</option>
									<option value="Ms">Ms</option>
									<option value="Mrs">Mrs</option>
									<option value="Doctor">Doctor</option>
									<option value="Reverend">Reverend</option>
								</select>
							</label><br>
							<label for="forename">Forename<span class="required">*</span><br>
								<input id="forename" name="forename" type="text" required="required">
							</label><br>
							<label for="surname">Surname<span class="required">*</span><br>
								<input id="surname" name="surname" type="text" required="required">
							</label><br>
							<label for="firstLineAddress">1st Line Address<span class="required">*</span><br>
								<input id="firstLineAddress" name="firstLineAddress" type="text" required="required">
							</label><br>
							<label for="secondLineAddress">2nd Line Address<br>
								<input id="secondLineAddress" name="secondLineAddress" type="text">
							</label><br>
							<label for="town">Town<span class="required">*</span><br>
								<input id="town" name="town" type="text" required="required">
							</label><br>
							<label for="county">County<span class="required">*</span><br>
								<input id="county" name="county" type="text" required="required">
							</label><br>
							<label for="postcode">Postcode<span class="required">*</span><br>
								<input id="postcode" name="postcode" type="text" required="required">
							</label><br>
							<label for="phone">Phone<span class="required">*</span><br>
								<input id="phone" name="phone" type="tel" required="required">
							</label><br>
							<label for="email">Email<span class="required">*</span><br>
								<input id="email" name="email" type="email" required="required" autocomplete="off">
							</label><br>
							<label for="emailConfirm">Confirm Email<span class="required">*</span><br>
								<input id="emailConfirm" name="emailConfirm" type="email" required="required" autocomplete="off">
							</label><br>
							<label for="pwrd">Password<span class="required">*</span><br>
								<input id="pwrd" name="pwrd" type="password" required="required" autocomplete="off">
							</label><br>
							<label for="pwrdConfirm">Confirm Password<span class="required">*</span><br>
								<input id="pwrdConfirm" name="pwrdConfirm" type="password" required="required" autocomplete="off">
							</label><br>
							<input id="submit" name="submit" type="submit">
						</fieldset>
					</form>
					<!-- /. form -->
				</div>
				<!-- /. col-lg-12 -->
			</div>
			<!-- /.row -->
		</div>
		<!-- /.container -->
		<?php
	}
	// /. Sessions/Cookies

?>
<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Fictional recycling company website for my 2nd year Foundation Degree Web Based Database Module">
	<meta name="author" content="Darren Howlett">

	<title>Recycling 4 U</title>

	<!-- Bootstrap Core CSS -->
	<link href="../../css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom CSS -->
	<style>
		body {
			padding-top: 70px;
			/* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
		}
	</style>

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="../../js/html5shiv.min.js"></script>
	<script src="../../js/respond.min.js"></script>
	<![endif]-->

	<!-- Site Specific Styles -->
	<link type="text/css" rel="stylesheet" href="../../css/r4ustyles.css">

</head>
<body>

<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="../../index.php">Recycling 4 U</a>
		</div>
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li>
					<a href="../products/gallery/productGallery.php">Products</a>
				</li>
				<li>
					<a href="../products/upload/productUpload.php">Product Upload</a>
				</li>
				<li>
					<a href="register.php">Register</a>
				</li>
				<li>
					<a href="../general/contact.php">Contact</a>
				</li>
				<li>
					<a href="../login/login.php">Log In</a>
				</li>
				<li>
					<a href="../profile/profile.php">My Profile</a>
				</li>
				<li>
					<a href="../login/logout.php">Log Out</a>
				</li>
			</ul>
		</div>
		<!-- /.navbar-collapse -->
	</div>
	<!-- /.container -->
</nav>
<!-- /.nav -->

<div class="container">

	<hr>

	<!-- Footer -->
	<footer>
		<div class="row">
			<div class="col-lg-4">
				<h3>Recycling For U Policies</h3>
				<ul>
					<li><a href="#" target="_blank">Privacy Policy</a></li>
					<li><a href="#" target="_blank">Warranties policy</a></li>
				</ul>
			</div>
			<div class="col-lg-4">
				<h3>Site Map</h3>
				<ul>
					<li><a href="../index.php">Home</a></li>
					<li><a href="#">Products</a>
						<ul>
							<li><a href="#">White Goods</a>
								<ul>
									<li><a href="#">Washing Machines</a></li>
									<li><a href="#">Dishwashers</a></li>
									<li><a href="#">Fridges</a></li>
									<li><a href="#">Freezers</a></li>
									<li><a href="#">Chest Freezers</a></li>
									<li><a href="#">Fridge Freezers</a></li>
									<li><a href="#">Microwaves</a></li>
									<li><a href="#">Cookers</a></li>
								</ul>
							</li>
							<li><a href="#">Gardening Equipment</a>
								<ul>
									<li><a href="#">Lawn Mowers</a></li>
									<li><a href="#">Ride-on Mowers</a></li>
									<li><a href="#">Strimmers</a></li>
									<li><a href="#">Cultivators</a></li>
									<li><a href="#">Hedge Trimmers</a></li>
									<li><a href="#">Electric Tools</a></li>
									<li><a href="#">Manual Tools</a></li>
								</ul>
							</li>
						</ul>
					</li>
					<li><a href="../products/upload/productUpload.php">Product Upload</a></li>
					<li><a href="register.php">Register</a></li>
					<li><a href="../general/contact.php">Contact Us</a></li>
					<li><a href="../login/login.php">Log In</a></li>
					<li><a href="../profile/profile.php">My Profile</a></li>
					<li><a href="../login/logout.php">Log Out</a></li>
				</ul>
			</div>
			<div class="col-lg-4">
				<h3>External Sites</h3>
				<ul>
					<li><a href="https://www.gov.uk/government/publications/2010-to-2015-government-policy-waste-and-recycling/2010-to-2015-government-policy-waste-and-recycling" target="_blank">2010 to 2015 government policy: waste and recycling</a></li>
					<li><a href="http://northdevon.gov.uk/bins-and-recycling/find-a-tip/" target="_blank">North Devon District Council - Find a tip</a></li>
					<li><a href="http://northdevon.gov.uk/bins-and-recycling/" target="_blank">North Devon District Council - Bins and recycling</a></li>
				</ul>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<p class="text-center">Copyright &copy; Recycling 4 U <?php echo date("Y"); ?></p>
			</div>
		</div>
	</footer>

</div>
<!-- /.container -->

<!-- jQuery Version 1.11.1 -->
<script src="../../js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../../js/bootstrap.min.js"></script>

</body>
</html>