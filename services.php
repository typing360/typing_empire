<?php
require_once 'conn.php';

if (isset($_POST['add_service'])) {
    $name = $_POST['services_name'];
    $price = $_POST['services_price'];

    $sql = "INSERT INTO services (services_name, services_price)
            VALUES ('$name', '$price')";

    mysqli_query($conn, $sql);
}

$sql = "SELECT * FROM services";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TYPING EMPIRE - Services</title>

    <link rel="stylesheet"
    href="plugins/fontawesome-free/css/all.min.css">

    <link rel="stylesheet"
    href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <span class="navbar-brand">TYPING EMPIRE</span>
    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="index.php" class="brand-link">
            <span class="brand-text font-weight-light">
                TYPING EMPIRE
            </span>
        </a>

        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column">

                    <li class="nav-item">
                        <a href="index.php" class="nav-link">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="products.php" class="nav-link">
                            <i class="nav-icon fas fa-box"></i>
                            <p>Products</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="services.php" class="nav-link active">
                            <i class="nav-icon fas fa-tools"></i>
                            <p>Services</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="sales.php" class="nav-link">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>Sales</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="services_order.php" class="nav-link">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <p>Service Orders</p>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>
    </aside>

    <div class="content-wrapper">

        <section class="content-header">
            <div class="container-fluid">
                <h1>Manage Services</h1>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">

                <div class="card card-teal">
                    <div class="card-header">
                        <h3 class="card-title">Add New Service</h3>
                    </div>

                    <div class="card-body">
                        <form method="POST">

                            <div class="form-group">
                                <label>Service Name</label>
                                <input type="text"
                                name="services_name"
                                class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Service Price (TSh)</label>
                                <input type="number"
                                name="services_price"
                                class="form-control"
                                min="0" required>
                            </div>

                            <button type="submit"
                            name="add_service"
                            class="btn btn-success">
                                Add Service
                            </button>

                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Services List</h3>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Service ID</th>
                                    <th>Service Name</th>
                                    <th>Service Price</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?php echo $row['services_id']; ?></td>
                                    <td><?php echo $row['services_name']; ?></td>
                                    <td><?php echo $row['services_price']; ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>

                        </table>
                    </div>
                </div>

            </div>
        </section>

    </div>

    <footer class="main-footer">
        <strong>TYPING EMPIRE</strong> - Ulipo tupo.
    </footer>

</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>

</body>
</html>