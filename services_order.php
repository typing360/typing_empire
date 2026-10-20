<?php
require_once 'conn.php';

$message = "";

// Kuhifadhi order ya huduma
if (isset($_POST['add_order'])) {

    $services_id = $_POST['services_id'];
    $quantity = (int) $_POST['quantity'];

    // Kupata bei ya huduma
    $sql = "SELECT * FROM services
            WHERE services_id = '$services_id'";

    $result = mysqli_query($conn, $sql);
    $service = mysqli_fetch_assoc($result);

    if ($service && $quantity > 0) {

        $price = $service['services_price'];
        $total = $price * $quantity;
        $order_date = date('Y-m-d');

        // Kuhifadhi order
        $sql = "INSERT INTO service_orders
                (services_id, quantity, total, order_date)
                VALUES ('$services_id', '$quantity',
                        '$total', '$order_date')";

        if (mysqli_query($conn, $sql)) {
            $message = "Service order imehifadhiwa vizuri!";
        } else {
            $message = "Kuna tatizo kuhifadhi order.";
        }

    } else {
        $message = "Tafadhali chagua huduma na quantity sahihi.";
    }
}

// Kupata huduma zote
$services = mysqli_query($conn, "SELECT * FROM services");

// Kupata historia ya orders
$orders = mysqli_query($conn,
    "SELECT service_orders.*, services.services_name
     FROM service_orders
     INNER JOIN services
     ON service_orders.services_id = services.services_id
     ORDER BY service_orders.id DESC"
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Service Orders - TYPING EMPIRE</title>

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
                <span class="nav-link">TYPING EMPIRE - Service Orders</span>
            </li>
        </ul>
    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">

        <a href="index.php" class="brand-link">
            <span class="brand-text font-weight-light">TYPING EMPIRE</span>
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
                        <a href="services.php" class="nav-link">
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
                        <a href="http://localhost/typing_empire/service_orders.php"
   class="nav-link active">
    <i class="nav-icon fas fa-clipboard-list"></i>
    <p>Service Orders</p>
</a>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>
    </aside>

    <div class="content-wrapper">

        <section class="content-header">
            <div class="container-fluid">
                <h1>Service Orders Management</h1>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">

                <?php if ($message != "") { ?>
                    <div class="alert alert-info">
                        <?php echo $message; ?>
                    </div>
                <?php } ?>

                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Add Service Order</h3>
                    </div>

                    <form method="POST">
                        <div class="card-body">

                            <div class="form-group">
                                <label>Select Service</label>

                                <select name="services_id"
                                        class="form-control" required>

                                    <option value="">Choose service</option>

                                    <?php while ($row = mysqli_fetch_assoc($services)) { ?>
                                        <option value="<?php echo $row['services_id']; ?>">
                                            <?php echo htmlspecialchars($row['services_name']); ?>
                                            - TSh <?php echo $row['services_price']; ?>
                                        </option>
                                    <?php } ?>

                                </select>
                            </div>

                            <div class="form-group">
                                <label>Quantity</label>

                                <input type="number"
                                       name="quantity"
                                       class="form-control"
                                       min="1"
                                       required>
                            </div>

                        </div>

                        <div class="card-footer">
                            <button type="submit"
                                    name="add_order"
                                    class="btn btn-info">
                                <i class="fas fa-save"></i>
                                Save Order
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Service Orders History</h3>
                    </div>

                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-striped">

                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Service</th>
                                    <th>Quantity</th>
                                    <th>Total (TSh)</th>
                                    <th>Order Date</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($orders)) { ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo htmlspecialchars($row['services_name']); ?></td>
                                        <td><?php echo $row['quantity']; ?></td>
                                        <td><?php echo number_format($row['total']); ?></td>
                                        <td><?php echo $row['order_date']; ?></td>
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