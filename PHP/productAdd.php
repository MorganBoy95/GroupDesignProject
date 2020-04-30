<?php
session_start();
require "server.php";
require "validate.php";

if (!isset($_SESSION['loggedin'])) {
    header ("Location: ../HTML/index.html");
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- Font Awesome Kit Code -->
    <script src="https://kit.fontawesome.com/9477a9faa7.js" crossorigin="anonymous"></script>

    <title>Add a Product</title>
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
                <a class="nav-item nav-link" href="viewPorders.php">Purchase Order Requests</a>
                <a class="nav-item nav-link" href="viewOrders.php">Purchase Orders</a>
                <a class="nav-item nav-link" href="reports.php">Reports</a>
            </div>
        </div>
    </nav>

    <div class="container text-center">
        <form action="productToDB.php" method="POST">
            <div class="form-group">
                <label for="newProdCode">Product Code*</label>
                <input type="text" name="newProdCode" id="newProdCode" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="newProdName">Product Name*</label>
                <input type="text" name="newProdName" id="newProdName" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="newProdType">Product Type*</label>
                <select name="newProdType" id="newProdType" class="form-control" required>
                    <?php  
                    $stmt = "SELECT productTypeCode FROM producttype";
                    $result = $con->query($stmt);

                    while ($row = $result->fetch_assoc()) {
                        echo "<option name='" . $row['productTypeCode'] . "'>" . $row['productTypeCode'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="newProdDesc"></label>
                <textarea name="newProdDesc" id="newProdDesc" cols="30" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="newProdInStck">Amount Currently In Stock*</label>
                <input type="text" class="form-control" name="newProdInStck" id="newProdInStck" required>
            </div>
            <div class="form-group">
                <label for="newProdImg">Path to Photo*</label>
                <input type="text" name="newProdImg" class="form-control" id="newProdImg" required>
            </div>
            <div class="form-group">
                <label for="newProdMin">Minimum Stock Level*</label>
                <input type="text" class="form-control" id="newProdMin" name="newProdMin" required>
            </div>
            <div class="form-group">
                <label for="newProdMax">Maximum Stock Level*</label>
                <input type="text" name="newProdMax" id="newProdMax" class="form-control" required>
            </div>
            <button class="btn btn-primary">Submit</button>
        </form>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
</body>

</html>