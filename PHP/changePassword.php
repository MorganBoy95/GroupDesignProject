<?php
//Include server connection info
include "server.php";
//Ensures user is logged in
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
                <h5 class="text-right"><?php echo $_SESSION['title'] . " " . $_SESSION['firstName'] . " " . $_SESSION['lastName'] ?></h5>
                <h5 class="text-right"><?php echo $_SESSION['appointment'] ?></h5>
                <div class="btn-group float-right" role="group" aria-label="Login Options">
                    <a href="../HTML/register.html" class="btn btn-secondary float-right"><i class="fas fa-user-plus"></i> Staff Registration Portal</a>
                    <a href="#" class="btn btn-secondary float-right"><i class="fas fa-cog"></i> Change Password</a>
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
                <a class="nav-item nav-link" href="#">New Purchase Order</a>
                <a class="nav-item nav-link" href="#">Purchase Order Status</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="text-center">Change Your Password</h1>
                <form action="passChange.php" method="POST">
                    <div class="form-group w-25 mx-auto d-block">
                        <label for="staffID">Staff ID*</label>
                        <input type="text" placeholder="<?php echo $_SESSION['name']?>" name="staffID" class="form-control" id="staffIDReg" readonly>
                    </div>
                    <div class="form-group w-25 mx-auto d-block">
                        <label for="newpass1">New Password*</label>
                        <input type="password" name="newpass1" class="form-control" id="chngPassNew1" required>
                    </div>
                    <div class="form-group w-25 mx-auto d-block">
                        <label for="newpass2">Retype New Password*</label>
                        <input type="password" name="newpass2" class="form-control" id="chngPassNew2" required>
                    </div>
                    <button class="btn btn-primary mx-auto d-block"><i class="fas fa-key"></i> Change Password</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>