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

		if (isset($_POST['uploadPhotoConfirm'])) {

			/* --------------------------------------------
		 * Variables From File Information
		-------------------------------------------- */

			$productID 			= $_SESSION['productID'];
			$fileName 			= $_FILES['userfile']['name'];
			$tmpName 			= $_FILES['userfile']['tmp_name'];
			$fileSize 			= $_FILES['userfile']['size'];
			$fileType 			= $_FILES['userfile']['type'];
			$productPhotoName 	= $_POST['productPhotoName'];
			$folderName 		= $_POST['folderName']; // Returns the value of the dropdown option, not what is
			// displayed to the user

			// This determines where the file is to be uploaded
			$uploadDir = '../../../pics/products/'.$folderName.'/';

			// This variable takes the path of the directory to which the file is to be uploaded to
			// and appends the file name to that directory, this is what is uploaded to the database,
			// the file itself will be uploaded and stored wherever the path pointed to.
			$filePath = $uploadDir . $fileName;

			$fileName = addslashes($fileName);
			$filePath = addslashes($filePath);

			$result = move_uploaded_file($tmpName, $filePath);
			if (!$result) {
				echo "Error uploading file";
				exit;
			}

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
			$productPhotoName = mysqli_real_escape_string($conn, $productPhotoName);

			// Trim any whitespace from the beginning and end of the user input
			$productPhotoName = trim($productPhotoName);

			// Remove any HTML & PHP tags that may have been injected in to the input
			$productPhotoName = strip_tags($productPhotoName);

			// Convert any tags that may have slipped through in to string data,
			// for example <b>Darren</b> becomes &lt;b&gt;Darren&lt;/b&gt;
			$productPhotoName = htmlentities($productPhotoName);

			/* --------------------------------------------
			 * Form Checks
			-------------------------------------------- */

			// Check ALL form entries have been filled in
			if (empty($productPhotoName)) {
				?>
				<div class="container">
					<div class="row">
						<div class="col-lg-12">
							<p class="lead">The photo must be given a name.</p>
						</div>
					</div>
				</div>
				<?php
			} else {

				$insertPhoto = "INSERT INTO `productPhoto`
								(`fileName`, `fileType`, `fileSize`, `fileLocation`, `productPhotoName`, `productPhotoMaster`, `productID`)
								VALUES
								('".$fileName."', '".$fileType."', '".$fileSize."', '".$filePath."', '".$productPhotoName."', 1, '".$productID."')
								";

				$insertPhotoResult = $conn -> query($insertPhoto) or die($conn.__LINE__);

				if (!$result) {

					?>
					<div class="container">
						<div class="row">
							<div class="col-lg-12">
								<p class="lead">There was an error uploading your file, please contact your system adminsitrator.</p>
							</div>
						</div>
					</div>
					<?php

				} else {

					?>
					<div class="container">
						<div class="row">
							<div class="col-lg-12">
								<p class="lead">Your product has been uploaded.</p>
								<a href="productUpload.php">Upload another product.</a>
							</div>
						</div>
					</div>
					<?php

				} // /. if (!$result)

			} // /. if (empty($productPhotoName))

		} // /. if (isset($_POST['uploadPhotoConfirm']))

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
