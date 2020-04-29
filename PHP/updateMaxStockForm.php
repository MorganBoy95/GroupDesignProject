<?php
session_start();
require "server.php";
require "validate.php";

if (!isset($_SESSION['loggedin'])) {
    header("Location: ../HTML/index.html");
    exit();
}

if ($_SESSION['isAdmin'] === 0) {
    header("refresh: 3, url=products.php");
    echo "<h2>Insufficient Permissions</h2>\n";
    echo "<h4>Redirecting...</h4>";
}

$stmt = "SELECT productCode FROM product";
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

    <title>Update Max Stock</title>
</head>

<body>
    <div class="container text-center">
        <form action="updateMax.php" method="POST">
            <div class="form-group">
                <label for="updateMaxProdCode"></label>
                <select name="updateMaxProdCode" id="updateMaxProdCode" class="form-control" required>
                    <?php
                        while ($row = $result->fetch_assoc()) {
                            echo "<option name='" . $row['productCode'] . "'>" . $row['productCode'] . "</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="updateMaxNum"></label>
                <input type="number" name="updateMaxNum" id="updateMaxNum" class="form-control" min="1" max="1000" required>
            </div>
            <button class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>