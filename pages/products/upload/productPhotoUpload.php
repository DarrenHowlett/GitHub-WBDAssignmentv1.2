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

		if (isset($_POST['uploadPhoto'])) {

			// Make variables from session data
			$productMake 				= $_SESSION['productMake'];
			$productModel 				= $_SESSION['productModel'];
			$productName 				= $_SESSION['productName'];
			$productPrice 				= $_SESSION['productPrice'];
			$productQtyAvailable 		= $_SESSION['productQtyAvailable'];
			$productShortDescription 	= $_SESSION['productShortDescription'];
			$productLongDescription 	= $_SESSION['productLongDescription'];
			$tags 						= $_SESSION['tags'];
			$warrantyID 				= $_SESSION['warrantyID'];

			// Before any photo can be added to a product, the product's ID needs to be retrieved from the database. As the
			// products sold on this web site are recycled, even though there may be two items that are the same make, model etc,
			// the chances of them being identical, unless they came from the same location, is going to be slim.  Because of
			// this, the ID cannot be retrieved by comparing one piece of information.  So to make sure the ID is retrieved for
			// the correct product, every field in the database is compared, this will make sure that the correct item is selected.
			$selectProductID = "SELECT `productID` FROM `product` WHERE
							`productMake` LIKE BINARY '".$productMake."' AND
							`productModel` LIKE BINARY '".$productModel."' AND
							`productName` LIKE BINARY '".$productName."' AND
							`productPrice` LIKE BINARY '".$productPrice."' AND
							`productQtyAvailable` LIKE BINARY '".$productQtyAvailable."' AND
							`productShortDescription` LIKE BINARY '".$productShortDescription."' AND
							`productLongDescription` LIKE BINARY '".$productLongDescription."' AND
							`tags` LIKE BINARY '".$tags."' AND
							`warrantyID` LIKE BINARY '".$warrantyID."'
							";
			$productIDResult = $conn -> query($selectProductID) or die($conn.__LINE__);

			while ($productIDRow = $productIDResult -> fetch_assoc()) {

				$_SESSION['newProductID'] = $productIDRow['productID'];
				$newProductID = $_SESSION['newProductID'];

				?>

				<div class="container">
					<div class="row">
						<div class="col-lg-12">
							<!-- Add A Photo To A Product Form -->
							<form action="productPhotoUploadConfirmation.php" method="post" enctype="multipart/form-data">
								<div class="col-lg-12">
									<h3>Product Photo Information</h3>
									<h4>Photo To Upload</h4>
									<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
									<input name="userfile" type="file" id="userfile">
									<h4>File Name</h4>
									<label for="productPhotoName">
										<input id="productPhotoName" name="productPhotoName" type="text">
									</label><br>
									<h4>Directory To Upload To</h4>
									<label for="folderName">Folder Name<br>
										<select id="folderName" name="folderName">
											<option value="chestFreezer">Chest Freezer</option>
											<option value="cooker">Cooker</option>
											<option value="dishwasher">Dishwasher</option>
											<option value="freezer">Freezer</option>
											<option value="fridgeFreezer">Fridge Freezer</option>
											<option value="fridge">Fridge</option>
											<option value="microwave">Microwave</option>
											<option value="washingMachine">Washing Machine</option>
											<option value="cultivator">Cultivator</option>
											<option value="elctricTool">Electric Tool</option>
											<option value="hedgeTrimmer">Hedge Trimmer</option>
											<option value="lawnMower">Lawn Mower</option>
											<option value="manualTool">Manual Tool</option>
											<option value="rideOnMower">Ride On Mower</option>
											<option value="strimmer">Strimmer</option>
										</select>
									</label><br><br>
								</div>
								<div class="col-lg-12">
									<input id="uploadPhotoConfirm" name="uploadPhotoConfirm" type="submit" value="Confirm Photo upload">
								</div>
							</form>
							<!-- /. Add A Photo To A Product Form -->
						</div>
					</div>
				</div>

				<?php
			} // /. while ($productIDRow = $productIDResult -> fetch_assoc())

		} // /. if (isset($_POST['uploadPhoto']))

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
