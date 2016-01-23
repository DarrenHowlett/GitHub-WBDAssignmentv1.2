<?php

	// Sessions/Cookies
	session_start();
	// /. Sessions/Cookies

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

		$email = $_POST['email'];
		$pwrd = $_POST['pwrd'];

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
		$email = mysqli_real_escape_string($conn, $email);
		$pwrd = mysqli_real_escape_string($conn, $pwrd);

		// Trim any whitespace from the beginning and end of the user input
		$email = trim($email);
		$pwrd = trim($pwrd);

		// Remove any HTML & PHP tags that may have been injected in to the input
		$email = strip_tags($email);
		$pwrd = strip_tags($pwrd);

		// Convert any tags that may have slipped through in to string data,
		// for example <b>Darren</b> becomes &lt;b&gt;Darren&lt;/b&gt;
		$email = htmlentities($email);
		$pwrd = htmlentities($pwrd);

		/* --------------------------------------------
		 * Form Checks
		-------------------------------------------- */

		// Check that either of the form fields have not been left blank if any have been,
		// display an error message
		if (empty($email) || empty($pwrd)) {
			?>
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<p class="lead">Both email and password fields must be filled in.</p>
						<a href="login.php">Back to log in page.</a>
					</div>
				</div>
			</div>
			<?php
		} else {

			/* --------------------------------------------
			 * Check email matches an entry in database
			-------------------------------------------- */

			// Select the email from the table user WHERE an email entered in the form matches
			// is an EXACT match to an email in the database.  It has to be an EXACT match as BINARY has been used in
			// the query, this is what tells the query to only return exact matches.
			$select = "SELECT `email` FROM `userTable` WHERE `email` LIKE BINARY '".$email."'";

			// Perform a query on the database using the SQL in the variable $select
			// and store the result in this $result variable.  As the SQL is asking to return an email address based
			// on the email address entered in the form, either an email address is returned or not.
			$result = $conn->query($select) or die($conn.__LINE__);

			// Check how many results are returned.  This is achieved by seeing how many rows from the table are
			// returned.  If 0 rows are returned, this means no email address matched what was entered in to the form.
			// If this is the case, then display an error message.
			if ($result = mysqli_num_rows($result) == 0) {
				// If email DOES NOT exist, display this message
				?>
				<div class="container">
					<div class="row">
						<div class="col-lg-12">
							<p class="lead">The email entered does not match any on record! Please try again.</p>
							<a href="login.php">Back to log in page.</a>
						</div>
					</div>
				</div>
				<?php

				// If the amount of rows returned is grater than 0, then move on to the next step in the
				// verification process.
			} else {

				/* ----------------------------------------------------------------------
				 * Check password matches the database entry associated with the email
				---------------------------------------------------------------------- */

				// Select the record that matches the email entered in the form and return the password associated with
				// that record.
				$select = "SELECT `password` FROM `userTable` WHERE `email` LIKE BINARY '".$email."'";

				// Perform the query using the SQL held in the variable $select.
				$result = $conn->query($select) or die($conn.__LINE__);

				// While there are results returned from the table, put them in an associative array with the variable
				// name of $row.  The attributes of the record can then be called using their name.  As the query is
				// only asking for the password to be returned, and the attribute name of the corresponding field is
				// called password, the code to return the attribute will be $row['password'].
				while ($row = $result -> fetch_assoc()) {

					// This will store the password that is in the record of the returned result in to a variable
					$dbpwrd = $row['password'];

					// This will then check that the password entered in to the form is an exact match to the password
					// returned.  As the password in the table was hashed for security, the password entered in to the
					// needs to be hashed, this is what the password_verify function performs
					$pwrdCheck = password_verify($pwrd, $dbpwrd);

					// If the passwords DO NOT match, display an error message
					if ($pwrdCheck != TRUE) {
						?>
						<div class="container">
							<div class="row">
								<div class="col-lg-12">
									<p class="lead">The password entered DOES NOT match the password on record! Please try again.</p>
									<a href="login.php">Back to log in page.</a>
								</div>
							</div>
						</div>
						<?php
					} else {

						// If after the checks have been performed and the passwords DO match, then the user is logged in
						// and the registeredUser config file will be loaded allowing the user to update their profile and
						// buy items.
						// Include/Required files
						require_once ('../../admin/config/registeredUser.php');
						// /. Include/Required files

						// Open database connection
						$conn = new mysqli($host, $user, $pwrd, $dbase);
						if (mysqli_connect_errno()) {
							printf("Database connection failed due to: %s\n", mysqli_connect_error());
							exit();
						}
						// /. Open database connection

						$select = "SELECT * FROM `userTable` WHERE `email` LIKE BINARY '".$email."'";
						$result = $conn->query($select) or die($conn.__LINE__);

						while ($row = $result -> fetch_assoc()) {
							$_SESSION['loggedIn'] 			= TRUE;
							$_SESSION['userID'] 			= $row['userID'];
							$_SESSION['title'] 				= $row['title'];
							$_SESSION['forename'] 			= $row['forename'];
							$_SESSION['surname'] 			= $row['surname'];
							$_SESSION['firstLineAddress'] 	= $row['firstLineAddress'];
							$_SESSION['secondLineAddress'] 	= $row['secondLineAddress'];
							$_SESSION['town'] 				= $row['town'];
							$_SESSION['county'] 			= $row['county'];
							$_SESSION['postcode'] 			= $row['postcode'];
							$_SESSION['phone'] 				= $row['phone'];
							$_SESSION['email'] 				= $row['email'];
							$_SESSION['accessLevel'] 		= $row['accessLevel'];

							?>
							<div class="container">
								<div class="row">
									<div class="col-lg-12">
										<p class="lead">You Have Successfully Logged In.  You Can Now Purchase Products For Sale And/Or Make changes To your Profile.</p>
									</div>
								</div>
							</div>
							<?php
						}

					} // End of password check else

				} // End of password while loop

			} // /. End of password else

		} // /. End of email else

	} // /. End of if (isset)
	// /. Form Validation

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
					<li><a href="../products/gallery/productGallery.php">Products</a>
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