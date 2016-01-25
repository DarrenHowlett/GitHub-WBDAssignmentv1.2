$getProductID = $_SESSION['getProductID'];

echo "ProductID: ".$getProductID."<br>";
echo "SessionID: ".$_SESSION['getProductID'];

$selectProduct = "SELECT * FROM `product`, `productPhoto` WHERE product.productID = '".$productID."' AND product.productID = productPhoto.productID AND productPhoto.productPhotoMaster = 1";
$selectProductResult = $conn -> query($selectProduct) or die($conn.__LINE__);

while ($selectProductRow = $selectProductResult -> fetch_assoc()) {
?>
<!-- Portfolio Item Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $selectProductRow['productMake']." ".$selectProductRow['productModel']." ".$selectProductRow['productName']; ?>
            <small>Categories: <?php echo $selectProductRow['tags']; ?></small>
        </h1>
    </div>
</div>
<!-- /.row -->

<!-- Portfolio Item Row -->
<div class="row">

    <div class="col-md-8">
        <img class="img-responsive" src="<?php echo $selectProductRow['fileLocation']; ?>" alt="<?php echo $selectProductRow['productPhotoName']; ?>">
    </div>

    <div class="col-md-4">
        <h3>Product Description</h3>
        <p><?php echo $selectProductRow['productLongDescription']; ?></p>
        <h3>Price</h3>
        <p>£<?php echo $selectProductRow['productPrice']; ?></p>
        <h3>Warranty</h3>
        <p><?php
                $warrantyID = $selectProductRow['warrantyID'];

                $selectWarranty = "SELECT `warrantyDescription` FROM `warranty` WHERE `warrantyID` = '".$warrantyID."'";
                $warrantyResult = $conn -> query($selectWarranty) or die($conn.__LINE__);

                while ($warrantyRow = $warrantyResult -> fetch_assoc()) {
                    echo $warrantyRow['warrantyDescription'];
                }

            ?></p>
        <h3>Product Options</h3>
        <form action="../buy/buyProduct.php" method="post">
            <input id="buyProduct" name="buyProduct" type="submit" value="Buy Product">
        </form>
        <br>
        <form action="../update/updateProduct.php" method="post">
            <input id="updateProduct" name="updateProduct" type="submit" value="Update Product">
        </form>
        <br>
        <form action="../delete/deleteProduct.php" method="post">
            <input id="deleteProduct" name="deleteProduct" type="submit" value="Delete Product">
        </form>
    </div>

</div>
<!-- /.row -->

<?php
    } // /. while ($selectProductRow = $selectProductResult -> fetch_assoc())







------------------------------------------------------------------------------------------------------------------------








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

                ?>
                <form action="productView.php?id=<?php echo $selectProductRow['productID']; ?>" method="post">
                    <div class="col-md-3 col-sm-6 hero-feature">
                        <div class="thumbnail">
                            <?php

                                //$productID = $selectProductRow['productID'];
                                $_SESSION['getProductID'] = $selectProductRow['productID'];

                                echo "SESSION['getPoductID']:".$_SESSION['getProductID']."<br>";
                                //echo "productID: ".$productID;

                            ?>
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