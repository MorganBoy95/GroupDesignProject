<?php
session_start();
//Include server connection info
require "server.php";
//Ensures user is logged in
if (!isset($_SESSION['loggedin'])) {
    header('Location:../HTML/index.html');
    exit();
}

//Create variable with SQL string attached to it
$sql = "SELECT `productCode`, `productName`, `productDescription`, `productPhoto`, `amountInStock`, `minStock`, `maxStock` FROM `product`";
//Execute query and store the result
$result = $con->query($sql);

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

    <title>Products</title>
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
                <a class="nav-item nav-link active" href="#">Store Stock <span class="sr-only">(current)</span></a>
                <a class="nav-item nav-link" href="newPorder.php">New Purchase Order</a>
                <a class="nav-item nav-link" href="viewPorders.php">Purchase Order Requests</a>
                <a class="nav-item nav-link" href="viewOrders.php">Purchase Orders</a>
                <a class="nav-item nav-link" href="reports.php">Reports</a>
            </div>
        </div>
    </nav>


    <div class="container">
        <h1 class="text-center">Product Information</h1>
        <p class="text-center"><a href="autoReorderCost.php" class="btn btn-primary">Auto Reorder, Prioritising
                Cost</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="autoReorderDeliv.php" class="btn btn-primary">Auto Reorder,
                Prioritise Delivery</a></p>
        <p class="text-center"><a href="suppliers.php" class="btn btn-primary">View
                Suppliers</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="productAdd.php" class="btn btn-primary">Add a
                Product</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="updateMaxStockForm.php" class="btn btn-primary">Update
                Item's Maximum Stock Level</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="deleteProdForm.php" class="btn btn-primary">Delete a Product</a>
        </p>
        
        <div class="container text-center">
            <form action="search.php" method="GET">
                <div class="form-group">
                    <label for="prodsearch">Search by Product Name, Product Code or Product Type:</label>
                    <input type="text" id="prodsearch" class="form-control" name="prodsearch" required>
                </div>
                <button class="btn btn-primary">Search</button>
            </form>
        </div>

        <br>

        <?php $i = 1; ?>
        <?php while ($row = $result->fetch_assoc()) {
            if ((int) $row['amountInStock'] > ((int) $row['minStock'] + 5)) {
                $background = "bg-success";
            } elseif ((int) $row['amountInStock'] >= (int) $row['minStock']) {
                $background = "bg-warning";
            } elseif ((int) $row['amountInStock'] < (int) $row['minStock']) {
                $background = "bg-danger";
            } ?>
        <?php if ($i % 2 != 0) { ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="card-deck mb-4">
                    <div class='card border-dark'>
                        <img class="card-image-top h-20" style="width: 100%; height:15vw; object-fit:contain;"
                            src="../images/<?php echo $row['productPhoto'] ?>"
                            alt="Image of <?php echo $row['productDescription']; ?>">
                        <div class='card-header'>
                            <h5 class='card-title'><?php echo $row['productCode']; ?></h5>
                            <h6 class='card-title'><?php echo $row['productName']; ?></h6>
                        </div>
                        <div class='card-body'>
                            <?php echo $row['productDescription']; ?>
                        </div>
                        <div class='card-footer <?php echo $background; ?>'>
                            <p>Quantity in Stock: <?php echo $row['amountInStock']; ?></p>
                            <p>Maximum Stock Level: <?=$row['maxStock']?></p>
                        </div>

                    </div>
                    <?php } else { ?>

                    <div class='card border-dark'>
                        <img class="card-image-top h-20" style="width: 100%; height:15vw; object-fit: contain;"
                            src="../images/<?php echo $row['productPhoto'] ?>"
                            alt="Image of <?php echo $row['productDescription']; ?>">
                        <div class='card-header'>
                            <h5 class='card-title'><?php echo $row['productCode']; ?></h5>
                            <h6 class='card-title'><?php echo $row['productName']; ?></h6>
                        </div>
                        <div class='card-body'>
                            <?php echo $row['productDescription']; ?>
                        </div>
                        <div class='card-footer <?php echo $background; ?>'>
                            <p>Quantity in Stock: <?php echo $row['amountInStock'] ?></p>
                            <p>Maximum Stock Level: <?=$row['maxStock']?></p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php } ?>
        <?php $i++; ?>
        <?php } ?>
    </div>


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