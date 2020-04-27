<?php
session_start();
require "server.php";
require "validate.php";

if (!isset($_SESSION['loggedin'])) {
    header('Location:../HTML/index.html');
    exit();
}

$stmt = "SELECT * FROM `order` ORDER BY orderNumber DESC";
$result = $con->query($stmt);
?>

<!DOCTYPE html>
<html>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- Font Awesome Kit Code -->
    <script src="https://kit.fontawesome.com/9477a9faa7.js" crossorigin="anonymous"></script>

    <title>View Purchase Orders</title>
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
                    <a href="../HTML/register.html" class="btn btn-secondary float-right"><i class="fas fa-user-plus"></i> Staff Registration Portal</a>
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
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link" href="home.php">Home</a>
                <a class="nav-item nav-link" href="products.php">Store Stock</a>
                <a class="nav-item nav-link" href="newPorder.php">New Purchase Order</a>
                <a class="nav-item nav-link" href="viewPorders.php">Purchase Order Requests</a>
                <a class="nav-item nav-link active" href="#"><span class="sr-only">(current)</span> Purchase Orders</a>
                <a class="nav-item nav-link" href="reports.php">Reports</a>
            </div>
        </div>
    </nav>

    <h1 class="text-center">Purchase Orders:</h1>
    <br>
    <div class="container text-center">
        <form action="inspectOrder.php" method="GET">
            <div class="form-group">
                <label for="inspectOrder">Inspect Porder</label>
                <?php $result = $con->query($stmt) ?>
                <select name="inspectOrder" id="inspectOrder" class="form-control">
                    <?php while ($row = $result->fetch_assoc()) {
                        echo "<option value = '" . $row['orderNumber'] . "'>" . $row['orderNumber'] . "</option>";
                    } ?>
                </select>
            </div>
            <button class="btn btn-primary mx-auto d-block">Inspect</button>
        </form>
    </div>
    <br>
    <br>
    <div class="container">
        <table class="table mx-3">
            <thead>
                <tr>
                    <th scope="col">Order Number</th>
                    <th scope="col">Submitted To</th>
                    <th scope="col">Created On</th>
                    <th scope="col">Cost</th>
                    <th scope="col">Order State</th>
                    <th scope="col">Ordered By</th>
                    <th scope="col">Shipped On</th>
                </tr>
            </thead>
            <?php $result = $con->query($stmt) ?>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                    <td>" . $row['orderNumber'] . "</td>
                    <td>" . $row['supplierID'] . "</td>
                    <td>" . $row['orderDate'] . "</td>
                    <td>" . "£" . $row['orderTotalCost'] . "</td>
                    <td>" . $row['orderState'] . "</td>
                    <td>" . $row['staffID'] . "</td>
                    <td>" . $row['shippedOn'] . "</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>