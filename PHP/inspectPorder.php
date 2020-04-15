<?php
session_start();
require "validate.php";
require "server.php";
if (!isset($_SESSION['loggedin'])) {
    header('Location:../HTML/index.html');
    exit();
}

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
                <h5 class="text-right"><?php echo $_SESSION['title'] . " " . $_SESSION['firstName'] . " " . $_SESSION['lastName'] ?></h5>
                <h5 class="text-right"><?php echo $_SESSION['appointment'] ?></h5>
                <div class="btn-group float-right" role="group" aria-label="Login Options">
                    <a href="../HTML/register.html" class="btn btn-secondary float-right"><i class="fas fa-user-plus"></i> Staff Registration Portal</a>
                    <a href="changePassword.php" class="btn btn-secondary float-right"><i class="fas fa-cog"></i> Change Password</a>
                    <a href="logout.php" class="btn btn-primary float-right"><i class="fas fa-sign-out-alt"></i> Logout</a>
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
                <a class="nav-item nav-link active" href="#">Purchase Order Status <span class="sr-only">(current)</span></a>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1 class="text-center">Inspecting Contents of Request <?= $_SESSION['activeInspectPorder']?></h1>
        <br/>
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

</body>

</html>