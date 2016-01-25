<?php

    // Sessions/Cookies
    session_start();

    if ($_SESSION['loggedIn'] != TRUE) {

        header('Location: ../../login/login.php');

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

        if (isset($_POST['buyProduct'])) {

            $productID = $_SESSION['productID'];
            $userID = $_SESSION['userID'];

            $selectProductDetails = "SELECT * FROM `userTable`, `product` WHERE userTable.userID = '".$userID."' AND product.productID = '".$productID."'";
            $productDetailsResult = $conn -> query($selectProductDetails) or die($conn.__LINE__);

            while ($productDetailsRow = $productDetailsResult -> fetch_assoc()) {

                ?>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="order">
                                <tr>
                                    <th colspan="2">Order Details</th>
                                    <th colspan="3">Customer Details</th>
                                </tr>
                                <tr>
                                    <td colspan="2">Order Number: <?php echo rand(); ?></td>
                                    <td colspan="3"><?php echo $productDetailsRow['title']." ".$productDetailsRow['forename']." ".$productDetailsRow['surname'];?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">Order Date: <?php echo date("D d F Y"); ?></td>
                                    <td colspan="3"><?php echo $productDetailsRow['firstLineAddress']; ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                    <td colspan="3"><?php echo $productDetailsRow['secondLineAddress']; ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                    <td colspan="3"><?php echo $productDetailsRow['town']; ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                    <td colspan="3"><?php echo $productDetailsRow['county']; ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                    <td colspan="3"><?php echo $productDetailsRow['postcode']; ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                    <td colspan="3"><?php echo $productDetailsRow['phone']; ?></td>
                                </tr>
                                <tr>
                                    <td colspan="5">&nbsp;</td>
                                </tr>
                                <tr>
                                    <th>Product Number</th>
                                    <th>Product Make/Model/Name</th>
                                    <th class="amount">Price £</th>
                                    <th class="amount">Qty</th>
                                    <th class="amount">Total £</th>
                                </tr>
                                <tr>
                                    <td><?php echo $productDetailsRow['productID']; ?></td>
                                    <td>
                                        <?php
                                            echo $productDetailsRow['productMake']." ".$productDetailsRow['productModel']." ".$productDetailsRow['productName'];
                                        ?>
                                    </td>
                                    <td class="amount"><?php echo $productDetailsRow['productPrice']; ?></td>
                                    <td class="amount"><?php echo $productDetailsRow['productQtyAvailable']; ?></td>
                                    <td class="amount">
                                        <?php
                                            $orderLineTotal = $productDetailsRow['productPrice'] * $productDetailsRow['productQtyAvailable'];
                                            echo $orderLineTotal;
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="5">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="5">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="5">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="5">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="5">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="5">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="5">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="5">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="5">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="5">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="5">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="5">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="5">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="5">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="5">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="5">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="5">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="5">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="5">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                    <td colspan="2" class="amount">Sub Total: £</td>
                                    <td colspan="1" class="amount">
                                        <?php

                                            $subTotal = $orderLineTotal;
                                            echo number_format($subTotal, 2);

                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                    <td colspan="2" class="amount">VAT: £</td>
                                    <td colspan="1" class="amount">
                                        <?php

                                            $vat = $subTotal / 100 * 20;
                                            echo number_format($vat, 2);

                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                    <td colspan="2" class="amount">Order Total: £</td>
                                    <td colspan="1" class="amount">
                                        <?php

                                            $total = $subTotal + $vat;
                                            echo number_format($total, 2);

                                        ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <?php

            } // /.

        } // /. if (isset($_POST['buyProduct']))

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

    <title>Portfolio Item - Start Bootstrap Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../../css/portfolio-item.css" rel="stylesheet">

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

<!-- Page Content -->
<div class="container">

</div>

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