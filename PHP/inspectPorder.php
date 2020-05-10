<?php
session_start();
require "validate.php";
require "server.php";
if (!isset($_SESSION['loggedin'])) {
    header('Location:../HTML/index.html');
    exit();
}

$_SESSION['activeInspectPorder'] = $_GET['inspectPorder'];

$stmt = "SELECT product.productCode, product.productName, requestedproduct.quantity, supplier.name FROM supplier INNER JOIN requestedproduct ON supplier.supplierID = requestedproduct.supplierID INNER JOIN product ON requestedproduct.productCode = product.productCode WHERE requestedproduct.requestID = " . $_SESSION['activeInspectPorder'];
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

    <title>View Purchase Orders</title>
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
                <a class="nav-item nav-link" href="newPorder.php">New Purchase Order</a>
                <a class="nav-item nav-link" href="viewPorders.php">Purchase Order Requests</a>
                <a class="nav-item nav-link" href="viewOrders.php">Purchase Orders</a>
                <a class="nav-item nav-link" href="reports.php">Reports</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1 class="text-center">Inspecting Contents of Request <?= $_SESSION['activeInspectPorder'] ?></h1>
        <br />
        <table class="table mx-3">
            <thead>
                <tr>
                    <th scope="col">Product Code</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Supplier</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                    <td>" . $row['productCode'] . "</td>
                    <td>" . $row['productName'] . "</td>
                    <td>" . $row['quantity'] . "</td>
                    <td>" . $row['name'] . "</td>
                    </tr>";
                } ?>
            </tbody>
        </table>
    </div>
    <div class="container text-center">
        <p><a class="btn btn-success" href="./authorisePorder.php"><i class="fas fa-check"></i>
                Authorise</a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-success" href="confirmPorder.php"><i
                    class="fas fa-check-double"></i> Confirm</a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-warning"
                href="createIssue.php"><i class="fas fa-exclamation-triangle"></i> Flag
                Issue</a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-danger" href="closePorder.php"><i
                    class="fas fa-lock"></i> Close Request</a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-danger"
                href="deletePorder.php"><i class="fas fa-trash-alt"></i> Delete</a></p>
        <p><i>Note: Only delete a purchase order if it was made in error or it is wrong, they should typically be closed
                so the record is retained. Close a request once an order has been placed for its contained items.</i>
        </p>

        <?php $stmt = "SELECT DISTINCT supplierID FROM requestedproduct WHERE requestID = " . $_SESSION['activeInspectPorder'];
        $result = $con->query($stmt); ?>

        <form action="createOrder.php" method="POST">
            <div class="form-group">
                <label for="pordersuppliercreate">Select a Supplier in this Purchase Order to Generate an Order to.
                    Please only create an actual order if you are the staff member responsible for this Porder, or you
                    will have to take responsibility for this.</label>
                <select class="form-control" name="pordersuppliercreate" id="pordersuppliercreate">
                    <?php while ($row = $result->fetch_assoc()) {
                        echo "<option name='" . $row['supplierID'] . "'>" . $row['supplierID'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <button class="btn btn-primary">Create Order</button>
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