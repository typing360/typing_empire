<?php
require_once 'conn.php';

// Kuhesabu bidhaa
$result_products = mysqli_query($conn, "SELECT COUNT(*) AS total FROM products");
$row_products = mysqli_fetch_assoc($result_products);
$total_products = $row_products['total'];

// Kuhesabu huduma
$result_services = mysqli_query($conn, "SELECT COUNT(*) AS total FROM services");
$row_services = mysqli_fetch_assoc($result_services);
$total_services = $row_services['total'];

// Kuhesabu mauzo
$result_sales = mysqli_query($conn, "SELECT COUNT(*) AS total FROM sales");
$row_sales = mysqli_fetch_assoc($result_sales);
$total_sales = $row_sales['total'];

// Kuhesabu jumla ya mapato ya mauzo
$result_revenue = mysqli_query($conn, "SELECT SUM(total) AS revenue FROM sales");
$row_revenue = mysqli_fetch_assoc($result_revenue);
$total_revenue = $row_revenue['revenue'];

// Kuhesabu service orders
$result_orders = mysqli_query($conn, "SELECT COUNT(*) AS total FROM service_orders");
$row_orders = mysqli_fetch_assoc($result_orders);
$total_orders = $row_orders['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TYPING EMPIRE | Dashboard</title>

    <link rel="stylesheet"
          href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet"
          href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
        </ul>
        <span class="navbar-text ml-3">
            TYPING EMPIRE
        </span>
    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="index.php" class="brand-link">
            <span class="brand-text font-weight-light ml-3">
                TYPING EMPIRE
            </span>
        </a>

        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column"
                    data-widget="treeview" role="menu">

                    <li class="nav-item">
                        <a href="index.php" class="nav-link active">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
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
                        <a href="services.php" class="nav-link">
                            <i class="nav-icon fas fa-print"></i>
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
        <div class="content-header">
            <div class="container-fluid">
                <h1>Dashboard</h1>
                <p>Welcome to TYPING EMPIRE Management System.</p>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3><?php echo $total_products; ?></h3>
                                <p>Manage your stock</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-box"></i>
                            </div>
                            <a href="products.php" class="small-box-footer">
                                Open <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <div class="inner">
    <h3><?php echo $total_sales; ?></h3>
    <h5>
        TSh <?php echo number_format($total_revenue ?? 0); ?>
    Total Sales Revenue</h5>
    
</div>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="sales.php" class="small-box-footer">
                                Open <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3><?php echo $total_services; ?></h3>
                                <p>Typing and printng</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-print"></i>
                            </div>
                            <a href="services.php" class="small-box-footer">
                                Open <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                              <h3><?php echo $total_orders; ?></h3>
                                <p>Manage service orders</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <a href="service_orders.php" class="small-box-footer">
                                Open <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <section class="content">
    <div class="container-fluid">
        <div class="card">
            <img src="dist/img/empire.jpg"
                 class="card-img-top"
                 alt="TYPING EMPIRE Printer"
                 style="height: 500px; object-fit: cover;">

            <div class="card-body text-center">
                <h2 class="text-info">
                    Welcome to TYPING EMPIRE
                </h2>

                <p>
                    Your trusted place for typing,
                    printing and stationery services.
                </p>

                <h5 class="text-success">
                    Ulipo tupo 💚
                </h5>
            </div>
        </div>
    </div>
</section>
    </div>

    <footer class="main-footer">
        <strong>TYPING EMPIRE</strong> | Stationery Management System
    </footer>

</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>