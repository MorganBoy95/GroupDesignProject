<?php
session_start();
require "validate.php";
require "server.php";
if (!isset($_SESSION['loggedin'])) {
    header('Location:../HTML/index.html');
    exit();
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

    <title>Home Page</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
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

    <div class="jumbotron">
        <h1 class="display-4">Hello, <?= $_SESSION['firstName'] ?> <?= $_SESSION['lastName'] ?></h1>
        <hr class="my-4">
        <p class="lead">Welcome to the G4U Purchase Order System. To place a new Purchase Order, click here:</p>
        <p class="lead"><a href="newPorder.php" class="btn btn-primary">New Purchase Order</a></p>
    </div>

    <div class="container-fluid text-center" style="border-bottom-style: solid">
        <?php $stmt = "SELECT issueText, requestID FROM request WHERE requestState = 'Issue' AND staffID = '" . $_SESSION['name'] . "'";
        $result = $con->query($stmt);
        $rowcnt = $result->num_rows;

        if ($rowcnt > 0) { ?>
        <h2>You have <?= $rowcnt ?> porders with issues marked against them:</h2>
        <table class="table mx-5">
            <thead>
                <tr>
                    <th scope="col">Request ID</th>
                    <th scope="col">Issue Text</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>" . $row['requestID'] . "</td>
                            <td>" . $row['issueText'] . "</td>
                        </tr>";
                    } ?>
            </tbody>
        </table>
        <?php } ?>
    </div>
    <br></br>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">System Not Working?</h5>
                <p class="card-text">Contact Lighthouse Support</p>
                <p class="card-text">Tel: 01632 960321</p>
                <p class="card-text">Email: support@lighthouse.com</p>
            </div>
        </div>
        <br></br>
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


    <!-- Bootstrap JavaScript -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
</body>

</html>