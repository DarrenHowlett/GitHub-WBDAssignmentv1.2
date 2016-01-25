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

        <title>Heroic Features - Start Bootstrap Template</title>

        <!-- Bootstrap Core CSS -->
        <link href="../../../css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="../../../css/heroic-features.css" rel="stylesheet">

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
    <div class="container">

        <!-- Jumbotron Header -->
        <header class="jumbotron hero-spacer">
            <h1>Our Products</h1>
            <p>This is where you will find all of our products that we have for sale.  If you cannot find what you are looking for, or know what it is you want, you can always use the search below to narrow your search to see if we have an item suitable to you.</p>
            <form action="productGallery.php" method="post">
                <label for="productSearch">
                    <select id="productSearch" name="productSearch">
                        <option value="White Goods">White Goods</option>
                        <option value="Chest Freezer">Chest Freezer</option>
                        <option value="Cooker">Cooker</option>
                        <option value="Dishwasher">Dishwasher</option>
                        <option value="Freezer">Freezer</option>
                        <option value="Fridge Freezer">Fridge Freezer</option>
                        <option value="Fridge">Fridge</option>
                        <option value="Microwave">Microwave</option>
                        <option value="Washing Machine">Washing Machine</option>
                        <option value="Gardening Equipment">Gardening Equipment</option>
                        <option value="Cultivator">Cultivator</option>
                        <option value="Elctric Tool">Electric Tool</option>
                        <option value="Hedge Trimmer">Hedge Trimmer</option>
                        <option value="Lawn Mower">Lawn Mower</option>
                        <option value="Manual Tool">Manual Tool</option>
                        <option value="Ride-On-Mower">Ride On Mower</option>
                        <option value="Strimmer">Strimmer</option>
                    </select>
                </label>
                <br>
                <input id="productSearchSubmit" name="productSearchSubmit" type="submit" value="Search Products">
            </form>
        </header>

        <hr>

        <!-- Page Features -->
        <div class="row text-center">
            <?php

            $selectProduct = "SELECT * FROM `product`, `productPhoto` WHERE product.productID = productPhoto.productID AND productPhoto.productPhotoMaster = 1";
            $selectProductResult = $conn -> query($selectProduct) or die($conn.__LINE__);

            if (isset($_POST['productSearchSubmit'])) {

                // Store the selection from product search in a variable
                $productSearchSelection = $_POST['productSearch'];

                // Because the product search will be compared to the tags stored in the database
                // against each product, the selection made needs to have the % symbol added
                // to the beginning and end of the selection, these are called "wildcards".
                // By having these wildcards, when the search is performed on the database
                // everything before & after the selection will be ignored and only the selection
                // will be used.
                $productSearchSelection = "%".$productSearchSelection."%";

                $selectProduct = "SELECT * FROM `product`, `productPhoto` WHERE product.productID = productPhoto.productID AND productPhoto.productPhotoMaster = 1 AND `tags` LIKE  '".$productSearchSelection."'";

                $selectProductResult = $conn -> query($selectProduct) or die($conn.__LINE__);

            }

            while ($selectProductRow = $selectProductResult -> fetch_assoc()) {
                $productID = $selectProductRow['productID'];
                $_SESSION['getProductID'] = $productID;

                echo "SESSION['getPoductID']:".$_SESSION['getProductID']."<br>";
                echo "productID: ".$productID;
                ?>
            <form action="productView.php?id=<?php echo $selectProductRow['productID']; ?>" method="post">
                <div class="col-md-3 col-sm-6 hero-feature">
                    <div class="thumbnail">
                        <img src="<?php echo $selectProductRow['fileLocation']; ?>" alt="<?php echo $selectProductRow['productPhotoName']; ?>">
                        <div class="caption">
                            <h3><?php echo $selectProductRow['productMake']." ".$selectProductRow['productModel']; ?></h3>
                            <p>£<?php echo $selectProductRow['productPrice']; ?></p>
                            <p><?php echo $selectProductRow['productShortDescription']; ?></p>
                            <input id="productView" name="productView" type="submit" value="Product Information">

                        </div>
                    </div>
                </div>
            </form>

                <?php

            } // /. while ()

            ?>

        </div>
        <!-- /.row -->

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