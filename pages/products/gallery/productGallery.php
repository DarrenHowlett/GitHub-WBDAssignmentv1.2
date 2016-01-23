<?php

    // Sessions/Cookies
    session_start();

    if ($_SESSION['loggedIn'] != TRUE) {

        // Include/Required files
        require_once('../../../admin/config/normalUser.php');
        // /. Include/Required files

        // Open database connection
        $conn = new mysqli($host, $user, $pwrd, $dbase);
        if (mysqli_connect_errno()) {
            printf("Database connection failed due to: %s\n", mysqli_connect_error());
            exit();
        }
        // /. Open database connection

    } else {

        // Include/Required files
        require_once('../../../admin/config/registeredUser.php');
        // /. Include/Required files

        // Open database connection
        $conn = new mysqli($host, $user, $pwrd, $dbase);
        if (mysqli_connect_errno()) {
            printf("Database connection failed due to: %s\n", mysqli_connect_error());
            exit();
        }
        // /. Open database connection

    } // /. Sessions/Cookies

?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Shop Homepage - Start Bootstrap Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../../css/shop-homepage.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="../../../js/html5shiv.min.js"></script>
    <script src="../../../js/respond.min.js"></script>
    <![endif]-->

    <!-- Site Specific CSS -->
    <link rel="stylesheet" type="text/css" href="../../../css/r4ustyles.css">

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
                    <a href="productGallery.php">Products</a>
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

<!-- Page Content -->
<?php

    $selectPhotos = "SELECT * FROM `product`, `productPhoto` WHERE product.productID = productPhoto.productID AND productPhoto.productPhotoMaster = 1";
    $selectPhotosResult = $conn -> query($selectPhotos) or die($conn.__LINE__);

    while ($selectPhotosRow = $selectPhotosResult -> fetch_assoc()) {

        $_SESSION['productID'] = $selectPhotosRow['productID'];

    ?>
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- class="col-sm-4 col-lg-4 col-md-4" -->
                <div class="col-sm-4 col-lg-4 col-md-4">
                    <!-- class="thumbnail" -->
                    <div class="thumbnail">
                        <img src="<?php echo $selectPhotosRow['fileLocation']; ?>" alt="<?php echo $selectPhotosRow['productPhotoName']; ?>">
                        <!-- class="caption" -->
                        <div class="caption">
                            <h4 class="pull-right">$<?php echo $selectPhotosRow['productPrice']; ?></h4>
                            <h4><?php echo $selectPhotosRow['productName']; ?></h4>
                            <p><?php echo $selectPhotosRow['productShortDescription']; ?></p>
                            <form action="productView.php?productID=<?php echo $selectPhotosRow['productID']; ?>" method="post">
                                <input id="viewProduct" name="viewProduct" type="submit" value="View Product">
                            </form>
                        </div>
                        <!-- /. class="ratings" -->
                    </div>
                    <!-- /. class="thumbnail" -->
                </div>
                <!-- /. class="col-sm-4 col-lg-4 col-md-4" -->
            </div>
            <!-- /. row -->
        </div>
        <!-- /. container -->
    <?php
    } // /. while ($selectPhotosRow = $selectPhotosResult -> fetch_assoc())
?>

<div class="container">

    <hr>

    <!-- Footer -->
    <!-- The footer contains content with regards to copyright information, external site links, site maps and any other information that while useful to the user, is not the most important to convey to the user. -->
    <footer>
        <!-- This <div class="row"> will display the content within this div on a new row below any content above it. -->
        <div class="row">
            <div class="col-lg-4">
                <h3>Recycling For U Policies</h3>
                <ul>
                    <li><a href="#" target="_blank">Privacy Policy</a></li>
                    <li><a href="#" target="_blank">Warranties policy</a></li>
                </ul>
            </div>
            <div class="col-lg-4">
                <!-- Site Map -->
                <!-- This site map details links to all the page headings on this web site.  Not all pages are detailed in the navigation bar, but will be accessible via a link in the navigation bar.  For example White Goods are accessible via the For Sale link. -->
                <h3>Site Map</h3>
                <ul>
                    <li><a href="../../../index.php">Home</a></li>
                    <li><a href="productGallery.php">Products</a>
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
                <!-- External Links -->
                <!-- This is where any links to external web sites are placed.  External links are links to web sites, that while they belong to other sites, they do have some relevance to this web site or information on this web site. -->
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
                <!-- The php date function will always show the current year.  If this was hard coded, someone would have to remember to change it whenever a new year began. -->
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