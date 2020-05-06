<?php
session_start();
require "server.php";
require "validate.php";

if (!isset($_SESSION['loggedin'])) {
    header("Location: ../HTML/index.html");
    exit();
}

$search = "%{$_GET['prodsearch']}%";

$stmt = $con->prepare("SELECT productCode, productName, producttype.productTypeName, productDescription, amountInStock, productPhoto, minStock, maxStock FROM product INNER JOIN producttype ON product.productTypeCode = producttype.productTypeCode WHERE productName LIKE ? OR productCode LIKE ? OR producttype.productTypeName LIKE ?");
$stmt->bind_param("sss", $search, $search, $search);
$stmt->execute();
$stmt->bind_result($productCode, $productName, $productTypeName, $desc, $inStock, $img, $minStock, $maxStock);

?>

<!DOCTYPE html>
<html>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- Font Awesome Kit Code -->
    <script src="https://kit.fontawesome.com/9477a9faa7.js" crossorigin="anonymous"></script>

    <title>Product Search Result</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row mb-1">
            <div class="col">
                <img src="../images/logo_sm.png" class="img-fluid float-left" alt="Gadgets4U Logo">
                <h5 class="text-right"><?php echo $_SESSION['name'] ?></h5>
                <h5 class="text-right">
                    <?php echo $_SESSION['title'] . " " . $_SESSION['firstName'] . " " . $_SESSION['lastName'] ?></h5>
                <h5 class="text-right"><?php echo $_SESSION['appointment'] ?></h5>
                <div class="btn-group float-right" role="group" aria-label="Login Options">
                    <a href="../HTML/register.html" class="btn btn-secondary float-right"><i
                            class="fas fa-user-plus"></i> Staff Registration Portal</a>
                    <a href="changePassword.php" class="btn btn-secondary float-right"><i class="fas fa-cog"></i> Change
                        Password</a>
                    <a href="logout.php" class="btn btn-primary float-right"><i class="fas fa-sign-out-alt"></i>
                        Logout</a>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Gadgets4U Purchase Order System</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link" href="home.php">Home</a>
                <a class="nav-item nav-link" href="products.php">Store Stock</a>
                <a class="nav-item nav-link" href="newPorder.php">New Purchase Order</a>
                <a class="nav-item nav-link" href="viewPorders.php">Purchase Order Requests</a>
                <a class="nav-item nav-link" href="viewOrders.php">Purchase Orders</a>
                <a class="nav-item nav-link" href="reports.php">Reports</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1 class="text-center">Results For: <?=  $_GET['prodsearch'] ?></h1>
        <?php $i = 1; ?>
        <?php while ($stmt->fetch()) {

            if ((int)$inStock > ((int) $minStock + 5)) {
                $background = "bg-success";
            } elseif ((int) $inStock >= (int) $minStock) {
                $background = "bg-warning";
            } elseif ((int) $inStock < (int) $minStock) {
                $background = "bg-danger";
            } ?>
        <?php if ($i % 2 != 0) { ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="card-deck mb-4">
                    <div class='card border-dark'>
                        <img class="card-image-top h-20" style="width: 100%; height:15vw; object-fit:contain;"
                            src="../images/<?php echo $img ?>"
                            alt="Image of <?php echo $desc; ?>">
                        <div class='card-header'>
                            <h5 class='card-title'><?php echo $productCode; ?> <span class="badge badge-secondary"><?= $productTypeName ?></span></h5>
                            <h6 class='card-title'><?php echo $productName; ?></h6>
                        </div>
                        <div class='card-body'>
                            <?php echo $desc; ?>
                        </div>
                        <div class='card-footer <?php echo $background; ?>'>
                            <p>Quantity in Stock: <?php echo $inStock; ?></p>
                            <p>Maximum Stock Level: <?=$maxStock?></p>
                        </div>

                    </div>
                    <?php } else { ?>

                    <div class='card border-dark'>
                        <img class="card-image-top h-20" style="width: 100%; height:15vw; object-fit: contain;"
                            src="../images/<?php echo $img ?>"
                            alt="Image of <?php echo $desc; ?>">
                        <div class='card-header'>
                            <h5 class='card-title'><?php echo $productCode; ?> <span class="badge badge-secondary"><?= $productTypeName ?></span></h5>
                            <h6 class='card-title'><?php echo $productName; ?></h6>
                        </div>
                        <div class='card-body'>
                            <?php echo $desc; ?>
                        </div>
                        <div class='card-footer <?php echo $background; ?>'>
                            <p>Quantity in Stock: <?php echo $inStock ?></p>
                            <p>Maximum Stock Level: <?=$maxStock?></p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php } ?>
        <?php $i++; ?>
        <?php } ?>
    </div>
    
</body>
</html>