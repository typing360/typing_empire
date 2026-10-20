<?php
require_once 'conn.php';

$message = "";

// Kuhifadhi mauzo
if (isset($_POST['sell'])) {

    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Kupata bei na stock ya bidhaa
    $sql = "SELECT * FROM products WHERE id = '$product_id'";
    $result = mysqli_query($conn, $sql);
    $product = mysqli_fetch_assoc($result);

    if ($product && $quantity > 0 && $product['quantity'] >= $quantity) {

        $price = $product['price'];
        $total = $price * $quantity;
        $sale_date = date('Y-m-d');

        // Kuhifadhi mauzo
        $sql = "INSERT INTO sales
                (product_id, quantity, total, sale_date)
                VALUES ('$product_id', '$quantity', '$total', '$sale_date')";

        if (mysqli_query($conn, $sql)) {

            // Kupunguza stock
            $sql = "UPDATE products
                    SET quantity = quantity - $quantity
                    WHERE id = '$product_id'";

            mysqli_query($conn, $sql);

            $message = "Mauzo yamehifadhiwa vizuri!";

        } else {
            $message = "Kuna tatizo kuhifadhi mauzo.";
        }

    } else {
        $message = "Bidhaa haipo au stock haitoshi.";
    }
}

// Kupata bidhaa
$products = mysqli_query($conn, "SELECT * FROM products");

// Kupata historia ya mauzo
$sales = mysqli_query($conn,
    "SELECT sales.*, products.name
     FROM sales
     INNER JOIN products ON sales.product_id = products.id
     ORDER BY sales.sale_id DESC"
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sales - TYPING EMPIRE</title>

    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <span class="nav-link">
                    TYPING EMPIRE - Sales
                </span>
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
                        <a href="sales.php" class="nav-link active">
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
                <h1>Sales Management</h1>
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
                        <h3 class="card-title">Record New Sale</h3>
                    </div>

                    <form method="POST">
                        <div class="card-body">

                            <div class="form-group">
                                <label>Select Product</label>

                                <select name="product_id" class="form-control" required>
                                    <option value="">Choose product</option>

                                    <?php while ($row = mysqli_fetch_assoc($products)) { ?>
                                        <option value="<?php echo $row['id']; ?>">
                                            <?php
                                            echo htmlspecialchars($row['name']);
                                            ?>
                                            - TSh <?php echo $row['price']; ?>
                                            (Stock: <?php echo $row['quantity']; ?>)
                                        </option>
                                    <?php } ?>

                                </select>
                            </div>

                            <div class="form-group">
                                <label>Quantity Sold</label>
                                <input type="number" name="quantity"
                                       class="form-control" min="1" required>
                            </div>

                        </div>

                        <div class="card-footer">
                            <button type="submit" name="sell" class="btn btn-info">
                                <i class="fas fa-save"></i> Save Sale
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Sales History</h3>
                    </div>

                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Sale ID</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Total (TSh)</th>
                                    <th>Sale Date</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($sales)) { ?>
                                    <tr>
                                        <td><?php echo $row['sale_id']; ?></td>
                                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                                        <td><?php echo $row['quantity']; ?></td>
                                        <td><?php echo number_format($row['total']); ?></td>
                                        <td><?php echo $row['sale_date']; ?></td>
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