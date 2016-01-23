<?php

	// Sessions/Cookies
	session_start();
	$_SESSION['loggedIn'] = FALSE;

	if ($_SESSION['loggedIn'] != TRUE) {

		// Include/Required files
		require_once ('../../admin/config/normalUser.php');
		// /. Include/Required files

		// Open database connection
		$conn = new mysqli($host, $user, $pwrd, $dbase);
		if (mysqli_connect_errno()) {
			printf("Database connection failed due to: %s\n", mysqli_connect_error());
			exit();
		}
		// /. Open database connection

		// Form Validation
		if (isset($_POST['submit'])) {

			/* --------------------------------------------
			 * Variables From User Input
			-------------------------------------------- */

			$title 				= $_POST['title'];
			$forename 			= $_POST['forename'];
			$surname 			= $_POST['surname'];
			$firstLineAddress 	= $_POST['firstLineAddress'];
			$secondLineAddress 	= $_POST['secondLineAddress'];
			$town 				= $_POST['town'];
			$county 			= $_POST['county'];
			$postcode 			= $_POST['postcode'];
			$phone 				= $_POST['phone'];
			$email 				= $_POST['email'];
			$emailConfirm 		= $_POST['emailConfirm'];
			$pwrd 				= $_POST['pwrd'];
			$pwrdConfirm 		= $_POST['pwrdConfirm'];

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
			$email = mysqli_real_escape_string($conn, $email);
			$emailConfirm = mysqli_real_escape_string($conn, $emailConfirm);
			$pwrd = mysqli_real_escape_string($conn, $pwrd);
			$pwrdConfirm = mysqli_real_escape_string($conn, $pwrdConfirm);

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
			$email = trim($email);
			$emailConfirm = trim($emailConfirm);
			$pwrd = trim($pwrd);
			$pwrdConfirm = trim($pwrdConfirm);

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
			$email = strip_tags($email);
			$emailConfirm = strip_tags($emailConfirm);
			$pwrd = strip_tags($pwrd);
			$pwrdConfirm = strip_tags($pwrdConfirm);

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
			$email = htmlentities($email);
			$emailConfirm = htmlentities($emailConfirm);
			$pwrd = htmlentities($pwrd);
			$pwrdConfirm = htmlentities($pwrdConfirm);

			/* --------------------------------------------
			 * Form Checks
			-------------------------------------------- */

			// Check that any of the form fields that are required have not been left blank if any have been,
			// display an error message
			if (empty($title) || empty($forename) || empty($surname) || empty($firstLineAddress) || empty($town) || empty($county) || empty($postcode) || empty($phone) || empty($email) || empty($emailConfirm) || empty($pwrd) || empty($pwrdConfirm)) {
				?>
				<div class="container">
					<div class="row">
						<div class="col-lg-12">
							<p class="lead">ALL fields with an asterix (<span class="required">*</span>) must be filled in.</p>
							<a href="register.php">Back to register page.</a>
						</div>
					</div>
				</div>
				<?php
			} else {

				// Check updateEmail and emailComfirm match
				if ($email != $emailConfirm) {
					?>
					<div class="container">
						<div class="row">
							<div class="col-lg-12">
								<p class="lead">The emails entered DO NOT match, please try again</p>
								<a href="register.php">Back to register page.</a>
							</div>
						</div>
					</div>
					<?php
				} else {

					$select = "SELECT `email` FROM `user` WHERE `email` LIKE BINARY '".$email."'";
					$result = $conn -> query($select) or die($conn.__LINE__);

					if ($result = mysqli_num_rows($result) === 1) {
						?>
						<div class="container">
							<div class="row">
								<div class="col-lg-12">
									<p class="lead">The email entered already exists, please log in with that email to continue.</p>
									<a href="register.php">Back to register page.</a>
								</div>
							</div>
						</div>
						<?php
					} else {

						// Check password and passwordConfirm match
						if ($pwrd != $pwrdConfirm) {
							?>
							<div class="container">
								<div class="row">
									<div class="col-lg-12">
										<p class="lead">The passwords entered DO NOT match, please try again</p>
										<a href="register.php">Back to register page.</a>
									</div>
								</div>
							</div>
							<?php
						} else {

							// Hash the password that is to be entered in to the database
							$pwrd = password_hash($pwrd, PASSWORD_DEFAULT);

							// ALL checks have passed, enter user details in to the database
							$insert = "INSERT INTO `user` (`title`, `forename`, `surname`, `firstLineAddress`, `secondLineAddress`, `town`, `county`, `postcode`, `phone`, `email`, `password`) VALUES ('".$title."', '".$forename."', '".$surname."', '".$firstLineAddress."', '".$secondLineAddress."', '".$town."', '".$county."', '".$postcode."', '".$phone."', '".$email."', '".$pwrd."')";
							$result = $conn -> query($insert) or die($conn.__LINE__);

							$_SESSION['loggedIn'] = TRUE;
							$_SESSION['title'] = $title;
							$_SESSION['forename'] = $forename;
							$_SESSION['surname'] = $surname;
							$_SESSION['firstLineAddress'] = $firstLineAddress;
							$_SESSION['secondLineAddress'] = $secondLineAddress;
							$_SESSION['town'] = $town;
							$_SESSION['county'] = $county;
							$_SESSION['postcode'] = $postcode;
							$_SESSION['phone'] = $phone;
							$_SESSION['email'] = $email;
							$_SESSION['pwrd'] = $pwrd;

							?>
							<div class="container">
								<div class="row">
									<div class="col-lg-12">
										<p class="lead">You Have Successfully Registered.</p>
									</div>
								</div>
							</div>
							<?php

						} // End of insert form entries in to the database

					} // End Of Check Email Does Not Already Exist

				} // End of check emails match

			} // End of empty fields

		} // End of if (isset($_POST['submit']))
		// /. Form Validation
	} else {
		?>
		<!-- Page Content -->
		<div class="container">

			<div class="row">

				<div class="col-lg-12">

					<p>You have already registered</p>

				</div>

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
<?php
	// Close database connection
	mysqli_close($conn);
	// /. Close database connection
?>