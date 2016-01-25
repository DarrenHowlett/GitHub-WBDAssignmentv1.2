<?php

	// Sessions/Cookies
	session_start();
	if ($_SESSION['loggedIn'] != TRUE) {

		// If a user tries to access this page without logging in, they will be redirected to the log in page
		header('Location: ../../login/login.php');
	} else {

		// Include/Required files
		require_once ('../../../admin/config/registeredUser.php');
		// /. Include/Required Files

		// Open database connection
		$conn = new mysqli($host, $user, $pwrd, $dbase);
		if (mysqli_connect_errno()) {
			printf("Database connection failed due to: %s\n", mysqli_connect_error());
			exit();
		}
		// /. Open database connection

		if (isset($_POST['updateProfile'])) {

			$title 				= $_POST['title'];
			$forename 			= $_POST['forename'];
			$surname 			= $_POST['surname'];
			$firstLineAddress 	= $_POST['firstLineAddress'];
			$secondLineAddress 	= $_POST['secondLineAddress'];
			$town 				= $_POST['town'];
			$county 			= $_POST['county'];
			$postcode 			= $_POST['postcode'];
			$phone 				= $_POST['phone'];

			/* --------------------------------------------
			 * User Input From Form Validation
			-------------------------------------------- */

			// SQL INJECTION COUNTERMEASURES
			// This only has to apply to fields that allow users to type string data in, fields that
			// have dropdown boxes, checkboxes, radio buttons etc or are restricted to number input need not be put through sanitation.
			// The reason inputs restricted to number input do not have to be put through sanitation is, even though the input
			// will allow for text to be entered in to the input box, any text that is entered will not actually be returned.

			// Escape any special characters, for example O'Conner becomes O\'Conner
			// The first parameter of mysqli_real_escape_string is the database connection to open,
			// The second parameter is the string to have the special characters escaped.
			$title = mysqli_real_escape_string($conn, $title);
			$forename = mysqli_real_escape_string($conn, $forename);
			$surname = mysqli_real_escape_string($conn, $surname);
			$firstLineAddress = mysqli_real_escape_string($conn, $firstLineAddress);
			$secondLineAddress = mysqli_real_escape_string($conn, $secondLineAddress);
			$town = mysqli_real_escape_string($conn, $town);
			$county = mysqli_real_escape_string($conn, $county);
			$postcode = mysqli_real_escape_string($conn, $postcode);
			$phone = mysqli_real_escape_string($conn, $phone);

			// Trim any whitespace from the beginning and end of the user input
			$title = trim($title);
			$forename = trim($forename);
			$surname = trim($surname);
			$firstLineAddress = trim($firstLineAddress);
			$secondLineAddress = trim($secondLineAddress);
			$town = trim($town);
			$county = trim($county);
			$postcode = trim($postcode);
			$phone = trim($phone);

			// Remove any HTML & PHP tags that may have been injected in to the input
			$title = strip_tags($title);
			$forename = strip_tags($forename);
			$surname = strip_tags($surname);
			$firstLineAddress = strip_tags($firstLineAddress);
			$secondLineAddress = strip_tags($secondLineAddress);
			$town = strip_tags($town);
			$county = strip_tags($county);
			$postcode = strip_tags($postcode);
			$phone = strip_tags($phone);

			// Convert any tags that may have slipped through in to string data,
			// for example <b>Darren</b> becomes &lt;b&gt;Darren&lt;/b&gt;
			$title = htmlentities($title);
			$forename = htmlentities($forename);
			$surname = htmlentities($surname);
			$firstLineAddress = htmlentities($firstLineAddress);
			$secondLineAddress = htmlentities($secondLineAddress);
			$town = htmlentities($town);
			$county = htmlentities($county);
			$postcode = htmlentities($postcode);
			$phone = htmlentities($phone);

			?>
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<form action="updateProfileResults.php" method="post">
							<label for="title">Title<br>
								<input id="title" name="title" type="text" value="<?php echo $title; ?>">
							</label><br>
							<label for="forename">Forename<br>
								<input id="forename" name="forename" type="text" value="<?php echo $forename; ?>">
							</label><br>
							<label for="surname">Surname<br>
								<input id="surname" name="surname" type="text" value="<?php echo $surname; ?>">
							</label><br>
							<label for="firstLineAddress">1st Line Address<br>
								<input id="firstLineAddress" name="firstLineAddress" type="text" value="<?php echo $firstLineAddress; ?>">
							</label><br>
							<label for="secondLineAddress">2nd Line Address<br>
								<input id="secondLineAddress" name="secondLineAddress" type="text" value="<?php echo $secondLineAddress; ?>">
							</label><br>
							<label for="town">Town<br>
								<input id="town" name="town" type="text" value="<?php echo $town; ?>">
							</label><br>
							<label for="county">County<br>
								<input id="county" name="county" type="text" value="<?php echo $county; ?>">
							</label><br>
							<label for="postcode">Postcode<br>
								<input id="postcode" name="postcode" type="text" value="<?php echo $postcode; ?>">
							</label><br>
							<label for="phone">Phone<br>
								<input id="phone" name="phone" type="tel" value="<?php echo $phone; ?>">
							</label><br><br>
							<input id="confirmProfile" name="confirmProfile" type="submit" value="Apply My Profile Changes">
						</form>
						<p>If you DO NOT wish to apply these change, <a href="../profile.php">please go back to your profile.</a></p>
					</div>
				</div>
			</div>

			<?php

		} // /.if (isset($_POST['submit']))
		
	} // /. Sessions/Cookies


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
	<link href="../../../css/bootstrap.min.css" rel="stylesheet">

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
	<script src="../../../js/html5shiv.min.js"></script>
	<script src="../../../js/respond.min.js"></script>
	<![endif]-->

	<!-- Site Specific Styles -->
	<link type="text/css" rel="stylesheet" href="../../../css/r4ustyles.css">

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
			<a class="navbar-brand" href="../../../index.php">Recycling 4 U</a>
		</div>
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li>
					<a href="../../products/gallery/productGallery.php">Products</a>
				</li>
				<li>
					<a href="../../register/register.php">Register</a>
				</li>
				<li>
					<a href="../../general/contact.php">Contact</a>
				</li>
				<li>
					<a href="../../login/login.php">Log In</a>
				</li>
				<li>
					<a href="../../profile/profile.php">My Profile</a>
				</li>
				<li>
					<a href="../../login/logout.php">Log Out</a>
				</li>
				<li>
					<a href="../../products/upload/productUpload.php" <?php

						if ($_SESSION['loggedIn'] != TRUE || $_SESSION['accessLevel'] <= 1) {
							echo 'class="hideMe"';
						}

					?>>Product Upload</a>
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
					<li><a href="../../../index.php">Home</a></li>
					<li><a href="../../products/gallery/productGallery.php">Products</a>
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
					<li>
						<a href="../../products/upload/productUpload.php" <?php

							if ($_SESSION['loggedIn'] != TRUE || $_SESSION['accessLevel'] <= 1) {
								echo 'class="hideMe"';
							}

						?>>Product Upload</a>
					</li>
					<li><a href="../../register/register.php">Register</a></li>
					<li><a href="../../general/contact.php">Contact Us</a></li>
					<li><a href="../../login/login.php">Log In</a></li>
					<li><a href="../../profile/profile.php">My Profile</a></li>
					<li><a href="../../login/logout.php">Log Out</a></li>
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
<script src="../../../js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../../../js/bootstrap.min.js"></script>

</body>
</html>
<?php
	// Close database connection
	mysqli_close($conn);
	// /. Close database connection
?>
