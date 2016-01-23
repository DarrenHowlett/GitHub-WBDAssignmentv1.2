<?php

	// Sessions/Cookies
	session_start();

	// Sessions/Cookies
	session_start();
	if ($_SESSION['loggedIn'] != TRUE) {

		// If a user tries to access this page without logging in, they will be redirected to the log in page
		header('Location: ../../login/login.php');

	} elseif ($_SESSION['accessLevel'] == 1) {

		// If the user does not have the correct access level, they will be shown an error message
		?>
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<p class="lead">You DO NOT have the correct access level to access this page.  If you are a member of staff, please contact your system administrator.</p>
				</div>
			</div>
		</div>
		<?php

	} else {

		// If the user trying too access this page has the correct access level then they will be given permission to use this page
		// and upload a new product as they are at least a member of staff, this will also load the staffMember config file

		// Include/Required files
		require_once ('../../../admin/config/staffMember.php');
		// /. Include/Required files

		// Open database connection
		$conn = new mysqli($host, $user, $pwrd, $dbase);
		if (mysqli_connect_errno()) {
			printf("Database connection failed due to: %s\n", mysqli_connect_error());
			exit();
		}
		// /. Open database connection

		if (isset($_POST['newProduct'])) {

			$productMake				= $_POST['productMake'];
			$productModel 				= $_POST['productModel'];
			$productName 				= $_POST['productName'];
			$productPrice 				= $_POST['productPrice'];
			$productQtyAvailable		= $_POST['productQtyAvailable'];
			$productShortDescription 	= $_POST['productShortDescription'];
			$productLongDescription 	= $_POST['productLongDescription'];
			$tags 						= $_POST['tags']; // Returns the value of the checkbox, not what is displayed to the user.
			// This is then Placed in to an array as the name of the checkboxes in the tag list is tags[]

			$warrantyID 				= $_POST['warrantyID']; // Returns the value of the radio button, not what is displayed
			// to the user. The value of the radio button is the Primary Key from the Warranty table in the database and will
			// be inserted in to the Product table as a Foreign Key.

			$tags 						= implode(", ", $_POST['tags']); // By imploding the contents of the array, this turns the array
			// data into string data which is then used to insert in to the database. Although the tags have now been made in to string
			// data, there is no need to sanitize them as the input came from checkboxes and it is the PHP that has turned the data in
			// to string data, not user input.

			// SQL INJECTION COUNTERMEASURES
			// This only has to apply to fields that allow users to type string data in, fields that have dropdown boxes,
			// checkboxes, radio buttons etc or are restricted to number input need not be put through sanitation. The reason
			// inputs restricted to number input do not have to be put through sanitation is, even though the input will allow
			// for text to be entered in to the input box, any text that is entered will not actually be returned.

			// Escape any special characters, for example O'Conner becomes O\'Conner
			// The first parameter of mysqli_real_escape_string is the database connection to open,
			// The second parameter is the string to have the special characters escaped.
			$productMake 				= mysqli_real_escape_string($conn, $productMake);
			$productModel 				= mysqli_real_escape_string($conn, $productModel);
			$productName 				= mysqli_real_escape_string($conn, $productName);
			$productShortDescription 	= mysqli_real_escape_string($conn, $productShortDescription);
			$productLongDescription 	= mysqli_real_escape_string($conn, $productLongDescription);

			// Trim any whitespace from the beginning and end of the user input
			$productMake 				= trim($productMake);
			$productModel 				= trim($productModel);
			$productName 				= trim($productName);
			$productShortDescription 	= trim($productShortDescription);
			$productLongDescription 	= trim($productLongDescription);

			// Remove any HTML & PHP tags that may have been injected in to the input
			$productMake 				= strip_tags($productMake);
			$productModel 				= strip_tags($productModel);
			$productName 				= strip_tags($productName);
			$productShortDescription 	= strip_tags($productShortDescription);
			$productLongDescription 	= strip_tags($productLongDescription);

			// Convert any tags that may have slipped through in to string data,
			// for example <b>Darren</b> becomes &lt;b&gt;Darren&lt;/b&gt;
			$productMake 				= htmlentities($productMake);
			$productModel 				= htmlentities($productModel);
			$productName 				= htmlentities($productName);
			$productShortDescription 	= htmlentities($productShortDescription);
			$productLongDescription 	= htmlentities($productLongDescription);

			// Put all the variables in to sessions so they can be used later on.
			$_SESSION['productMake'] 				= $productMake;
			$_SESSION['productModel'] 				= $productModel;
			$_SESSION['productName'] 				= $productName;
			$_SESSION['productPrice'] 				= $productPrice;
			$_SESSION['productQtyAvailable'] 		= $productQtyAvailable;
			$_SESSION['productShortDescription'] 	= $productShortDescription;
			$_SESSION['productLongDescription'] 	= $productLongDescription;
			$_SESSION['tags'] 						= $tags;
			$_SESSION['warrantyID'] 				= $warrantyID;

			// As the products for sale are recycled goods, there is a chance that not all the information in the form can
			// be filled out as the information may not be available.  Because of this, and the fact that a member of staff
			// is filling in the form, a certain level of latitude has been given and the empty fields check has not been
			// implemented for this form.

			// Display what the staff member has entered so they can confirm the details are correct
			?>
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<table>
							<thead>
							<tr>
								<th>Field Name</th>
								<th class="profileTH">Field Entry</th>
							</tr>
							</thead>
							<tbody>
							<tr>
								<td>Product Make</td>
								<td class="profileTD"><?php echo $_SESSION['productMake']; ?></td>
							</tr>
							<tr>
								<td>Product Model</td>
								<td class="profileTD"><?php echo $_SESSION['productModel']; ?></td>
							</tr>
							<tr>
								<td>Product Name</td>
								<td class="profileTD"><?php echo $_SESSION['productName']; ?></td>
							</tr>
							<tr>
								<td>Product Price</td>
								<td class="profileTD"><?php echo $_SESSION['productPrice']; ?></td>
							</tr>
							<tr>
								<td>Quantity Available</td>
								<td class="profileTD"><?php echo $_SESSION['productQtyAvailable']; ?></td>
							</tr>
							<tr>
								<td>Product Short Description</td>
								<td class="profileTD"><?php echo $_SESSION['productShortDescription']; ?></td>
							</tr>
							<tr>
								<td>Product Long Description</td>
								<td class="profileTD"><?php echo $_SESSION['productLongDescription']; ?></td>
							</tr>
							<tr>
								<td>Tags</td>
								<td class="profileTD"><?php echo $_SESSION['tags']; ?></td>
							</tr>
							<tr>
								<td>WarrantyID</td>
								<td class="profileTD"><?php echo $_SESSION['warrantyID']; ?></td>
							</tr>
							</tbody>
						</table>
						<h4>Warranty ID Key</h4>
						<ul>
							<li>1 = Sold As Seen</li>
							<li>2 = 3mths</li>
							<li>3 = 6mths</li>
						</ul>
						<form action="productUploadResults.php" method="post">
							<p class="lead">If the above details are correct and you wish to continue, please click the upload to database button below, otherwise <a href="productUpload.php">go back to the Product Upload page</a> and start again.</p>
							<input id="confirmProductDetails" name="confirmProductDetails" type="submit" value="Upload Product To Database">
						</form>
					</div>
				</div>
			</div>
			<?php


		} // /.if (isset($_POST['newProduct']))


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
					<a href="../gallery/productGallery.php">Products</a>
				</li>
				<li>
					<a href="productUpload.php">Product Upload</a>
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
					<li><a href="../gallery/productGallery.php">Products</a>
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
					<li><a href="productUpload.php">Product Upload</a></li>
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
