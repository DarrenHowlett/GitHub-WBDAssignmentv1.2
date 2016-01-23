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
		<div class="container">
			<!-- row -->
			<div class="row">
				<!-- col-lg-6 -->
				<div class="col-lg-6">
					<h1>Register</h1>
					<p class="lead">If you have not already registered with us, you will not be able to buy any goods until you have done so.  Please <a href="../register/register.php">go to the register page</a> to register your details.</p>
				</div>
				<!-- /. col-lg-6 -->
				<!-- col-lg-6 -->
				<div class="col-lg-6">
					<h1>Log In</h1>
					<p class="lead">If you have registered with us and wish to view/amend your profile, or purchase any of our products, you will need to log in using the form below before you can do so.</p>
				<form method="post" action="loginResults.php">
					<label for="email">Email:<br>
						<input id="email" name="email" type="email" required="required">
					</label><br>
					<label for="pwrd">Password:<br>
						<input id="pwrd" name="pwrd" type="password" required="required">
					</label><br>
					<input id="submit" name="submit" type="submit">
				</form>
				</div>
				<!-- /. col-lg-6 -->
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
					<a href="../register/register.php">Register</a>
				</li>
				<li>
					<a href="../general/contact.php">Contact</a>
				</li>
				<li>
					<a href="login.php">Log In</a>
				</li>
				<li>
					<a href="../profile/profile.php">My Profile</a>
				</li>
				<li>
					<a href="logout.php">Log Out</a>
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
					<li><a href="../../index.php">Home</a></li>
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
					<li><a href="../register/register.php">Register</a></li>
					<li><a href="../general/contact.php">Contact Us</a></li>
					<li><a href="login.php">Log In</a></li>
					<li><a href="../profile/profile.php">My Profile</a></li>
					<li><a href="logout.php">Log Out</a></li>
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
<?php
	// Close database connection
	mysqli_close($conn);
	// /. Close database connection
?>