<?php
session_start();
require "server.php";
require "validate.php";

if (!isset($_SESSION['loggedin'])) {
    header("Location: ../HTML/index.html");
    exit();
}

if ($_SESSION['isAdmin'] === 0) {
    header("Location: home.php");
}

$stmt = "SELECT staff.staffID, staff.title, staff.firstName, staff.lastName, staff.appointment, department.departmentName, isAdmin FROM staff LEFT JOIN department on staff.departmentID = department.departmentID";
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
                <a class="nav-item nav-link" href="viewOrders.php">Purchase Orders</a>
                <a class="nav-item nav-link" href="reports.php">Reports</a>
            </div>
        </div>
    </nav>

    <div class="container text-center">
        <h2>Staff List</h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Staff ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Position</th>
                    <th scope="col">Department</th>
                    <th scope="col">System Admin?</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                
                while($row = $result->fetch_assoc()) {
                    if ((int)$row['isAdmin'] === 0) {
                        $admin = "No";
                    } else {
                        $admin = "Yes";
                    }
                    echo "<tr>
                    <td>" . $row['staffID'] . "</td>
                    <td>" . $row['title'] . " " . $row['firstName'] . " " . $row['lastName'] . "</td>
                    <td>" . $row['appointment'] . "</td>
                    <td>" . $row['departmentName'] . "</td>
                    <td>" . $admin . "</td>
                    </tr>";
                } ?>
            </tbody>
        </table>

        <h2>Departments</h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">DepartmentID</th>
                    <th scope="col">Department Name</th>
                    <th scope="col">Department Manager</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $stmt = "SELECT department.departmentID, department.departmentName, staff.title, staff.firstName, staff.lastName FROM department LEFT JOIN staff ON department.departmentManager = staff.staffID";
                    $result = $con->query($stmt);

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                        <td>" . $row['departmentID'] . "</td>
                        <td>" . $row['departmentName'] . "</td>
                        <td>" . $row['title'] . " " . $row['firstName'] . " " . $row['lastName'] . "</td>
                        </tr>";
                    }
                ?>
            </tbody>
        </table>
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