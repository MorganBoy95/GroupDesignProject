<?php
session_start();
include 'server.php';
include 'validate.php';

if (!isset($_SESSION['loggedin'])) {
    header('Location:../HTML/index.html');
    exit();
}


$stmt = "SELECT `productCode`, `productName`, `productDescription`, `productPhoto`, `amountInStock`, `minStock`, `maxStock` FROM `product`";
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

    <title>Add Purchase Order Item</title>
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
                <a class="nav-item nav-link active" href="#">Store Stock <span class="sr-only">(current)</span></a>
                <a class="nav-item nav-link" href="#">New Purchase Order</a>
                <a class="nav-item nav-link" href="#">Purchase Order Status</a>
            </div>
        </div>
    </nav>

    <h1 class="text-center">Select Item and Quantity</h1>
    <h5 class="text-center">Do not exceed a product's maximum stock level.</h5>

    <form action="quantityCheck.php" method="POST">
        <div class="form-group w-25 mx-auto d-block">
            <label for="productIDPorder">Select Product ID*</label>
            <select name="productIDPorder" id="productIDPorder" class="form-control" required>
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['productCode'] . "'>" . $row['productCode'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group w-25 mx-auto d-block">
            <label for="quantityPorder">Quantity</label>
            <input type="number" id="quantityPorder" name="quantityPorder" min="1" max="100" class="form-control" required>
        </div>
        <button class="btn btn-primary mx-auto d-block">Add to Porder</button>
    </form>

    <br>
    <br>

    <div class="container">

        <?php $result = $con->query($stmt) ?>

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
                                <img class="card-image-top h-20" style="width: 100%; height:15vw; object-fit:contain;" src="../images/<?php echo $row['productPhoto'] ?>" alt="Image of <?php echo $row['productDescription']; ?>">
                                <div class='card-header'>
                                    <h5 class='card-title'><?php echo $row['productCode']; ?></h5>
                                    <h6 class='card-title'><?php echo $row['productName']; ?></h6>
                                </div>
                                <div class='card-body'>
                                    <?php echo $row['productDescription']; ?>
                                </div>
                                <div class='card-footer <?php echo $background; ?>'>
                                    Quantity in Stock: <?php echo $row['amountInStock']; ?>
                                </div>

                            </div>
                        <?php } else { ?>

                            <div class='card border-dark'>
                                <img class="card-image-top h-20" style="width: 100%; height:15vw; object-fit: contain;" src="../images/<?php echo $row['productPhoto'] ?>" alt="Image of <?php echo $row['productDescription']; ?>">
                                <div class='card-header'>
                                    <h5 class='card-title'><?php echo $row['productCode']; ?></h5>
                                    <h6 class='card-title'><?php echo $row['productName']; ?></h6>
                                </div>
                                <div class='card-body'>
                                    <?php echo $row['productDescription']; ?>
                                </div>
                                <div class='card-footer <?php echo $background; ?>'>
                                    Quantity in Stock: <?php echo $row['amountInStock'] ?>
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
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>

</body>

</html>