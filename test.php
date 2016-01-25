else {

$pageLanding = "SELECT * FROM `product`, `productPhoto` WHERE product.productID = productPhoto.productID AND productPhoto.productPhotoMaster = 1";

$pageLandingResult = $conn -> query($pageLanding) or die($conn.__LINE__);

while ($pageLandingRow = $pageLandingResult -> fetch_assoc()) {
$productID = $pageLandingRow['productID'];
?>

<div class="col-md-3 col-sm-6 hero-feature">
    <div class="thumbnail">
        <img src="<?php echo $pageLandingRow['fileLocation']; ?>" alt="<?php echo $pageLandingRow['productPhotoName']; ?>">
        <div class="caption">
            <h3><?php echo $pageLandingRow['productMake']." ".$pageLandingRow['productModel']; ?></h3>
            <p>£<?php echo $pageLandingRow['productPrice']; ?></p>
            <p><?php echo $pageLandingRow['productShortDescription']; ?></p>
            <form action="productView.php?id=<?php echo $pageLandingRow['productID']; ?>" method="post">
                <input id="productView" name="productView" type="submit" value="Product Information">
            </form>
        </div>
    </div>
</div>

<?php

} // /. while ()