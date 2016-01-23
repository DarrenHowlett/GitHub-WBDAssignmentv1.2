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

		if (isset($_POST['submit'])) {

			$userID 			= $_SESSION['userID'];
			$oldPwrd 			= $_POST['oldPwrd'];
			$newPwrd 			= $_POST['newPwrd'];
			$newPwrdConfirm 	= $_POST['newPwrdConfirm'];

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

			$oldPwrd = mysqli_real_escape_string($conn, $oldPwrd);
			$newPwrd = mysqli_real_escape_string($conn, $newPwrd);
			$newPwrdConfirm = mysqli_real_escape_string($conn, $newPwrdConfirm);

			// Trim any whitespace from the beginning and end of the user input

			$oldPwrd = trim($oldPwrd);
			$newPwrd = trim($newPwrd);
			$newPwrdConfirm = trim($newPwrdConfirm);

			// Remove any HTML & PHP tags that may have been injected in to the input

			$oldPwrd = strip_tags($oldPwrd);
			$newPwrd = strip_tags($newPwrd);
			$newPwrdConfirm = strip_tags($newPwrdConfirm);

			// Convert any tags that may have slipped through in to string data,
			// for example <b>Darren</b> becomes &lt;b&gt;Darren&lt;/b&gt;

			$oldPwrd = htmlentities($oldPwrd);
			$newPwrd = htmlentities($newPwrd);
			$newPwrdConfirm = htmlentities($newPwrdConfirm);

			// Check ALL Form Fields Have Been Filled In
			if (empty($oldPwrd) || empty($newPwrd) || empty($newPwrdConfirm)) {
				// If Form Fields Have Been Left Empty, Display An Error
				?>
				<div class="container">
					<div class="row">
						<div class="col-lg-12">
							<p class="lead">ALL fields must be filled in.</p>
							<a href="../profile.php">Back to profile page.</a>
						</div>
					</div>
				</div>
				<?php
			} else {
				// To change the password, the old password entered has to be checked against the password on record,
				// This SELECT query retrieves the old password based on the users ID from when they logged in and retrieves
				// the password on file.  Once this has been completed, the password checks can begin.
				$select = "SELECT `password` FROM `userTable` WHERE `userID` LIKE $userID";
				$result = $conn -> query($select) or die($conn.__LINE__);

				while ($row = $result -> fetch_assoc()) {

					// Store the password retrieved from the users record as a variable
					$pwrd = $row['password'];

					// Check Old Password Entered Matches The Password On File
					$pwrdCheck = password_verify($oldPwrd, $pwrd);
					if ($pwrdCheck != TRUE) {

						// If Passwords DO NOT Match, Display An Error
						?>
						<div class="container">
							<div class="row">
								<div class="col-lg-12">
									<p class="lead">Your old password does not match what we have on record, please try again.</p>
									<a href="../profile.php">Back to profile page.</a>
								</div>
							</div>
						</div>
						<?php

					} else {

						// Check New Password And Confirm New Password Match
						if ($newPwrd != $newPwrdConfirm) {

							// If New Password And Confirm New Password DO NOT Match, Display An Error
							?>
							<div class="container">
								<div class="row">
									<div class="col-lg-12">
										<p class="lead">New Password and Confirm New Password DO NOT match, please try again.</p>
										<a href="../profile.php">Back to profile page.</a>
									</div>
								</div>
							</div>
							<?php

						} else {

							// Check New Password Is NOT The Same As The Old Password
							if ($oldPwrd == $newPwrd) {

								// If New Password And Confirm New Password DO NOT Match, Display An Error
								?>
								<div class="container">
									<div class="row">
										<div class="col-lg-12">
											<p class="lead">You CANNOT change your password to what is already held on file, please try again.</p>
											<a href="../profile.php">Back to profile page.</a>
										</div>
									</div>
								</div>
								<?php

							} else {

								// Once ALL The Above Checks Pass, Then The New Password Can Be Entered In To The Database

								// First The New Password Has To Be Hashed
								$newPwrd = password_hash($newPwrd, PASSWORD_DEFAULT);

								$update = "UPDATE `userTable` SET `password` = '".$newPwrd."' WHERE `userID` = '".$userID."'";
								$resultUpdate = $conn -> query($update) or die($conn.__LINE__);

								if (!$resultUpdate) {
									?>
									<div class="container">
										<div class="row">
											<div class="col-lg-12">
												<p class="lead">there was a problem updating your password, please try again.</p>
												<a href="../profile.php">Back to profile page.</a>
											</div>
										</div>
									</div>
									<?php
								} else {
									?>
									<div class="container">
										<div class="row">
											<div class="col-lg-12">
												<p class="lead">Your password has successfully been changed. To continue using the site <a href="../../login/login.php">please log in again</a> using your new password.</p>
											</div>
										</div>
									</div>
									<?php
									// After The New Password Has Been Entered In To The Database The Session That Has Been Started Will Have
									// To Be Destroyed, This Will Log The User Out Of The Current Session, A Message Will Be Displayed To Show
									// The User That Their Password Has Been Changed And That They Will Need To Log In Again To Continue Using
									// The Site
									session_destroy();


								} // /.Enter New Password in To The Database

							} // /. Check New Password Is NOT The Same As The Old Password

						} // /. Check New Password And Confirm New Password Match

					} // /. Check Old Password Entered Matches The Password On File

				} // /. while ($row = $result -> fetch_assoc())

			} // /. Check ALL Form Fields Have Been Filled In

		} // /. if (isset($_POST['updateProfile']))

	} // /. else
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
					<a href="../../products/upload/productUpload.php">Product Upload</a>
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
					<li><a href="../../products/upload/productUpload.php">Product Upload</a></li>
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
