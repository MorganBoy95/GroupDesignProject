<?php
session_start();
require "server.php";
require "validate.php";

if(!isset($_SESSION['loggedin'])) {
    header("Location:../HTML/index.html");
    exit();
}

if($_SESSION['isAdmin'] === 0) {
    header("Location: products.php");
}

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

    <title>New Supplier/Product Interaction</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <a href="home.php">
                    <img src="../images/logo_sm.png" class="img-fluid float-left" alt="Gadgets4U Logo">
                </a>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Gadgets4U Purchase Order System</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link active" href="#">Home <span class="sr-only">(current)</span></a>
                <a class="nav-item nav-link" href="products.php">Store Stock</a>
                <a class="nav-item nav-link" href="newPorder.php">New Purchase Order</a>
                <a class="nav-item nav-link" href="viewPorders.php">Purchase Order Requests</a>
                <a class="nav-item nav-link" href="viewOrders.php">Purchase Orders</a>
                <a class="nav-item nav-link" href="reports.php">Reports</a>
            </div>
        </div>
    </nav>
    <div class="text-center">
        <form action="newSuppProd.php" method="POST">
            <div class="form-group">
                <label for="SPCode">Product Code*</label>
                <select name="SPCode" id="SPCode" class="form-control" required>
                    <?php 
                        $stmt = "SELECT productCode FROM product";
                        $result = $con->query($stmt);
                        while ($row = $result->fetch_assoc()){
                            echo "<option name='" . $row['productCode'] . "'>" . $row['productCode'] . "</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="SPSupp">Supplier ID*</label>
                <select name="SPSupp" id="SPSupp" class="form-control" required>
                    <?php
                        $stmt = "SELECT supplierID FROM supplier";
                        $result = $con->query($stmt);

                        while ($row = $result->fetch_assoc()) {
                            echo "<option name='" . $row['supplierID'] . "'>" . $row['supplierID'] . "</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="SPDeliv">Delivery Time In Working Days*</label>
                <input type="number" name="SPDeliv" id="SPDeliv" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="SPCost">Cost In Pence*</label>
                <input type="number" name="SPCost" id="SPCost" class="form-control" required>
            </div>
            <button class="btn btn-primary">Submit</button>
        </form>
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