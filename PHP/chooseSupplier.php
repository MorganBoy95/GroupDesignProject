<?php
session_start();
require "validate.php";
require "server.php";

if (!isset($_SESSION['loggedin'])) {
    header('Location:../HTML/index.html');
    exit();
}

$activeProductCode = $_SESSION['activePorderItem'];

$stmt = "SELECT `productsupplier`.`supplierID`, `productsupplier`.`costInPence`, `productsupplier`.`deliveryTimeInWorkingDays`, `supplier`.`name`  FROM `productsupplier` INNER JOIN `supplier` ON `productsupplier`.`supplierID` = `supplier`.`supplierID` WHERE `productsupplier`.`productCode` = '" . $activeProductCode . "';";



$result = $con->query($stmt);
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
    <link rel="stylesheet" href="stylesheet.css">
    <!-- Font Awesome Kit Code -->
    <script src="https://kit.fontawesome.com/9477a9faa7.js" crossorigin="anonymous"></script>

    <title>Select Item Supplier</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row mb-1">
            <div class="col">
                <a href="home.php">
                    <img src="../images/logo_sm.png" class="img-fluid float-left" alt="Gadgets4U Logo">
                </a>
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

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Gadgets4U Purchase Order System</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link" href="home.php">Home</a>
                <a class="nav-item nav-link" href="products.php">Store Stock</a>
                <a class="nav-item nav-link active" href="newPorder.php">New Purchase Order <span
                        class="sr-only">(current)</span></a>
                <a class="nav-item nav-link" href="viewPorders.php">Purchase Order Requests</a>
                <a class="nav-item nav-link" href="viewOrders.php">Purchase Orders</a>
                <a class="nav-item nav-link" href="reports.php">Reports</a>
            </div>
        </div>
    </nav>

    <h1 class="text-center">Suppliers for <?php echo $activeProductCode ?></h1>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <form action="addMore.php" method="POST">
                    <div class="form-group w-25 mx-auto d-block">
                        <label for="porderSupplier">Select Supplier*</label>
                        <select name="porderSupplier" id="porderSupplier" class="form-control" required>
                            <?php
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['supplierID'] . "'>" . $row['supplierID'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button class="btn btn-primary mx-auto d-block">Select</button>
                </form>
            </div>
        </div>
    </div>

    <br>
    <br>

    <?php $result = $con->query($stmt); ?>

    <div class="container-fluid">
        <?php while ($row = $result->fetch_assoc()) { ?>

        <div class="row">
            <div class="col-sm-12">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title"><?php echo $row['supplierID'] ?> - <?php echo $row['name'] ?></h5>
                    </div>
                    <div class="card-body">
                        <p>Delivery Time: <?php echo $row['deliveryTimeInWorkingDays'] ?> Working Days</p>
                        <p>Cost: £<?php echo number_format((int) $row['costInPence'] / 100, '2', '.', '') ?></p>
                    </div>
                </div>
            </div>
        </div>

        <?php } ?>
    </div>
    <!-- Footer -->
    <footer class="page-footer font-small text-white bg-dark pt-4">

        <!-- Footer Links -->
        <div class="container text-center text-md-left">

            <!-- Grid row -->
            <div class="row">
                <!-- Grid column -->
                <!-- Grid column -->
                <div class="col-md-2 mx-auto">

                    <!-- Links -->


                    <ul class="list-unstyled">
                        <li>
                            <a class="disabled" href="home.php" aria-disabled="true">Home</a>
                        </li>
                        <li>
                            <a class="disabled" href="products.php" aria-disabled="true">Store Stock</a>
                        </li>
                        <li>
                            <a class="disabled" href="newPorder.php " aria-disabled="true">New Purchase Order</a>
                        </li>
                        <li>
                            <a class="disabled" href="viewPorders.php" aria-disabled="true">Purcahse Order Requests</a>
                        </li>
                        <li>
                            <a class="disabled" href="viewOrders.php" aria-disabled="true">Purcahse Order</a>
                        </li>
                        <li>
                            <a class="disabled" href="reports.php" aria-disabled="true">Reports</a>
                        </li>
                    </ul>

                </div>
                <!-- Grid column -->
                <div class="col-md-2 mx-auto">
                    <h5 class="font-weight-bold text-uppercase mt-3 mb-4">Site Map</h5>
                </div>
                <!-- Grid column -->
                <div class="col-md-2 mx-auto">

                    <!-- Links -->


                    <ul class="list-unstyled">
                        <li>
                            <a href="register.html">Register</a>
                        </li>
                        <li>
                            <a href="suppliers.php">Suppliers</a>
                        </li>
                        <li>
                            <a href="productAdd.php">Add Product</a>
                        </li>
                        <li>
                            <a href="deleteProdForm.php">Delete Product</a>
                        </li>
                    </ul>

                </div>


            </div>
            <!-- Grid row -->

        </div>
        <!-- Copyright -->
        <div class="footer-copyright text-center py-3">© 2020 Copyright:
        </div>
        <!-- Copyright -->

    </footer>
</body>

</html>