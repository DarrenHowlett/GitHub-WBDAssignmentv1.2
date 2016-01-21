<?php

	// Sessions/Cookies
	session_start();

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

		// If the user trying to view this page has not registered or logged in, then this message will be displayed.
		?>
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<p class="lead">You Have To Log In To See your Profile.</p>
				</div>
			</div>
		</div>
		<?php

	} else {
		// The user has registered/logged in, they can then see their profile and make any necessary changes.

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

		$select = "SELECT `userID` FROM `user` WHERE `email` LIKE BINARY '".$_SESSION['email']."'";
		$result = $conn -> query($select) or die($conn.__LINE__);

		while ($row = $result -> fetch_assoc()) {
			$_SESSION['userID'] = $row['userID'];

			?>
			<!-- Content Container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<!-- col-lg-12 -->
					<div class="col-lg-12">
						<h1>My Profile</h1>
						<table>
							<thead>
							<tr>
								<th>Field Name</th>
								<th class="profileTH">What We Have Stored</th>
							</tr>
							</thead>
							<tbody>
							<tr>
								<td>ID [For Testing SESSIONS ONLY]</td>
								<td class="profileTD"><?php echo $_SESSION['userID']; ?></td>
							</tr>
							<tr>
								<td>Title</td>
								<td class="profileTD"><?php echo $_SESSION['title']; ?></td>
							</tr>
							<tr>
								<td>Forename</td>
								<td class="profileTD"><?php echo $_SESSION['forename']; ?></td>
							</tr>
							<tr>
								<td>Surname</td>
								<td class="profileTD"><?php echo $_SESSION['surname']; ?></td>
							</tr>
							<tr>
								<td>First Line Address</td>
								<td class="profileTD"><?php echo $_SESSION['firstLineAddress']; ?></td>
							</tr>
							<tr>
								<td>Second Line Address</td>
								<td class="profileTD"><?php echo $_SESSION['secondLineAddress']; ?></td>
							</tr>
							<tr>
								<td>Town</td>
								<td class="profileTD"><?php echo $_SESSION['town']; ?></td>
							</tr>
							<tr>
								<td>County</td>
								<td class="profileTD"><?php echo $_SESSION['county']; ?></td>
							</tr>
							<tr>
								<td>Postcode</td>
								<td class="profileTD"><?php echo $_SESSION['postcode']; ?></td>
							</tr>
							<tr>
								<td>Phone</td>
								<td class="profileTD"><?php echo $_SESSION['phone']; ?></td>
							</tr>
							<tr>
								<td>Email</td>
								<td class="profileTD"><?php echo $_SESSION['email']; ?></td>
							</tr>
							</tbody>
						</table>
						<br>
					</div>
					<!-- /. col-lg-12 -->
				</div>
				<!-- /. row -->

				<!-- row -->
				<div class="row">
					<!-- col-lg-12 -->
					<div class="col-lg-12">
						<p class="lead">Profile Options</p>
						<form action="updateProfile/updateProfile.php" method="post">
							<input id="profileUpdate" name="profileUpdate" type="submit" value="Update Profile">
						</form><br>
						<form action="updateEmail/updateEmail.php" method="post">
							<input id="updateEmail" name="updateEmail" type="submit" value="Update Email">
						</form><br>
						<form action="updatePwrd/updatePwrd.php" method="post">
							<input id="updatePwrd" name="updatePwrd" type="submit" value="Update Password">
						</form><br>
						<form action="deleteProfile/deleteProfile.php" method="post">
							<input id="deleteProfile" name="deleteProfile" type="submit" value="Delete Profile">
						</form>
					</div>
					<!-- /. col-lg-12 -->
				</div>
				<!-- /. row -->
			</div>
			<!-- /. Content Container -->
			<?php

		}
		// /. while

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
					<a href="../products/productGallery.php">Products</a>
				</li>
				<li>
					<a href="../products/productUpload.php">Product Upload</a>
				</li>
				<li>
					<a href="../register/register.php">Register</a>
				</li>
				<li>
					<a href="../general/contact.php">Contact</a>
				</li>
				<li>
					<a href="../login/login.php">Log In</a>
				</li>
				<li>
					<a href="profile.php">My Profile</a>
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

<!-- Content Container -->
<div class="container">
	<!-- row -->
	<div class="row">
		<!-- col-lg-12 -->
		<div class="col-lg-12">

		</div>
		<!-- /. col-lg-12 -->
	</div>
	<!-- /. row -->
</div>
<!-- /. Content Container -->

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
					<li><a href="../products/productUpload.php">Product Upload</a></li>
					<li><a href="../register/register.php">Register</a></li>
					<li><a href="../general/contact.php">Contact Us</a></li>
					<li><a href="../login/login.php">Log In</a></li>
					<li><a href="profile.php">My Profile</a></li>
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
