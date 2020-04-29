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

    <!-- Font Awesome Kit Code -->
    <script src="https://kit.fontawesome.com/9477a9faa7.js" crossorigin="anonymous"></script>

    <title>New Supplier/Product Interaction</title>
</head>

<body>
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
</body>

</html>